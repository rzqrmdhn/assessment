<?php
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="container.css">
    <link rel="stylesheet" href="footer.css">
</head>
<body>

<?php include 'header.php'; ?>

<aside id="sidebar">
    <div class="sidebar">
        <h2>Menu</h2>
        <ul>
            <li><a href="manage_user.php">Manage User</a></li>
            <li><a href="manage_article.php">Manage Article</a></li>
        </ul>
    </div>
</aside>

</body>
</html>
