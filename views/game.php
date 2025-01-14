<?php
include '../config/db.php';
include 'navbar.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Tentang Mood</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Efek animasi untuk elemen yang dipilih */
        .selected {
            transform: scale(1.1);
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
        }

        /* Efek pulse (getar) */
        @keyframes pulse {
            0% {
                transform: scale(1);
                box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
            }
            50% {
                transform: scale(1.05);
                box-shadow: 0 0 15px rgba(0, 0, 0, 0.4);
            }
            100% {
                transform: scale(1);
                box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
            }
        }

        /* Hover effect tanpa mengubah latar belakang */
        .hover:hover {
            transform: scale(1.05);
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
        }

        .game-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .game-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1rem;
            width: 100%;
        }
    </style>
</head>

<body class="bg-gray-100">

    <!-- Container -->
    <div class="max-w-7xl mx-auto mt-8 p-4">

        <!-- Flash Message -->
        <?php
        // Tampilkan pesan flash jika ada
        if (isset($_SESSION['flash_message'])) {
            echo '<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6 text-center" role="alert">';
            echo $_SESSION['flash_message'];
            echo '</div>';
            // Hapus pesan flash setelah ditampilkan
            unset($_SESSION['flash_message']);
        }
        ?>

        <!-- Title -->
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-6">ProbMaxCare Game</h2>
        <p class="text-1xl font-semibold text-center text-gray-600 mb-6">Pilih salah satu dari opsi di bawah ini untuk melihat apa yang anda butuhkan sekarang ini</p>

<!-- Form -->
        <form action="../process/process_game.php" method="POST" class="space-y-8 flex flex-col items-center">
        <label class="text-left font-bold text-gray-600">Username Anda :
            <input type="text" id="username" name="username" required class="border border-gray-300 rounded-lg px-4 py-2 w-80 mb-1">
        </label>
            <!-- Mood Game -->
            <div class="game-section text-center">
                <h3 class="text-2xl font-semibold mb-4 text-gray-800">Pilih Warna yang Mewakili Mood Anda Saat Ini</h3>
                <div class="game-grid grid grid-cols-2 sm:grid-cols-4 gap-4 justify-center">
                    <!-- Mood - Bahagia -->
                    <label class="cursor-pointer flex flex-col items-center">
                        <input type="radio" name="selected_mood" value="Bahagia" class="hidden" onclick="highlightChoice(this, 'mood')">
                        <div class="bg-yellow-400 w-24 h-24 rounded-lg shadow-lg hover:scale-110 transition-transform duration-300 flex items-center justify-center">
                            <span class="text-white text-xl">Bahagia</span>
                        </div>
                    </label>
                    <!-- Mood - Sedih -->
                    <label class="cursor-pointer flex flex-col items-center">
                        <input type="radio" name="selected_mood" value="Sedih" class="hidden" onclick="highlightChoice(this, 'mood')">
                        <div class="bg-blue-400 w-24 h-24 rounded-lg shadow-lg hover:scale-110 transition-transform duration-300 flex items-center justify-center">
                            <span class="text-white text-xl">Sedih</span>
                        </div>
                    </label>
                    <!-- Mood - Marah -->
                    <label class="cursor-pointer flex flex-col items-center">
                        <input type="radio" name="selected_mood" value="Marah" class="hidden" onclick="highlightChoice(this, 'mood')">
                        <div class="bg-red-500 w-24 h-24 rounded-lg shadow-lg hover:scale-110 transition-transform duration-300 flex items-center justify-center">
                            <span class="text-white text-xl">Marah</span>
                        </div>
                    </label>
                    <!-- Mood - Cemas -->
                    <label class="cursor-pointer flex flex-col items-center">
                        <input type="radio" name="selected_mood" value="Cemas" class="hidden" onclick="highlightChoice(this, 'mood')">
                        <div class="bg-gray-400 w-24 h-24 rounded-lg shadow-lg hover:scale-110 transition-transform duration-300 flex items-center justify-center">
                            <span class="text-white text-xl">Cemas</span>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Habit Game -->
            <div class="game-section text-center">
                <h3 class="text-2xl font-semibold text-gray-800 mb-6">Apa Kebiasaan Anda Sehari-hari?</h3>
                <div class="game-grid grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 px-4 sm:px-8">
                    <!-- Habit - Olahraga -->
                    <label class="cursor-pointer text-center group">
                        <input type="radio" name="selected_habit" value="Olahraga" class="hidden" onclick="highlightChoice(this, 'habit')">
                        <div class="bg-blue-100 p-4 rounded-lg shadow-md hover:bg-blue-200 transition duration-300">
                            <div class="overflow-hidden rounded-full w-32 h-32 mx-auto mb-4">
                                <img src="../assets/images/habits/sports.jpeg" alt="Olahraga" class="object-cover w-full h-full">
                            </div>
                            <p class="font-semibold text-gray-700 group-hover:text-gray-900 transition duration-300">Olahraga</p>
                        </div>
                    </label>
                    <!-- Habit - Membaca -->
                    <label class="cursor-pointer text-center group">
                        <input type="radio" name="selected_habit" value="Membaca" class="hidden" onclick="highlightChoice(this, 'habit')">
                        <div class="bg-green-100 p-4 rounded-lg shadow-md hover:bg-green-200 transition duration-300">
                            <div class="overflow-hidden rounded-full w-32 h-32 mx-auto mb-4">
                                <img src="../assets/images/habits/reading.jpeg" alt="Membaca" class="object-cover w-full h-full">
                            </div>
                            <p class="font-semibold text-gray-700 group-hover:text-gray-900 transition duration-300">Membaca</p>
                        </div>
                    </label>
                    <!-- Habit - Menonton Film -->
                    <label class="cursor-pointer text-center group">
                        <input type="radio" name="selected_habit" value="Menonton Film" class="hidden" onclick="highlightChoice(this, 'habit')">
                        <div class="bg-yellow-100 p-4 rounded-lg shadow-md hover:bg-yellow-200 transition duration-300">
                            <div class="overflow-hidden rounded-full w-32 h-32 mx-auto mb-4">
                                <img src="../assets/images/habits/film.jpeg" alt="Menonton Film" class="object-cover w-full h-full">
                            </div>
                            <p class="font-semibold text-gray-700 group-hover:text-gray-900 transition duration-300">Menonton TV</p>
                        </div>
                    </label>
                    <!-- Habit - Nongkrong -->
                    <label class="cursor-pointer text-center group">
                        <input type="radio" name="selected_habit" value="Nongkrong" class="hidden" onclick="highlightChoice(this, 'habit')">
                        <div class="bg-purple-100 p-4 rounded-lg shadow-md hover:bg-purple-200 transition duration-300">
                            <div class="overflow-hidden rounded-full w-32 h-32 mx-auto mb-4">
                                <img src="../assets/images/habits/hangout.jpeg" alt="Nongkrong" class="object-cover w-full h-full">
                            </div>
                            <p class="font-semibold text-gray-700 group-hover:text-gray-900 transition duration-300">Nongkrong</p>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Liking Game -->
            <div class="game-section text-center">
                <h3 class="text-2xl font-semibold text-gray-800 mb-4">Apa yang Anda Sukai untuk Dilakukan pada Waktu Luang?</h3>
                <div class="game-grid grid grid-cols-2 sm:grid-cols-4 gap-6 justify-center">
                    <!-- Liking - Musik -->
                    <label class="cursor-pointer text-center">
                        <input type="radio" name="selected_liking" value="Musik" class="hidden" onclick="highlightChoice(this, 'liking')">
                        <div class="w-full bg-green-100 p-6 rounded-lg shadow-lg hover:bg-green-200 transition duration-200">
                            <p class="font-semibold text-gray-700">Musik</p>
                        </div>
                    </label>
                    <!-- Liking - Makanan -->
                    <label class="cursor-pointer text-center">
                        <input type="radio" name="selected_liking" value="Makanan" class="hidden" onclick="highlightChoice(this, 'liking')">
                        <div class="w-full bg-orange-100 p-6 rounded-lg shadow-lg hover:bg-orange-200 transition duration-200">
                            <p class="font-semibold text-gray-700">Makanan</p>
                        </div>
                    </label>
                    <!-- Liking - Traveling -->
                    <label class="cursor-pointer text-center">
                        <input type="radio" name="selected_liking" value="Traveling" class="hidden" onclick="highlightChoice(this, 'liking')">
                        <div class="w-full bg-teal-100 p-6 rounded-lg shadow-lg hover:bg-teal-200 transition duration-200">
                            <p class="font-semibold text-gray-700">Traveling</p>
                        </div>
                    </label>
                    <!-- Liking - Olahraga -->
                    <label class="cursor-pointer text-center">
                        <input type="radio" name="selected_liking" value="Olahraga" class="hidden" onclick="highlightChoice(this, 'liking')">
                        <div class="w-full bg-pink-100 p-6 rounded-lg shadow-lg hover:bg-pink-200 transition duration-200">
                            <p class="font-semibold text-gray-700">Olahraga</p>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Submit Button (Centered at the bottom) -->
            <div class="flex justify-center w-full">
                <button type="submit" class="mt-6 bg-blue-500 text-white py-3 px-6 rounded-lg sm:w-1/2 hover:bg-blue-600 transition duration-300">Kirim</button>
            </div>
        </form>

    </div>

    <!-- Footer -->
    <?php include 'footer.php'; ?>

    <!-- Animasi untuk Highlight pilihan -->
    <script>
        function highlightChoice(inputElement, category) {
            // Ambil semua elemen radio dalam kategori yang sama
            const radioButtons = document.querySelectorAll(`input[name="selected_${category}"]`);
            
            // Reset semua pilihan dalam kategori
            radioButtons.forEach(button => {
                const label = button.closest('label');
                label.classList.remove('highlight', 'selected');
            });

            // Tambahkan efek pada label yang dipilih
            const selectedLabel = inputElement.closest('label');
            selectedLabel.classList.add('highlight', 'selected');
        }
    </script>

</body>

</html>
