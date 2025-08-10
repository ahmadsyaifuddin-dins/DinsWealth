<?php

namespace App\Helpers;

use Illuminate\Support\Carbon;

class DashboardGreetingHelper
{
    /**
     * Generate greeting message berdasarkan pengeluaran harian
     */
    public static function generateDailyGreeting($pengeluaranHariIni, $rataRataHarian, $saldoSaatIni)
    {
        $timeGreeting = self::getTimeGreeting();
        $spendingAnalysis = self::analyzeSpending($pengeluaranHariIni, $rataRataHarian, $saldoSaatIni);
        
        return array_merge($timeGreeting, $spendingAnalysis, [
            'pengeluaran_hari_ini' => $pengeluaranHariIni,
            'rata_rata' => $rataRataHarian,
            'tanggal' => now()->locale('id')->isoFormat('dddd, D MMMM Y'),
            'persentase_vs_rata' => $rataRataHarian > 0 ? round(($pengeluaranHariIni / $rataRataHarian) * 100, 1) : 0
        ]);
    }
    
    /**
     * Dapatkan greeting berdasarkan waktu
     */
    private static function getTimeGreeting()
    {
        $waktu = now()->hour;
        
        if ($waktu >= 5 && $waktu < 11) {
            return [
                'waktu' => 'Pagi',
                'icon_waktu' => 'fa-sun',
                'salam' => 'Selamat Pagi'
            ];
        } elseif ($waktu >= 11 && $waktu < 15) {
            return [
                'waktu' => 'Siang',
                'icon_waktu' => 'fa-sun',
                'salam' => 'Selamat Siang'
            ];
        } elseif ($waktu >= 15 && $waktu < 18) {
            return [
                'waktu' => 'Sore',
                'icon_waktu' => 'fa-cloud-sun',
                'salam' => 'Selamat Sore'
            ];
        } else {
            return [
                'waktu' => 'Malam',
                'icon_waktu' => 'fa-moon',
                'salam' => 'Selamat Malam'
            ];
        }
    }
    
    /**
     * Analisis pengeluaran dan generate pesan
     */
    private static function analyzeSpending($pengeluaranHariIni, $rataRataHarian, $saldoSaatIni)
    {
        // Kondisi: Zero Spending
        if ($pengeluaranHariIni == 0) {
            return [
                'tipe' => 'excellent',
                'icon' => 'fa-star',
                'color' => 'from-green-500 to-emerald-600',
                'gradient_text' => 'from-green-600 to-emerald-700',
                'status' => 'Zero Spending',
                'badge_color' => 'bg-green-500/20 text-green-100 border-green-400/30',
                'badge_icon' => 'fa-solid fa-star',
                'icon_badge_color' => 'text-green-500',
                'badge_text' => 'Excellent Control',
                'pesan' => self::getRandomMessage([
                    "Luar biasa! Hari ini kamu belum mengeluarkan uang sama sekali. Pertahankan kebiasaan hemat ini! 💚",
                    "Hebat! Zero spending hari ini. Tabunganmu pasti berterima kasih! ⭐",
                    "Amazing! Kamu berhasil tidak mengeluarkan uang hari ini. Keep it up! 🌟"
                ])
            ];
        }
        
        // Kondisi: Very Low Spending (≤ 50% dari rata-rata)
        if ($pengeluaranHariIni <= $rataRataHarian * 0.5) {
            return [
                'tipe' => 'great',
                'icon' => 'fa-thumbs-up',
                'color' => 'from-blue-500 to-cyan-600',
                'gradient_text' => 'from-blue-600 to-cyan-700',
                'status' => 'Low Spending',
                'badge_color' => 'bg-blue-500/20 text-blue-100 border-blue-400/30',
                'badge_icon' => 'fa-solid fa-thumbs-up',
                'icon_badge_color' => 'text-white',
                'badge_text' => 'Great Management',
                'pesan' => self::getRandomMessage([
                    "Bagus! Pengeluaran hari ini jauh di bawah rata-rata. Kamu hebat dalam mengatur keuangan! 👍",
                    "Keren! Spending hari ini sangat terkontrol. Financial discipline yang patut dicontoh! 💙",
                    "Well done! Pengeluaran minimal hari ini. Tabungan goals semakin dekat! 🎯"
                ])
            ];
        }
        
        // Kondisi: Normal Spending (≤ 100% dari rata-rata)
        if ($pengeluaranHariIni <= $rataRataHarian) {
            return [
                'tipe' => 'good',
                'icon' => 'fa-check-circle',
                'color' => 'from-indigo-500 to-purple-600',
                'gradient_text' => 'from-indigo-600 to-purple-700',
                'status' => 'Normal Spending',
                'badge_color' => 'bg-purple-500/20 text-purple-100 border-purple-400/30',
                'badge_icon' => 'fa-solid fa-check-circle',
                'icon_badge_color' => 'text-white',
                'badge_text' => 'Good Balance',
                'pesan' => self::getRandomMessage([
                    "Good job! Pengeluaran masih dalam batas normal. Keep spending wisely! ✅",
                    "Nice! Kamu berhasil menjaga pengeluaran dalam rata-rata harian. Solid! 💜",
                    "Steady! Pengeluaran terkendali hari ini. Konsistensi adalah kunci! 🔑"
                ])
            ];
        }
        
        // Kondisi: High Spending (≤ 150% dari rata-rata)
        if ($pengeluaranHariIni <= $rataRataHarian * 1.5) {
            return [
                'tipe' => 'warning',
                'icon' => 'fa-exclamation-triangle',
                'color' => 'from-yellow-500 to-orange-500',
                'gradient_text' => 'from-yellow-600 to-orange-600',
                'status' => 'Above Average',
                'badge_color' => 'bg-yellow-500/20 text-yellow-100 border-yellow-400/30',
                'badge_icon' => 'fa-solid fa-exclamation-triangle',
                'icon_badge_color' => 'text-white',
                'badge_text' => 'Watch Spending',
                'pesan' => self::getRandomMessage([
                    "Hmm, pengeluaran hari ini agak tinggi. Coba review lagi ya, masih ada yang bisa dihemat? 🤔",
                    "Spending alert! Hari ini agak boros. Tomorrow let's be more mindful! ⚠️",
                    "Pengeluaran di atas rata-rata nih. Yuk, evaluasi dan planning yang lebih baik! 📋"
                ])
            ];
        }
        
        // Kondisi: Very High Spending (> 150% dari rata-rata)
        $isLowBalance = $saldoSaatIni < $pengeluaranHariIni * 10;
        
        return [
            'tipe' => 'alert',
            'icon' => 'fa-fire',
            'color' => 'from-red-500 to-pink-600',
            'gradient_text' => 'from-red-600 to-pink-700',
            'status' => $isLowBalance ? 'Critical Alert' : 'High Spending',
            'badge_color' => 'bg-red-500/20 text-red-100 border-red-400/30',
            'badge_icon' => 'fa-solid fa-fire',
            'icon_badge_color' => 'text-white',
            'badge_text' => 'High Alert',
            'pesan' => self::getRandomMessage($isLowBalance ? [
                "Whoa! Pengeluaran hari ini sangat tinggi dan saldo mulai tipis. Time to budget more carefully! 🚨",
                "Red alert! Spending tinggi + saldo terbatas. Saatnya super hemat mode ON! 🔥",
                "Critical! Pengeluaran besar hari ini. Please consider your financial limits! ⛔"
            ] : [
                "Wah, pengeluaran hari ini lumayan besar! Pastikan semuanya untuk kebutuhan penting ya! 🔥",
                "Big spending day! Semoga semuanya worth it. Tomorrow let's be more conservative! 💸",
                "Pengeluaran tinggi detected! Review dan pastikan semuanya necessary spending! 📊"
            ])
        ];
    }
    
    /**
     * Pilih pesan random dari array
     */
    private static function getRandomMessage(array $messages)
    {
        return $messages[array_rand($messages)];
    }
    
    /**
     * Format mata uang Indonesia
     */
    public static function formatRupiah($amount)
    {
        return 'Rp' . number_format($amount, 0, ',', '.');
    }
    
    /**
     * Get spending comparison text
     */
    public static function getSpendingComparison($current, $average)
    {
        if ($average == 0) return 'Tidak ada data pembanding';
        
        $percentage = ($current / $average) * 100;
        
        if ($percentage <= 50) return "Hemat " . round(100 - $percentage, 1) . "% dari rata-rata";
        if ($percentage <= 100) return "Normal, " . round($percentage, 1) . "% dari rata-rata";
        
        return "Lebih tinggi " . round($percentage - 100, 1) . "% dari rata-rata";
    }
}