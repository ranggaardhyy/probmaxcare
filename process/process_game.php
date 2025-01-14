<?php
session_start();
include '../config/db.php';

// Pastikan user sudah login
if (isset($_SESSION['user_id'])) {
    // Ambil data dari form
    $user_id = $_SESSION['user_id'];  // Mendapatkan user_id dari sesi
    $username = $_POST['username'];
    $selected_mood = $_POST['selected_mood'];
    $selected_habit = $_POST['selected_habit'];
    $selected_liking = $_POST['selected_liking'];

    // Simpan data ke database
    $stmt = $pdo->prepare("INSERT INTO user_feedback (user_id, username, selected_mood, selected_habit, selected_liking) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$user_id, $username, $selected_mood, $selected_habit, $selected_liking]);

    // Set flash message
    $_SESSION['flash_message'] = 'Jawaban Anda Telah Kami Terima';

    // Redirect ke halaman result_game.php
    header('Location: ../views/result_game.php');
    exit();
} else {
    // Jika user tidak login, redirect ke halaman login
    header('Location: ../views/login.php');
    exit();
}
?>
