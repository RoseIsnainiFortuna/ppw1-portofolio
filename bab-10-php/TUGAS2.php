<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hitung Indeks Massa Tubuh (IMT)</title>
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            align-items: center;
            display: flex;
            justify-content: center;
        }
        .container {
            width: 90%;             /* Mengambil 90% lebar layar pada perangkat kecil */
            max-width: 450px;       /* Batas lebar maksimal kotak pada layar besar */
            min-width: 320px;       /* KUNCI: Mencegah kotak menyusut menjadi terlalu kecil */
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            
        }
        h2 {
            color: #333;
            border-bottom: 2px solid #3498db;
            padding-bottom: 8px;
        }
        .result-box {
            margin-top: 20px;
            padding: 15px;
            background-color: #e8f4fd;
            border-left: 5px solid #3498db;
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
    <h2>Kalkulator IMT</h2>

    <?php
    // 1. Definisikan fungsi hitungIMT
    function hitungIMT($berat, $tinggi) {
        // Mengubah tinggi dari cm ke meter
        $tinggiMeter = $tinggi / 100;
        
        // Rumus IMT = berat (kg) / (tinggi (m) * tinggi (m))
        $imt = $berat / ($tinggiMeter * $tinggiMeter);
        
        // Menentukan kategori berdasarkan nilai IMT
        if ($imt < 18.5) {
            $kategori = 'Kurus';
        } elseif ($imt >= 18.5 && $imt < 25) {
            $kategori = 'Normal';
        } elseif ($imt >= 25 && $imt < 30) {
            $kategori = 'Gemuk';
        } else {
            $kategori = 'Obesitas';
        }
        
        // Mengembalikan data dalam bentuk array (nilai IMT dan kategorinya)
        return [
            'nilai' => round($imt, 2),
            'kategori' => $kategori
        ];
    }

    // 2. Data Uji Coba (Silakan ubah nilai berat dan tinggi ini sesuai kebutuhan)
    $beratBadan = 60;   // dalam satuan kilogram (kg)
    $tinggiBadan = 165; // dalam satuan sentimeter (cm)

    // 3. Memanggil fungsi
    $hasil = hitungIMT($beratBadan, $tinggiBadan);
    ?>

    <div class="result-box">
        <p>Berat Badan: <span class="highlight"><?= $beratBadan; ?> kg</span></p>
        <p>Tinggi Badan: <span class="highlight"><?= $tinggiBadan; ?> cm</span></p>
        <hr>
        <p>Nilai IMT Anda: <span class="highlight"><?= $hasil['nilai']; ?></span></p>
        <p>Kategori: <span class="highlight" style="color: #e74c3c;"><?= $hasil['kategori']; ?></span></p>
    </div>
</div>

</body>
</html>