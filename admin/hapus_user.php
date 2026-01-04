<?php
session_start();
include "../config/koneksi.php";

// Proteksi admin
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

// Ambil ID user
if (!isset($_GET['id'])) {
    header("Location: kelola-user.php");
    exit;
}

$id = $_GET['id'];

// Hapus user
mysqli_query($koneksi, "DELETE FROM users WHERE id='$id' AND role='user'");

echo "<script>alert('User berhasil dihapus'); window.location.href='kelola-user.php';</script>";
exit;
