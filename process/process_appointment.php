<?php
session_start();
include '../config/db.php'; // Pastikan konfigurasi PDO di sini

try {
    // Validasi input
    if (!isset($_POST['location']) || !isset($_POST['appointment_date']) || !isset($_POST['appointment_time']) || !isset($_POST['whatsapp_number'])) {
        throw new Exception("Form tidak lengkap. Pastikan semua data diisi.");
    }

    $location = trim($_POST['location']);
    $appointment_date = $_POST['appointment_date']; // Tanggal Janji Temu
    $appointment_time = $_POST['appointment_time']; // Waktu Janji Temu
    $whatsapp_number = $_POST['whatsapp_number']; // Nomor WhatsApp
    $user_id = $_SESSION['user_id'] ?? null; // Pastikan `user_id` diatur saat login
    $username = $_SESSION['username'] ?? null; // Ambil username dari sesi

    if (!$user_id) {
        throw new Exception("Anda harus login untuk membuat janji temu.");
    }

    if (!$username) {
        throw new Exception("Username tidak ditemukan.");
    }

    // Validasi format nomor WhatsApp
    if (!preg_match("/^\+?\d{10,13}$/", $whatsapp_number)) {
        throw new Exception("Nomor WhatsApp tidak valid. Format yang benar: +628123456789 atau 08123456789.");
    }

    // Memastikan format tanggal dan waktu benar
    $appointment_datetime = $appointment_date . ' ' . $appointment_time; // Gabungkan tanggal dan waktu

    // Simpan data ke database
    $stmt = $pdo->prepare("INSERT INTO appointment (user_id, username, location, appointment_date, appointment_time, whatsapp_number, created_at) 
                           VALUES (:user_id, :username, :location, :appointment_date, :appointment_time, :whatsapp_number, NOW())");
    $stmt->execute([
        ':user_id' => $user_id,
        ':username' => $username,
        ':location' => $location,
        ':appointment_date' => $appointment_date,
        ':appointment_time' => $appointment_time,
        ':whatsapp_number' => $whatsapp_number
    ]);

    // Atur flash message
    $_SESSION['flash_message'] = "Janji temu berhasil dibuat!";

} catch (Exception $e) {
    // Tangani error dan atur flash message
    $_SESSION['flash_message'] = "Terjadi kesalahan: " . $e->getMessage();
}

// Arahkan kembali ke halaman janji temu
header("Location: ../views/appointment.php");
exit;
?>
