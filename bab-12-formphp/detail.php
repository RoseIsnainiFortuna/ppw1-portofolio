<?php

include_once("config.php");
requireLogin();

// Pastikan ada parameter ID di URL
if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit();
}

$id = (int)$_GET['id'];

// Ambil data mahasiswa berdasarkan ID
$query = "SELECT * FROM mahasiswa WHERE id = $id";
$result = mysqli_query($conn, $query);

// Jika data tidak ditemukan, kembalikan ke halaman utama
if (mysqli_num_rows($result) == 0) {
    $_SESSION['error'] = "Data mahasiswa tidak ditemukan.";
    header('Location: index.php');
    exit();
}

$row = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Mahasiswa - <?= htmlspecialchars($row['nama']) ?></title>
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background-color: #f4f6f9; margin: 0; padding: 40px 20px; }
        .card { background: #fff; max-width: 650px; margin: auto; padding: 30px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        h2 { margin-top: 0; color: #333; border-bottom: 2px solid #eee; padding-bottom: 10px; text-align: center; }
        
        .detail-container { display: flex; flex-direction: column; align-items: center; gap: 25px; margin-top: 20px; }
        @media (min-width: 500px) {
            .detail-container { flex-direction: row; align-items: flex-start; }
        }

        .photo-section { flex: 1; text-align: center; }
        .big-photo { width: 220px; height: 220px; border-radius: 8px; object-fit: cover; box-shadow: 0 4px 10px rgba(0,0,0,0.15); border: 3px solid #fff; }
        .no-big-photo { width: 220px; height: 220px; border-radius: 8px; background: #e9ecef; display: flex; align-items: center; justify-content: center; font-size: 14px; color: #888; border: 2px dashed #ccc; margin: auto; }
        
        .info-section { flex: 2; width: 100%; }
        table { width: 100%; border-collapse: collapse; }
        td { padding: 10px; border-bottom: 1px solid #f1f1f1; vertical-align: top; font-size: 15px; }
        td.label { font-weight: 600; color: #555; width: 35%; }
        td.value { color: #333; }
        
        .action-buttons { display: flex; justify-content: flex-end; gap: 10px; margin-top: 30px; border-top: 2px solid #eee; padding-top: 20px; }
        .btn { padding: 10px 20px; border-radius: 4px; border: none; font-size: 14px; cursor: pointer; text-decoration: none; text-align: center; font-weight: 500; }
        .btn-secondary { background: #6c757d; color: white; }
        .btn-warning { background: #ffc107; color: #212529; }
        .btn-secondary:hover { background: #5a6268; }
        .btn-warning:hover { background: #e0a96d; }
    </style>
</head>
<body>

    <div class="card">
        <h2>Detail Data Mahasiswa</h2>
        
        <div class="detail-container">
            <div class="photo-section">
                <?php if ($row['foto']): ?>
                    <img src="uploads/mahasiswa/<?= htmlspecialchars($row['foto']) ?>" class="big-photo" alt="Foto Besar">
                <?php else: ?>
                    <div class="no-big-photo">Tidak Ada Foto</div>
                <?php endif; ?>
            </div>
            
            <div class="info-section">
                <table>
                    <tr>
                        <td class="label">NIM</td>
                        <td class="value"><?= htmlspecialchars($row['nim']) ?></td>
                    </tr>
                    <tr>
                        <td class="label">Nama Lengkap</td>
                        <td class="value"><?= htmlspecialchars($row['nama']) ?></td>
                    </tr>
                    <tr>
                        <td class="label">Jurusan</td>
                        <td class="value"><?= htmlspecialchars($row['jurusan']) ?></td>
                    </tr>
                    <tr>
                        <td class="label">Email</td>
                        <td class="value"><?= htmlspecialchars($row['email']) ?></td>
                    </tr>
                    <tr>
                        <td class="label">Alamat</td>
                        <td class="value"><?= !empty($row['alamat']) ? nl2br(htmlspecialchars($row['alamat'])) : '<em style="color:#aaa;">Belum diisi</em>' ?></td>
                    </tr>
                    <tr>
                        <td class="label">Tanggal Daftar</td>
                        <td class="value">
                            <?php 
                            // Menampilkan tanggal jika field created_at/reg_date tersedia di database Anda
                            echo isset($row['created_at']) ? date('d F Y, H:i', strtotime($row['created_at'])) : date('d F Y'); 
                            ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        
        <div class="action-buttons">
            <a href="index.php" class="btn btn-secondary">← Kembali</a>
            <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-warning">Edit Data</a>
        </div>
    </div>

</body>
</html>