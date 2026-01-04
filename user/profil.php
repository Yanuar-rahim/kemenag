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
$id = $_SESSION['user_id'];
$user = mysqli_query($koneksi, "SELECT * FROM users WHERE id='$id'");
$data = mysqli_fetch_assoc($user);

$pesan = "";

/* =====================
   SIMPAN PROFIL
===================== */
if (isset($_POST['simpan'])) {

    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $nik = $_POST['nik'];
    $alamat = $_POST['alamat'];
    $no_hp = $_POST['no_hp'];

    $password_lama = $_POST['password_lama'];
    $password_baru = $_POST['password_baru'];
    $konfirmasi_pass = $_POST['konfirmasi_password'];

    if ($nama == "" || $username == "" || $nik == "" || $alamat == "" || $no_hp == "") {
        $pesan = "Semua field wajib diisi (kecuali password)";
    } else {

        /* =====================
           JIKA GANTI PASSWORD
        ===================== */
        if ($password_baru != "") {

            if ($password_lama == "") {
                $pesan = "Password lama wajib diisi";
            } elseif (!password_verify($password_lama, $data['password'])) {
                $pesan = "Password lama salah";
            } elseif ($password_baru != $konfirmasi_pass) {
                $pesan = "Konfirmasi password tidak sesuai";
            } else {
                $password_hash = password_hash($password_baru, PASSWORD_DEFAULT);

                mysqli_query($koneksi, "
                    UPDATE users SET
                    nama='$nama',
                    username='$username',
                    password='$password_hash',
                    nik='$nik',
                    alamat='$alamat',
                    no_hp='$no_hp'
                    WHERE id='$id'
                ");

                header("Location: ajukan_layanan.php?profil=lengkap");
                exit;
            }
        }
        /* =====================
           TANPA GANTI PASSWORD
        ===================== */ else {
            mysqli_query($koneksi, "
                UPDATE users SET
                nama='$nama',
                username='$username',
                nik='$nik',
                alamat='$alamat',
                no_hp='$no_hp'
                WHERE id='$id'
            ");

            header("Location: ajukan_layanan.php?profil=lengkap");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Profil Saya | Kemenag Baubau</title>
    <link rel="stylesheet" href="../assets/css/index.css">
</head>

<body>

    <?php include "../includes/header.php"; ?>

    <div class="container" style="margin-top:10px;">
        <h2 style="margin: 10px 0; text-align: left;">Profil</h2>
        <div class="card">
            <?php if ($pesan != ""): ?>
                <script>alert("<?= $pesan ?>");</script>
            <?php endif; ?>

            <?php if (isset($_GET['lengkap']) && $_GET['lengkap'] == 0): ?>
                <script>
                    alert("Silakan lengkapi data profil terlebih dahulu sebelum mengajukan layanan.");
                </script>
            <?php endif; ?>


            <form method="post" class="form-input">

                <h3>Profil saya</h3>
                <label>Nama Lengkap</label>
                <input type="text" name="nama" value="<?= $data['nama'] ?>" required>

                <label>Username</label>
                <input type="text" name="username" value="<?= $data['username'] ?>" required>

                <hr style="margin:15px 0;">
                <h3>Password</h3>
                <label>Password Lama</label>
                <input type="password" name="password_lama" placeholder="Wajib diisi jika ganti password">

                <label>Password Baru</label>
                <input type="password" name="password_baru" placeholder="Kosongkan jika tidak diubah">

                <label>Konfirmasi Password Baru</label>
                <input type="password" name="konfirmasi_password" placeholder="Ulangi password baru">

                <hr style="margin:15px 0;">
                <h3>Data Pribadi</h3>
                <label>NIK</label>
                <input type="text" name="nik" value="<?= $data['nik'] ?>" required>

                <label>Alamat</label>
                <textarea name="alamat" required><?= $data['alamat'] ?></textarea>

                <label>No HP</label>
                <input type="text" name="no_hp" value="<?= $data['no_hp'] ?>" required>

                <button type="submit" name="simpan" style="margin-top:20px;">
                    Simpan Perubahan
                </button>

            </form>
        </div>
    </div>

    <?php include "../includes/footer.php"; ?>

</body>

</html>