<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informasi Bulan dan Sisa Hari</title>
    <style>
        /* Mengatur halaman agar memenuhi seluruh tinggi layar */
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        /* Mengaktifkan Flexbox untuk memosisikan kontainer tepat di tengah */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center; /* Mengetengahkan secara horizontal */
            align-items: center;     /* Mengetengahkan secara vertikal */
        }

        .container {
            width: 90%;             /* Mengambil 90% lebar layar pada perangkat kecil */
            max-width: 450px;       /* Batas lebar maksimal kotak pada layar besar */
            min-width: 320px;       /* Mencegah kotak menyusut menjadi terlalu kecil */
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            box-sizing: border-box;
        }

        h2 {
            color: #333;
            border-bottom: 2px solid #2ecc71; /* Menggunakan warna hijau agar beda dari Tugas 2 */
            padding-bottom: 8px;
            margin-top: 0;
        }

        .result-box {
            margin-top: 20px;
            padding: 15px;
            background-color: #eafaf1;
            border-left: 5px solid #2ecc71;
            border-radius: 4px;
        }

        .highlight {
            font-weight: bold;
            color: #2c3e50;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Informasi Bulan</h2>

    <?php
    // Set timezone ke Waktu Indonesia Barat (WIB) agar akurat
    date_default_timezone_set('Asia/Jakarta');

    // 1. Mendapatkan nama bulan sekarang dalam bahasa Indonesia
    // Kita gunakan array lokal karena date("F") bawaan PHP menghasilkan bahasa Inggris
    $daftarBulan = [
        1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];
    $angkaBulan = date('n'); // Mengambil angka bulan sekarang (1-12)
    $bulanSekarang = $daftarBulan[$angkaBulan];

    // 2. Menghitung sisa hari di bulan ini
    $tanggalSekarang = date('j'); // Tanggal hari ini (1-31)
    $totalHariBulanIni = date('t'); // Total jumlah hari di bulan ini (28-31)
    
    $sisaHari = $totalHariBulanIni - $tanggalSekarang;
    ?>

    <div class="result-box">
        <p>Bulan Sekarang: <span class="highlight"><?= $bulanSekarang; ?></span></p>
        <p>Tanggal Hari Ini: <span class="highlight"><?= date('d/m/Y'); ?></span></p>
        <hr style="border: 0; border-top: 1px solid #d5dbdb;">
        <p>Total Hari Bulan Ini: <span class="highlight"><?= $totalHariBulanIni; ?> hari</span></p>
        <p>Sisa Hari Tersisa: <span class="highlight" style="color: #27ae60;"><?= $sisaHari; ?> hari lagi</span></p>
    </div>
</div>

</body>
</html>