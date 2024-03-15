<?php
// Mulai session
session_start();

// Sisipkan koneksi ke database
include 'koneksi.php';
date_default_timezone_set("Asia/Jakarta");

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    // Jika belum login, redirect ke halaman login
    header("Location: login_user.php");
    exit();
}

// Tangkap data yang dikirimkan melalui form
$nama_penulis = $_SESSION['username']; // Ambil username dari sesi
$judul_artikel = $_POST['judul_artikel'];
$isi_artikel = $_POST['isi_artikel'];
$kategori = $_POST['kategori'];
$user_id = $_SESSION['user_id'];

// Tambahkan detail tanggal saat artikel diposting
$tanggal_posting = date("j F Y"); // Format tanggal, contoh: 20 January 2021

// Proses upload gambar
if ($_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
    // Mendapatkan informasi tentang file yang diupload
    $file_name = $_FILES['gambar']['name'];
    $file_tmp = $_FILES['gambar']['tmp_name'];
    $file_size = $_FILES['gambar']['size'];
    $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);

    // Batasan ukuran file (dalam bytes)
    $max_size = 3 * 1024 * 1024; // 3 MB

    // Periksa ukuran file
    if ($file_size > $max_size) {
        echo "Ukuran file terlalu besar. Maksimal 3 MB.";
        exit();
    }

    // Mendapatkan tanggal saat ini
    $tanggal_sekarang = date("Y-m-d");
    $tahun=date("Y");
    $bulan=date("m");
    $hari=date("d");
    

    // Generate nama file yang unik
    $nama_file_baru = generateRandomName($user_id, $tanggal_sekarang) . "." . $file_ext;
    
    // Lokasi penyimpanan file
    $upload_directory = "D:/xampp/htdocs/neuron_news/uploads/".$tahun."/".$bulan."/".$hari."/";

    // Buat folder untuk menyimpan gambar jika belum ada
    if (!file_exists($upload_directory)) {
        mkdir($upload_directory, 0777, true);
    }

    // Pindahkan file yang diupload ke folder tujuan
    if (move_uploaded_file($file_tmp, $upload_directory . $nama_file_baru)) {
        // File berhasil diupload, lanjutkan dengan penyimpanan informasi artikel ke database

        // Tambahkan detail tanggal ke dalam isi artikel
        $isi_artikel_dengan_tanggal = $tanggal_posting . " (" . $isi_artikel . ")";

        // Query untuk menyimpan informasi artikel ke database
        $query = "INSERT INTO post_article (user_id, username, title, description, category_id, post_date, post_img) VALUES ('$user_id', '$nama_penulis', '$judul_artikel', '$isi_artikel_dengan_tanggal', '$kategori', SYSDATE(), '$nama_file_baru')";

        // Eksekusi query
if (mysqli_query($conn, $query)) {
    // Redirect ke halaman dashboard_user.php dengan notifikasi
    header("Location: dashboard_user.php?notif=success");
    exit();
} else {
    echo "Error: " . $query . "<br>" . mysqli_error($conn);
}

    } else {
        echo "Maaf, terjadi kesalahan saat mengunggah gambar.";
    }
} else {
    echo "Maaf, terjadi kesalahan saat mengunggah gambar.";
}

// Fungsi untuk menghasilkan nama file acak
function generateRandomName($user_id, $date) {
    $randomString = '';

    // Ambil tahun, bulan, dan tanggal dari tanggal yang diberikan
    $year = date("Y", strtotime($date));
    $month = date("m", strtotime($date));
    $day = date("d", strtotime($date));

    // Format nama file: tahun-bulan-tanggal_user_id_randomstring
    // $randomString .= $year . "-" . $month . "-" . $day . "_" . $user_id;

    // Karakter yang mungkin digunakan untuk nama file
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    // Panjang string random yang diinginkan
    $length = 10;

    // Pembentukan bagian random dari nama file
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }

    return $randomString;
}
?>
