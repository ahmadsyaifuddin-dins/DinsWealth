<?php

namespace App\Http\Controllers;

use App\Exports\TabunganExport;
use App\Models\KategoriJenisTabungan;
use App\Models\KategoriNamaTabungan;
use App\Models\Tabungan;
use App\Models\TabunganImage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
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

        // HITUNG TOTAL UNTUK LAPORAN
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
        $query = Tabungan::with(['user', 'kategoriNama', 'kategoriJenis', 'images']);

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

        return $query->latest();
    }

    public function index(Request $request)
    {
        // 1. DATA UNTUK TABEL & TOTAL (SESUAI FILTER DARI USER)
        $user = Auth::user();

        // Mulai query dasar
        $query = Tabungan::with(['user', 'kategoriNama', 'kategoriJenis', 'images']);

        // Terapkan filter berdasarkan input dari request (URL)

        // 1. Filter berdasarkan rentang tanggal
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('created_at', '>=', $request->tanggal_mulai);
        }
        if ($request->filled('tanggal_selesai')) {
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

        // Ambil data SETELAH semua kondisi diterapkan
        $queryForTotalsAndCharts = clone $query;
        $allFilteredData = $queryForTotalsAndCharts->latest()->get();

        $data = $query->latest()->paginate(15);
        // PERSIAPAN DATA UNTUK GRAFIK (MENGIKUTI FILTER)
        $chartData = [];
        if ($allFilteredData->isNotEmpty()) {
            // 1. Data untuk Pie Chart (Pemasukan vs Pengeluaran)
            $totalPemasukanPie = $allFilteredData->where('kategoriJenis.jenis', 'Pemasukan')->sum('nominal');
            $totalPengeluaranPie = $allFilteredData->where('kategoriJenis.jenis', 'Pengeluaran')->sum('nominal');
            $chartData['pie'] = [$totalPemasukanPie, $totalPengeluaranPie];

            // 2. Data untuk Line Chart (Riwayat per bulan)
            $lineChartData = $allFilteredData->sortBy('created_at')
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
                    return \Carbon\Carbon::createFromFormat('Y-m', $date)->isoFormat('MMMM Y');
                }),
                'data' => $lineChartData->values(),
            ];

            // 3. Data untuk Bar Chart (Kategori paling sering)
            $barChartData = $allFilteredData->where('kategoriJenis.jenis', 'Pengeluaran') // Fokus pada pengeluaran
                ->countBy('kategoriNama.nama')
                ->sortDesc()
                ->take(5); // Ambil 5 teratas

            $chartData['bar'] = [
                'labels' => $barChartData->keys(),
                'data' => $barChartData->values(),
            ];

            // 4. Data untuk Line Chart Bulanan
            $lineChartBulanan = $allFilteredData->sortBy('created_at')
                ->groupBy(function ($item) {
                    return $item->created_at->format('Y-m');
                })
                ->map(function ($group) {
                    $pemasukan = $group->where('kategoriJenis.jenis', 'Pemasukan')->sum('nominal');
                    $pengeluaran = $group->where('kategoriJenis.jenis', 'Pengeluaran')->sum('nominal');
                    return $pemasukan - $pengeluaran;
                });

            $chartData['line_monthly'] = [
                'labels' => $lineChartBulanan->keys()->map(function ($date) {
                    return \Carbon\Carbon::createFromFormat('Y-m', $date)->isoFormat('MMMM Y');
                }),
                'data' => $lineChartBulanan->values(),
            ];

            // 5. Data untuk Line Chart Harian (30 hari terakhir dari data yang difilter)
            $dataHarian = $allFilteredData->filter(function ($item) {
                return $item->created_at >= now()->subDays(29)->startOfDay();
            })
                ->sortBy('created_at')
                ->groupBy(function ($item) {
                    return $item->created_at->format('Y-m-d');
                })
                ->map(function ($group) {
                    $pemasukan = $group->where('kategoriJenis.jenis', 'Pemasukan')->sum('nominal');
                    $pengeluaran = $group->where('kategoriJenis.jenis', 'Pengeluaran')->sum('nominal');
                    return $pemasukan - $pengeluaran;
                });

            $chartData['line_daily'] = [
                'labels' => $dataHarian->keys()->map(function ($date) {
                    return \Carbon\Carbon::createFromFormat('Y-m-d', $date)->isoFormat('D MMM');
                }),
                'data' => $dataHarian->values(),
            ];

            // 6. Data untuk Line Chart Per Jam (hari ini dari data yang difilter)
            $dataJamIni = $allFilteredData->filter(function ($item) {
                return $item->created_at->isToday();
            })
                ->sortBy('created_at')
                ->groupBy(function ($item) {
                    return $item->created_at->format('H');
                })
                ->map(function ($group) {
                    $pemasukan = $group->where('kategoriJenis.jenis', 'Pemasukan')->sum('nominal');
                    $pengeluaran = $group->where('kategoriJenis.jenis', 'Pengeluaran')->sum('nominal');
                    return $pemasukan - $pengeluaran;
                });

            // 6. Data untuk Line Chart Mingguan
            $lineChartMingguan = $allFilteredData->sortBy('created_at')
                ->groupBy(function ($item) {
                    // Grup berdasarkan Tahun-Mingguke (misal: 2025-42)
                    return $item->created_at->isoFormat('YYYY-WW');
                })
                ->map(function ($group) {
                    $pemasukan = $group->where('kategoriJenis.jenis', 'Pemasukan')->sum('nominal');
                    $pengeluaran = $group->where('kategoriJenis.jenis', 'Pengeluaran')->sum('nominal');
                    return $pemasukan - $pengeluaran;
                });

            $chartData['line_weekly'] = [
                'labels' => $lineChartMingguan->keys()->map(function ($date) {
                    // Format label menjadi "Mgg [W], [YYYY]"
                    $year = substr($date, 0, 4);
                    $week = (int)substr($date, 5, 2);
                    return 'Mgg ' . $week . ', ' . $year;
                }),
                'data' => $lineChartMingguan->values(),
            ];

            // 7. Data untuk Line Chart Tahunan
            $lineChartTahunan = $allFilteredData->sortBy('created_at')
                ->groupBy(function ($item) {
                    return $item->created_at->format('Y'); // Grup berdasarkan Tahun
                })
                ->map(function ($group) {
                    $pemasukan = $group->where('kategoriJenis.jenis', 'Pemasukan')->sum('nominal');
                    $pengeluaran = $group->where('kategoriJenis.jenis', 'Pengeluaran')->sum('nominal');
                    return $pemasukan - $pengeluaran;
                });

            $chartData['line_yearly'] = [
                'labels' => $lineChartTahunan->keys(), // Labelnya adalah tahun (misal: "2024", "2025")
                'data' => $lineChartTahunan->values(),
            ];
        }

        // HITUNG TOTAL UNTUK DASHBOARD (DARI DATA YANG SUDAH DIFILTER)
        $totalPemasukan = $allFilteredData->where('kategoriJenis.jenis', 'Pemasukan')->sum('nominal');
        $totalPengeluaran = $allFilteredData->where('kategoriJenis.jenis', 'Pengeluaran')->sum('nominal');
        $saldoAkhir = $totalPemasukan - $totalPengeluaran;

        $totalTransaksi = $allFilteredData->count();

        // AMBIL DATA UNTUK DROPDOWN & KIRIM KE VIEW
        $namaKategori = KategoriNamaTabungan::all();
        $jenisKategori = KategoriJenisTabungan::all();

        // Kirim semua data ke view, termasuk data grafik
        return view('tabungan.index', compact(
            'data',
            'user',
            'namaKategori',
            'jenisKategori',
            'chartData',
            'totalPemasukan',
            'totalPengeluaran',
            'saldoAkhir',
            'totalTransaksi'
        ));
    }

    public function create()
    {
        $namaKategori = KategoriNamaTabungan::all();
        $jenisKategori = KategoriJenisTabungan::all();
        return view('tabungan.create', compact('namaKategori', 'jenisKategori'));
    }

    // Fungsi helper untuk menentukan disk mana yang akan digunakan
    private function getStorageDisk()
    {
        // Jika environment adalah 'local', gunakan disk 'public'.
        // Jika tidak (misal: production di InfinityFree), gunakan disk 'hosting_public'.
        return app()->environment('local') ? 'public' : 'hosting_public';
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|exists:kategori_nama_tabungans,id',
            'jenis' => 'required|exists:kategori_jenis_tabungans,id',
            'nominal' => 'required|string', // format-nya akan dibersihkan manual
            'keterangan' => 'nullable|string|max:255',
            'images' => 'nullable|array', // Validasi bahwa 'images' adalah array
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi setiap item dalam array
        ]);

        // Bersihkan angka nominal dari titik/koma agar bisa disimpan sebagai integer
        $cleanedNominal = (int) str_replace(['.', ','], '', $validated['nominal']);

        // Buat data tabungan terlebih dahulu
        $tabungan = Tabungan::create([
            'nama' => $validated['nama'],
            'jenis' => $validated['jenis'],
            'nominal' => $cleanedNominal,
            'keterangan' => $validated['keterangan'],
            'user_id' => auth()->id(),
        ]);

        // Jika ada gambar yang di-upload, loop dan simpan
        if ($request->hasFile('images')) {
            $disk = $this->getStorageDisk();
            foreach ($request->file('images') as $file) {
                $path = $file->store('tabungan_images', $disk);
                $tabungan->images()->create(['path' => $path]);
            }
        }

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
            'images' => 'nullable|array',
            'created_at' => 'required|date',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'deleted_images' => 'nullable|array', // Untuk menampung ID gambar yang mau dihapus
        ]);

        $cleanedNominal = (int) str_replace(['.', ','], '', $validated['nominal']);

        $tabungan = Tabungan::findOrFail($id);
        $disk = $this->getStorageDisk();

        $tabungan->update([
            'nama' => $validated['nama'],
            'jenis' => $validated['jenis'],
            'nominal' => $cleanedNominal,
            'keterangan' => $validated['keterangan'],
            'created_at' => $validated['created_at'],
        ]);

        // Hapus gambar yang ditandai untuk dihapus
        if (!empty($validated['deleted_images'])) {
            $imagesToDelete = TabunganImage::whereIn('id', $validated['deleted_images'])->get();
            foreach ($imagesToDelete as $image) {
                Storage::disk($disk)->delete($image->path);
                $image->delete();
            }
        }

        // Tambahkan gambar baru jika ada
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('tabungan_images', $disk);
                $tabungan->images()->create(['path' => $path]);
            }
        }

        return redirect()->route('tabungan.index')->with('success', 'Tabungan berhasil diupdate.');
    }

    /**
     * Soft delete tabungan (hanya untuk role dins)
     */
    public function destroy(Tabungan $tabungan)
    {
        // Cek apakah user memiliki role dins
        if (Auth::user()->role !== 'dins') {
            return redirect()->route('tabungan.index')
                ->with('error', 'Anda tidak memiliki akses untuk menghapus data tabungan!');
        }

        $tabungan->delete(); // Soft delete

        return redirect()->route('tabungan.index')
            ->with('success', 'Data tabungan berhasil dihapus! Data dapat dipulihkan dari menu sampah.');
    }

    /**
     * Tampilkan halaman recycle bin / sampah tabungan
     */
    public function trash()
    {
        // Cek apakah user memiliki role dins
        if (Auth::user()->role !== 'dins') {
            return redirect()->route('tabungan.index')
                ->with('error', 'Anda tidak memiliki akses untuk melihat sampah tabungan!');
        }

        $trashedTabungans = Tabungan::onlyTrashed()
            ->with(['kategoriNama', 'kategoriJenis'])
            ->orderBy('deleted_at', 'desc')
            ->paginate(10);

        return view('tabungan.trash', compact('trashedTabungans'));
    }

    /**
     * Pulihkan data tabungan dari sampah
     */
    public function restore($id)
    {
        // Cek apakah user memiliki role dins
        if (Auth::user()->role !== 'dins') {
            return redirect()->route('tabungan.index')
                ->with('error', 'Anda tidak memiliki akses untuk memulihkan data tabungan!');
        }

        $tabungan = Tabungan::onlyTrashed()->findOrFail($id);
        $tabungan->restore();

        return redirect()->route('tabungan.trash')
            ->with('success', 'Data tabungan berhasil dipulihkan!');
    }

    /**
     * Hapus permanen data tabungan dari database
     */
    public function forceDelete($id)
    {
        // Cek apakah user memiliki role dins
        if (Auth::user()->role !== 'dins') {
            return redirect()->route('tabungan.index')
                ->with('error', 'Anda tidak memiliki akses untuk menghapus permanen data tabungan!');
        }

        $tabungan = Tabungan::onlyTrashed()->with('images')->findOrFail($id);
        $disk = $this->getStorageDisk();

        // Hapus semua file gambar terkait
        foreach ($tabungan->images as $image) {
            Storage::disk($disk)->delete($image->path);
        }

        $tabungan->forceDelete();

        return redirect()->route('tabungan.trash')
            ->with('success', 'Data tabungan berhasil dihapus permanen dari database!');
    }

    /**
     * Pulihkan semua data tabungan dari sampah
     */
    public function restoreAll()
    {
        // Cek apakah user memiliki role dins
        if (Auth::user()->role !== 'dins') {
            return redirect()->route('tabungan.index')
                ->with('error', 'Anda tidak memiliki akses untuk memulihkan data tabungan!');
        }

        $count = Tabungan::onlyTrashed()->count();
        Tabungan::onlyTrashed()->restore();

        return redirect()->route('tabungan.trash')
            ->with('success', "Berhasil memulihkan {$count} data tabungan!");
    }

    public function emptyTrash()
    {
        // Cek apakah user memiliki role dins
        if (Auth::user()->role !== 'dins') {
            return redirect()->route('tabungan.index')
                ->with('error', 'Anda tidak memiliki akses untuk mengosongkan sampah tabungan!');
        }

        $disk = $this->getStorageDisk();

        // 1. Ambil semua data yang ada di sampah beserta relasi gambarnya
        $trashedTabungans = Tabungan::onlyTrashed()->with('images')->get();
        $count = $trashedTabungans->count();

        if ($count > 0) {
            foreach ($trashedTabungans as $tabungan) {
                // 2. Loop dan hapus setiap file gambar dari storage
                foreach ($tabungan->images as $image) {
                    Storage::disk($disk)->delete($image->path);
                }
                // 3. Hapus record dari database
                // onDelete('cascade') akan otomatis menghapus record di 'tabungan_images'
                $tabungan->forceDelete();
            }
        }

        return redirect()->route('tabungan.trash')
            ->with('success', "Berhasil menghapus permanen {$count} data tabungan dari database!");
    }
}
