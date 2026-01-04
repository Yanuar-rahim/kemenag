<?php
session_start();
include "config/koneksi.php";

$pesan = "";

if (isset($_POST['register'])) {
    $nama             = $_POST['nama'];
    $username         = $_POST['username'];
    $email            = $_POST['email'];
    $password         = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $pesan = "Konfirmasi password tidak sesuai";
    } else {
        // Cek username sudah ada atau belum
        $cek = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username'");
        if (mysqli_num_rows($cek) > 0) {
            $pesan = "Username sudah digunakan";
        } else {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $role = 'user'; // default role

            $simpan = mysqli_query($koneksi, "INSERT INTO users (nama, username, email, password, role, nik, alamat, no_hp)
                                              VALUES ('$nama', '$username', '$email', '$password_hash', '$role', NULL, NULL, NULL)");
            if ($simpan) {
                header("Location: login.php?register=success");
                exit;
            } else {
                $pesan = "Registrasi gagal";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Registrasi Akun</title>
    <link rel="stylesheet" href="assets/css/index.css">
</head>
<body>

<?php include "includes/header_index.php"; ?>

<div class="container" style="margin-top:100px;">
    <div class="card" style="max-width:450px;margin:auto;">
        <h2 style="margin-bottom:20px;">Registrasi User</h2>

        <?php if ($pesan != "") : ?>
            <p style="color:red;margin-bottom:15px;"><?= $pesan; ?></p>
        <?php endif; ?>

        <form method="post" class="form-input">
            <label for="">Nama Lengkap</label>
            <input type="text" name="nama" placeholder="Nama Lengkap" required>
            <label for="">Email</label>
            <input type="email" name="email" placeholder="Email" required>
            <label for="">Username</label>
            <input type="text" name="username" placeholder="Username" required>
            <label for="">Password</label>
            <input type="password" name="password" placeholder="Password" required>
            <label for="">Konfirmasi Password</label>
            <input type="password" name="confirm_password" placeholder="Konfirmasi Password" required>
            <button type="submit" name="register">Daftar</button>
        </form>

        <p style="margin-top:15px;">Sudah punya akun? <a href="login.php">Login</a></p>
    </div>
</div>

<?php include "includes/footer.php"; ?>

</body>
</html>
