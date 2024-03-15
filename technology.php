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
    <title>Portal Berita Neuron - Technology</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="container.css">
    <link rel="stylesheet" href="footer.css">
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
            
            <h2>Artikel Technology</h2>
            <?php
            // Query untuk mengambil data artikel dengan category_id = 16 (Technology)
$query = "SELECT * FROM post_article WHERE category_id = 16";
$result = mysqli_query($conn, $query);
            // Periksa apakah ada data yang ditemukan
            if (mysqli_num_rows($result) > 0) {
                // Loop untuk menampilkan setiap artikel
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<article>';
                    echo '<h3>' . $row['title'] . '</h3>'; // Tampilkan judul artikel
                    echo '<p>' . $row['description'] . '</p>'; // Tampilkan deskripsi artikel
                    // Tambahan informasi artikel lainnya bisa ditampilkan di sini
                    echo '</article>';
                }
            } else {
                // Jika tidak ada artikel yang ditemukan
                echo '<p>Tidak ada artikel Technology saat ini.</p>';
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
