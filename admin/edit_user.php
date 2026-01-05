<?php
session_start();
include "../config/koneksi.php";

// Proteksi admin
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

// Ambil ID user
if (!isset($_GET['id'])) {
    header("Location: kelola-user.php");
    exit;
}

$id = $_GET['id'];
$query = mysqli_query($koneksi, "SELECT * FROM users WHERE id='$id' AND role='user'");
$user = mysqli_fetch_assoc($query);

if (!$user) {
    echo "<script>alert('User tidak ditemukan'); window.location.href='kelola-user.php';</script>";
    exit;
}

$pesan = "";

// Proses simpan
if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'];
    $username = $_POST['username'];

    $password_baru = $_POST['password_baru'];
    $konfirmasi = $_POST['konfirmasi_password'];

    if ($nama == "" || $username == "") {
        $pesan = "Semua field wajib diisi (kecuali password)";
    } else {
        // Update password jika diisi
        if ($password_baru != "") {
            if ($password_baru !== $konfirmasi) {
                $pesan = "Konfirmasi password tidak sesuai";
            } else {
                $password_hash = password_hash($password_baru, PASSWORD_DEFAULT);
                // Update user
                mysqli_query($koneksi, "
                    UPDATE users SET 
                    nama='$nama',
                    username='$username',
                    password='$password_hash'
                    WHERE id='$id'
                ");
                echo "<script>alert('User berhasil diperbarui'); window.location.href='kelola-user.php';</script>";
                exit;
            }
        } else {
            // Update user tanpa password baru
            mysqli_query($koneksi, "
                UPDATE users SET 
                nama='$nama',
                username='$username'
                WHERE id='$id'
            ");
            echo "<script>alert('User berhasil diperbarui'); window.location.href='kelola-user.php';</script>";
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit User | Admin Kemenag Baubau</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
    <link rel="stylesheet" href="../assets/css/index.css">
</head>
<body>
<div class="dashboard">
    <?php include "../includes/sidebar.php"; ?>
    <main class="content" style="margin-top:20px;">
        <h2>Edit User</h2>

        <?php if ($pesan != ""): ?>
            <script>alert("<?= $pesan ?>");</script>
        <?php endif; ?>

        <form method="post" class="form-input">
            <label>Nama</label>
            <input type="text" name="nama" value="<?= htmlspecialchars($user['nama']) ?>" required>

            <label>Username</label>
            <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>

            <hr style="margin:10px 0;">

            <h3>Password (opsional)</h3>
            <label>Password Baru</label>
            <input type="password" name="password_baru" placeholder="Kosongkan jika tidak diubah">

            <label>Konfirmasi Password Baru</label>
            <input type="password" name="konfirmasi_password" placeholder="Ulangi password baru">
            <div style="display: flex; gap: 10px; width: 35%;">
                <button type="submit" name="simpan">Simpan Perubahan</button>
                <button type="button" onclick="window.location.href='kelola_user.php'" style="background-color: red;">Kembali</button>
            </div>
        </form>
    </main>
</div>
</body>
</html>
