<?php

namespace App\Http\Controllers;

use App\Models\Tabungan;
use App\Models\KategoriNamaTabungan;
use App\Models\KategoriJenisTabungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\TabunganExport;
use Maatwebsite\Excel\Facades\Excel;

class TabunganController extends Controller
{

    // METHOD BARU UNTUK EXPORT EXCEL
    public function exportExcel(Request $request)
    {
        $data = $this->getFilteredQuery($request)->get();
        return Excel::download(new TabunganExport($data), 'laporan-tabungan.xlsx');
    }

    // METHOD BARU UNTUK EXPORT PDF
    public function exportPdf(Request $request)
    {
        // Ambil data yang sudah difilter
        $data = $this->getFilteredQuery($request)->get();

        // ===============================================
        // BAGIAN BARU: HITUNG TOTAL UNTUK LAPORAN
        // ===============================================
        $totalPemasukan = $data->where('kategoriJenis.jenis', 'Pemasukan')->sum('nominal');
        $totalPengeluaran = $data->where('kategoriJenis.jenis', 'Pengeluaran')->sum('nominal');
        $saldoAkhir = $totalPemasukan - $totalPengeluaran;

        // Ambil juga filter yang aktif untuk ditampilkan di judul laporan
        $filters = $request->only(['tanggal_mulai', 'tanggal_selesai']);

        // Kirim semua data (termasuk totalan) ke view PDF
        $pdf = Pdf::loadView('tabungan.pdf', compact(
            'data',
            'totalPemasukan',
            'totalPengeluaran',
            'saldoAkhir',
            'filters'
        ));

        return $pdf->download('laporan-tabungan-' . date('d-m-Y') . '.pdf');
    }

    // HELPER METHOD UNTUK MENGAMBIL QUERY (AGAR TIDAK DUPLIKAT KODE)
    private function getFilteredQuery(Request $request)
    {
        $user = auth()->user();
        $query = Tabungan::with(['user', 'kategoriNama', 'kategoriJenis']);

        // Terapkan semua filter
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('created_at', '>=', $request->tanggal_mulai);
        }
        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('created_at', '<=', $request->tanggal_selesai);
        }
        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }
        if ($request->filled('kategori')) {
            $query->where('nama', $request->kategori);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('keterangan', 'like', "%{$search}%");
        }

        // Aturan Role
        //  if ($user->role === 'viewer') {
        // //      $query->where('user_id', $user->id);
        //  } elseif ($user->role !== 'dins') {
        //      abort(403);
        //  }

        return $query->latest();
    }

    public function index(Request $request)
    {
        $data = $this->getFilteredQuery($request)->get();
        $user = Auth::user();

        // Mulai query dasar
        $query = Tabungan::with(['user', 'kategoriNama', 'kategoriJenis']);

        // Terapkan filter berdasarkan input dari request (URL)

        // 1. Filter berdasarkan rentang tanggal
        if ($request->filled('tanggal_mulai')) {
            // Gunakan kolom 'created_at' yang ada di database kamu
            $query->whereDate('created_at', '>=', $request->tanggal_mulai);
        }
        if ($request->filled('tanggal_selesai')) {
            // Gunakan kolom 'created_at' yang ada di database kamu
            $query->whereDate('created_at', '<=', $request->tanggal_selesai);
        }

        // 2. Filter berdasarkan jenis (ID dari kategori jenis)
        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        // 3. Filter berdasarkan kategori (ID dari kategori nama)
        if ($request->filled('kategori')) {
            $query->where('nama', $request->kategori);
        }

        // 4. Filter berdasarkan kata kunci di keterangan
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('keterangan', 'like', "%{$search}%");
        }

        // Terapkan aturan role SETELAH semua filter diterapkan
        // if ($user->role === 'dins') {
        //     // Dins bisa lihat semua data (yang sudah difilter)
        // } elseif ($user->role === 'viewer') {
        //     // Viewer hanya bisa lihat datanya sendiri (yang sudah difilter)
        //     $query->where('user_id', $user->id);
        // } else {
        //     abort(403);
        // }

        // Ambil data SETELAH semua kondisi diterapkan
        $data = $query->latest()->get();

        // =======================================================
        // PERSIAPAN DATA UNTUK GRAFIK (BAGIAN BARU)
        // =======================================================
        $chartData = [];
        if ($data->isNotEmpty()) {
            // 1. Data untuk Pie Chart (Pemasukan vs Pengeluaran)
            $totalPemasukan = $data->where('kategoriJenis.jenis', 'Pemasukan')->sum('nominal');
            $totalPengeluaran = $data->where('kategoriJenis.jenis', 'Pengeluaran')->sum('nominal');
            $chartData['pie'] = [$totalPemasukan, $totalPengeluaran];

            // 2. Data untuk Line Chart (Riwayat per bulan)
            $lineChartData = $data->sortBy('created_at')
                ->groupBy(function ($item) {
                    return $item->created_at->format('Y-m'); // Grup berdasarkan Tahun-Bulan
                })
                ->map(function ($group) {
                    $pemasukan = $group->where('kategoriJenis.jenis', 'Pemasukan')->sum('nominal');
                    $pengeluaran = $group->where('kategoriJenis.jenis', 'Pengeluaran')->sum('nominal');
                    return $pemasukan - $pengeluaran; // Hitung arus kas bersih
                });

            $chartData['line'] = [
                'labels' => $lineChartData->keys()->map(function ($date) {
                    // Format label menjadi "Nama Bulan Tahun"
                    return \Carbon\Carbon::createFromFormat('Y-m', $date)->isoFormat('MMMM Y');
                }),
                'data' => $lineChartData->values(),
            ];

            // 3. Data untuk Bar Chart (Kategori paling sering)
            $barChartData = $data->where('kategoriJenis.jenis', 'Pengeluaran') // Fokus pada pengeluaran
                ->countBy('kategoriNama.nama')
                ->sortDesc()
                ->take(5); // Ambil 5 teratas

            $chartData['bar'] = [
                'labels' => $barChartData->keys(),
                'data' => $barChartData->values(),
            ];
        }
        // =======================================================

        $namaKategori = KategoriNamaTabungan::all();
        $jenisKategori = KategoriJenisTabungan::all();

        // Kirim semua data ke view, termasuk data grafik
        return view('tabungan.index', compact('data', 'user', 'namaKategori', 'jenisKategori', 'chartData'));
    }

    public function create()
    {
        $namaKategori = KategoriNamaTabungan::all();
        $jenisKategori = KategoriJenisTabungan::all();
        return view('tabungan.create', compact('namaKategori', 'jenisKategori'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|exists:kategori_nama_tabungans,id',
            'jenis' => 'required|exists:kategori_jenis_tabungans,id',
            'nominal' => 'required|string', // format-nya akan dibersihkan manual
            'keterangan' => 'nullable|string|max:255',
        ]);

        // Bersihkan angka nominal dari titik/koma agar bisa disimpan sebagai integer
        $cleanedNominal = (int) str_replace(['.', ','], '', $validated['nominal']);

        Tabungan::create([
            'nama' => $validated['nama'],         // ini ID kategori nama tabungan
            'jenis' => $validated['jenis'],       // ini ID kategori jenis tabungan
            'nominal' => $cleanedNominal,
            'keterangan' => $validated['keterangan'],
            'user_id' => auth()->id(),            // supaya tercatat siapa yang nabung
        ]);

        return redirect()->route('tabungan.index')->with('success', 'Tabungan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $tabungan = Tabungan::findOrFail($id);
        $namaKategori = KategoriNamaTabungan::all();
        $jenisKategori = KategoriJenisTabungan::all();

        return view('tabungan.edit', compact('tabungan', 'namaKategori', 'jenisKategori'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama' => 'required|exists:kategori_nama_tabungans,id',
            'jenis' => 'required|exists:kategori_jenis_tabungans,id',
            'nominal' => 'required|string',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $cleanedNominal = (int) str_replace(['.', ','], '', $validated['nominal']);

        $tabungan = Tabungan::findOrFail($id);
        $tabungan->update([
            'nama' => $validated['nama'],
            'jenis' => $validated['jenis'],
            'nominal' => $cleanedNominal,
            'keterangan' => $validated['keterangan'],
        ]);

        return redirect()->route('tabungan.index')->with('success', 'Tabungan berhasil diupdate.');
    }

    public function destroy($id)
    {
        $tabungan = Tabungan::findOrFail($id);
        $tabungan->delete();

        return redirect()->route('tabungan.index')->with('success', 'Tabungan berhasil dihapus.');
    }
}
