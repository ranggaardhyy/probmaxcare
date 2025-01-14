<?php
// Redirect jika pengguna mengakses root domain (/) ke halaman home.php
if ($_SERVER['REQUEST_URI'] == "/ProbMaxCare/") {
    header('Location: /ProbMaxCare/views/home.php');
    exit; // Pastikan untuk keluar setelah redirect
}

// Mulai sesi jika diperlukan
session_start();

// Mengatur koneksi database jika diperlukan
include './config/db.php';

// Mengambil URL yang diminta
$request_uri = $_SERVER['REQUEST_URI'];

// Routing berdasarkan URL
switch ($request_uri) {
    case '/ProbMaxCare/':
        // Jangan lakukan apa-apa karena sudah redirect ke home.php
        break;

    case '/ProbMaxCare/home':
        include './views/home.php';
        break;

    case '/ProbMaxCare/chat':
        include './views/chat.php';
        break;

    case '/ProbMaxCare/login':
        include './views/login.php';
        break;

    case '/ProbMaxCare/register':
        include './views/register.php';
        break;

    // Tambahkan lebih banyak case untuk halaman lain sesuai kebutuhan

    default:
        // Jika URL tidak ditemukan, tampilkan halaman 404 atau redirect
        include './views/404.php'; // Pastikan Anda memiliki halaman 404.php
        break;
}
?>
