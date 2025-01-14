<?php include './header.php'; ?>

<main class="flex-grow flex items-center justify-center">
    <div class="bg-white shadow-md rounded-lg p-6 w-full max-w-sm mx-4">
        <h2 class="text-2xl font-semibold mb-4 text-center">Selamat Datang Di ProbMaxCare</h2>
        <p class="mb-4 text-center">Silakan login atau registrasi untuk memulai.</p>
        <div class="flex justify-center">
            <a href="/probmaxcare/views/login.php" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition duration-300 mr-2">Login</a>
            <a href="/probmaxcare/views/register.php" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition duration-300">Register</a>
        </div>
    </div>
</main>

<?php include './footer.php'; ?>