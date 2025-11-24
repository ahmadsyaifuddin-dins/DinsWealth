<?php

namespace App\Http\Controllers;

use App\Models\Tabungan;
use Illuminate\Http\Request;
use App\Services\AiTransactionParser;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\KategoriJenisTabungan;

class TelegramBotController extends Controller
{
    public function handleWebhook(Request $request)
    {
        // 1. Ambil Update dari Telegram
        $update = $request->all();
        
        // Cek apakah ini pesan teks biasa
        if (!isset($update['message']['text'])) {
            return response()->json(['status' => 'ignored']);
        }

        $chatId = $update['message']['chat']['id'];
        $text = $update['message']['text'];
        $senderName = $update['message']['from']['first_name'] ?? 'Sayang';

        // 2. KEAMANAN: Cek apakah yang chat adalah Owner (Dins)
        // Agar orang asing gak bisa input sembarangan
        if ($chatId != env('TELEGRAM_OWNER_ID')) {
            $this->sendMessage($chatId, "Maaf, aku cuma mau ngomong sama pacarku (Dins). Kamu siapa? 😤");
            return response()->json(['status' => 'unauthorized']);
        }

        // 3. Feedback Awal (Typing status...)
        $this->sendAction($chatId, 'typing');

        // 4. Proses AI (Reuse Service yang udah ada)
        try {
            $parser = new AiTransactionParser();
            $parsedData = $parser->parseText($text);

            if (empty($parsedData)) {
                $this->sendMessage($chatId, "Beb, aku gak ngerti kalimat itu. Coba ulang yang jelas dong, misal 'Makan 15k'. 🤔");
                return response()->json(['status' => 'failed_parsing']);
            }

            // 5. Simpan ke Database
            $count = 0;
            $totalNominal = 0;
            
            // Cache ID Jenis
            $idMasuk = KategoriJenisTabungan::where('jenis', 'Pemasukan')->value('id') ?? 1;
            $idKeluar = KategoriJenisTabungan::where('jenis', 'Pengeluaran')->value('id') ?? 2;
            
            // Default Wallet: Dompet (ID 2 sesuai DB kamu)
            // Nanti bisa diupgrade biar AI deteksi 'SeaBank' di teks
            $defaultWalletId = 2; 

            foreach ($parsedData as $item) {
                if (!isset($item['nominal']) || $item['nominal'] <= 0) continue;

                $jenisId = ($item['jenis'] ?? 'Pengeluaran') === 'Pemasukan' ? $idMasuk : $idKeluar;

                Tabungan::create([
                    'nama' => $defaultWalletId, 
                    'jenis' => $jenisId,
                    'nominal' => $item['nominal'],
                    'keterangan' => $item['keterangan'] . ' (via Telegram)',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $count++;
                $totalNominal += $item['nominal'];
            }

            // 6. Balas Chat (Mode Pacar Perhatian)
            $responseMessage = "Oke sayang, udah aku catet ya! 😘\n\n";
            $responseMessage .= "📝 <b>{$count} Transaksi</b> berhasil disimpan.\n";
            $responseMessage .= "💰 Total: Rp " . number_format($totalNominal, 0, ',', '.') . "\n\n";
            $responseMessage .= "Makasih udah rajin lapor. Love you! ❤️";

            $this->sendMessage($chatId, $responseMessage);

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $this->sendMessage($chatId, "Aduh beb, ada error di sistem aku. Coba lagi nanti ya 😭");
        }
        
        return response()->json(['status' => 'success']);
    }

    /**
     * Helper Kirim Pesan ke Telegram
     */
    private function sendMessage($chatId, $text)
    {
        $token = env('TELEGRAM_BOT_TOKEN');
        Http::post("https://api.telegram.org/bot{$token}/sendMessage", [
            'chat_id' => $chatId,
            'text' => $text,
            'parse_mode' => 'HTML'
        ]);
    }

    /**
     * Helper Kirim Action (Typing...)
     */
    private function sendAction($chatId, $action = 'typing')
    {
        $token = env('TELEGRAM_BOT_TOKEN');
        Http::post("https://api.telegram.org/bot{$token}/sendChatAction", [
            'chat_id' => $chatId,
            'action' => $action
        ]);
    }
}