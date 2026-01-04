<?php
session_start();
include "../config/koneksi.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}

$cari = $_GET['cari'] ?? '';

$data = mysqli_query($koneksi, "
    SELECT * FROM pengajuan_layanan
    WHERE nama LIKE '%$cari%'
       OR email LIKE '%$cari%'
       OR nik LIKE '%$cari%'
       OR nama_layanan LIKE '%$cari%'
       OR status LIKE '%$cari%'
    ORDER BY id DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Pengajuan Layanan</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #000;
        }

        h2 {
            text-align: center;
            margin-bottom: 5px;
        }

        h3 {
            text-align: center;
            margin-top: 0;
            font-weight: normal;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        table, th, td {
            border: 1px solid #000;
        }

        th {
            background: #eaeaea;
            padding: 6px;
            text-align: center;
        }

        td {
            padding: 6px;
        }

        .center {
            text-align: center;
        }

        .print-btn {
            display: flex;
            justify-content: center;
            margin: 15px 0;
            text-align: center;
            gap: 10px;
        }

        .btn-print {
            display: inline-block;
            padding: 5px 20px;
            border: none;
            background-color: dodgerblue;
            color: white;
            border-radius: 3px;
        }

        @media print {
            .print-btn {
                display: none;
            }
        }
    </style>
</head>

<body>

<h2>LAPORAN PENGAJUAN LAYANAN</h2>
<h3>KEMENTERIAN AGAMA KOTA BAUBAU</h3>

<table>
    <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Email</th>
        <th>NIK</th>
        <th>Alamat</th>
        <th>No HP</th>
        <th>Layanan</th>
        <th>Tanggal</th>
        <th>Status</th>
    </tr>

    <?php if (mysqli_num_rows($data) > 0): ?>
        <?php $no = 1; while ($row = mysqli_fetch_assoc($data)): ?>
        <tr>
            <td class="center"><?= $no++ ?></td>
            <td><?= $row['nama'] ?></td>
            <td><?= $row['email'] ?></td>
            <td><?= $row['nik'] ?></td>
            <td><?= $row['alamat'] ?></td>
            <td><?= $row['no_hp'] ?></td>
            <td><?= $row['nama_layanan'] ?></td>
            <td class="center"><?= $row['tanggal_pengajuan'] ?></td>
            <td class="center"><?= $row['status'] ?></td>
        </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr>
            <td colspan="9" class="center">Tidak ada data</td>
        </tr>
    <?php endif; ?>
</table>

<div class="print-btn">
    <button onclick="window.print()" class="btn-print">Cetak</button>
    <button onclick="window.close()" class="btn-print">Tutup</button>
</div>

<p style="margin-top:20px;">
    Dicetak pada: <?= date('d-m-Y') ?>
</p>

</body>
</html>
