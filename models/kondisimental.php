<?php
include '../config/db.php';
session_start();

// Pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: ../views/login.php');
    exit();
}

try {
    $stmt = $pdo->prepare("SELECT * FROM daily_feedback 
                           WHERE user_id = ? 
                           ORDER BY created_at DESC 
                           LIMIT 1");
    $stmt->execute([$_SESSION['user_id']]);
    $assessment = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$assessment) {
        throw new Exception("Tidak ada data penilaian ditemukan.");
    }

    // Gunakan data dari database
    $totalScore = $assessment['total_score'];
    $stressLevel = $assessment['stress_level'];
    $color = $assessment['color'];
    $username = $assessment['username'];  // Menambahkan kolom username

} catch (Exception $e) {
    // Tangani error jika tidak ada data
    $_SESSION['error_message'] = $e->getMessage();
    header('Location: ../views/kuisioner.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Tingkat Stres</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        orange: {
                            50: '#fff7ed',
                            200: '#fed7aa',
                            600: '#ea580c',
                            700: '#c2410c'
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full">
        <h2 class="text-3xl font-bold text-center mb-6">Hasil Tingkat Stres Anda</h2>
        
        <div class="text-center">
            <p class="text-xl mb-4">
                Username: <span class="font-bold"><?= htmlspecialchars($username) ?></span>
            </p>
            <p class="text-xl mb-4">
                Skor Tingkat Stres: 
                <span class="font-bold 
                    <?php 
                    switch($color) {
                        case 'green':
                            echo 'text-green-600';
                            break;
                        case 'yellow':
                            echo 'text-yellow-600';
                            break;
                        case 'orange':
                            echo 'text-orange-600';
                            break;
                        case 'red':
                            echo 'text-red-600';
                            break;
                        default:
                            echo 'text-gray-600';
                    }
                    ?>"><?= $totalScore ?></span>
            </p>
            <p class="text-xl mb-6">
                Kategori: 
                <span class="font-bold 
                    <?php 
                    switch($color) {
                        case 'green':
                            echo 'text-green-600';
                            break;
                        case 'yellow':
                            echo 'text-yellow-600';
                            break;
                        case 'orange':
                            echo 'text-orange-600';
                            break;
                        case 'red':
                            echo 'text-red-600';
                            break;
                        default:
                            echo 'text-gray-600';
                    }
                    ?>"><?= $stressLevel ?></span>
            </p>

            <!-- Saran berdasarkan level stres -->
            <div class="p-4 rounded-lg border 
                <?php 
                switch($color) {
                    case 'green':
                        echo 'bg-green-50 border-green-200 text-green-700';
                        break;
                    case 'yellow':
                        echo 'bg-yellow-50 border-yellow-200 text-yellow-700';
                        break;
                    case 'orange':
                        echo 'bg-orange-50 border-orange-200 text-orange-700';
                        break;
                    case 'red':
                        echo 'bg-red-50 border-red-200 text-red-700';
                        break;
                    default:
                        echo 'bg-gray-50 border-gray-200 text-gray-700';
                }
                ?>">
                <?php if ($totalScore >= 25 && $totalScore <= 30): ?>
                    <p>Anda berada dalam kondisi mental yang baik. Terus jaga kebiasaan positif!</p>
                <?php elseif ($totalScore >= 15 && $totalScore <= 24): ?>
                    <p>Kondisi mental Anda cukup baik, namun mungkin butuh lebih banyak perhatian dan relaksasi.</p>
                <?php elseif ($totalScore >= 10 && $totalScore <= 14):?>
                    <span class="font-bold text-orange-600"><?= $totalScore ?></span>
                    <span class="font-bold text-orange-600"><?= $stressLevel ?></span>
                        <div class="bg-orange-50 border-orange-200 text-orange-700 p-4 rounded-lg border">
                            <p>Anda mungkin sedang mengalami tekanan. Luangkan waktu untuk istirahat dan cari dukungan.</p>
                        </div>
                <?php else: ?>
                    <p>Kesehatan mental Anda perlu perhatian serius. Jangan ragu untuk berkonsultasi dengan profesional.</p>
                <?php endif; ?>
            </div>

            <!-- Tombol kembali -->
            <a href="../views/kuisioner.php" class="mt-6 inline-block bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600 transition">
                Kembali ke Kuesioner
            </a>
        </div>
    </div>
</body>
</html>
