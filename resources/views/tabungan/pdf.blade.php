<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Keuangan</title>
    <style>
        /* CSS untuk tampilan laporan yang lebih profesional */
        :root {
            --primary-color: #4F46E5; /* Indigo */
            --secondary-color: #4B5563; /* Gray */
            --green-color: #10B981; /* Emerald */
            --red-color: #EF4444; /* Red */
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 12px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 25px;
        }
        .header h1 {
            color: var(--primary-color);
            margin: 0;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
            font-size: 14px;
            color: var(--secondary-color);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table thead th {
            background-color: var(--primary-color);
            color: white;
            padding: 10px;
            text-align: left;
            font-weight: bold;
        }
        table tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        table td {
            border: 1px solid #e9ecef;
            padding: 8px 10px;
        }
        .text-pemasukan {
            color: var(--green-color);
            font-weight: bold;
        }
        .text-pengeluaran {
            color: var(--red-color);
            font-weight: bold;
        }
        .summary-box {
            border: 2px solid #e9ecef;
            padding: 15px;
            width: 40%;
            margin-left: auto; /* Posisikan ke kanan */
            background: #f8f9fa;
            border-radius: 8px;
        }
        .summary-box table {
            width: 100%;
            border: none;
        }
        .summary-box td {
            border: none;
            padding: 5px 0;
        }
        .summary-box .total {
            font-weight: bold;
            border-top: 2px solid #dee2e6;
            padding-top: 10px;
            margin-top: 5px;
        }
        .footer {
            position: fixed;
            bottom: -30px;
            left: 0;
            right: 0;
            height: 50px;
            font-size: 10px;
            text-align: center;
            color: var(--secondary-color);
        }
        .page-number:before {
            content: "Halaman " counter(page);
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Laporan Keuangan</h1>
        <p>Ringkasan transaksi berdasarkan filter yang dipilih.</p>
        @if(!empty($filters['tanggal_mulai']) && !empty($filters['tanggal_selesai']))
            <p><strong>Periode:</strong> {{ \Carbon\Carbon::parse($filters['tanggal_mulai'])->isoFormat('D MMMM Y') }} - {{ \Carbon\Carbon::parse($filters['tanggal_selesai'])->isoFormat('D MMMM Y') }}</p>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Kategori</th>
                <th>Keterangan</th>
                <th>Pemasukan (Rp)</th>
                <th>Pengeluaran (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->created_at->isoFormat('D MMM Y') }}</td>
                    <td>{{ $item->kategoriNama->nama ?? 'N/A' }}</td>
                    <td>{{ $item->keterangan }}</td>
                    @if($item->kategoriJenis->jenis === 'Pemasukan')
                        <td class="text-pemasukan">{{ number_format($item->nominal, 0, ',', '.') }}</td>
                        <td>-</td>
                    @else
                        <td>-</td>
                        <td class="text-pengeluaran">{{ number_format($item->nominal, 0, ',', '.') }}</td>
                    @endif
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center;">Tidak ada data untuk periode ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="summary-box">
        <table>
            <tr>
                <td>Total Pemasukan</td>
                <td style="text-align: right;" class="text-pemasukan">Rp{{ number_format($totalPemasukan, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Total Pengeluaran</td>
                <td style="text-align: right;" class="text-pengeluaran">Rp{{ number_format($totalPengeluaran, 0, ',', '.') }}</td>
            </tr>
            <tr class="total">
                <td>SALDO AKHIR</td>
                <td style="text-align: right;">Rp{{ number_format($saldoAkhir, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>
    
    <div class="footer">
        Dicetak pada: {{ now()->isoFormat('D MMMM Y, HH:mm') }} | <span class="page-number"></span>
    </div>

</body>
</html>