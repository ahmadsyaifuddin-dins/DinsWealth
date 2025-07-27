<?php

namespace App\Exports;

use App\Models\Tabungan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TabunganExport implements FromCollection, WithHeadings, WithMapping
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->data;
    }

    /**
    * @return array
    */
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

    /**
    * @param mixed $tabungan
    *
    * @return array
    */
    public function map($tabungan): array
    {
        return [
            $tabungan->created_at->format('d-m-Y'),
            $tabungan->kategoriNama->nama ?? 'N/A',
            $tabungan->kategoriJenis->jenis ?? 'N/A',
            $tabungan->nominal,
            $tabungan->keterangan,
        ];
    }
}