<?php

namespace App\Exports;

use App\Models\Tabungan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

// PERBAIKAN: Gunakan 'ShouldAutoSize' bukan 'WithAutoSize'
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class TabunganExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    WithStyles,
    WithColumnFormatting,
    ShouldAutoSize // PERBAIKAN: Ganti di sini
{
    protected $data;
    protected $totalPemasukan;
    protected $totalPengeluaran;

    public function __construct($data)
    {
        $this->data = $data;
        $this->totalPemasukan = $this->data->where('kategoriJenis.jenis', 'Pemasukan')->sum('nominal');
        $this->totalPengeluaran = $this->data->where('kategoriJenis.jenis', 'Pengeluaran')->sum('nominal');
    }

    public function collection()
    {
        $exportData = clone $this->data;

        if ($exportData->isNotEmpty()) {
            $exportData->push(['']);
            $exportData->push(['']);
            $exportData->push(['', '', 'Total Pemasukan:', $this->totalPemasukan]);
            $exportData->push(['', '', 'Total Pengeluaran:', $this->totalPengeluaran]);
            $exportData->push(['', '', 'Saldo Akhir:', $this->totalPemasukan - $this->totalPengeluaran]);
        }
        
        return $exportData;
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Kategori',
            'Jenis',
            'Nominal',
            'Keterangan',
        ];
    }

    public function map($row): array
    {
        if (!$row instanceof Tabungan) {
            return $row;
        }

        return [
            $row->created_at->format('d-m-Y'),
            $row->kategoriNama->nama ?? 'N/A',
            $row->kategoriJenis->jenis ?? 'N/A',
            $row->nominal,
            $row->keterangan,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'D' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Style untuk header (Baris 1)
        $sheet->getStyle('1')->getFont()->setBold(true);
        $sheet->getStyle('A1:E1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('4F46E5');
        $sheet->getStyle('A1:E1')->getFont()->getColor()->setARGB('FFFFFF');

        // Style untuk baris summary jika ada data
        if ($this->data->isNotEmpty()) {
            $lastRow = $sheet->getHighestRow();
            $summaryStartRow = $lastRow - 2;
            
            $sheet->getStyle("C{$summaryStartRow}:D{$lastRow}")->getFont()->setBold(true);
            $sheet->getStyle("C" . ($lastRow))->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('E0E7FF');
        }
    }
}