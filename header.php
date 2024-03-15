<?php
// Periksa apakah sesi sudah dimulai sebelumnya
if (session_status() == PHP_SESSION_NONE) {
    // Jika belum, mulai sesi
    session_start();
}

// Periksa apakah pengguna sudah login
$user_logged_in = isset($_SESSION['user_id']);

// Sisipkan koneksi ke database
include 'koneksi.php';
?>
<header>
    <div class="container">
        <!-- Tautan ke index.php -->
        <h1><a href="index.php" style="color: white;">Portal Berita Neuron</a></h1>
        <div class="user-info">
            <?php if ($user_logged_in): ?>
                <?php
                // Jika pengguna sudah login, tampilkan pesan selamat datang dan tombol logout
                $user_id = $_SESSION['user_id'];
                $query = "SELECT first_name FROM act_users WHERE user_id = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("i", $user_id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result && $result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $first_name = $row['first_name'];
                    ?>
                    <span>Selamat datang, <?php echo htmlspecialchars($first_name); ?></span>
                    <div class="logout-dropdown">
                        <form action="logout.php" method="post">
                            <button type="submit" class="logout-btn _lg-da" name="logout">Logout</button>
                        </form>
                    </div>
                    <?php
                } else {
                    echo '<span>Selamat datang, Pengguna</span>'; // Jika gagal mengambil nama, tampilkan pesan default
                }
                ?>
            <?php else: ?>
                <!-- Jika pengguna belum login, tampilkan tombol login -->
                <a href="login_user.php" class="login-btn _idx">Login</a>
            <?php endif; ?>
        </div>
    </div>
</header>
