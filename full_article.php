<?php
// Sisipkan koneksi ke database
include 'koneksi.php';

// Periksa apakah parameter post_id telah diterima
if(isset($_GET['post_id'])) {
    // Ambil nilai post_id dari parameter GET
    $article_id = $_GET['post_id'];
    
    // Query untuk mengambil data artikel berdasarkan id
    $query = "SELECT * FROM post_article WHERE post_id = $article_id";
    $result = mysqli_query($conn, $query);
    
    // Periksa apakah artikel ditemukan
    if(mysqli_num_rows($result) > 0) {
        // Ambil data artikel
        $article = mysqli_fetch_assoc($result);

        // Tambahkan nilai total_like setiap kali halaman ini diakses
        $query_increment_like = "UPDATE post_article SET total_like = total_like + 1 WHERE post_id = $article_id";
        mysqli_query($conn, $query_increment_like);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $article['title']; ?></title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<?php include 'header.php'; ?>

<div class="container">
    <h1><?php echo $article['title']; ?></h1>
    <!-- Tampilkan gambar artikel -->
    <img src="http://localhost/neuron_news/uploads/<?php echo str_replace("-","/",explode(" ",$article['post_date'])[0]) . "/" . $article['post_img']; ?>" alt="Article Image" style="max-width: 1200px;">
    <p><?php echo $article['description']; ?></p>
    
</div>


<?php include 'footer.php'; ?>

</body>
</html>
<?php
    } else {
        // Artikel tidak ditemukan
        echo "Artikel tidak ditemukan.";
    }
} else {
    // Jika parameter post_id tidak diterima
    echo "Parameter post_id tidak ditemukan.";
}
?>
