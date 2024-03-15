<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Berita Neuron</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="container.css">
    <link rel="stylesheet" href="footer.css">
  </head>
  <body> <?php include 'header.php'; ?> <section class="content">
	  <div class="row">
		<div class="col-sm-2" >
		</div>
		<div class="col-sm-8" >
			<div class="container">
				<aside id="sidebar">
				  <div class="sidebar">
					<h2>Kategori Berita</h2>
					<ul>
					  <li>
						<a href="sport.php">Sports</a>
					  </li>
					  <li>
						<a href="health.php">Health</a>
					  </li>
					  <li>
						<a href="politics.php">Politics</a>
					  </li>
					  <li>
						<a href="entertainment.php">Entertainment</a>
					  </li>
					  <li>
						<a href="business.php">Business</a>
					  </li>
					  <li>
						<a href="technology.php">Technology</a>
					  </li>
					</ul>
				  </div>
				</aside>
				<section class="content">
				  <div class="search-bar">
					<form action="#" method="GET">
					  <input type="text" name="search" placeholder="Search...">
					  <button type="submit">Search</button>
					</form>
				  </div> <?php
					// Periksa apakah ada parameter pencarian yang dikirimkan
					if(isset($_GET['search'])) {
						// Sisipkan koneksi ke database
						include 'koneksi.php';

						// Ambil nilai pencarian dari parameter GET
						$keyword = $_GET['search'];

						// Query untuk mencari artikel berdasarkan kata kunci dalam judul
						$query = "SELECT * FROM post_article WHERE title LIKE '%$keyword%'";
						$result = mysqli_query($conn, $query);

						// Periksa apakah ada hasil pencarian
						if(mysqli_num_rows($result) > 0) {
							// Tampilkan hasil pencarian
							echo '
													<h2>Hasil Pencarian untuk "'.$keyword.'"</h2>';
							echo '
													<table class="article-table">';
							while ($row = mysqli_fetch_assoc($result)) {
								echo '
														<tr>';
								// Tampilkan gambar artikel
								echo '
															<td>
                                                            <img src="http://localhost/neuron_news/uploads/' . str_replace("-","/",explode(" ",$row['post_date'])[0]) . "/" . $row['post_img'] . '" alt="Article Image" style="max-width: 100px;">
																</td>';
								// Tampilkan judul artikel sebagai link dengan href ke full artikel
								echo '
																<td>
																	<h3>
																		<a href="full_article.php?post_id=' . $row['post_id'] . '">' . $row['title'] . '</a>
																	</h3>';
								// Tampilkan deskripsi artikel yang dibatasi menjadi 150 karakter
								echo '
																	<p>' . substr($row['description'], 0, 150) . '...</p>
																</td>';
								echo '
															</tr>';
							}
							echo '
														</table>';
						} else {
							// Tampilkan pesan jika tidak ada hasil pencarian
							echo '
														<p>Tidak ditemukan artikel dengan kata kunci "'.$keyword.'"</p>';
						}
					} else {
						// Jika tidak ada parameter pencarian, tampilkan artikel utama
						// Sisipkan koneksi ke database
						include 'koneksi.php';

						// Query untuk mengambil data dari tabel post_article
						$query = "SELECT * FROM post_article";
						$result = mysqli_query($conn, $query);

						echo '
														<h2>Artikel Utama</h2>';

						// Periksa apakah ada data yang ditemukan
		if (mysqli_num_rows($result) > 0) {
			// Tampilkan tabel untuk artikel
			echo '
														<table class="article-table">';
			// Loop untuk menampilkan setiap artikel
		while ($row = mysqli_fetch_assoc($result)) {
			echo '
															<tr>';
			// Tampilkan gambar artikel dengan alamat URL yang benar
			echo '
																<td>
                                                                <img src="http://localhost/neuron_news/uploads/' . str_replace("-","/",explode(" ",$row['post_date'])[0]) . "/" . $row['post_img'] . '" alt="Article Image" style="max-width: 100px;">
																	</td>';
			// Tampilkan judul artikel sebagai link dengan href ke full artikel
			echo '
																	<td>
																		<h3>
																			<a href="full_article.php?post_id=' . $row['post_id'] . '">' . $row['title'] . '</a>
																		</h3>';
			// Tampilkan deskripsi artikel yang dibatasi menjadi 150 karakter
			echo '
																		<p>' . substr($row['description'], 0, 150) . '...</p>
																	</td>';
			echo '
																</tr>';
		}
			echo '
															</table>'; // Tutup tabel artikel
		} else {
			// Jika tidak ada artikel yang ditemukan
			echo '
															<p>Tidak ada artikel utama saat ini.</p>';
		}

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
		</div>
		<div class="col-sm-2" >
            <div class="container_fav">
                <section class="content">
                <div class="favorite-articles">
                    <h2>Artikel Favorite</h2>
                    <table class="favorite-table"> <?php
                    // Query untuk mengambil judul artikel favorit berdasarkan total_like
                    // $query_favorite = "SELECT * FROM post_article ORDER BY total_like DESC LIMIT 5";
                    $query_favorite = "select * , rank() OVER ( order by total_like desc  ) AS 'rank' FROM post_article where total_like > 0 limit 5;";
                    $result_favorite = mysqli_query($conn, $query_favorite);

                    // Periksa apakah ada hasil favorit
                    if(mysqli_num_rows($result_favorite) > 0) {
                        // Tampilkan judul artikel favorit dalam tabel
                        while ($row_favorite = mysqli_fetch_assoc($result_favorite)) {
                            // Tambahkan link ke halaman full_article.php dengan menyertakan id artikel
                            echo '
                                                                    <tr>
                                                                        <td>
                                                                            <a href="full_article.php?post_id=' . $row_favorite['post_id'] . '">' . $row_favorite['title'] . '</a>
                                                                        </td>
                                                                    </tr>';
                        }
                    } else {
                        echo '
                                                                    <tr>
                                                                        <td>Tidak ada artikel favorit saat ini.</td>
                                                                    </tr>';
                    }
                    ?> </table>
                </div>
                </section>
            </div>
		</div>
	  </div>
      </main> <?php include 'footer.php'; ?> </body>
</html>