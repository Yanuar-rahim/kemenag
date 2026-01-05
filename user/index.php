<?php
session_start();
include "../config/koneksi.php";

// Proteksi user
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'user') {
    header("Location: ../index.php");
    exit;
}

$sql = mysqli_query($koneksi, "SELECT * FROM layanan");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Beranda User | Kemenag Baubau</title>
    <link rel="stylesheet" href="../assets/css/index.css">
</head>

<body>

    <?php include "../includes/header.php"; ?>

    <?php if (isset($_SESSION['login_success'])): ?>
        <script>
            alert("Login berhasil! Selamat datang, <?= $_SESSION['nama']; ?>");
        </script>
        <?php unset($_SESSION['login_success']); endif; ?>

    <section class="hero">
        <h2>Selamat Datang di Sistem Informasi Kemenag Baubau</h2>
        <p>
            Sistem ini digunakan untuk mengakses layanan dan informasi
            Kementerian Agama Kota Baubau secara online.
        </p>
        <a href="ajukan_layanan.php">Ajukan Layanan</a>
    </section>

    <div class="container">
        <div class="section-title">
            <h3>Layanan Tersedia</h3>
        </div>

        <div class="card-wrapper">
            <?php if (mysqli_num_rows($sql) > 0): ?>
                <?php while ($row = mysqli_fetch_array($sql)): ?>
                    <div class="card">
                        <h4><?= $row['nama_layanan']; ?></h4>
                        <p><?= $row['deskripsi']; ?></p>
                    </div>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </div>

    <?php include "../includes/footer.php"; ?>

</body>

</html>