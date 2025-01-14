<?php
session_start();
include '../config/db.php';
include 'navbar.php';

// Pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kuisioner Deteksi Stres</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        /* Tooltip styling */
        .tooltip {
            position: relative;
            display: inline-block;
            cursor: pointer;
        }

        .tooltip .tooltiptext {
            visibility: hidden;
            width: 250px;
            background-color: #f9f9f9;
            color: #333;
            text-align: left;
            border-radius: 5px;
            padding: 10px;
            position: absolute;
            z-index: 1;
            bottom: 100%; /* Position above */
            left: 50%;
            transform: translateX(-50%);
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            font-size: 14px;
        }

        .tooltip:hover .tooltiptext {
            visibility: visible;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto mt-8 px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-center mb-6 text-gray-800">Kuesioner Tingkat Stres</h2>
        <p class="text-center mb-4 text-gray-600">Jawab pertanyaan di bawah untuk mengetahui tingkat stres Anda hari ini.</p>

        <div class="bg-white p-8 rounded-lg shadow-lg">
            <form action="../process/process_daily_feedback.php" method="POST">
                <?php
                $questions = [
                    "Bagaimana perasaan Anda dalam 7 hari terakhir?" => [
                        "tooltip" => "Ceritakan kondisi emosional Anda selama satu minggu terakhir.",
                        "options" => [
                            "Sering cemas atau khawatir berlebihan" => 3,
                            "Lelah, kurang semangat, atau mudah tersinggung" => 2,
                            "Baik-baik saja, namun kadang merasa bosan" => 1,
                            "Merasa bahagia dan seimbang" => 0
                        ],
                        "icon" => "fa-smile-beam"
                    ],
                    "Apakah Anda memiliki seseorang untuk diajak berbicara saat sedang stres atau sedih?" => [
                        "tooltip" => "Apakah Anda memiliki dukungan sosial yang memadai?",
                        "options" => [
                            "Ya, saya punya teman/keluarga yang bisa dipercaya" => 3,
                            "Hanya kadang-kadang, tidak selalu" => 2,
                            "Tidak, saya cenderung memendam semuanya sendiri" => 1,
                            "Saya lebih suka menulis atau mengalihkan perhatian ke hobi" => 0
                        ],
                        "icon" => "fa-users"
                    ],
                    "Berapa jam tidur Anda rata-rata setiap malam?" => [
                        "tooltip" => "Tidur yang cukup penting untuk kesehatan mental Anda.",
                        "options" => [
                            "Kurang dari 5 jam" => 3,
                            "5-6 jam" => 2,
                            "7-8 jam" => 1,
                            "Lebih dari 8 jam" => 0
                        ],
                        "icon" => "fa-bed"
                    ],
                    "Apa yang biasanya Anda lakukan untuk mengatasi stres?" => [
                        "tooltip" => "Berbagai cara dapat digunakan untuk mengurangi stres.",
                        "options" => [
                            "Olahraga atau melakukan aktivitas fisik" => 3,
                            "Bermeditasi, membaca, atau melakukan hobi" => 2,
                            "Menonton film, bermain game, atau makan camilan" => 1,
                            "Tidak melakukan apa pun, hanya membiarkan stres menumpuk" => 0
                        ],
                        "icon" => "fa-dumbbell"
                    ],
                    "Seberapa sering Anda merasa kewalahan dengan rutinitas sehari-hari?" => [
                        "tooltip" => "Rutinitas yang terlalu padat bisa menyebabkan stres.",
                        "options" => [
                            "Hampir setiap hari" => 3,
                            "Beberapa kali dalam seminggu" => 2,
                            "Kadang-kadang" => 1,
                            "Jarang atau tidak pernah" => 0
                        ],
                        "icon" => "fa-calendar-alt"
                    ],
                    "Apakah Anda merasa puas dengan kualitas hubungan Anda dengan keluarga atau teman?" => [
                        "tooltip" => "Hubungan sosial yang baik dapat mengurangi stres.",
                        "options" => [
                            "Ya, sangat puas" => 3,
                            "Cukup puas" => 2,
                            "Tidak terlalu puas" => 1,
                            "Tidak puas sama sekali" => 0
                        ],
                        "icon" => "fa-heart"
                    ],
                    "Saat menghadapi masalah, bagaimana reaksi Anda?" => [
                        "tooltip" => "Cara Anda mengatasi masalah dapat mempengaruhi tingkat stres.",
                        "options" => [
                            "Menghadapinya dengan berpikir positif dan tenang" => 3,
                            "Menunda penyelesaian masalah hingga terasa mendesak" => 2,
                            "Cemas atau panik, tapi tetap mencoba menyelesaikannya" => 1,
                            "Menghindari masalah sepenuhnya" => 0
                        ],
                        "icon" => "fa-question-circle"
                    ],
                    "Seberapa sering Anda meluangkan waktu untuk diri sendiri (self-care)?" => [
                        "tooltip" => "Merawat diri sendiri sangat penting untuk kesejahteraan mental.",
                        "options" => [
                            "Setiap hari" => 3,
                            "Beberapa kali seminggu" => 2,
                            "Jarang, mungkin hanya sebulan sekali" => 1,
                            "Tidak pernah sama sekali" => 0
                        ],
                        "icon" => "fa-spa"
                    ],
                    "Apakah Anda merasa terbebani oleh ekspektasi dari orang lain (keluarga, teman, atau pekerjaan)?" => [
                        "tooltip" => "Ekspektasi yang berlebihan bisa m menjadi sumber stres.",
                        "options" => [
                            "Sangat sering" => 3,
                            "Cukup sering" => 2,
                            "Kadang-kadang" => 1,
                            "Tidak pernah" => 0
                        ],
                        "icon" => "fa-users-cog"
                    ],
                    "Bagaimana Anda menilai kesehatan mental Anda saat ini?" => [
                        "tooltip" => "Penting untuk menilai kondisi kesehatan mental Anda secara rutin.",
                        "options" => [
                            "Sangat baik dan stabil" => 3,
                            "Cukup baik, meskipun kadang ada masalah kecil" => 2,
                            "Tidak terlalu baik, saya sering merasa sedih/cemas" => 1,
                            "Buruk, saya merasa perlu bantuan untuk mengatasinya" => 0
                        ],
                        "icon" => "fa-brain"
                    ]
                ];

                $index = 1;
                foreach ($questions as $question => $details) {
                    echo "<div class='mb-6'>";
                    echo "<label class='block text-gray-700 text-lg font-semibold mb-2'>$index. ";
                    echo "<i class='fas {$details['icon']} text-blue-500'></i> $question ";
                    echo "<span class='tooltip'><i class='fas fa-info-circle text-gray-500'></i>";
                    echo "<span class='tooltiptext'>{$details['tooltip']}</span></span></label>";
                    echo "<div class='flex flex-col space-y-2'>";
                    foreach ($details['options'] as $option => $value) {
                        echo "<label class='flex items-center'><input type='radio' name='question_$index' value='$value' required class='mr-2'>$option</label>";
                    }
                    echo "</div>";
                    echo "</div>";
                    $index++;
                }
                ?>

                <button type="submit" class="w-full sm:w-auto bg-blue-500 text-white px-6 py-2 rounded-lg shadow-lg hover:bg-blue-600">Kirim</button>
            </form>
        </div>
    </div>
</body>
</html>
