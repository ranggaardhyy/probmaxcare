<?php
session_start();
include '../config/db.php';
include 'navbar.php'; // Menampilkan navbar
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Janji Temu</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-b from-blue-50 to-gray-100 min-h-screen flex flex-col">
    <!-- Main Content -->
    <div class="flex-grow flex items-center justify-center">
        <div class="container max-w-lg mx-auto">
            <!-- Flash Message -->
            <?php
            if (isset($_SESSION['flash_message'])) {
                echo '<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6 mt-6 text-center" role="alert">';
                echo $_SESSION['flash_message'];
                echo '</div>';
                unset($_SESSION['flash_message']); // Hapus pesan setelah ditampilkan
            }
            ?>

            <!-- Card Container -->
            <div class="bg-white rounded-lg mt-6 mb-6 shadow-lg p-8">
                <!-- Title -->
                <h2 class="text-3xl font-bold text-center text-gray-800 mb-6">Buat Janji Temu</h2>
                <p class="text-center text-gray-600 mb-8">Atur jadwal pertemuan dengan konsultan kami dengan mudah.</p>

                <!-- Form -->
                <form id= "appointmentForm" action="../process/process_appointment.php" method="POST" class="space-y-6">
                    <!-- Input Lokasi -->
                    <div>
                        <label for="location" class="block text-gray-700 font-semibold mb-2">Lokasi</label>
                        <input 
                            type="text" 
                            id="location" 
                            name="location" 
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" 
                            placeholder="Masukkan lokasi Anda" 
                            required>
                    </div>
                    
                    <!-- Input Tanggal -->
                    <div>
                        <label for="appointment_date" class="block text-gray-700 font-semibold mb-2">Tanggal Janji</label>
                        <input 
                            type="date" 
                            id="appointment_date" 
                            name="appointment_date" 
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" 
                            required>
                    </div>

                    <!-- Input Waktu -->
                    <div>
                        <label for="appointment_time" class="block text-gray-700 font-semibold mb-2">Waktu Janji</label>
                        <input 
                            type="time" 
                            id="appointment_time" 
                            name="appointment_time" 
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" 
                            required>
                    </div>

                    <!-- Input Nomor WhatsApp -->
                    <div>
                        <label for="whatsapp_number" class="block text-gray-700 font-semibold mb-2">Nomor WhatsApp</label>
                        <input 
                            type="tel" 
                            id="whatsapp_number" 
                            name="whatsapp_number" 
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" 
                            placeholder="Masukkan nomor WhatsApp Anda" 
                            pattern="^\+?\d{0,13}" 
                            required
                            title="Nomor WhatsApp tidak valid. Format yang benar: +628123456789 atau 08123456789."
                        >
                        
                        <span id="whatsapp-error" class="text-red-500 text-sm"></span>
                    </div>

                    <!-- Submit Button -->
                    <div class="text-center">
                        <button 
                            type="submit" 
                            class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-6 rounded-lg shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50 transition duration-200">
                            Buat Janji Temu
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include 'footer.php'; ?>

    <script>
        document.getElementById('appointmentForm').addEventListener('submit', function(event) {
            var whatsappInput = document.getElementById('whatsapp_number');
            var errorMessage = document.getElementById('whatsapp-error');
            var pattern = new RegExp('^\\+?\\d{10,13}$'); // Memastikan panjang nomor minimal 10 karakter dan maksimal 13

            if (!pattern.test(whatsappInput.value)) {
                event.preventDefault(); // Menghentikan pengiriman form
                errorMessage.textContent = "Nomor WhatsApp tidak valid. Format yang benar: +628123456789 atau 08123456789.";
            } else {
                errorMessage.textContent = ""; // Menghapus pesan kesalahan jika valid
            }
        });
    </script>
</body>
</html>
