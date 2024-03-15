<?php
// Sisipkan koneksi ke database
include 'koneksi.php';

// Mulai session
session_start();

// Periksa apakah pengguna telah login
if (!isset($_SESSION['user_id'])) {
    // Jika tidak, redirect ke halaman login_admin.php
    header("Location: login_admin.php");
    exit();
}

// Periksa apakah role_id pengguna adalah 1
if ($_SESSION['role_id'] != 1) {
    // Jika tidak, redirect ke halaman login_admin.php
    header("Location: login_admin.php");
    exit();
}

// Periksa apakah ada parameter tindakan dan id pengguna yang dikirim melalui GET
if (isset($_GET['action']) && isset($_GET['userId'])) {
    $action = $_GET['action'];
    $userId = $_GET['userId'];

    // Periksa apakah tindakan yang diterima adalah "suspend" atau "unsuspend"
    if ($action == 'suspend') {
        // Update status akun menjadi 2 (suspended)
        $update_query = "UPDATE act_users SET status_acc = 2 WHERE user_id = $userId";
        $update_result = mysqli_query($conn, $update_query);

        if ($update_result) {
            // Jika berhasil, kembalikan ke halaman sebelumnya dengan notifikasi
            header("Location: {$_SERVER['HTTP_REFERER']}?notif=suspend_success");
            exit();
        } else {
            // Jika gagal, kembalikan ke halaman sebelumnya dengan notifikasi
            header("Location: {$_SERVER['HTTP_REFERER']}?notif=suspend_failed");
            exit();
        }
    } elseif ($action == 'unsuspend') {
        // Update status akun menjadi 1 (active)
        $update_query = "UPDATE act_users SET status_acc = 1 WHERE user_id = $userId";
        $update_result = mysqli_query($conn, $update_query);

        if ($update_result) {
            // Jika berhasil, kembalikan ke halaman sebelumnya dengan notifikasi
            header("Location: {$_SERVER['HTTP_REFERER']}?notif=unsuspend_success");
            exit();
        } else {
            // Jika gagal, kembalikan ke halaman sebelumnya dengan notifikasi
            header("Location: {$_SERVER['HTTP_REFERER']}?notif=unsuspend_failed");
            exit();
        }
    }
}

// Query untuk mengambil data dari tabel act_users dengan role_id = 2
$query = "SELECT * FROM act_users WHERE role_id = 2";
$result = mysqli_query($conn, $query);

// Array untuk menyimpan data pengguna
$users = array();

// Periksa apakah query berhasil dieksekusi
if ($result && mysqli_num_rows($result) > 0) {
    // Ambil data pengguna dan masukkan ke dalam array
    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage User Accounts</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="container.css">
    <link rel="stylesheet" href="footer.css">
    <!-- Tambahkan link ke font awesome jika belum ada -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        /* Tambahkan CSS sesuai kebutuhan untuk table dan pagination */
        .user-table {
            width: 100%;
            border-collapse: collapse;
        }

        .user-table td, .user-table th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .user-table th {
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

        .action-btn {
            display: inline-block;
            margin-right: 10px;
            color: #007bff; /* Ubah warna sesuai kebutuhan */
            text-decoration: none;
        }

        /* Tambahkan pemisah antara kolom Status Akun dan kolom Actions */
        .user-table th.status-col {
            width: 120px; /* Atur lebar sesuai kebutuhan */
        }

        .user-table th.actions-col {
            width: 160px; /* Atur lebar sesuai kebutuhan */
        }
    </style>
</head>
<body>

<?php include 'header.php'; ?>

<aside id="sidebar">
    <div class="sidebar">
        <h2>Menu</h2>
        <ul>
            <li><a href="dashboard_admin.php">Dashboard Admin</a></li>
            <li><a href="manage_user.php">Manage User</a></li>
            <li><a href="membuat_berita.php">Membuat Berita</a></li>
        </ul>
    </div>
</aside>

<main class="main-content">
    <div class="container">
        <h2>Daftar Pengguna</h2>

        <!-- Tabel utama untuk menampilkan daftar pengguna -->
        <table class="user-table">
            <tr>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th class="status-col">Status Akun</th>
                <th class="actions-col">Actions</th>
            </tr>
            <?php
            // Menampilkan data pengguna
            foreach ($users as $user) {
            ?>
                <tr>
                    <td><?php echo $user['username']; ?></td>
                    <td><?php echo $user['email']; ?></td>
                    <td><?php echo $user['role_id']; ?></td>
                    <td>
                        <!-- Tambahkan tampilan status akun -->
                        <?php
                        // Tentukan teks status berdasarkan nilai status_acc
                        $statusText = ($user['status_acc'] == 1) ? 'Active' : 'Suspended';
                        // Tentukan warna teks berdasarkan nilai status_acc
                        $statusColor = ($user['status_acc'] == 1) ? 'green' : 'red';
                        ?>
                        <span style="color: <?php echo $statusColor; ?>"><?php echo $statusText; ?></span>
                    </td>
                    <td>
                                <!-- Tambahkan tombol aksi sesuai kebutuhan -->
        <?php if ($user['status_acc'] == 1) { ?>
            <a href="manage_user.php?action=suspend&userId=<?php echo $user['user_id']; ?>" class="action-btn"><i class="fas fa-pause-circle"></i> Suspend</a>
        <?php } else { ?>
            <a href="manage_user.php?action=unsuspend&userId=<?php echo $user['user_id']; ?>" class="action-btn"><i class="fas fa-play-circle"></i> Unsuspend</a>
        <?php } ?>



                    </td>
                </tr>
            <?php
            }
            ?>
        </table>

        <!-- Pagination -->
        <!-- Tambahkan pagination jika perlu -->
    </div>
</main>

<?php include 'footer.php'; ?>

</body>
</html>
