<?php
session_start();
include "config/koneksi.php";

$pesan = "";

if (isset($_POST['login'])) {
    $user_input = $_POST['user_input'];
    $password = $_POST['password'];

    if (empty($user_input) || empty($password)) {
        $pesan = "Username / Email dan password wajib diisi";
    } else {
        // Cek login via username atau email
        $query = mysqli_query(
            $koneksi,
            "SELECT * FROM users 
             WHERE username='$user_input' 
             OR email='$user_input'"
        );

        if (mysqli_num_rows($query) === 1) {
            $user = mysqli_fetch_assoc($query);

            if (password_verify($password, $user['password'])) {
                // SET SESSION
                $_SESSION['login'] = true;
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['nama'] = $user['nama'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['login_success'] = true;


                // REDIRECT SESUAI ROLE
                if ($user['role'] === 'admin') {
                    header("Location: admin/dashboard.php");
                } else {
                    header("Location: user/index.php");
                }
                exit;
            } else {
                $pesan = "Password salah";
            }
        } else {
            $pesan = "Akun tidak ditemukan";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Login | Kemenag Baubau</title>
    <link rel="stylesheet" href="assets/css/index.css">
</head>

<body>

    <header>
        <div class="navbar">
            <h1>Kemenag Baubau</h1>
            <ul>
                <li><a href="index.php">Beranda</a></li>
                <li><a href="register.php">Registrasi</a></li>
            </ul>
        </div>
    </header>

    <div class="container" style="margin-top:100px;">
        <div class="card" style="max-width:420px;margin:auto;">
            <h2 style="margin-bottom:20px;">Login</h2>

            <?php if ($pesan != ""): ?>
                <p style="color:red;margin-bottom:15px;"><?= $pesan; ?></p>
            <?php endif; ?>

            <?php if (isset($_GET['register']) && $_GET['register'] == 'success'): ?>
                <p style="color:green;margin-bottom:15px;">
                    Registrasi berhasil, silakan login
                </p>
            <?php endif; ?>

            <form method="post" class="form-input">
                <label>Username atau Email</label>
                <input type="text" name="user_input" placeholder="Username / Email" required>
                <label>Password</label>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" name="login">Login</button>
            </form>

            <p style="margin-top:15px;">
                Belum punya akun? <a href="register.php">Daftar</a>
            </p>
        </div>
    </div>

    <footer>
        <p>&copy; 2026 Kementerian Agama Kota Baubau</p>
    </footer>

</body>

</html>