{{-- resources/views/user/p2m/bukti_pdf.blade.php --}}
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Bukti Pendaftaran Sosialisasi</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 30px;
            background: #f9fafb;
        }

        .container {
            border: 2px solid #022D57;
            border-radius: 10px;
            padding: 20px;
            background-color: #fff;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #022D57;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .header h2 {
            color: #022D57;
            margin: 0;
        }

        .info {
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .footer {
            border-top: 1px dashed #999;
            text-align: center;
            padding-top: 10px;
            font-size: 12px;
            color: #555;
        }

        .thank {
            text-align: center;
            font-weight: bold;
            color: #022D57;
            margin-top: 10px;
        }

    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>BNNP KEPULAUAN RIAU</h2>
            <p><strong>Bukti Pendaftaran Permohonan Sosialisasi Narkoba</strong></p>
        </div>

        <div class="info">
            <p><strong>Nama Pemohon:</strong> {{ $nama }}</p>
            <p><strong>Tanggal Pendaftaran:</strong> {{ $tanggal }}</p>
            <p><strong>Status:</strong> Pendaftaran berhasil diterima oleh sistem.</p>
        </div>

        <div class="thank">
            <p>Terima kasih telah berpartisipasi dalam program Sosialisasi Anti Narkoba.</p>
            <p><em>"War On Drugs!"</em></p>
        </div>

        <div class="footer">
            Dicetak otomatis oleh sistem BNNP Kepulauan Riau. Tidak memerlukan tanda tangan resmi.
        </div>
    </div>
</body>

</html>
