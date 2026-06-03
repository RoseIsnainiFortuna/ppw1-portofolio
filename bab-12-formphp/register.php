<?php

include_once("config.php");

// Jika sudah login, langsung ke index
if (isLoggedIn()) {
    header('Location: index.php');
    exit();
}

$errors = [];

if (isset($_POST['register'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];

    // Validasi input
    if (empty($username)) {
        $errors[] = 'Username tidak boleh kosong';
    }
    if (empty($email)) {
        $errors[] = 'Email tidak boleh kosong';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Format email tidak valid';
    }
    if (empty($full_name)) {
        $errors[] = 'Nama lengkap tidak boleh kosong';
    }
    if (strlen($password) < 6) {
        $errors[] = 'Password minimal 6 karakter';
    }
    if ($password !== $confirm) {
        $errors[] = 'Konfirmasi password tidak cocok';
    }

    // Cek apakah username/email sudah terdaftar
    $check = mysqli_query($conn, "SELECT id FROM users WHERE username = '$username' OR email = '$email'");
    if (mysqli_num_rows($check) > 0) {
        $errors[] = 'Username atau email sudah terdaftar';
    }

    if (empty($errors)) {
        // Hash password sebelum disimpan
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username, email, full_name, password)
                VALUES ('$username','$email','$full_name','$hashed')";
        if (mysqli_query($conn, $sql)) {
            $success = 'Registrasi berhasil! Silakan login.';
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
    <title>Daftar Akun Baru</title>
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background-color: #f4f6f9; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .card { background: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); width: 100%; max-width: 400px; box-sizing: border-box; }
        h2 { text-align: center; color: #333; margin-bottom: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; color: #666; font-size: 14px; }
        input { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; font-size: 14px; }
        button { width: 100%; padding: 10px; background: #007bff; border: none; color: white; border-radius: 4px; font-size: 16px; cursor: pointer; transition: 0.2s; }
        button:hover { background: #0056b3; }
        .error-box { background: #f8d7da; color: #721c24; padding: 10px; border-radius: 4px; margin-bottom: 15px; font-size: 14px; }
        p { text-align: center; font-size: 14px; color: #666; }
        a { color: #007bff; text-decoration: none; }
    </style>
</head>
<body>
    <div class="card">
        <h2>Register</h2>
        <?php if (!empty($errors)): ?>
            <div class="error-box">
                <?php foreach($errors as $error) echo "• $error<br>"; ?>
            </div>
        <?php endif; ?>
        <form action="" method="POST">
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="full_name" value="<?= isset($_POST['full_name']) ? htmlspecialchars($_POST['full_name']) : '' ?>">
            </div>
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password">
            </div>
            <div class="form-group">
                <label>Konfirmasi Password</label>
                <input type="password" name="confirm_password">
            </div>
            <button type="submit" name="register">Daftar Akun</button>
        </form>
        <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
    </div>
</body>
</html>