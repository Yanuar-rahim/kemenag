<?php
session_start();
include "../config/koneksi.php";

/* =====================
   CEK LOGIN USER
===================== */
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'user') {
    header("Location: ../login.php");
    exit;
}

/* =====================
   AMBIL DATA USER
===================== */
$id = $_SESSION["user_id"];
$user = mysqli_query($koneksi, "SELECT * FROM users WHERE id='$id'");
$user_hasil = mysqli_fetch_assoc($user);

/* =====================
   CEK KELENGKAPAN PROFIL
===================== */
if (
    empty($user_hasil['nik']) ||
    empty($user_hasil['alamat']) ||
    empty($user_hasil['no_hp'])
) {
    header("Location: profil.php?lengkap=0");
    exit;
}


/* =====================
   AMBIL DATA LAYANAN
===================== */
$layanan = mysqli_query($koneksi, "SELECT * FROM layanan WHERE status='Aktif'");

$pesan = "";

/* =====================
   PROSES SIMPAN
===================== */
if (isset($_POST['kirim'])) {

    $nama           = $user_hasil['nama'];
    $email          = $user_hasil['email'];
    $nik            = $user_hasil['nik'];
    $alamat         = $user_hasil['alamat'];
    $no_hp          = $user_hasil['no_hp'];

    $nama_layanan   = $_POST['nama_layanan'];
    $keterangan     = $_POST['keterangan'];
    $tanggal        = date('Y-m-d');
    $status         = 'Menunggu';

    if ($nama_layanan == "" || $keterangan == "") {
        $pesan = "Semua field wajib diisi";
    } else {

        $simpan = mysqli_query($koneksi, "
            INSERT INTO pengajuan_layanan
            (nama, email, nik, alamat, no_hp, nama_layanan, keterangan, tanggal_pengajuan, status)
            VALUES
            ('$nama', '$email', '$nik', '$alamat', '$no_hp',
             '$nama_layanan', '$keterangan', '$tanggal', '$status')
        ");

        if ($simpan) {
            $pesan = "Pengajuan layanan berhasil dikirim";
        } else {
            $pesan = "Gagal mengirim pengajuan";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Ajukan Layanan | Kemenag Baubau</title>
    <link rel="stylesheet" href="../assets/css/index.css">
</head>
<body>

<?php include "../includes/header.php"; ?>

<div class="container" style="margin-top:70px;">
    <div class="card" style="max-width:600px; margin:auto;">
        <h2>Form Pengajuan Layanan</h2>

        <?php if ($pesan != ""): ?>
            <script>alert("<?= $pesan ?>");</script>
        <?php endif; ?>

        <form method="post" class="form-input">

            <label>Jenis Layanan</label>
            <select name="nama_layanan" required>
                <option value="">-- Pilih Layanan --</option>
                <?php while ($row = mysqli_fetch_assoc($layanan)): ?>
                    <option value="<?= $row['nama_layanan'] ?>">
                        <?= $row['nama_layanan'] ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <label style="margin-top:15px;">Keterangan</label>
            <textarea name="keterangan" rows="4" placeholder="Jelaskan kebutuhan layanan" required></textarea>

            <button type="submit" name="kirim" style="margin-top:15px;">
                Kirim Pengajuan
            </button>

        </form>
    </div>
</div>

<?php include "../includes/footer.php"; ?>

</body>
</html>
