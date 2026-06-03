<?php

include_once("config.php");
requireLogin();

// Pastikan ada ID di URL
if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit();
}

$id = (int)$_GET["id"];

// Ambil data mahasiswa yang akan diedit
$result = mysqli_query($conn, "SELECT * FROM mahasiswa WHERE id = $id");
if (mysqli_num_rows($result) == 0) {
    header('Location: index.php');
    exit();
}

$row = mysqli_fetch_assoc($result);
$current_foto = $row["foto"];

if (isset($_POST['update'])) {
    $nim = mysqli_real_escape_string($conn, $_POST['nim']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $jurusan = mysqli_real_escape_string($conn, $_POST['jurusan']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);

    $errors = [];
    $foto_filename = $current_foto; // default: pertahankan foto lama

    // Validasi field wajib
    if (empty($nim)) {
        $errors[] = 'NIM tidak boleh kosong';
    } else {
        if (!preg_match('/^[0-9]+$/', $nim)) {
            $errors[] = 'NIM hanya boleh berisi angka';
        }
        if (strlen($nim) < 8 || strlen($nim) > 12) {
            $errors[] = 'Panjang NIM harus 8 sampai 12 digit';
        }
    }
    if (empty($nama)) {
        $errors[] = 'Nama tidak boleh kosong';
    }
    if (empty($jurusan)) {
        $errors[] = 'Jurusan tidak boleh kosong';
    }
    if (empty($email)) {
        $errors[] = 'Email tidak boleh kosong';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Format email tidak valid';
    }

    // Proses upload foto BARU jika ada
    if (!empty($_FILES['foto']['name'])) {
        $upload = uploadFile($_FILES['foto']);
        if ($upload['success']) {
            if ($current_foto) {
                deleteFile($current_foto);
            }
            $foto_filename = $upload['filename'];
        } else {
            $errors[] = $upload['message'];
        }
    }

    // Hapus foto jika user centang opsi hapus foto
    if (isset($_POST['hapus_foto']) && $_POST['hapus_foto'] == '1') {
        if ($current_foto) {
            deleteFile($current_foto);
        }
        $foto_filename = null;
    }

    if (empty($errors)) {
        $foto_sql = $foto_filename ? "'$foto_filename'" : 'NULL';
        $sql = "UPDATE mahasiswa SET
                nim = '$nim', nama = '$nama', jurusan = '$jurusan',
                email = '$email', alamat = '$alamat', foto = $foto_sql
                WHERE id = $id";
        if (mysqli_query($conn, $sql)) {
            $success = 'Data berhasil diperbarui!';
        } else {
            $errors[] = 'Error: ' . mysqli_error($conn);
        }
    }
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Mahasiswa</title>
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background-color: #f4f6f9; margin: 0; padding: 40px 20px; }
        .card { background: #fff; max-width: 600px; margin: auto; padding: 30px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        h2 { margin-top: 0; color: #333; border-bottom: 2px solid #eee; padding-bottom: 10px; }
        .form-group { margin-bottom: 18px; }
        label { display: block; margin-bottom: 6px; font-weight: 600; color: #444; font-size: 14px; }
        input[type="text"], input[type="email"], textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; font-size: 14px; }
        textarea { height: 80px; resize: vertical; }
        .required { color: red; }
        .error-box { background: #f8d7da; color: #721c24; padding: 12px; border-radius: 4px; margin-bottom: 20px; font-size: 14px; }
        .current-photo-container { display: flex; align-items: center; gap: 15px; background: #f8f9fa; padding: 10px; border-radius: 4px; border: 1px dashed #ccc; margin-bottom: 10px; }
        .current-photo { width: 60px; height: 60px; border-radius: 4px; object-fit: cover; }
        .action-buttons { display: flex; gap: 10px; margin-top: 25px; }
        .btn { padding: 10px 20px; border-radius: 4px; border: none; font-size: 15px; cursor: pointer; text-decoration: none; text-align: center; }
        .btn-primary { background: #007bff; color: white; }
        .btn-secondary { background: #6c757d; color: white; }
    </style>
</head>
<body>
    <div class="card">
        <h2>Edit Data Mahasiswa</h2>
        <?php if (!empty($errors)): ?>
            <div class="error-box">
                <?php foreach($errors as $error) echo "• $error<br>"; ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Foto Saat Ini</label>
                <?php if ($current_foto): ?>
                    <div class="current-photo-container">
                        <img src="uploads/mahasiswa/<?= htmlspecialchars($current_foto) ?>" class="current-photo">
                        <label style="font-weight: normal; font-size: 13px; cursor: pointer;">
                            <input type="checkbox" name="hapus_foto" value="1"> Hapus foto saat ini
                        </label>
                    </div>
                <?php else: ?>
                    <p style="margin: 0 0 10px 0; font-size: 13px; color: #999;">Belum ada foto.</p>
                <?php endif; ?>
                <label>Ganti/Upload Foto Baru</label>
                <input type="file" name="foto" accept="image/*">
            </div>
            <div class="form-group">
                <label>NIM <span class="required">*</span></label>
                <input type="text" name="nim" required value="<?= htmlspecialchars($row['nim']) ?>">
            </div>
            <div class="form-group">
                <label>Nama Lengkap <span class="required">*</span></label>
                <input type="text" name="nama" required value="<?= htmlspecialchars($row['nama']) ?>">
            </div>
            <div class="form-group">
                <label>Jurusan <span class="required">*</span></label>
                <input type="text" name="jurusan" required value="<?= htmlspecialchars($row['jurusan']) ?>">
            </div>
            <div class="form-group">
                <label>Email <span class="required">*</span></label>
                <input type="email" name="email" required value="<?= htmlspecialchars($row['email']) ?>">
            </div>
            <div class="form-group">
                <label>Alamat</label>
                <textarea name="alamat"><?= htmlspecialchars($row['alamat']) ?></textarea>
            </div>
            <div class="action-buttons">
                <button type="submit" name="update" class="btn btn-primary">Perbarui Data</button>
                <a href="index.php" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</body>
</html>