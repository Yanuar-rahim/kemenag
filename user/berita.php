<?php
session_start();
include "../config/koneksi.php";

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'user') {
    header("Location: ../index.php");
    exit;
}

// Ambil data berita
$cari_berita = $_GET['cari_berita'] ?? '';
$berita = mysqli_query($koneksi, "
    SELECT * FROM berita
    WHERE judul LIKE '%$cari_berita%'
    ORDER BY tanggal DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Berita & Pengumuman | Kemenag Baubau</title>
    <link rel="stylesheet" href="../assets/css/index.css">
</head>
<body>
    <?php include "../includes/header.php"; ?>

    <main class="container" style="margin-top: 60px; padding: 20px;">
        <h2>Berita & Pengumuman</h2>

        <!-- Cari Berita -->
        <div class="header-tabel">
            <form method="get">
                <input type="text" name="cari_berita" placeholder="Cari berita..."
                    value="<?= $cari_berita ?>">
                <button type="submit" class="button">Cari</button>
            </form>
        </div>

        <!-- Tabel Daftar Berita -->
        <div class="berita-list">
            <?php while ($b = mysqli_fetch_assoc($berita)): ?>
            <div class="berita-item">
                <div class="berita-gambar">
                    <?php if ($b['gambar']): ?>
                    <img src="../uploads/<?= $b['gambar'] ?>" width="100" height="75" alt="Gambar Berita">
                    <?php else: ?>
                    <p>Tidak ada gambar</p>
                    <?php endif; ?>
                </div>
                <h3><?= $b['judul'] ?></h3>
                <p><small>Posted on <?= date('d-m-Y', strtotime($b['tanggal'])) ?></small></p>
                <p><?= substr($b['konten'], 0, 150) ?>...</p>
                <a href="detail_berita.php?id=<?= $b['id'] ?>" class="button">Baca Selengkapnya</a>
            </div>
            <?php endwhile; ?>
        </div>

    </main>

    <?php include "../includes/footer.php"; ?>
</body>
</html>
