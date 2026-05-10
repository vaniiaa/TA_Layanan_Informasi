<?php

namespace App\Exports;

use App\Models\PendaftaranTAT;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Carbon\Carbon;

class PendaftaranTATExport implements
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

        return PendaftaranTAT::when($this->bulan, function ($q) {
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
                    $item->nik,
                    $item->nama_tersangka,
                    $item->nama_lengkap,
                    $item->alamat,
                    $item->instansi,
                    $item->nama_penyidik,
                    $item->wa_penyidik,
                    Carbon::parse($item->tanggal_surat_pengajuan)->format('d-m-Y'),
                    Carbon::parse($item->tanggal_lp)->format('d-m-Y'),
                    Carbon::parse($item->tanggal_penangkapan)->format('d-m-Y'),
                    is_array($item->barang_bukti)
                        ? implode(', ', $item->barang_bukti)
                        : '-',
                    $item->berat_barang_bukti ?? '-',
                    is_array($item->hasil_urine)
                        ? implode(', ', $item->hasil_urine)
                        : '-',
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
            'NIK',
            'Nama Tersangka',
            'Nama Pemohon',
            'Alamat',
            'Instansi',
            'Nama Penyidik',
            'WA Penyidik',
            'Tanggal Surat Pengajuan',
            'Tanggal LP',
            'Tanggal Penangkapan',
            'Barang Bukti',
            'Berat Barang Bukti',
            'Hasil Tes Urine',
        ];
    }

    /**
     * ================= LEBAR KOLOM =================
     */
    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 20,
            'C' => 25,
            'D' => 25,
            'E' => 40,
            'F' => 25,
            'G' => 25,
            'H' => 18,
            'I' => 22,
            'J' => 18,
            'K' => 22,
            'L' => 35,
            'M' => 20,
            'N' => 30,
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

        // Merge sesuai jumlah kolom (A:N)
        $sheet->mergeCells('A1:N1');
        $sheet->mergeCells('A2:N2');

        $sheet->setCellValue('A1', 'LAPORAN PENDAFTARAN ASSESSMENT TERPADU (TAT)');
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
        $sheet->getStyle('A4:N4')->applyFromArray([
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

        $sheet->getStyle("A5:N{$highestRow}")->applyFromArray([
            'alignment' => [
                'wrapText'   => true,
                'vertical'   => Alignment::VERTICAL_TOP,
                'horizontal' => Alignment::HORIZONTAL_JUSTIFY,
            ],
        ]);

        $sheet->getStyle("A5:A{$highestRow}")
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->getStyle("B5:B{$highestRow}")
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        for ($row = 5; $row <= $highestRow; $row++) {
            $sheet->getRowDimension($row)->setRowHeight(-1);
        }

        $sheet->getStyle("A4:N{$highestRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ]);
    }
}