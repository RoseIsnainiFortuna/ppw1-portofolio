<?php

include_once("config.php");
requireLogin();

// ============================================================
// KONFIGURASI PAGINATION
// ============================================================
$limit = 5; // jumlah data per halaman
$page = isset($_GET["page"]) ? (int)$_GET["page"] : 1;
$offset = ($page - 1) * $limit;

// ============================================================
// KONFIGURASI SEARCH
// ============================================================
$search = isset($_GET["search"]) ? mysqli_real_escape_string($conn, $_GET["search"]) : "";
$where = "";

if (!empty($search)) {
    $where = "WHERE nim LIKE '%$search%'
            OR nama LIKE '%$search%'
            OR jurusan LIKE '%$search%'
            OR email LIKE '%$search%'";
}

// Hitung total data (untuk pagination)
$count_result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM mahasiswa $where");
$total_data = mysqli_fetch_assoc($count_result)["total"];
$total_pages = ceil($total_data / $limit);

// Ambil data sesuai halaman aktif
$query = "SELECT * FROM mahasiswa $where ORDER BY id DESC LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Mahasiswa</title>
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background-color: #f4f6f9; margin: 0; padding: 20px; }
        .container { max-width: 1000px; background: #fff; margin: auto; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .header { display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #eee; padding-bottom: 15px; margin-bottom: 20px; }
        .header h2 { margin: 0; color: #333; }
        .user-info { font-size: 14px; color: #666; }
.btn {
    padding: 6px 12px;
    border-radius: 4px;
    text-decoration: none;
    font-size: 13px;
    cursor: pointer;
    display: inline-block;
    box-sizing: border-box;
}
        .btn-primary { background: #007bff; color: white; }
        .btn-warning { background: #ffc107; color: #212529; }
        .btn-danger { background: #dc3545; color: white; }
        .btn-logout { background: #6c757d; color: white; margin-left: 10px; }
        .search-container { margin-bottom: 20px; display: flex; justify-content: space-between; }
        .search-container input { width: 70%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; }
        .search-container button { width: 25%; background: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; background: #fff; }
        th, td { border: 1px solid #eee; padding: 12px; text-align: left; }
        th { background-color: #f8f9fa; color: #555; }
        .photo { width: 50px; height: 50px; border-radius: 50%; object-fit: cover; }
        .no-photo { width: 50px; height: 50px; border-radius: 50%; background: #e9ecef; display: flex; align-items: center; justify-content: center; font-size: 11px; color: #888; }
        .pagination { display: flex; justify-content: center; margin-top: 25px; gap: 5px; }
        .pagination a { padding: 8px 12px; border: 1px solid #ddd; text-decoration: none; border-radius: 4px; color: #333; font-size: 14px; }
        .pagination a.current { background: #007bff; color: white; border-color: #007bff; }
        .alert { padding: 10px; border-radius: 4px; margin-bottom: 15px; font-size: 14px; }
        .alert-success { background: #d4edda; color: #155724; }
    </style>
</head>
<body>

<div class="container">
    
    <div class="header">
        <h2>Sistem Manajemen Mahasiswa</h2>
        <div class="user-info">
            Halo, <strong><?= htmlspecialchars($_SESSION['full_name']) ?></strong>
            <a href="logout.php" class="btn btn-logout" onclick="return confirm('Yakin ingin log out?')">Logout</a>
        </div>
    </div>

    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-success">
            <?php echo $_SESSION['message']; unset($_SESSION['message']); ?>
        </div>
    <?php endif; ?>

    <div class="search-container">
        <a href="tambah.php" class="btn btn-primary">+ Tambah Mahasiswa</a>
        <form action="" method="GET" style="width: 50%; display: flex; gap: 5px;">
            <input type="text" name="search" placeholder="Cari berdasarkan NIM, Nama, Jurusan..." value="<?= htmlspecialchars($search) ?>">
            <button type="submit">Cari</button>
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>Foto</th>
                <th>NIM</th>
                <th>Nama</th>
                <th>Jurusan</th>
                <th>Email</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td>
                            <?php if ($row['foto']): ?>
                                <img src="uploads/mahasiswa/<?= htmlspecialchars($row["foto"]) ?>" class="photo" alt="Foto">
                            <?php else: ?>
                                <div class="no-photo">N/A</div>
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($row['nim']) ?></td>
                        <td><?= htmlspecialchars($row['nama']) ?></td>
                        <td><?= htmlspecialchars($row['jurusan']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td style="min-width: 220px; white-space: nowrap; text-align: center; vertical-align: middle;">
                            <div style="display: block; text-align: center;">
                            <a href="detail.php?id=<?= $row['id'] ?>" class="btn btn-primary" style="background: #17a2b8; color: white; margin-right: 4px; display: inline-block;">Detail</a>
                            <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-warning" style="margin-right: 4px; display: inline-block;">Edit</a>
                            <a href="hapus.php?id=<?= $row['id'] ?>" onclick="return confirm('Yakin hapus data ini?')" class="btn btn-danger" style="display: inline-block;">Hapus</a>
                            </div>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" style="text-align: center; color: #999;">Tidak ada data ditemukan.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <?php if ($total_pages > 1): ?>
        <div class="pagination">
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="?page=<?= $i ?>&search=<?= urlencode($search) ?>" class="<?= $i == $page ? 'current' : '' ?>">
                    <?= $i ?>
                </a>
            <?php endfor; ?>
        </div>
    <?php endif; ?>
</div>

</body>
</html>