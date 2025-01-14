<?php
session_start();
include '../config/db.php';
include '../views/navbar.php';

// Pastikan user_id ada di session
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    try {
        // Query untuk mengambil data terakhir yang disimpan untuk user_id
        $query = "SELECT * FROM user_feedback WHERE user_id = :user_id ORDER BY created_at DESC LIMIT 1";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $feedback = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($feedback) {
            echo '<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">';
            echo '<div class="container mx-auto px-6 py-8 bg-white rounded-lg shadow-lg mt-10 max-w-6xl">';
            echo '<h2 class="text-4xl font-bold text-center text-gray-800 mb-10">Hasil Pilihan Anda</h2>';

            // Mood
            echo '<div class="flex flex-col md:flex-row items-center gap-6 mb-10">';
            echo '<div class="w-full md:w-1/2">';
            echo '<h3 class="text-2xl font-semibold text-gray-800 mb-2">Mood Anda:</h3>';
            echo '<p class="text-lg text-gray-600 mb-4">' . htmlspecialchars($feedback['selected_mood']) . '</p>';
            if ($feedback['selected_mood'] == "Bahagia") {
                echo "<p class='text-gray-600'>Interpretasi: Kamu merasa ceria dan penuh semangat! Tetap pertahankan perasaan bahagia ini, dan bagikan energi positif kepada orang di sekitar!</p>";
                $image_url = "../assets/images/mood/happy.jpeg";
            } elseif ($feedback['selected_mood'] == "Sedih") {
                echo "<p class='text-gray-600'>Interpretasi: Terkadang, perasaan sedih datang tanpa sebab yang jelas. Cobalah untuk berbicara dengan seseorang atau melakukan sesuatu yang bisa mengangkat suasana hati kamu.</p>";
                $image_url = "../assets/images/mood/sad.jpeg";
            } elseif ($feedback['selected_mood'] == "Marah") {
                echo "<p class='text-gray-600'>Interpretasi: Perasaan marah bisa menjadi tanda bahwa ada sesuatu yang perlu diubah. Cobalah untuk menenangkan diri dan mencari solusi yang lebih baik untuk menghadapi situasi ini.</p>";
                $image_url = "../assets/images/mood/angry.jpeg";
            } elseif ($feedback['selected_mood'] == "Cemas") {
                echo "<p class='text-gray-600'>Interpretasi: Kecemasan seringkali datang ketika kita merasa tidak memiliki kendali atas situasi. Cobalah untuk berfokus pada hal-hal yang bisa kamu kontrol dan ingat untuk bernafas dalam-dalam.</p>";
                $image_url = "../assets/images/mood/anxious.jpeg";
            }
            echo '</div>';
            echo '<div class="w-full md:w-1/2">';
            echo '<img src="' . htmlspecialchars($image_url) . '" alt="Mood Image" class="rounded-lg shadow-lg w-full">';
            echo '</div>';
            echo '</div>';

            // Habit
            echo '<div class="flex flex-col md:flex-row items-center gap-6 mb-10">';
            echo '<div class="w-full md:w-1/2">';
            echo '<h3 class="text-2xl font-semibold text-gray-800 mb-2">Kebiasaan Anda:</h3>';
            echo '<p class="text-lg text-gray-600 mb-4">' . htmlspecialchars($feedback['selected_habit']) . '</p>';
            if ($feedback['selected_habit'] == "Olahraga") {
                echo "<p class='text-gray-600'>Interpretasi: Olahraga adalah cara yang sangat baik untuk mengurangi stres dan memperbaiki suasana hati. Mungkin kamu sedang mencari cara untuk merasa lebih baik dan lebih energik.</p>";
                $image_url = "../assets/images/habits/sports.jpeg";
            } elseif ($feedback['selected_habit'] == "Membaca") {
                echo "<p class='text-gray-600'>Interpretasi: Membaca bisa menjadi cara yang bagus untuk melarikan diri dari rutinitas atau mencari ketenangan. Kamu mungkin sedang mencari inspirasi atau pemahaman baru tentang dunia.</p>";
                $image_url = "../assets/images/habits/reading.jpeg";
            } elseif ($feedback['selected_habit'] == "Menonton Film") {
                echo "<p class='text-gray-600'>Interpretasi: Menonton Film bisa menjadi cara santai untuk melepas penat setelah hari yang panjang. Ini memberikan hiburan dan waktu untuk bersantai.</p>";
                $image_url = "../assets/images/habits/film.jpeg";
            } elseif ($feedback['selected_habit'] == "Nongkrong") {
                echo "<p class='text-gray-600'>Interpretasi: Nongkrong menunjukkan bahwa kamu menikmati kebersamaan dengan orang-orang terdekatmu. Mungkin kamu sedang mencari koneksi atau hanya ingin menghabiskan waktu yang menyenangkan.</p>";
                $image_url = "../assets/images/habits/hangout.jpeg";
            }
            echo '</div>';
            echo '<div class="w-full md:w-1/2">';
            echo '<img src="' . htmlspecialchars($image_url) . '" alt="Habit Image" class="rounded-lg shadow-lg w-full">';
            echo '</div>';
            echo '</div>';

            // Liking
            echo '<div class="flex flex-col md:flex-row items-center gap-6">';
            echo '<div class="w-full md:w-1/2">';
            echo '<h3 class="text-2xl font-semibold text-gray-800 mb-2">Hal yang Anda Sukai:</h3>';
            echo '<p class="text-lg text-gray-600 mb-4">' . htmlspecialchars($feedback['selected_liking']) . '</p>';
            if ($feedback['selected_liking'] == "Musik") {
                echo "<p class='text-gray-600'>Interpretasi: Musik adalah sahabat yang baik untuk menenangkan pikiran dan hati. Mungkin kamu sedang mencari lagu yang bisa mencerminkan perasaanmu saat ini atau membantu kamu merasa lebih baik.</p>";
                $image_url = "../assets/images/liking/music.jpeg";
            } elseif ($feedback['selected_liking'] == "Makanan") {
                echo "<p class='text-gray-600'>Interpretasi: Makanan bisa menjadi cara untuk merasa lebih baik, memberikan kenyamanan dan kebahagiaan dalam momen yang sulit. Cobalah untuk menikmati hidangan yang kamu sukai untuk meredakan stres.</p>";
                $image_url = "../assets/images/liking/food.jpeg";
            }
            echo '</div>';
            echo '<div class="w-full md:w-1/2">';
            echo '<img src="' . htmlspecialchars($image_url) . '" alt="Liking Image" class="rounded-lg shadow-lg w-full">';
            echo '</div>';
            echo '</div>';

            echo '</div>'; // End container
        } else {
            echo "<p class='text-center text-xl text-red-600 mt-6'>Belum ada data yang disimpan.</p>";
        }
    } catch (PDOException $e) {
        echo "<p class='text-center text-xl text-red-600 mt-6'>Terjadi kesalahan: " . $e->getMessage() . "</p>";
    }
} else {
    echo "<p class='text-center text-xl text-red-600 mt-6'>User tidak ditemukan, harap login terlebih dahulu.</p>";
}

include '../views/footer.php';
?>
