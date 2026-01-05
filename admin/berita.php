<?php
session_start();
include "../config/koneksi.php";

// Proteksi admin
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

// Ambil data berita
$cari_berita = $_GET['cari_berita'] ?? '';
$berita = mysqli_query($koneksi, "
    SELECT * FROM berita
    WHERE judul LIKE '%$cari_berita%'
    ORDER BY tanggal DESC
");

$pesan = "";

// Proses simpan atau update berita
if (isset($_POST['simpan'])) {
    $judul = $_POST['judul'];
    $konten = $_POST['konten'];

    // Menangani upload gambar
    $gambar = '';
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $target_dir = "../uploads/"; // Folder tempat menyimpan gambar
        $target_file = $target_dir . basename($_FILES["gambar"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Cek apakah file gambar valid (ekstensi)
        $valid_extensions = ["jpg", "png", "jpeg", "gif"];
        if (in_array($imageFileType, $valid_extensions)) {
            // Pindahkan gambar ke folder uploads
            if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
                $gambar = basename($_FILES["gambar"]["name"]);
            } else {
                $pesan = "Gagal mengunggah gambar.";
            }
        } else {
            $pesan = "Hanya file gambar dengan ekstensi JPG, PNG, JPEG, atau GIF yang diizinkan.";
        }
    }

    if (empty($judul) || empty($konten)) {
        $pesan = "Judul dan Konten wajib diisi!";
    } else {
        if (isset($_POST['id'])) {
            // Update berita
            $id = $_POST['id'];
            if ($gambar != '') {
                $query = "UPDATE berita SET judul='$judul', konten='$konten', gambar='$gambar' WHERE id='$id'";
            } else {
                $query = "UPDATE berita SET judul='$judul', konten='$konten' WHERE id='$id'";
            }
            mysqli_query($koneksi, $query);
            $pesan = "Berita berhasil diperbarui!";
        } else {
            // Insert berita
            $query = "INSERT INTO berita (judul, konten, gambar) VALUES ('$judul', '$konten', '$gambar')";
            mysqli_query($koneksi, $query);
            $pesan = "Berita berhasil ditambahkan!";
        }
    }
}

// Proses hapus berita
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM berita WHERE id='$id'");
    header("Location: berita_pengumuman.php");
    exit;
}

// Jika ada parameter edit, ambil data berita yang akan diedit
if (isset($_GET['edit'])) {
    $id_edit = $_GET['edit'];
    $query_edit = mysqli_query($koneksi, "SELECT * FROM berita WHERE id='$id_edit'");
    $berita_edit = mysqli_fetch_assoc($query_edit);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Berita & Pengumuman | Admin Kemenag Baubau</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
    <link rel="stylesheet" href="../assets/css/index.css">
</head>
<body>
<div class="dashboard">
    <?php include "../includes/sidebar.php"; ?>
    
    <main class="content" style="margin-top:20px;">
        <h2>Berita & Pengumuman</h2>
        
        <?php if ($pesan != ""): ?>
            <script>alert("<?= $pesan ?>");</script>
        <?php endif; ?>

        <!-- Form Tambah/Edit Berita -->
        <h3><?= isset($_GET['edit']) ? 'Edit' : 'Tambah' ?> Berita</h3>
        <form method="post" class="form-input" enctype="multipart/form-data">
            <label>Judul Berita</label>
            <input type="text" name="judul" value="<?= isset($berita_edit) ? $berita_edit['judul'] : '' ?>" required>

            <label>Konten Berita</label>
            <textarea name="konten" rows="4" required><?= isset($berita_edit) ? $berita_edit['konten'] : '' ?></textarea>

            <label>Gambar Berita (opsional)</label>
            <input type="file" name="gambar" accept="image/*">

            <?php if (isset($berita_edit['gambar']) && $berita_edit['gambar'] != ''): ?>
                <img src="../uploads/<?= $berita_edit['gambar'] ?>" width="100" height="75" alt="Gambar Berita">
            <?php endif; ?>

            <input type="hidden" name="id" value="<?= isset($berita_edit) ? $berita_edit['id'] : '' ?>">
            
            <div style="display: flex; gap: 10px; width: 30%;">
                <button type="submit" name="simpan">Simpan</button>
                <button type="reset" onclick="window.location.href='berita.php';" style="background-color: red;">Reset</button>
            </div>
        </form>

        <hr>

        <!-- Cari Berita -->
        <h2 style="margin-top: 20px; text-align: left;">Daftar Berita</h2>
        <div class="header-tabel">
            <form method="get">
                <input type="text" name="cari_berita" placeholder="Cari berita..."
                       value="<?= $cari_berita ?>">
                <button type="submit" class="button">Cari</button>
            </form>
        </div>

        <!-- Tabel Daftar Berita -->
        <table style="margin-bottom: 20px;">
            <tr>
                <th>No</th>
                <th>Judul</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
            <?php $no=1; while($b=mysqli_fetch_assoc($berita)): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $b['judul'] ?></td>
                <td style="text-align: center;"><?= date('d-m-Y', strtotime($b['tanggal'])) ?></td>
                <td style="text-align: center;">
                    <a href="?edit=<?= $b['id'] ?>">Edit</a> | 
                    <a href="?hapus=<?= $b['id'] ?>" onclick="return confirm('Hapus berita?')">Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </main>
</div>

</body>
</html>
