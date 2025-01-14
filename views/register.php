<?php
session_start();
include './header.php';
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $recaptchaResponse = $_POST['g-recaptcha-response'] ?? '';
    $role_id = 3; // Default role_id untuk pengguna biasa

    // Validasi input
    if (empty($username) || empty($email) || empty($password)) {
        $error = "Semua kolom wajib diisi!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Format email tidak valid!";
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
                // Hash password
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                // Cek apakah username atau email sudah ada
                $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = :username OR email = :email");
                $stmt->execute([':username' => $username, ':email' => $email]);
                $userCount = $stmt->fetchColumn();

                if ($userCount > 0) {
                    $error = "Username atau email sudah terdaftar!";
                } else {
                    // Simpan user baru ke database
                    $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role_id) VALUES (:username, :email, :password, :role_id)");
                    $stmt->execute([
                        ':username' => $username,
                        ':email' => $email,
                        ':password' => $hashedPassword,
                        ':role_id' => $role_id
                    ]);

                    $_SESSION['success'] = "Registrasi berhasil. Silakan login.";
                    header('Location: login.php');
                    exit();
                }
            } catch (PDOException $e) {
                $error = "Terjadi kesalahan pada server: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
            }
        }
    }
}
?>

<!-- Halaman Register -->
<div class="flex justify-center items-center min-h-screen bg-gradient-to-r from-teal-500 to-green-600">
    <div class="w-full max-w-md p-6 bg-white rounded-lg shadow-xl">
        <h2 class="text-3xl font-semibold text-center text-gray-800 mb-6">Register</h2>

        <?php if (isset($error)): ?>
            <div class="bg-red-100 text-red-500 text-sm p-3 rounded mb-4">
                <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
            </div>
        <?php endif; ?>

        <form action="register.php" method="POST" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-600" for="username">Username</label>
                <input id="username" name="username" type="text" required placeholder="Masukkan username"
                       class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-600" for="email">Email</label>
                <input id="email" name="email" type="email" required placeholder="Masukkan email"
                       class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-600" for="password">Password</label>
                <input id="password" name="password" type="password" required placeholder="Masukkan password"
                       class="w-full p-3 border border-gray-300 rounded-lg focus:ring -2 focus:ring-teal-500 focus:outline-none">
            </div>
            <div class="g-recaptcha" data-sitekey="6Lc-lJEqAAAAAL49qMNwwMQp06hxAnlsZoIL8bxR"></div>
            <input type="hidden" name="role_id" value="1"> <!-- Default role_id -->
            <button type="submit" class="w-full py-3 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-400 transition duration-300">
                Register
            </button>

            <!-- Login Link -->
            <p class="mt-4 text-center text-sm text-gray-600">
                Sudah punya akun? <a href="login.php" class="text-blue-500 hover:underline">Login di sini</a>.
            </p>
        </form>
    </div>
</div>

<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<?php include './footer.php'; ?>