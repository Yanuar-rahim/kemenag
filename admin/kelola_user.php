<?php
session_start();
include "../config/koneksi.php";

// Proteksi admin
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

// Ambil keyword pencarian
$cari_user = $_GET['cari_user'] ?? '';

// Query user dengan pencarian
$user = mysqli_query($koneksi, "
    SELECT * FROM users
    WHERE role='user' 
      AND (nama LIKE '%$cari_user%' 
        OR username LIKE '%$cari_user%' 
        OR email LIKE '%$cari_user%')
    ORDER BY id DESC
");

// Hitung total user
$total_user = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM users WHERE role='user'"));
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola User | Admin Kemenag Baubau</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
    <link rel="stylesheet" href="../assets/css/index.css">
</head>
<body>

<div class="dashboard">

    <?php include "../includes/sidebar.php"; ?>

    <main class="content" style="margin-top:20px;">
        <h2 style="text-align: left;">Kelola User</h2>
        <p>Total User: <?= $total_user ?></p>

        <div class="header-tabel" style="margin-bottom:10px;">
            <form method="get">
                <input type="text" name="cari_user" placeholder="Cari user..." value="<?= htmlspecialchars($cari_user) ?>">
                <button type="submit" class="button">Cari</button>
            </form>
            <button type="button" onclick="window.location.href='kelola_user.php';" class="button">Reset</button>
        </div>

        <table style="width:100%; margin-bottom:20px;">
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Username</th>
                <th>Email</th>
                <th>NIK</th>
                <th>Alamat</th>
                <th>No HP</th>
                <th>Aksi</th>
            </tr>
            <?php if(mysqli_num_rows($user) > 0): ?>
            <?php $no=1; while($u=mysqli_fetch_assoc($user)): ?>
            <tr>
                <td style="text-align:center;"><?= $no++ ?></td>
                <td><?= $u['nama'] ?></td>
                <td><?= $u['username'] ?></td>
                <td><?= substr($u['email'],0, 4) ?>****@gmail.com</td>
                <td><?= substr($u['nik'], 0, 4) ?>****</td>
                <td><?= $u['alamat'] ?></td>
                <td><?= $u['no_hp'] ?></td>
                <td style="text-align:center; width: 150px;">
                    <a href="edit_user.php?id=<?= $u['id'] ?>">Edit</a> |
                    <a href="hapus_user.php?id=<?= $u['id'] ?>" onclick="return confirm('Hapus user ini?')">Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
            <?php else: ?>
            <tr>
                <td colspan="8" style="text-align:center;">Tidak ada user ditemukan</td>
            </tr>
            <?php endif; ?>
        </table>
    </main>

</div>

</body>
</html>
