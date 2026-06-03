<?php

include_once("config.php");
requireLogin();

if (isset($_POST['submit'])) {
    // Ambil dan escape data
    $nim = mysqli_real_escape_string($conn, $_POST['nim']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $jurusan = mysqli_real_escape_string($conn, $_POST['jurusan']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);

    $errors = [];
    $foto_filename = null;

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

    // Cek NIM sudah terdaftar
    $chk = mysqli_query($conn, "SELECT nim FROM mahasiswa WHERE nim = '$nim'");
    if (mysqli_num_rows($chk) > 0) {
        $errors[] = 'NIM sudah terdaftar';
    }

    // Proses upload foto (opsional)
    if (!empty($_FILES['foto']['name'])) {
        $upload = uploadFile($_FILES['foto']);
        if ($upload['success']) {
            $foto_filename = $upload['filename'];
        } else {
            $errors[] = $upload['message'];
        }
    }

    // Jika valid, simpan ke database
    if (empty($errors)) {
        $foto_sql = $foto_filename ? "'$foto_filename'" : 'NULL';
        $sql = "INSERT INTO mahasiswa (nim, nama, jurusan, email, alamat, foto)
                VALUES ('$nim','$nama','$jurusan','$email','$alamat',$foto_sql)";
        if (mysqli_query($conn, $sql)) {
            $_SESSION['message'] = 'Data berhasil ditambahkan!';
            header('Location: index.php');
            exit();
        } else {
            $errors[] = 'Error: ' . mysqli_error($conn);
            if ($foto_filename) {
                deleteFile($foto_filename);
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Mahasiswa</title>
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
        .action-buttons { display: flex; gap: 10px; margin-top: 25px; }
        .btn { padding: 10px 20px; border-radius: 4px; border: none; font-size: 15px; cursor: pointer; text-decoration: none; text-align: center; }
        .btn-success { background: #28a745; color: white; }
        .btn-secondary { background: #6c757d; color: white; }
    </style>
</head>
<body>
    <div class="card">
        <h2>Tambah Data Mahasiswa</h2>
        <?php if (!empty($errors)): ?>
            <div class="error-box">
                <?php foreach($errors as $error) echo "• $error<br>"; ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Foto Mahasiswa</label>
                <input type="file" name="foto" accept="image/*">
                <p style="margin: 5px 0 0 0; font-size: 12px; color: #888;">Format: JPG, PNG, GIF | Maks: 5MB</p>
            </div>
            <div class="form-group">
                <label>NIM <span class="required">*</span></label>
                <input type="text" name="nim" required value="<?= isset($_POST['nim']) ? htmlspecialchars($_POST['nim']) : '' ?>">
            </div>
            <div class="form-group">
                <label>Nama Lengkap <span class="required">*</span></label>
                <input type="text" name="nama" required value="<?= isset($_POST['nama']) ? htmlspecialchars($_POST['nama']) : '' ?>">
            </div>
            <div class="form-group">
                <label>Jurusan <span class="required">*</span></label>
                <input type="text" name="jurusan" required value="<?= isset($_POST['jurusan']) ? htmlspecialchars($_POST['jurusan']) : '' ?>">
            </div>
            <div class="form-group">
                <label>Email <span class="required">*</span></label>
                <input type="email" name="email" required value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">
            </div>
            <div class="form-group">
                <label>Alamat</label>
                <textarea name="alamat"><?= isset($_POST["alamat"]) ? htmlspecialchars($_POST["alamat"]) : "" ?></textarea>
            </div>
            <div class="action-buttons">
                <button type="submit" name="submit" class="btn btn-success">Simpan Data</button>
                <a href="index.php" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>
</body>
</html>