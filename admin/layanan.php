<?php
session_start();
include "../config/koneksi.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit;
}

/* =====================
   SEARCH
===================== */
$cari_layanan   = $_GET['cari_layanan'] ?? '';
$cari_pengajuan = $_GET['cari_pengajuan'] ?? '';

/* =====================
   TAMBAH / EDIT LAYANAN
===================== */
if (isset($_POST['simpan'])) {
    $nama       = $_POST['nama_layanan'];
    $deskripsi  = $_POST['deskripsi'];
    $status     = $_POST['status'];
    $id         = $_POST['id'];

    if ($id == "") {
        mysqli_query($koneksi, "
            INSERT INTO layanan (nama_layanan, deskripsi, status)
            VALUES ('$nama', '$deskripsi', '$status')
        ");
    } else {
        mysqli_query($koneksi, "
            UPDATE layanan SET
            nama_layanan='$nama',
            deskripsi='$deskripsi',
            status='$status'
            WHERE id='$id'
        ");
    }
    header("Location: layanan.php");
    exit;
}

/* =====================
   HAPUS LAYANAN
===================== */
if (isset($_GET['hapus'])) {
    mysqli_query($koneksi, "DELETE FROM layanan WHERE id='$_GET[hapus]'");
    header("Location: layanan.php");
    exit;
}

/* =====================
   DATA EDIT
===================== */
$edit = null;
if (isset($_GET['edit'])) {
    $q = mysqli_query($koneksi, "SELECT * FROM layanan WHERE id='$_GET[edit]'");
    $edit = mysqli_fetch_assoc($q);
}

/* =====================
   QUERY DATA
===================== */
$layanan = mysqli_query($koneksi, "
    SELECT * FROM layanan
    WHERE nama_layanan LIKE '%$cari_layanan%'
       OR status LIKE '%$cari_layanan%'
    ORDER BY id DESC
");

$pengajuan = mysqli_query($koneksi, "
    SELECT * FROM pengajuan_layanan
    WHERE nama LIKE '%$cari_pengajuan%'
       OR email LIKE '%$cari_pengajuan%'
       OR nik LIKE '%$cari_pengajuan%'
       OR nama_layanan LIKE '%$cari_pengajuan%'
       OR status LIKE '%$cari_pengajuan%'
    ORDER BY id DESC
");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Admin | Kelola Layanan</title>
    <link rel="stylesheet" href="../assets/css/index.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>

<body>

    <div class="dashboard">
        <?php include "../includes/sidebar.php"; ?>

        <div class="content">

            <!-- ================= FORM LAYANAN ================= -->
            <h2 style="margin: 10px 0;"><?= $edit ? 'Edit' : 'Tambah' ?> Layanan</h2>

            <form method="post" class="form-input">
                <input type="hidden" name="id" value="<?= $edit['id'] ?? '' ?>">

                <input type="text" name="nama_layanan" placeholder="Nama Layanan"
                    value="<?= $edit['nama_layanan'] ?? '' ?>" required>

                <textarea name="deskripsi" placeholder="Deskripsi Layanan"><?= $edit['deskripsi'] ?? '' ?></textarea>

                <select name="status">
                    <option value="Aktif" <?= ($edit && $edit['status'] == 'Aktif') ? 'selected' : '' ?>>Aktif</option>
                    <option value="Nonaktif" <?= ($edit && $edit['status'] == 'Nonaktif') ? 'selected' : '' ?>>Nonaktif</option>
                </select>

                <button type="submit" name="simpan">Simpan</button>
            </form>

            <!-- ================= DAFTAR LAYANAN ================= -->
            <h2 style="margin-top: 20px;">Daftar Layanan</h2>
            <div class="header-tabel">
                <form method="get">
                    <input type="text" name="cari_layanan" placeholder="Cari layanan..."
                        value="<?= $cari_layanan ?>">
                    <button type="submit" class="button">Cari</button>
                </form>
                <button onclick="window.location.href='layanan.php';" class="button">Reset</button>
            </div>

            <table>
                <tr>
                    <th>No</th>
                    <th>Nama Layanan</th>
                    <th>Deskripsi</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
                <?php $no = 1;
                while ($l = mysqli_fetch_assoc($layanan)): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $l['nama_layanan'] ?></td>
                        <td><?= $l['deskripsi'] ?></td>
                        <td style="text-align: center;"><?= $l['status'] ?></td>
                        <td style="text-align: center;">
                            <a href="?edit=<?= $l['id'] ?>">Edit</a> |
                            <a href="?hapus=<?= $l['id'] ?>" onclick="return confirm('Hapus layanan?')">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>

            <!-- ================= PENGAJUAN ================= -->
            <h2 style="margin-top: 20px;">Pengajuan Layanan</h2>
            <div class="header-tabel">
                <form method="get">
                    <input type="text" name="cari_pengajuan" placeholder="Cari pengajuan..."
                        value="<?= $cari_pengajuan ?>">
                    <button type="submit" class="button">Cari</button>
                </form>
                <a href="cetak_pengajuan.php?cari=<?= $cari_pengajuan ?>" target="_blank">
                    <button type="button" class="button">Cetak PDF</button>
                </a>
            </div>

            <table style="margin-bottom: 30px;">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Layanan</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
                <?php $no = 1;
                while ($p = mysqli_fetch_assoc($pengajuan)): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $p['nama'] ?></td>
                        <td><?= $p['nama_layanan'] ?></td>
                        <td style="text-align: center;"><?= $p['tanggal_pengajuan'] ?></td>
                        <td style="text-align: center;"><?= $p['status'] ?></td>
                        <td style="text-align: center;">
                            <a href="detail_pengajuan.php?id=<?= $p['id'] ?>">Detail</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>

        </div>
    </div>

</body>

</html>