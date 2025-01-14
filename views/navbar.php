<nav class="bg-pink-300 text-gray-800 p-4 rounded-lg shadow">
    <div class="container mx-auto flex justify-between items-center">
        <a href="/ProbMaxCare/views/dashboard.php" class="text-lg font-bold hover:text-pink-600 <?= basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'border-b-2 border-pink-600' : ''; ?>">Home</a>
        <ul class="flex space-x-4">
            <li><a href="/ProbMaxCare/views/game.php" class="hover:underline font-semibold<?= basename($_SERVER['PHP_SELF']) == 'game.php' ? 'border-b-2 border-pink-600' : ''; ?>">PMC Game</a></li>
            <li><a href="/ProbMaxCare/views/kuisioner.php" class="hover:underline font-semibold<?= basename($_SERVER['PHP_SELF']) == 'kuisioner.php' ? 'border-b-2 border-pink-600' : ''; ?>">Kuisioner Stres</a></li>
            <!-- Cerita Daring mengarah ke Tawk.to chat -->
            <li>
                <a href="https://tawk.to/chat/676553bcaf5bfec1dbdedff8/1ifhsu6nj" 
                   target="_blank" 
                   class="hover:underline font-semibold<?= basename($_SERVER['PHP_SELF']) == 'chat.php' ? 'border-b-2 border-pink-600' : ''; ?>">
                    Live Chat
                </a>
            </li>
            <li><a href="/ProbMaxCare/views/appointment.php" class="hover:underline font-semibold<?= basename($_SERVER['PHP_SELF']) == 'appointment.php' ? 'border-b-2 border-pink-600' : ''; ?>">Buat Janji</a></li>
        </ul>
        <a href="/ProbMaxCare/views/logout.php" class="font-semibold text-red-600 hover:underline">Logout</a>
    </div>
</nav>
