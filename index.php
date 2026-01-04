<?php 
include "config/koneksi.php";
$sql = mysqli_query($koneksi, "SELECT * FROM layanan");
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda | Kementerian Agama Kota Baubau</title>
    <link rel="stylesheet" href="assets/css/index.css">
</head>

<body>
    <span id="home"></span>
    <?php include "includes/header_index.php"; ?>

    <section class="hero">
        <h2>Sistem Informasi Kementerian Agama Kota Baubau</h2>
        <p>
            Website resmi pelayanan dan informasi keagamaan Kementerian Agama Kota Baubau
            yang terintegrasi, transparan, dan mudah diakses oleh masyarakat.
        </p>
        <a href="register.php">Ajukan Layanan</a>
        <span id="layanan"></span>
    </section>

    <div class="container">
        <div class="section-title">
            <h3>Layanan Unggulan</h3>
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
        <span id="tentang"></span>

        <div class="info">
            <h3>Tentang Sistem</h3>
            <p>
                Sistem Informasi Kementerian Agama Kota Baubau berbasis web ini dirancang
                untuk meningkatkan kualitas pelayanan publik, mempercepat proses administrasi,
                serta memberikan akses informasi yang akurat kepada masyarakat.
            </p>
        </div>
    </div>

    <?php include "includes/footer.php"; ?>

</body>

</html>