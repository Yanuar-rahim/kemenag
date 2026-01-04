<?php
session_start();
include "../config/koneksi.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: layanan.php");
    exit;
}

$id = $_GET['id'];

// ==================
// AMBIL DETAIL PENGAJUAN
// ==================
$query = mysqli_query($koneksi, "SELECT * FROM pengajuan_layanan WHERE id = $id");

$data = mysqli_fetch_assoc($query);

if (!$data) {
    die("Data tidak ditemukan");
}

// ==================
// PROSES VERIFIKASI
// ==================
if (isset($_POST['verifikasi'])) {
    $status = $_POST['status'];
    mysqli_query($koneksi, "
        UPDATE pengajuan_layanan 
        SET status='$status'
        WHERE id='$id'
    ");
    header("Location: layanan.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Detail Pengajuan</title>
    <link rel="stylesheet" href="../assets/css/index.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>

<body>

    <div class="dashboard">

        <?php include "../includes/sidebar.php"; ?>

        <div class="content">

            <h2>Detail Pengajuan Layanan</h2>

            <div class="card" style="margin-bottom: 20px;">
                <p><strong>Nama Pemohon</strong> : <?= $data['nama'] ?></p>
                <p><strong>Email</strong> : <?= $data['email'] ?></p>
                <p><strong>NIK</strong> : <?= $data['nik'] ?></p>
                <p><strong>Alamat</strong> : <?= $data['alamat'] ?></p>
                <p><strong>No HP</strong> : <?= $data['no_hp'] ?></p>
                <p><strong>Layanan</strong> : <?= $data['nama_layanan'] ?></p>
                <p><strong>Keterangan</strong> : <?= $data['keterangan'] ?></p>
                <p><strong>Tanggal Pengajuan</strong> : <?= $data['tanggal_pengajuan'] ?></p>
                <p><strong>Status Saat Ini</strong> : <?= $data['status'] ?></p>
            </div>

            <form method="post">
                <label><strong>Verifikasi Pengajuan</strong></label>
                <select name="status" required>
                    <option value="">-- Pilih Status --</option>
                    <option value="Diproses">Diproses</option>
                    <option value="Selesai">Disetujui</option>
                    <option value="Ditolak">Ditolak</option>
                </select>

                <button type="submit" name="verifikasi">Simpan Keputusan</button>
            </form>
            <button onclick="window.history.back();" class="kembali">Kembali</button>
        </div>

    </div>

</body>

</html>