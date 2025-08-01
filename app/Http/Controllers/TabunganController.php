<?php

namespace App\Http\Controllers;

use App\Models\Tabungan;
use App\Models\KategoriNamaTabungan;
use App\Models\KategoriJenisTabungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\TabunganExport;
use Illuminate\Support\Facades\DB;
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
        // =================================================================
        // 1. DATA UNTUK TABEL & TOTAL (SESUAI FILTER DARI USER) - Tetap sama
        // =================================================================
        $data = $this->getFilteredQuery($request)->get();
        $user = Auth::user();
        $totalPemasukan = $data->where('kategoriJenis.jenis', 'Pemasukan')->sum('nominal');
        $totalPengeluaran = $data->where('kategoriJenis.jenis', 'Pengeluaran')->sum('nominal');
        $saldoAkhir = $totalPemasukan - $totalPengeluaran;

        // =================================================================
        // 2. AMBIL DATA KHUSUS UNTUK GRAFIK (QUERY DIPERBARUI & LEBIH STABIL)
        // =================================================================
        $chartData = [];

        // Data untuk Pie Chart (menggunakan JOIN)
        $pieData = Tabungan::select(
            'kategori_jenis_tabungans.jenis',
            DB::raw('SUM(tabungans.nominal) as total_nominal')
        )
            ->join('kategori_jenis_tabungans', 'tabungans.jenis', '=', 'kategori_jenis_tabungans.id')
            ->groupBy('kategori_jenis_tabungans.jenis')
            ->pluck('total_nominal', 'jenis');

        $chartData['pie'] = [
            $pieData->get('Pemasukan', 0),
            $pieData->get('Pengeluaran', 0)
        ];

        // Data untuk Bar Chart (menggunakan JOIN)
        $barChartData = Tabungan::select(
            'kategori_nama_tabungans.nama',
            DB::raw('COUNT(*) as total_transaksi')
        )
            ->join('kategori_jenis_tabungans', 'tabungans.jenis', '=', 'kategori_jenis_tabungans.id')
            ->join('kategori_nama_tabungans', 'tabungans.nama', '=', 'kategori_nama_tabungans.id')
            ->where('kategori_jenis_tabungans.jenis', 'Pengeluaran')
            ->groupBy('kategori_nama_tabungans.nama')
            ->orderBy('total_transaksi', 'desc')
            ->take(5)
            ->pluck('total_transaksi', 'nama');

        $chartData['bar'] = [
            'labels' => $barChartData->keys(),
            'data'   => $barChartData->values(),
        ];

        // Data untuk Line Chart (Bulanan - selectRaw sudah stabil)
        $lineChartBulanan = Tabungan::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, SUM(CASE WHEN jenis = (SELECT id FROM kategori_jenis_tabungans WHERE jenis = 'Pemasukan') THEN nominal ELSE -nominal END) as net_flow")
            ->groupBy('month')->orderBy('month', 'asc')->get();
        $chartData['line_monthly'] = [
            'labels' => $lineChartBulanan->map(fn($item) => \Carbon\Carbon::createFromFormat('Y-m', $item->month)->isoFormat('MMMM Y')),
            'data'   => $lineChartBulanan->pluck('net_flow'),
        ];

        // Data untuk Line Chart (Harian - selectRaw sudah stabil)
        $lineChartHarian = Tabungan::selectRaw("DATE(created_at) as day, SUM(CASE WHEN jenis = (SELECT id FROM kategori_jenis_tabungans WHERE jenis = 'Pemasukan') THEN nominal ELSE -nominal END) as net_flow")
            ->where('created_at', '>=', now()->subDays(29)->startOfDay())->groupBy('day')->orderBy('day', 'asc')->get();
        $chartData['line_daily'] = [
            'labels' => $lineChartHarian->map(fn($item) => \Carbon\Carbon::parse($item->day)->isoFormat('D MMM')),
            'data'   => $lineChartHarian->pluck('net_flow'),
        ];

        // Data untuk Line Chart (Per Jam - selectRaw sudah stabil)
        $hourlyFlows = Tabungan::selectRaw("HOUR(created_at) as hour, SUM(CASE WHEN jenis = (SELECT id FROM kategori_jenis_tabungans WHERE jenis = 'Pemasukan') THEN nominal ELSE -nominal END) as net_flow")
            ->whereDate('created_at', today())->groupBy('hour')->orderBy('hour', 'asc')->pluck('net_flow', 'hour');
        $hourlyData = array_fill(0, 24, 0);
        foreach ($hourlyFlows as $hour => $net_flow) {
            $hourlyData[$hour] = $net_flow;
        }
        $chartData['line_hourly'] = [
            'labels' => array_map(fn($h) => str_pad($h, 2, '0', STR_PAD_LEFT) . ':00', array_keys($hourlyData)),
            'data'   => array_values($hourlyData),
        ];

        // =================================================================
        // 3. AMBIL DATA UNTUK DROPDOWN & KIRIM KE VIEW
        // =================================================================
        $namaKategori = KategoriNamaTabungan::all();
        $jenisKategori = KategoriJenisTabungan::all();

        return view('tabungan.index', compact(
            'data',
            'user',
            'namaKategori',
            'jenisKategori',
            'chartData',
            'totalPemasukan',
            'totalPengeluaran',
            'saldoAkhir'
        ));
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
