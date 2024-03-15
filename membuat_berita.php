<?php

// Mulai session
session_start();

// Sisipkan koneksi ke database
include 'koneksi.php';

// Periksa apakah pengguna sudah login
if (isset($_SESSION['user_id'])) {
    // Ambil user_id dari sesi
    $user_id = $_SESSION['user_id'];

    // Inisialisasi variabel artikel kosong
    $article = array();

    // Query untuk mengambil data artikel yang akan diedit
    $query = "SELECT * FROM post_article WHERE username = '$user_id'";
    $result = mysqli_query($conn, $query);

    // Periksa apakah artikel ditemukan
    if ($result && mysqli_num_rows($result) > 0) {
        // Ambil data artikel
        $article = mysqli_fetch_assoc($result);
    }

    // Query untuk mengambil semua kategori dari tabel category_post
    $query_kategori = "SELECT category_id, category_description FROM category_post";
    $result_kategori = mysqli_query($conn, $query_kategori);

    // Buat array untuk menyimpan opsi kategori
    $kategori_options = array();

    // Periksa apakah query kategori berhasil dieksekusi
    if ($result_kategori && mysqli_num_rows($result_kategori) > 0) {
        // Ambil setiap baris kategori dan tambahkan ke array opsi kategori
        while ($row_kategori = mysqli_fetch_assoc($result_kategori)) {
            $kategori_options[$row_kategori['category_id']] = $row_kategori['category_description'];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Berita Neuron</title>
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
            <h2 class="text-center">Membuat Artikel Baru</h2>
            <form action="proses_pembuatan_artikel.php" method="POST" enctype="multipart/form-data">
                <div class="input-group_mb">
                    <label for="nama_penulis">Nama Penulis:</label>
                    <!-- Tampilkan nama pengguna yang sudah login -->
                    <input type="text" id="nama_penulis" name="nama_penulis" value="<?php echo isset($nama_penulis) ? $nama_penulis : ''; ?>" readonly required>
                </div>
                <div class="input-group_mb">
                    <label for="judul_artikel">Judul Artikel:</label>
                    <!-- Isi nilai input dengan judul artikel jika sedang mengedit -->
                    <input type="text" id="judul_artikel" name="judul_artikel" value="<?php echo isset($article['title']) ? $article['title'] : ''; ?>" required>
                </div>
                <div class="input-group_mb">
                    <label for="isi_artikel">Isi Artikel:</label>
                    <!-- Isi nilai textarea dengan isi artikel jika sedang mengedit -->
                    <textarea id="isi_artikel" name="isi_artikel" rows="10" required><?php echo isset($article['description']) ? $article['description'] : ''; ?></textarea>
                </div>
                <div class="select-category">
                    <label for="kategori">Kategori:</label>
                    <select id="kategori" name="kategori">
                        <?php
                        // Loop melalui array opsi kategori dan tampilkan setiap opsi
                        foreach ($kategori_options as $category_id => $category_description) {
                            // Tentukan opsi mana yang dipilih berdasarkan data artikel
                            $selected = isset($article['category_id']) && $article['category_id'] == $category_id ? 'selected' : '';
                            echo "<option value=\"$category_id\" $selected>$category_description</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="upload-form">
                    <label for="gambar">Unggah Gambar:</label>
                    <input type="file" id="gambar" name="gambar">
                </div>
                <button type="submit" class="button_mb">Submit</button>
            </form>
        </section>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
