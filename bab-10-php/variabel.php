<?php
    // ── TIPE DATA DASAR ──────────────────────────────────────
    $nama = "Budi Santoso"; // String
    $umur = 21; // Integer
    $ipk = 3.75; // Float
    $lulus = true; // Boolean
    $kosong = null; // Null

// Cek tipe data dengan gettype()
    echo gettype($nama); // string
    echo("<br>");
    echo gettype($umur); // integer
    echo("<br>");
    echo gettype($ipk); // double
    echo("<br>");

// ── STRING FUNCTIONS ─────────────────────────────────────
    echo strlen($nama); // 12 — panjang string
    echo("<br>"); // untuk buat baris baru di HTML
    echo strtoupper($nama); // BUDI SANTOSO
    echo("<br>");
    echo strtolower($nama); // budi santoso
    echo("<br>");
    echo str_replace("Budi", "Andi", $nama); // Andi Santoso
    echo("<br>");
    echo substr($nama, 0, 4); // Budi — ambil 4 karakter
    echo("<br>");
    echo trim(" spasi "); // "spasi" — hapus spasi tepi
    echo("<br>");
    echo str_contains($nama, "Budi"); // true — PHP 8+
    echo("<br>");


// ── CONCATENATION ────────────────────────────────────────
    echo "Nama: " . $nama . ", Umur: " . $umur; // dengan titik
    echo("<br>");
    echo "Nama: $nama, Umur: $umur"; // interpolasi string
    echo("<br>");
    echo "IPK: {$ipk}"; // variabel kompleks pakai{}
?>
