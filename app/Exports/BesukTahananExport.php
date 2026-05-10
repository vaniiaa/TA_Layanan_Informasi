<?php

namespace App\Exports;

use App\Models\BesukTahanan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Carbon\Carbon;

class BesukTahananExport implements
    FromCollection,
    WithHeadings,
    WithStyles,
    WithColumnWidths
{
    protected $bulan;
    protected $tahun;

    public function __construct($bulan, $tahun = null)
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

        return BesukTahanan::with('tahanan')
            ->when($this->bulan, function ($q) {
                $q->whereMonth('created_at', (int) $this->bulan);
            })
            ->when($this->tahun, function ($q) {
                $q->whereYear('created_at', (int) $this->tahun);
            })
            ->get()
            ->map(function ($item) use (&$no) {
                return [
                    $no++,
                    $item->tahanan->nomor_tahanan ?? '-',
                    $item->nama_tahanan,
                    Carbon::parse($item->tanggal_kedatangan)->format('d-m-Y'),
                    $item->hari_kunjungan,
                    Carbon::parse($item->jam_masuk)->format('H:i'),
                    $item->nama_pembesuk,
                    $item->alamat_pembesuk,
                    $item->no_hp,
                    $item->self_assessment,
                    $item->hubungan,
                    $item->barang ?? '-',
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
            'Nomor Tahanan',
            'Nama Tahanan',
            'Tanggal Besuk',
            'Hari Kunjungan',
            'Jam Masuk',
            'Nama Pembesuk',
            'Alamat Pembesuk',
            'No Telp',
            'Self Assessment',
            'Hubungan',
            'Barang yang Dibawa',
        ];
    }

    /**
     * ================= LEBAR KOLOM =================
     */
    public function columnWidths(): array
    {
        return [
            'A' => 6,
            'B' => 18,
            'C' => 25,
            'D' => 18,
            'E' => 18,
            'F' => 15,
            'G' => 25,
            'H' => 35,
            'I' => 18,
            'J' => 20,
            'K' => 18,
            'L' => 30,
        ];
    }

    /**
     * ================= STYLE =================
     */
    public function styles(Worksheet $sheet)
    {
        $bulan = $this->bulan
            ? Carbon::create()->month((int)$this->bulan)->translatedFormat('F')
            : 'SEMUA BULAN';

        $tahun = $this->tahun ?? '-';

        $sheet->insertNewRowBefore(1, 3);

        $sheet->mergeCells('A1:L1');
        $sheet->mergeCells('A2:L2');

        $sheet->setCellValue('A1', 'LAPORAN PENDAFTARAN BESUK TAHANAN');
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
         * Header tabel
         */
        $sheet->getStyle('A4:L4')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER,
                'wrapText'   => true,
            ],
            'fill' => [
                'fillType'   => Fill::FILL_SOLID,
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

        $sheet->getStyle("A5:L{$highestRow}")->applyFromArray([
            'alignment' => [
                'wrapText'   => true,
                'vertical'   => Alignment::VERTICAL_TOP,
            ],
        ]);

        $sheet->getStyle("A5:A{$highestRow}")
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        for ($row = 5; $row <= $highestRow; $row++) {
            $sheet->getRowDimension($row)->setRowHeight(-1);
        }

        $sheet->getStyle("A4:L{$highestRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ]);
    }
}