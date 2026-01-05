<?php
session_start();
include "../config/koneksi.php";

// Proteksi user
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'user') {
    header("Location: ../index.php");
    exit;
}

// Ambil data berita berdasarkan ID
$id = $_GET['id'] ?? '';
$berita = mysqli_query($koneksi, "SELECT * FROM berita WHERE id='$id'");
$berita_detail = mysqli_fetch_assoc($berita);

// Jika berita tidak ditemukan
if (!$berita_detail) {
    echo "<script>alert('Berita tidak ditemukan'); window.location.href='berita_pengumuman.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Berita | Kemenag Baubau</title>
    <link rel="stylesheet" href="../assets/css/index.css">
</head>
<body>

<?php include "../includes/header.php"; ?>

<main class="container">
    <div class="berita-item" style="margin-top: 60px;">
        <h3><?= $berita_detail['judul'] ?></h3>
        <p><small>Posted on <?= date('d-m-Y', strtotime($berita_detail['tanggal'])) ?></small></p>
        <div class="berita-gambar">
            <?php if ($berita_detail['gambar']): ?>
                <img src="../uploads/<?= $berita_detail['gambar'] ?>" alt="Gambar Berita" style="height: 500px;">
            <?php else: ?>
                <p>Tidak ada gambar</p>
            <?php endif; ?>
        </div>
        <p><?= $berita_detail['konten'] ?></p>
        <a href="berita.php" class="button">Kembali ke Daftar Berita</a>
    </div>
</main>

<?php include "../includes/footer.php"; ?>  

</body>
</html>
