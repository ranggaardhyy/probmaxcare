<?php
include '../config/db.php';
session_start();

// Pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil user_id dari session
    $user_id = $_SESSION['user_id'];

    // Ambil username yang diinput oleh pengguna di form
    $username = isset($_POST['username']) ? $_POST['username'] : '';

    // Validasi jika username kosong
    if (empty($username)) {
        $_SESSION['error_message'] = "Username tidak boleh kosong.";
        header("Location: ../views/kuisioner.php");
        exit();
    }

    $totalScore = 0;
    $answers = [];

    // Hitung total skor dan simpan jawaban
    for ($i = 1; $i <= 10; $i++) {
        $question_key = 'question_' . $i;
        if (isset($_POST[$question_key])) {
            $score = intval($_POST[$question_key]);
            $totalScore += $score;
            $answers[$question_key] = $score;
        }
    }

    // Tentukan level stres dan warna berdasarkan skor baru
    if ($totalScore >= 25 && $totalScore <= 30) {
        $stressLevel = "Kondisi Mental Baik";
        $color = "green";
    } elseif ($totalScore >= 15 && $totalScore <= 24) {
        $stressLevel = "Cukup Baik, Butuh Perhatian";
        $color = "yellow";
    } elseif ($totalScore >= 5 && $totalScore <= 14) {
        $stressLevel = "Mengalami Tekanan";
        $color = "orange";
    } else {
        $stressLevel = "Butuh Perhatian Serius";
        $color = "red";
    }

    try {
        // Simpan hasil ke database
        $stmt = $pdo->prepare("INSERT INTO daily_feedback (
            user_id, 
            username,
            total_score, 
            stress_level, 
            color, 
            answers_json, 
            created_at
        ) VALUES (?, ?, ?, ?, ?, ?, NOW())");
        
        // Konversi jawaban ke JSON untuk penyimpanan
        $answersJson = json_encode($answers);
        
        // Eksekusi query untuk menyimpan data
        $stmt->execute([
            $user_id, 
            $username,
            $totalScore, 
            $stressLevel, 
            $color, 
            $answersJson
        ]);

        // Redirect ke halaman hasil
        header("Location: ../models/kondisimental.php");
        exit();
    } catch (PDOException $e) {
        // Tangani error database
        $_SESSION['error_message'] = "Gagal menyimpan data: " . $e->getMessage();
        header("Location: ../views/kuisioner.php");
        exit();
    }
} else {
    // Jika akses langsung tanpa POST
    header("Location: ../views/kuisioner.php");
    exit();
}
?>
