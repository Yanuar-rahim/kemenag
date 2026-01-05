<?php
session_start();
include "../config/koneksi.php";

// Proteksi user
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'user') {
    header("Location: ../index.php");
    exit;
}

// Ambil data riwayat pengajuan berdasarkan user yang login
$nama = $_SESSION['nama'];
$riwayat = mysqli_query($koneksi, "
    SELECT * FROM pengajuan_layanan
    WHERE nama = '$nama'
    ORDER BY tanggal_pengajuan DESC
");

// Untuk mencetak bukti pengajuan
if (isset($_GET['cetak']) && isset($_GET['id'])) {
    $id_pengajuan = $_GET['id'];
    $pengajuan = mysqli_query($koneksi, "SELECT * FROM pengajuan_layanan WHERE id = '$id_pengajuan'");
    $data_pengajuan = mysqli_fetch_assoc($pengajuan);
    // Verifikasi status
    if ($data_pengajuan['status'] != 'Selesai') {
        echo "<script>alert('Hanya pengajuan yang sudah selesai yang bisa dicetak!'); window.location.href='riwayat.php';</script>";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Riwayat Pengajuan | Kemenag Baubau</title>
    <link rel="stylesheet" href="../assets/css/index.css">
    <style>
        @media print {

            /* Menyembunyikan header dan footer saat dicetak */
            header,
            footer {
                display: none;
            }

            /* Menyembunyikan tombol-tombol atau elemen yang tidak perlu saat dicetak */
            .button {
                display: none;
            }

            .riwayat-list {
                margin-top: 0;
            }

            .riwayat-item {
                display: none;
            }

            .bukti-card button {
                display: none;
                /* Menyembunyikan tombol cetak saat dicetak */
            }
        }

        .no-ajuan {
            display: block;
            justify-content: center;
            align-items: center;
            height: 50vh;
            text-align: center;
        }
    </style>
</head>

<body>

    <?php include "../includes/header.php"; ?>
    <main class="container" style="margin-top: 20px;">
        <h2>Riwayat Pengajuan Layanan</h2>

        <div class="riwayat-list" style="margin-top: 20px;">
            <?php if (mysqli_num_rows($riwayat) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($riwayat)): ?>
                    <div class="riwayat-item card">
                        <h3><?= $row['nama_layanan'] ?></h3>
                        <p>Status: <?= $row['status'] ?></p>
                        <p>Tanggal Pengajuan: <?= date('d-m-Y', strtotime($row['tanggal_pengajuan'])) ?></p>
                        <p>Keterangan: <?= $row['keterangan'] ?></p>

                        <?php if ($row['status'] == 'Selesai'): ?>
                            <div style="text-align: center; margin: 20px 0;">
                                <a href="?cetak=1&id=<?= $row['id'] ?>" class="button" style="text-align: center;">Cetak Bukti
                                    Pengajuan</a>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="no-ajuan">
                    <h4>Belum ada ajuan</h4>
                </div>
            <?php endif; ?>

        </div>

        <?php if (isset($data_pengajuan)): ?>
            <div class="card" style="margin-top: 20px; text-align: center;">
                <h2>Bukti Pengajuan Layanan</h2>
                <p><strong>Nama Layanan:</strong> <?= $data_pengajuan['nama_layanan'] ?></p>
                <p><strong>Keterangan:</strong> <?= $data_pengajuan['keterangan'] ?></p>
                <p><strong>Status:</strong> <?= $data_pengajuan['status'] ?></p>
                <p><strong>Tanggal Pengajuan:</strong> <?= date('d-m-Y', strtotime($data_pengajuan['tanggal_pengajuan'])) ?>
                </p>

                <button class="button" onclick="window.print()" style="margin: 20px 0;">Cetak Bukti</button>
            </div>
        <?php endif; ?>

    </main>

    <?php include "../includes/footer.php"; ?>

</body>

</html>