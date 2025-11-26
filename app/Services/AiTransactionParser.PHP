<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class AiTransactionParser
{
    protected $apiKey;
    protected $model;
    protected $baseUrl;

    public function __construct()
    {
        // Pakai Key khusus Quick Capture, atau fallback ke key utama
        $this->apiKey = env('GROQ_API_KEY_QUICK', env('OPENAI_API_KEY'));
        $this->model = env('OPENAI_MODEL', 'llama-3.3-70b-versatile');
        $this->baseUrl = env('OPENAI_BASE_URL', 'https://api.groq.com/openai/v1/chat/completions');
    }

    public function parseText($inputText)
    {
        $prompt = "
        Kamu adalah AI Parser canggih untuk keuangan pribadi.
        
        Input Teks: '{$inputText}'

        Tugasmu:
        1. Deteksi item/keterangan transaksi. 
           - PENTING: Jika ada keterangan TEMPAT atau LOKASI (contoh: 'di Indomaret', 'di Pal 25', 'sama si A'), JANGAN DIBUANG. Masukkan itu ke dalam 'keterangan'.
              Contoh salah: 'Ayam Kentucky'.
              Contoh benar: 'Ayam Kentucky di Pal 25'.
           - PENTING: Jika ada keterangan JUMLAH/KUANTITAS (5pcs, 2kg, 1 liter, 2x) -> JANGAN DIBUANG. Masukkan detail itu ke dalam 'keterangan'.
           
        2. Deteksi nominal uang (bisa format: 15k, 15rb, 15.000, 15000). Ubah jadi integer murni.
        
        3. Deteksi jenisnya (Pemasukan/Pengeluaran).
           - Kata kunci Pemasukan: gajian, dapat, nemu, dikasih, cair, tf dari, terima bayaran, bayaran joki, terima bayaran joki, diberi, membari, minta, bari.
           - Defaultnya adalah Pengeluaran.

        Format Output WAJIB JSON MURNI (Array of Objects):
        [
            {
                \"keterangan\": \"Nama Item + Lokasi (jika ada)\",
                \"nominal\": 15000,
                \"jenis\": \"Pengeluaran\" 
            }
        ]
        
        Contoh Input: 'Beli ayam kentucky 9000 di pal 25, terus beli minuman 4000'
        Contoh Output: [{\"keterangan\":\"Beli Ayam Kentucky di Pal 25\",\"nominal\":9000,\"jenis\":\"Pengeluaran\"},{\"keterangan\":\"Beli Minuman\",\"nominal\":4000,\"jenis\":\"Pengeluaran\"}]
        ";

        try {
            $response = Http::timeout(15)
                ->withToken($this->apiKey)
                ->post($this->baseUrl, [
                    'model' => $this->model,
                    'messages' => [
                        ['role' => 'system', 'content' => 'You are a JSON extractor that preserves location context.'],
                        ['role' => 'user', 'content' => $prompt],
                    ],
                    'temperature' => 0.1, // Tetap rendah agar format konsisten
                    'response_format' => ['type' => 'json_object']
            ]);

            if ($response->successful()) {
                $content = $response->json()['choices'][0]['message']['content'];
                $cleanContent = str_replace(['```json', '```'], '', $content);
                $data = json_decode($cleanContent, true);
                
                // --- SMART UNWRAPPING LOGIC ---
                if (!is_array($data)) return [];

                // KASUS 1: Array Langsung (Ideal) -> [ {...}, {...} ]
                if (isset($data[0]['nominal'])) {
                    return $data;
                }

                // KASUS 2: Object Tunggal -> { "nominal": 20000, ... }
                // AI kadang lupa bungkus array kalau datanya cuma satu
                if (isset($data['nominal'])) {
                    return [$data]; // Kita bungkus manual jadi array
                }

                // KASUS 3: Terbungkus Key -> { "transactions": [ ... ] }
                foreach ($data as $key => $value) {
                    if (is_array($value) && !empty($value) && isset($value[0]['nominal'])) {
                        return $value;
                    }
                }

                // Fallback manual
                if (isset($data['transactions'])) return $data['transactions'];
                if (isset($data['items'])) return $data['items'];
                
                return []; 
            }
            
            return [];
        } catch (\Exception $e) {
            return [];
        }
    }
}