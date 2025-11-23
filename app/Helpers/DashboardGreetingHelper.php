<?php

namespace App\Helpers;

use Illuminate\Support\Carbon;

class DashboardGreetingHelper
{
    /**
     * Generate greeting message lengkap
     */
    public static function generateDailyGreeting($pengeluaranHariIni, $rataRataHarian, $saldoSaatIni)
    {
        // 1. Ambil Salam Waktu (Pagi/Siang/Sore/Malam)
        $timeGreeting = self::getTimeGreeting();

        // 2. Analisa Kebiasaan Belanja
        $spendingAnalysis = self::analyzeSpending($pengeluaranHariIni, $rataRataHarian, $saldoSaatIni);

        // 3. Hitung Persentase Realistis
        $persentase = 0;
        if ($rataRataHarian > 0) {
            $persentase = round(($pengeluaranHariIni / $rataRataHarian) * 100, 0);
        } elseif ($pengeluaranHariIni > 0) {
            $persentase = 100;
        }

        return array_merge($timeGreeting, $spendingAnalysis, [
            'pengeluaran_hari_ini' => $pengeluaranHariIni,
            'rata_rata' => $rataRataHarian,
            'tanggal' => now()->locale('id')->isoFormat('dddd, D MMMM Y'),
            'persentase_vs_rata' => $persentase
        ]);
    }

    /**
     * Logika Salam Waktu
     */
    private static function getTimeGreeting()
    {
        $jam = now()->hour;

        if ($jam >= 3 && $jam < 11) {
            return ['waktu' => 'Pagi', 'icon_waktu' => 'fa-cloud-sun', 'salam' => 'Selamat Pagi'];
        } elseif ($jam >= 11 && $jam < 15) {
            return ['waktu' => 'Siang', 'icon_waktu' => 'fa-sun', 'salam' => 'Selamat Siang'];
        } elseif ($jam >= 15 && $jam < 18) {
            return ['waktu' => 'Sore', 'icon_waktu' => 'fa-cloud-sun', 'salam' => 'Selamat Sore'];
        } else {
            return ['waktu' => 'Malam', 'icon_waktu' => 'fa-moon', 'salam' => 'Selamat Malam'];
        }
    }

    /**
     * Core Logic: Analisis Pengeluaran
     * REVISI WARNA: Menggunakan style Glassmorphism (Teks Putih) agar kontras di semua background.
     */
    private static function analyzeSpending($current, $average, $balance)
    {
        // KONDISI 1: Belum ada pengeluaran (Rp 0)
        if ($current == 0) {
            return [
                'tipe' => 'excellent',
                'icon' => 'fa-star',
                'color' => 'from-emerald-500 to-teal-600',
                // Ubah ke Putih Transparan (Glass Effect)
                'badge_color' => 'bg-white/20 text-white border-white/30 backdrop-blur-md',
                'badge_icon' => 'fa-solid fa-star',
                'icon_badge_color' => 'text-white', // Icon jadi putih
                'badge_text' => 'Zero Spending',
                'pesan' => self::getRandomMessage([
                    "Hari ini dompetmu aman terkendali. Belum ada pengeluaran sama sekali! 🛡️",
                    "Mode hemat aktif! Rp 0 keluar hari ini. Pertahankan! 💚",
                    "Start yang bagus, belum ada uang keluar hari ini. Keep it up! ✨"
                ])
            ];
        }

        // KONDISI KHUSUS: Building Data (Masalah yang kamu laporin)
        if ($average < 5000) {
            return [
                'tipe' => 'neutral',
                'icon' => 'fa-info-circle',
                'color' => 'from-blue-500 to-indigo-600',
                // FIX: Teks sekarang putih, background transparan. Pasti kelihatan.
                'badge_color' => 'bg-white/20 text-white border-white/30 backdrop-blur-md',
                'badge_icon' => 'fa-solid fa-chart-bar',
                'icon_badge_color' => 'text-white',
                'badge_text' => 'Building Data',
                'pesan' => "Sistem sedang mempelajari pola keuanganmu. Terus catat transaksimu ya! 📊"
            ];
        }

        $ratio = $current / $average;

        // KONDISI 2: Sangat Hemat
        if ($ratio <= 0.6) {
            return [
                'tipe' => 'great',
                'icon' => 'fa-thumbs-up',
                'color' => 'from-cyan-500 to-blue-600',
                'badge_color' => 'bg-white/20 text-white border-white/30 backdrop-blur-md',
                'badge_icon' => 'fa-solid fa-thumbs-up',
                'icon_badge_color' => 'text-white',
                'badge_text' => 'Sangat Hemat',
                'pesan' => self::getRandomMessage([
                    "Pengeluaranmu jauh di bawah rata-rata harian. Efisiensi tingkat tinggi! 📉",
                    "Keren! Hari ini kamu sangat irit. Tabungan aman sentosa. 👍",
                    "Good job! Spending hari ini sangat minimalis. 💙"
                ])
            ];
        }

        // KONDISI 3: Normal
        if ($ratio <= 1.15) {
            return [
                'tipe' => 'good',
                'icon' => 'fa-check-circle',
                'color' => 'from-indigo-500 to-violet-600',
                'badge_color' => 'bg-white/20 text-white border-white/30 backdrop-blur-md',
                'badge_icon' => 'fa-solid fa-check-circle',
                'icon_badge_color' => 'text-white',
                'badge_text' => 'Terkendali',
                'pesan' => self::getRandomMessage([
                    "Pengeluaranmu masih dalam batas wajar rata-rata harian. Lanjutkan! ✅",
                    "Semua terkendali. Pola belanja hari ini terlihat normal & sehat. 👌",
                    "Balance yang bagus. Tidak terlalu irit, tapi tidak boros juga. 💜"
                ])
            ];
        }

        // KONDISI 4: Warning
        if ($ratio <= 1.6) {
            return [
                'tipe' => 'warning',
                'icon' => 'fa-exclamation-circle',
                'color' => 'from-amber-500 to-orange-600',
                'badge_color' => 'bg-white/20 text-white border-white/30 backdrop-blur-md',
                'badge_icon' => 'fa-solid fa-exclamation-triangle',
                'icon_badge_color' => 'text-white',
                'badge_text' => 'Sedikit Boros',
                'pesan' => self::getRandomMessage([
                    "Sedikit melebihi rata-rata biasanya. Coba rem dikit untuk besok ya! ⚠️",
                    "Pengeluaran hari ini agak tinggi dari biasanya. Pastikan itu kebutuhan penting. 🤔",
                    "Warning ringan: Spending sudah di atas rata-rata harianmu. 📉"
                ])
            ];
        }

        // KONDISI 5: Bahaya
        $isSafeBalance = $balance > ($current * 20);

        return [
            'tipe' => 'danger',
            'icon' => 'fa-fire',
            'color' => 'from-rose-500 to-red-600',
            'badge_color' => 'bg-white/20 text-white border-white/30 backdrop-blur-md',
            'badge_icon' => 'fa-solid fa-fire-flame-curved',
            'icon_badge_color' => 'text-white',
            'badge_text' => 'High Spending',
            'pesan' => $isSafeBalance 
                ? "Pengeluaran hari ini melonjak tinggi! Untung saldomu masih aman, tapi tetap hati-hati. 💸"
                : "Alert! Pengeluaran hari ini sangat besar & tidak biasa. Segera evaluasi! 🚨"
        ];
    }

    public static function formatRupiah($angka)
    {
        return 'Rp' . number_format($angka, 0, ',', '.');
    }

    private static function getRandomMessage(array $messages)
    {
        return $messages[array_rand($messages)];
    }
}