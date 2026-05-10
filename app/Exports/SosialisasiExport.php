<?php

namespace App\Exports;

use App\Models\SosialisasiNarkoba;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Carbon\Carbon;

class SosialisasiExport implements
    FromCollection,
    WithHeadings,
    WithStyles,
    WithColumnWidths
{
    protected $bulan;
    protected $tahun;

    public function __construct($bulan = null, $tahun = null)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    /**
     * ================= DATA =================
     */
    public function collection()
    {
        $no = 1;

        return SosialisasiNarkoba::when($this->bulan, function ($q) {
                $q->whereMonth('created_at', (int) $this->bulan);
            })
            ->when($this->tahun, function ($q) {
                $q->whereYear('created_at', (int) $this->tahun);
            })
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($item) use (&$no) {
                return [
                    $no++,
                    $item->nama_lengkap,
                    $item->instansi,
                    $item->alamat,
                    $item->no_hp,
                    $item->nama_kegiatan,
                    $item->waktu_kegiatan,
                    Carbon::parse($item->tanggal_kegiatan)->format('d-m-Y'),
                    $item->lokasi,
                    $item->peserta,
                    $item->jumlah_peserta,
                ];
            });
    }

    /**
     * ================= HEADER =================
     */
    public function headings(): array
    {
        return [
            'No',
            'Nama Lengkap',
            'Instansi / Organisasi',
            'Alamat',
            'No HP / WA',
            'Nama Kegiatan',
            'Waktu Kegiatan',
            'Tanggal Kegiatan',
            'Lokasi Kegiatan',
            'Peserta Kegiatan',
            'Jumlah Peserta',
        ];
    }

    /**
     * ================= LEBAR KOLOM =================
     */
    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 25,
            'C' => 28,
            'D' => 40,
            'E' => 18,
            'F' => 30,
            'G' => 18,
            'H' => 18,
            'I' => 30,
            'J' => 25,
            'K' => 18,
        ];
    }

    /**
     * ================= STYLE =================
     */
    public function styles(Worksheet $sheet)
    {
        $bulan = $this->bulan
            ? Carbon::create()->month((int) $this->bulan)->translatedFormat('F')
            : '-';

        $tahun = $this->tahun ?? '-';

        // Tambah baris judul
        $sheet->insertNewRowBefore(1, 3);

        // Merge sesuai jumlah kolom (A:K)
        $sheet->mergeCells('A1:K1');
        $sheet->mergeCells('A2:K2');

        $sheet->setCellValue('A1', 'LAPORAN PERMOHONAN SOSIALISASI');
        $sheet->setCellValue('A2', "BULAN " . strtoupper($bulan) . " TAHUN {$tahun}");

        $sheet->getStyle('A1:A2')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 14,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER,
            ],
        ]);

        $highestRow = $sheet->getHighestRow();

        /**
         * HEADER TABEL
         */
        $sheet->getStyle('A4:K4')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => '000000'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER,
                'wrapText'   => true,
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

        $sheet->getStyle("A5:K{$highestRow}")->applyFromArray([
            'alignment' => [
                'wrapText'   => true,
                'vertical'   => Alignment::VERTICAL_TOP,
                'horizontal' => Alignment::HORIZONTAL_JUSTIFY,
            ],
        ]);

        $sheet->getStyle("A5:A{$highestRow}")
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->getStyle("K5:K{$highestRow}")
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        for ($row = 5; $row <= $highestRow; $row++) {
            $sheet->getRowDimension($row)->setRowHeight(-1);
        }

        $sheet->getStyle("A4:K{$highestRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ]);
    }
}