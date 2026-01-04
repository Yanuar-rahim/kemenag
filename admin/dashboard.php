<?php
session_start();
include "../config/koneksi.php";

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}
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
    <main class="content">
        <h2>Selamat Datang, <?= $_SESSION['nama']; ?></h2>
        <p>Dashboard Administrator Sistem Informasi Kementerian Agama Kota Baubau</p>

        <div class="stats">
            <div class="stat-card">
                <h4>Total User</h4>
                <p>0</p>
            </div>
            <div class="stat-card">
                <h4>Total Admin</h4>
                <p>0</p>
            </div>
            <div class="stat-card">
                <h4>Layanan Aktif</h4>
                <p>0</p>
            </div>
            <div class="stat-card">
                <h4>Pengajuan Masuk</h4>
                <p>0</p>
            </div>
        </div>
    </main>
</div>

</body>
</html>
