<?php
include './header.php';
include '../config/db.php';
session_start();

// Tangkap pesan flash
if (isset($_SESSION['flash_message'])) {
    $flash_message = $_SESSION['flash_message'];
    unset($_SESSION['flash_message']); // Hapus setelah ditampilkan
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $recaptchaResponse = $_POST['g-recaptcha-response'] ?? '';

    if (empty($username) || empty($password)) {
        $error = "Semua kolom wajib diisi!";
    } else {
        // Verifikasi reCAPTCHA
        $secretKey = '6Lc-lJEqAAAAADh9cnnizD5cvH4BpZTXt9tOcoHx'; // Ganti dengan Secret Key Anda
        $verifyUrl = 'https://www.google.com/recaptcha/api/siteverify';

        $response = file_get_contents($verifyUrl . '?secret=' . $secretKey . '&response=' . $recaptchaResponse);
        $responseKeys = json_decode($response, true);

        if (!$responseKeys['success']) {
            $error = "Verifikasi reCAPTCHA gagal. Silakan coba lagi.";
        } else {
            try {
                // Ambil user berdasarkan username
                $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
                $stmt->execute(['username' => $username]);
                $user = $stmt->fetch();

                if (!$user) {
                    $error = "Username atau password salah. Pastikan input Anda benar.";
                } else {
                    // Cek kecocokan password
                    if (password_verify($password, $user['password'])) {
                        // Simpan sesi berdasarkan role_id
                        $_SESSION['user_id'] = $user['id'];
                        $_SESSION['username'] = $user['username'];
                        $_SESSION['role_id'] = $user['role_id'];

                        // Redirect berdasarkan role_id
                        if ($user['role_id'] == 1) { // Admin
                            header('Location: ../controllers/CRUD.php');
                        } elseif ($user['role_id'] == 2) { // Konsultan
                            header('Location: ../controllers/dashboard_consultant.php');
                        } elseif ($user['role_id'] == 3) { // Pengguna
                            header('Location: dashboard.php');
                        } else {
                            $error = "Role tidak dikenali. Silakan hubungi administrator.";
                        }
                        exit();
                    } else {
                        $error = "Username atau password salah. Pastikan input Anda benar.";
                    }
                }
            } catch (PDOException $e) {
                $error = "Terjadi kesalahan pada server: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
            }
        }
    }
}
?>

<!-- Halaman Login -->
<div class="flex justify-center items-center min-h-screen bg-gradient-to-r from-blue-500 to-teal-600">
    <div class="w-full max-w-md p-6 bg-white rounded-lg shadow-xl">
        <h2 class="text-3xl font-semibold text-center text-gray-800 mb-6">Login</h2>

        <!-- Pesan Flash -->
        <?php if (isset($flash_message)): ?>
            <div class="bg-green-100 text-green-500 text-sm p-3 rounded mb-4">
                <?= htmlspecialchars($flash_message, ENT_QUOTES, 'UTF-8') ?>
            </div>
        <?php endif; ?>

        <!-- Pesan Error -->
        <?php if (isset($error)): ?>
            <div class="bg-red-100 text-red-500 text-sm p-3 rounded mb-4">
                <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
            </div>
        <?php endif; ?>

        <form action="login.php" method="POST" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-600" for="username">Username</label>
                <input id="username" name="username" type="text" required placeholder="Masukkan username"
                       class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-600" for="password">Password</label>
                <input id="password" name="password" type="password" required placeholder="Masukkan password"
                       class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>
            <div class="g-recaptcha" data-sitekey="6Lc-lJEqAAAAAL49qMNwwMQp06hxAnlsZoIL8bxR"></div> 
            <button type="submit" class="w-full py-3 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-400 transition duration-300">
                Login
            </button> 

            <!-- Register Link -->
            <p class="mt-4 text-center text-sm text-gray-600">
                Belum punya akun? <a href="register.php" class="text-blue-500 hover:underline">Register di sini</a>.
            </p>
            <!-- Lupa Password Link -->
            <p class="mt-4 text-center text-sm text-gray-600">
                Lupa password? <a href="https://tawk.to/chat/676553bcaf5bfec1dbdedff8/1ifhsu6nj" class="text-blue-500 hover:underline">Klik di sini</a> untuk menghubungi admin.
            </p>

        </form>
    </div>
</div>

<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<?php include './footer.php'; ?>
