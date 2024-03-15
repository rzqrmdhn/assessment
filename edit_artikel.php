<?php

// Mulai session
session_start();

// Sisipkan koneksi ke database
include 'koneksi.php';

// Periksa apakah parameter post_id dikirimkan melalui URL
if (!isset($_GET['post_id'])) {
    // Jika tidak ada parameter post_id, redirect ke halaman dashboard atau halaman lainnya
    header("Location: dashboard_user.php");
    exit();
}

// Ambil post_id dari parameter URL
$post_id = $_GET['post_id'];

// Query untuk mengambil data artikel berdasarkan post_id
$query = "SELECT * FROM post_article WHERE post_id = '$post_id'";
$result = mysqli_query($conn, $query);

// Periksa apakah artikel ditemukan
if (!$result || mysqli_num_rows($result) === 0) {
    // Jika artikel tidak ditemukan, redirect ke halaman dashboard atau halaman lainnya
    header("Location: dashboard_user.php");
    exit();
}

// Ambil data artikel
$article = mysqli_fetch_assoc($result);

// Fungsi untuk menghindari serangan XSS (cross-site scripting)
function escape($html) {
    return htmlspecialchars($html, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Artikel</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="container.css">
    <link rel="stylesheet" href="footer.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="container">
        <aside id="sidebar">
            <div class="sidebar">
                <h2>Menu</h2>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="dashboard_user.php">Dashboard</a></li>
                    <!-- Jika sedang mengedit, gunakan teks "Kembali" untuk kembali ke halaman dashboard -->
                    <li><a href="membuat_berita.php">Membuat Berita</a></li>
                </ul>
            </div>
        </aside>

        <section class="content form-membuat-artikel_mb">
            <!-- Ubah judul sesuai kondisi -->
            <h2 class="text-center">Edit Artikel</h2>
            <form action="proses_edit_artikel.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="post_id" value="<?php echo escape($article['post_id']); ?>">
                <div class="input-group_mb">
                    <label for="nama_penulis">Nama Penulis:</label>
                    <!-- Tampilkan nama pengguna yang sudah login -->
                    <input type="text" id="nama_penulis" name="nama_penulis" value="<?php echo escape($article['username']); ?>" readonly required>
                </div>
                <div class="input-group_mb">
                    <label for="judul_artikel">Judul Artikel:</label>
                    <!-- Isi nilai input dengan judul artikel jika sedang mengedit -->
                    <input type="text" id="judul_artikel" name="judul_artikel" value="<?php echo escape($article['title']); ?>" required>
                </div>
                <div class="input-group_mb">
                    <label for="isi_artikel">Isi Artikel:</label>
                    <!-- Isi nilai textarea dengan isi artikel jika sedang mengedit -->
                    <textarea id="isi_artikel" name="isi_artikel" rows="10" required><?php echo escape($article['description']); ?></textarea>
                </div>
                <div class="upload-form">
    <label for="gambar">Gambar Lama:</label><br>
    <!-- Tampilkan gambar artikel lama -->
    <img src="http://localhost/neuron_news/uploads/<?php echo str_replace("-","/",explode(" ",$article['post_date'])[0]) . "/" . $article['post_img']; ?>" alt="Article Image" style="max-width: 100px;"><br><br>
    <label for="gambar_baru">Unggah Gambar Baru:</label>
    <input type="file" id="gambar_baru" name="gambar_baru">
</div>

                <input type="hidden" name="category_id" value="<?php echo escape($article['category_id']); ?>">
                <button type="submit" class="button_mb">Simpan Perubahan</button>
            </form>
        </section>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>

