<?php
// Mulai session
session_start();

// Periksa apakah pengguna telah login
if (!isset($_SESSION['user_id'])) {
    // Jika tidak, redirect ke halaman login
    header("Location: login_user.php");
    exit();
}

// Sisipkan koneksi ke database
include 'koneksi.php';

// Mendapatkan username pengguna yang sedang login
$username = $_SESSION['username'];

// Mendapatkan data artikel dari database berdasarkan username pengguna yang sedang login
// $query = "SELECT * FROM post_article WHERE username = '$username'";
$query = "SELECT pa.*, cp.category_description FROM post_article pa , category_post cp WHERE username = '$username' and pa.category_id = cp.category_id";
$result = mysqli_query($conn, $query);

// Array untuk menyimpan data artikel
$articles = array();

// Periksa apakah ada hasil yang ditemukan
if ($result && mysqli_num_rows($result) > 0) {
    // Ambil data artikel dan masukkan ke dalam array
    while ($row = mysqli_fetch_assoc($result)) {
        $articles[] = $row;
    }
}

// Jumlah artikel per halaman
$articles_per_page = 10;

// Menghitung jumlah halaman
$total_pages = ceil(count($articles) / $articles_per_page);

// Mendapatkan nomor halaman dari URL (jika ada)
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// Menghitung indeks awal dan akhir artikel yang akan ditampilkan
$start_index = ($page - 1) * $articles_per_page;
$end_index = min($start_index + $articles_per_page, count($articles));
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
    <style>
        /* Tambahkan CSS sesuai kebutuhan untuk table dan pagination */
        .article-table {
            width: 100%;
            border-collapse: collapse;
        }

        .article-table td, .article-table th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .article-table th {
            background-color: #f2f2f2;
        }
        

        .pagination {
            margin-top: 20px;
            text-align: center;
        }

        .pagination a {
            color: black;
            display: inline-block;
            padding: 8px 16px;
            text-decoration: none;
            transition: background-color .3s;
            border: 1px solid #ddd;
            margin: 0 4px;
        }

        .pagination a.active {
            background-color: #4CAF50;
            color: white;
            border: 1px solid #4CAF50;
        }

        .pagination a:hover:not(.active) {background-color: #ddd;}
    </style>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

<?php include 'header.php'; ?>

<aside id="sidebar">
    <div class="sidebar">
        <h2>Menu</h2>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="membuat_berita.php">Membuat Berita</a></li>
            <li><a href="dashboard_user.php">Edit Artikel</a></li> <!-- Menghilangkan parameter edit -->
        </ul>
    </div>
</aside>

<main class="main-content">
<div class="container">
    <?php
    // Check if 'notif' parameter exists
    if(isset($_GET['notif']) && $_GET['notif'] == 'success') {
        echo '<div class="notif">Artikel berhasil disimpan.</div>';
    }
    ?>
        <h2>Daftar Artikel</h2>

        <!-- Tabel utama untuk menampilkan daftar artikel -->
        <table class="article-table">
            <tr>
                <th>Gambar</th>
                <th>Judul Artikel</th>
                <th>Penulis</th>
                <th>Kategori</th>
                <th>Isi Artikel</th>
                <th>Actions</th>
            </tr>
            <?php
            // Menampilkan artikel
            foreach ($articles as $article) {
                // Batasi isi artikel hingga 20 karakter dengan sisa menggunakan tanda titik-titik
                $isi_artikel = strlen($article['description']) > 20 ? substr($article['description'], 0, 20) . "..." : $article['description'];
            ?>
                <tr>
                <td><img src="http://localhost/neuron_news/uploads/<?php echo str_replace("-","/",explode(" ",$article['post_date'])[0]) . "/" . $article['post_img']; ?>" alt="Article Image" style="max-width: 100px;"></td>
                <td><a href="full_article.php?post_id=<?php echo $article['post_id']; ?>"><?php echo $article['title']; ?></a></td> <!-- Mengubah judul artikel menjadi link -->
                    <td><?php echo $article['username']; ?></td>
                    <td><?php echo $article['category_description']; ?></td>
                    <td><?php echo $isi_artikel; ?></td>
                    <td>
                     
    <a href="edit_artikel.php?post_id=<?php echo $article['post_id']; ?>"><i class='btn fa fa-pencil' style='font-size:9px' tooltips='edit'></i></a>
    <a href="#" onclick="confirmDelete(<?php echo $article['post_id']; ?>)"><i class='btn_del fa fa-trash' style='font-size:9px' tooltips='delete'></i></a>
</td>

                </tr>
            <?php
            }
            ?>
        </table>
        <script>
    function confirmDelete(postId) {
        if (confirm("Yakin Anda Ingin Menghapus Artikel Ini ?")) {
            // Jika pengguna menekan OK, arahkan ke halaman proses penghapusan dengan post_id sebagai parameter
            window.location.href = "proses_delete_artikel.php?post_id=" + postId;
        } else {
            // Jika pengguna menekan Cancel, tidak lakukan apa-apa
            return false;
        }
    }
</script>

        <!-- Pagination -->
        <div class="pagination">
            <?php
            // Tombol "Previous"
            if ($page > 1) {
                echo '<a href="?page=' . ($page - 1) . '">Previous</a>';
            }

            // Menampilkan tombol pagination
            for ($i = 1; $i <= $total_pages; $i++) {
                echo '<a href="?page=' . $i . '"' . ($page == $i ? ' class="active"' : '') . '>' . $i . '</a>';
            }

            // Tombol "Next"
            if ($page < $total_pages) {
                echo '<a href="?page=' . ($page + 1) . '">Next</a>';
            }
            ?>
        </div>
    </div>
</main>

</body>
</html>
