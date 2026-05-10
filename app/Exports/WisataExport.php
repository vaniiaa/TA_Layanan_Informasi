<?php

namespace App\Exports;

use App\Models\WisataEdukasi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Carbon\Carbon;

class WisataExport implements
    FromCollection,
    WithHeadings,
    WithStyles,
    WithColumnWidths
{
    protected $bulan;
    protected $tahun;

    public function __construct($bulan, $tahun)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    public function collection()
    {
        $query = WisataEdukasi::with('sekolah');

        if ($this->bulan) {
            $query->whereMonth('created_at', (int) $this->bulan);
        }

        if ($this->tahun) {
            $query->whereYear('created_at', $this->tahun);
        }

        $no = 1;

        return $query->get()->map(function ($item) use (&$no) {
            return [
                $no++,
                $item->nama_lengkap,
                $item->sekolah->npsn ?? '-',
                $item->sekolah->nama_sekolah ?? '-',
                $item->sekolah->alamat ?? '-',
                $item->no_telp,
                Carbon::parse($item->tanggal_kegiatan)->format('d-m-Y'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama',
            'NPSN',
            'Nama Sekolah',
            'Alamat',
            'No Telp',
            'Tanggal Kegiatan',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 6,
            'B' => 25,
            'C' => 18,
            'D' => 30,
            'E' => 40,
            'F' => 18,
            'G' => 20,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $bulan = $this->bulan
            ? Carbon::createFromDate($this->tahun, (int)$this->bulan, 1)->translatedFormat('F')
            : 'SEMUA BULAN';

        $tahun = $this->tahun ?? '-';

        $sheet->insertNewRowBefore(1, 3);
        $sheet->mergeCells('A1:G1');
        $sheet->mergeCells('A2:G2');

        $sheet->setCellValue('A1', 'LAPORAN PERMOHONAN WISATA EDUKASI');
        $sheet->setCellValue('A2', "BULAN " . strtoupper($bulan) . " TAHUN {$tahun}");

        $sheet->getStyle('A1:A2')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 14,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        $highestRow = $sheet->getHighestRow();

        $sheet->getStyle('A4:G4')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => 'D9EAF7',
                ],
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ]);

        $sheet->getStyle("A5:G{$highestRow}")->applyFromArray([
            'alignment' => [
                'wrapText' => true,
                'vertical' => Alignment::VERTICAL_TOP,
            ],
        ]);

        $sheet->getStyle("A5:A{$highestRow}")
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        for ($row = 5; $row <= $highestRow; $row++) {
            $sheet->getRowDimension($row)->setRowHeight(-1);
        }

        $sheet->getStyle("A4:G{$highestRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ]);
    }
}