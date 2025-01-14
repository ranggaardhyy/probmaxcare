<?php
include '../config/db.php';
session_start();

// Cek apakah user sudah login dan role_id adalah konsultan
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 2) {
    header('Location: ../login.php');
    exit();
}

// Ambil data dari tabel "game_responses"
try {
    $stmtGame = $pdo->prepare("SELECT gr.id, u.username, gr.selected_mood, gr.selected_habit, gr.selected_liking, gr.created_at
                               FROM user_feedback gr
                               JOIN users u ON gr.user_id = u.id
                               ORDER BY gr.created_at DESC");
    $stmtGame->execute();
    $responsesGame = $stmtGame->fetchAll();
    
    // Ambil data dari tabel "daily_feedback"
    $stmtDaily = $pdo->prepare("SELECT df.id, df.username, df.total_score, df.stress_level, df.created_at 
                                FROM daily_feedback df
                                JOIN users u ON df.user_id = u.id
                                ORDER BY df.created_at DESC");
    $stmtDaily->execute();
    $feedbacks = $stmtDaily->fetchAll();
    
    // Ambil data dari tabel "appointments"
    $stmtAppointment = $pdo->prepare("SELECT a.id, a.username, a.location, a.appointment_date, a.appointment_time, a.whatsapp_number, a.created_at
                                      FROM appointment a
                                      JOIN users u ON a.user_id = u.id
                                      ORDER BY a.created_at DESC");
    $stmtAppointment->execute();
    $responsesAppointment = $stmtAppointment->fetchAll();

} catch (PDOException $e) {
    die("Terjadi kesalahan pada server: " . htmlspecialchars($e->getMessage()));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Konsultan</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="flex flex-col min-h-screen bg-gray-100">

    <!-- Header -->
    <header class="bg-white text-gray-600 py-4 shadow">
        <div class="container mx-auto flex justify-between items-center px-4">
            <h1 class="text-2xl font-semibold">ProbMaxCare</h1>
            <nav>
                <a href="../views/logout.php" class="text-white bg-red-500 px-4 py-2 rounded hover:bg-red-400 transition">Logout</a>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto flex-1 p-6 bg-white shadow-lg rounded my-6">
        <!-- PMC Game Section -->
        <h2 class="text-xl font-semibold mb-4">Data PMC Game Pengguna</h2>
        <div class="overflow-x-auto mb-6">
            <table class="w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-blue-100">
                        <th class="border border-gray-300 px-4 py-2">ID</th>
                        <th class="border border-gray-300 px-4 py-2">Username</th>
                        <th class="border border-gray-300 px-4 py-2">Mood</th>
                        <th class="border border-gray-300 px-4 py-2">Kebiasaan</th>
                        <th class="border border-gray-300 px-4 py-2">Kesukaan</th>
                        <th class="border border-gray-300 px-4 py-2">Di Isi Pada Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($responsesGame as $response): ?>
                        <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100">
                            <td class="border border-gray-300 px-4 py-2 text-center"><?= htmlspecialchars($response['id']); ?></td>
                            <td class="border border-gray-300 px-4 py-2 text-center"><?= htmlspecialchars($response['username']); ?></td>
                            <td class="border border-gray-300 px-4 py-2 text-center"><?= htmlspecialchars($response['selected_mood']); ?></td>
                            <td class="border border-gray-300 px-4 py-2 text-center"><?= htmlspecialchars($response['selected_habit']); ?></td>
                            <td class="border border-gray-300 px-4 py-2 text-center"><?= htmlspecialchars($response['selected_liking']); ?></td>
                            <td class="border border-gray-300 px-4 py-2 text-center"><?= htmlspecialchars($response['created_at']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Daily Questions Section -->
        <h2 class="text-xl font-semibold mb-4">Data Tingkat Stres Pengguna</h2>
        <div class="overflow-x-auto mb-6">
            <table class="w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-blue-100">
                        <th class="border border-gray-300 px-4 py-2">ID</th>
                        <th class="border border-gray-300 px-4 py-2">Username</th>
                        <th class="border border-gray-300 px-4 py-2">Skor</th>
                        <th class="border border-gray-300 px-4 py-2">Tingkat Stres Pengguna</th>
                        <th class="border border-gray-300 px-4 py-2">Di Isi Pada Tanggal</th>
                    </tr>
                <tbody>
                    <?php foreach ($feedbacks as $feedback): ?>
                        <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100">
                            <td class="border border-gray-300 px-4 py-2 text-center"><?= htmlspecialchars($feedback['id']); ?></td>
                            <td class="border border-gray-300 px-4 py-2 text-center"><?= htmlspecialchars($feedback['username']); ?></td>
                            <td class="border border-gray-300 px-4 py-2 text-center"><?= htmlspecialchars($feedback['total_score']); ?></td>
                            <td class="border border-gray-300 px-4 py-2 text-center"><?= htmlspecialchars($feedback['stress_level']); ?></td>
                            <td class="border border-gray-300 px-4 py-2 text-center"><?= htmlspecialchars($feedback['created_at']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Appointments Section -->
        <h2 class="text-xl font-semibold mb-4">Data Janji Temu Pengguna</h2>
        <div class="overflow-x-auto">
            <table class="w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-yellow-100">
                        <th class="border border-gray-300 px-4 py-2">ID</th>
                        <th class="border border-gray-300 px-4 py-2">Username</th>
                        <th class="border border-gray-300 px-4 py-2">Nomor Whatsapp</th>
                        <th class="border border-gray-300 px-4 py-2">Lokasi</th>
                        <th class="border border-gray-300 px-4 py-2">Tanggal Pertemuan</th>
                        <th class="border border-gray-300 px-4 py-2">Waktu Pertemuan</th>
                        <th class="border border-gray-300 px-4 py-2">Di Buat Pada Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($responsesAppointment as $response): ?>
                        <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100">
                            <td class="border border-gray-300 px-4 py-2 text-center"><?= htmlspecialchars($response['id']); ?></td>
                            <td class="border border-gray-300 px-4 py-2 text-center"><?= htmlspecialchars($response['username']); ?></td>
                            <td class="border border-gray-300 px-4 py-2 text-center"><?= htmlspecialchars($response['whatsapp_number']); ?></td>
                            <td class="border border-gray-300 px-4 py-2 text-center"><?= htmlspecialchars($response['location']); ?></td>
                            <td class="border border-gray-300 px-4 py-2 text-center"><?= htmlspecialchars($response['appointment_date']); ?></td>
                            <td class="border border-gray-300 px-4 py-2 text-center"><?= htmlspecialchars($response['appointment_time']); ?></td>
                            <td class="border border-gray-300 px-4 py-2 text-center"><?= htmlspecialchars($response['created_at']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white text-gray-600 py-4">
        <div class="container mx-auto text-center">
            <p>&copy; 2024 ProbMaxCare. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>
