# Ringkasan Detail Proyek: DinsWealth

## 1. Gambaran Umum

**DinsWealth** adalah aplikasi web yang dibangun menggunakan framework **Laravel** untuk tujuan pelacakan keuangan pribadi. Aplikasi ini memungkinkan pengguna untuk mencatat, mengkategorikan, dan mengelola transaksi keuangan mereka. Berdasarkan struktur dan fungsionalitasnya, proyek ini dirancang sebagai sistem manajemen tabungan atau buku kas digital.

Aplikasi ini memiliki fitur-fitur inti yang berpusat pada pengelolaan data "Tabungan", yang tampaknya merupakan istilah umum untuk semua jenis transaksi (pemasukan, pengeluaran, dan donasi).

## 2. Fitur-fitur Utama

Aplikasi ini memiliki serangkaian fitur yang terdefinisi dengan baik, yang dapat diidentifikasi dari file `routes/web.php` dan controller yang ada:

- **Manajemen Transaksi (Tabungan):**
  - **CRUD:** Pengguna dapat membuat (Create), membaca (Read), memperbarui (Update), dan menghapus (Delete) data transaksi.
  - **Soft Deletes:** Terdapat fitur "tong sampah" (`trash`) yang memungkinkan pemulihan data transaksi yang telah dihapus (soft delete).
  - **Kategorisasi:** Setiap transaksi dikategorikan berdasarkan "Nama" (misalnya: Gaji, Makanan, Transportasi) dan "Jenis" (misalnya: Pemasukan, Pengeluaran, Donasi).

- **Manajemen Kategori:**
  - Pengguna dengan peran admin dapat mengelola kategori "Nama" dan "Jenis" transaksi, memastikan konsistensi data.

- **Transaksi Terencana (Planned Transactions):**
  - Pengguna dapat menjadwalkan transaksi yang akan datang atau berulang.
  - Terdapat fungsi untuk "menyelesaikan" (`complete`) transaksi terencana, yang kemungkinan besar akan memindahkannya menjadi transaksi aktual di tabel `tabungans`.

- **Ekspor Data:**
  - Aplikasi menyediakan fungsionalitas untuk mengekspor data transaksi ke dalam format **PDF** dan **Excel**, menggunakan library `dompdf` dan `maatwebsite/excel`.

- **Sistem Peran (Role-Based Access Control):**
  - Terdapat dua peran pengguna yang jelas:
    - **`dins` (Admin):** Memiliki akses penuh ke semua fitur, termasuk manajemen kategori dan transaksi.
    - **`viewer`:** Memiliki akses terbatas, kemungkinan hanya untuk melihat data (read-only).

## 3. Arsitektur Teknis

- **Framework:** **Laravel**, sebuah framework PHP modern yang mengikuti pola desain Model-View-Controller (MVC).
- **Database:** Migrasi database menunjukkan penggunaan database relasional. Terdapat tabel-tabel utama seperti `users`, `tabungans`, `kategori_nama_tabungans`, `kategori_jenis_tabungans`, dan `planned_transactions`.
- **Frontend:** Menggunakan Blade sebagai templating engine, dengan Vite untuk kompilasi aset (CSS dan JavaScript). Terdapat indikasi penggunaan Tailwind CSS.
- **Dependensi Utama (Backend):**
  - `laravel/framework`: Inti dari aplikasi.
  - `barryvdh/laravel-dompdf`: Untuk generate file PDF.
  - `maatwebsite/excel`: Untuk generate file Excel.

## 4. Model Data & Inkonsistensi Arsitektural

Analisis terhadap migrasi database menunjukkan adanya inkonsistensi penting dalam model data:

- **Tabel `tabungans` (Denormalisasi):**
  - Tabel ini menyimpan kategori transaksi (`nama` dan `jenis`) sebagai `string`. Ini berarti jika nama kategori diubah di masa depan, data transaksi lama tidak akan ikut berubah.
  - `Schema::create('tabungans', function (Blueprint $table) { ... $table->string('nama'); $table->string('jenis'); ... });`

- **Tabel `planned_transactions` (Normalisasi):**
  - Sebaliknya, tabel ini menggunakan foreign key yang merujuk ke tabel `kategori_nama_tabungans` dan `kategori_jenis_tabungans`. Ini adalah praktik yang lebih baik untuk menjaga integritas data.
  - `Schema::create('planned_transactions', function (Blueprint $table) { ... $table->foreignId('nama')->constrained('kategori_nama_tabungans'); $table->foreignId('jenis')->constrained('kategori_jenis_tabungans'); ... });`

**Implikasi:**
Inkonsistensi ini menunjukkan bahwa ketika sebuah "Transaksi Terencana" ditandai sebagai "selesai", logikanya kemungkinan besar menyalin nilai string dari kategori terkait ke dalam tabel `tabungans`, daripada mempertahankan relasi foreign key. Meskipun ini bisa menjadi pilihan desain yang disengaja, ini berpotensi menyebabkan masalah dalam pemeliharaan dan integritas data jangka panjang.

## 5. Tujuan Proyek

Berdasarkan analisis menyeluruh, **tujuan utama dari proyek DinsWealth adalah:**

> **Menyediakan sebuah platform digital yang terstruktur dan mudah digunakan bagi pengguna untuk melacak dan mengelola keuangan pribadi mereka, dengan kemampuan untuk mengkategorikan setiap transaksi, merencanakan pengeluaran/pemasukan di masa depan, dan menganalisis data keuangan melalui fitur ekspor.**

Proyek ini dirancang untuk memberikan gambaran yang jelas tentang kesehatan finansial pengguna dengan memisahkan berbagai jenis transaksi dan memberikan laporan yang dapat diekspor.
