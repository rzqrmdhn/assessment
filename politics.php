<?php
// Mulai session
session_start();

// Sisipkan koneksi ke database
include 'koneksi.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Berita Neuron - Politics</title>
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
</head>
<body>

<?php include 'header.php'; ?>

<main class="main-content">
    <div class="container">
        <aside id="sidebar">
            <div class="sidebar">
                <h2>Kategori Berita</h2>
                <ul>
                    <li><a href="sport.php">Sports</a></li>
                    <li><a href="health.php">Health</a></li>
                    <li><a href="politics.php">Politics</a></li>
                    <li><a href="entertainment.php">Entertainment</a></li>
                    <li><a href="business.php">Business</a></li>
                    <li><a href="technology.php">Technology</a></li>
                </ul>
            </div>
        </aside>
        
        <section class="content">
            <div class="search-bar">
                <form action="#" method="GET">
                    <input type="text" name="search" placeholder="Search...">
                    <button type="submit">Search</button>
                </form>
            </div>
            
            <h2>Artikel Politik</h2>
            <?php
            // Query untuk mengambil data dari tabel post_article dengan category_id=13 (Politics)
$query = "SELECT * FROM post_article WHERE category_id = 13";
$result = mysqli_query($conn, $query);
            // Periksa apakah ada data yang ditemukan
if (mysqli_num_rows($result) > 0) {
    // Tampilkan tabel untuk artikel
    echo '<table class="article-table">';
    // Loop untuk menampilkan setiap artikel
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>';
        // Tampilkan gambar artikel dengan alamat URL yang benar
        echo '<td><img src="http://localhost/neuron_news/uploads/' . str_replace("-","/",explode(" ",$row['post_date'])[0]) . "/" . $row['post_img'] . '" alt="Article Image" style="max-width: 100px;"></td>';
        // Tampilkan judul artikel sebagai link dengan href ke full artikel
        echo '<td><h3><a href="full_article.php?id=' . $row['post_id'] . '">' . $row['title'] . '</a></h3>';
        // Tampilkan deskripsi artikel yang dibatasi menjadi 150 karakter
        echo '<p>' . substr($row['description'], 0, 150) . '...</p></td>';
        echo '</tr>';
    }
    echo '</table>'; // Tutup tabel artikel
} else {
    // Jika tidak ada artikel yang ditemukan
    echo '<p>Tidak ada artikel utama saat ini.</p>';
}

            ?>
            
            <!-- Pagination -->
            <div class="pagination">
                <button class="prev-btn">&laquo; Prev</button>
                <button>1</button>
                <button>2</button>
                <button>3</button>
                <button class="next-btn">Next &raquo;</button>
            </div>
        </section>
    </div>
</main>
    
<?php include 'footer.php'; ?>
</body>
</html>
