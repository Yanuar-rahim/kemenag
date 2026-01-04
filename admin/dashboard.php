<?php
session_start();
include "../config/koneksi.php";

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

$cari_layanan   = $_GET['cari_layanan'] ?? '';

$layanan = mysqli_query($koneksi, "
    SELECT * FROM layanan
    WHERE nama_layanan LIKE '%$cari_layanan%'
       OR status LIKE '%$cari_layanan%'
    ORDER BY id DESC
");

$user = mysqli_query($koneksi,"SELECT * FROM users WHERE role = 'user'");
$total_user = mysqli_num_rows($user);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin | Kemenag Baubau</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
    <link rel="stylesheet" href="../assets/css/index.css">
</head>
<body>

<?php if (isset($_SESSION['login_success'])) : ?>
<script>
    alert("Login berhasil sebagai ADMIN. Selamat datang, <?= $_SESSION['nama']; ?>");
</script>
<?php unset($_SESSION['login_success']); endif; ?>


<div class="dashboard">
    
    <?php include "../includes/sidebar.php"; ?>

    <!-- CONTENT -->
    <main class="content" style="margin-top: 20px;">
        <h2 style="text-align: left;">Selamat Datang, <?= $_SESSION['nama']; ?></h2>
        <p>Dashboard Administrator Sistem Informasi Kementerian Agama Kota Baubau</p>

        <div class="stats">
            <div class="stat-card">
                <h4>Total User</h4>
                <p><?= $total_user; ?></p>
            </div>
            <div class="stat-card">
                <h4>Berita & Pengumuman</h4>
                <p><?= $total_pengumuman; ?></p>
            </div>
            <div class="stat-card">
                <h4>Layanan Aktif</h4>
                <p><?= $total_layanan; ?></p>
            </div>
            <div class="stat-card">
                <h4>Pengajuan Masuk</h4>
                <p><?= $total_pengajuan; ?></p>
            </div>
        </div>

        <div class="header-tabel">
             <h2>Daftar Layanan</h2>
     
             <form method="get">
                 <input type="text" name="cari_layanan" placeholder="Cari layanan..."
                        value="<?= $cari_layanan ?>">
                 <button type="submit" class="button">Cari</button>
                 <button onclick="window.history.back();" class="button">Reset</button>
             </form>
         </div>

        <table style="margin-bottom: 20px;">
            <tr>
                <th>No</th>
                <th>Nama Layanan</th>
                <th>Deskripsi</th>
                <th>Status</th>
            </tr>
            <?php $no=1; while($l=mysqli_fetch_assoc($layanan)): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $l['nama_layanan'] ?></td>
                <td><?= $l['deskripsi'] ?></td>
                <td style="text-align: center;"><?= $l['status'] ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </main>
</div>

</body>
</html>
