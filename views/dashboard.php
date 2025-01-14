<?php
session_start();

// Proteksi akses dashboard
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

include 'navbar.php'

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>
        ProblemMaximalCare - Website
    </title>
    <script src="https://cdn.tailwindcss.com">
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;amp;display=swap" rel="stylesheet" />
</head>

<body class="bg-gray-100 text-gray-900 font-roboto">
    <main class="p-4">
        <section class="mb-8">
            <h2 class="text-2xl text-center font-semibold mt-3 mb-4">
                Selamat Datang di ProbMaxCare!, <span class="text-pink-500 font-semibold>"><?= htmlspecialchars($_SESSION['username'] ?? 'Pengguna'); ?>!</span>
            </h2>
            <p class="text-lg text-center p-6 py-2 ml-12 mr-12">
                ProbMaxCare di kembangkan oleh Mahasiswa <span class="font-semibold">Universitas Respati Yogyakarta</span></br>
                Website ini di buat untuk memberikan layanan interaktif dengan gratis kepada orang-orang yang membutuhkan pertolongan
                dalam menangani mental issue yang di alami oleh pengguna. Kami juga menghadirkan berbagai macam fitur untuk meningkatkan pengalaman
                pengguna untuk menikmati layanan yang kami berikan.
            </p>
        </section>
        <section class="mb-8">
            <h2 class="text-3xl font-bold mb-4">
                Fitur Kami
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white p-4 rounded-lg shadow-md">
                    <img alt="PMC Game" class="rounded-lg mb-2" height="200" src="../assets/images/logo/pmcgame.jpeg" width="300" />
                    <h3 class="text-lg font-semibold">
                        PMC Game
                    </h3>
                    <p class="text-gray-600">
                        Fitur ini berisi tentang pilihan yang dapat di pilih oleh pengguna untuk melihat mood, kebiasaan anda dan hal yang anda sukai pada saat waktu luang
                    </p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-md">
                    <img alt="Kuisioner" class="rounded-lg mb-2" height="200" src="../assets/images/logo/kuisioner.jpeg" width="300" />
                    <h3 class="text-lg font-semibold">
                        Kuisioner Stres
                    </h3>
                    <p class="text-gray-600">
                        Pengguna akan di minta untuk mengisi pertanyaan yang telah di sediakan, pengguna harus menjawab sesuai dengan apa yang pengguna rasakan saat ini.
                    </p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-md">
                    <img alt="Live Chat" class="rounded-lg mb-2" height="200" src="../assets/images/logo/livechat.jpeg" width="300" />
                    <h3 class="text-lg font-semibold">
                        Live Chat
                    </h3>
                    <p class="text-gray-600">
                        Berbincang dengan konsultan kami secara daring tanpa harus menunggu lama.
                    </p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-md">
                    <img alt="Appointment" class="rounded-lg mb-2" height="200" src="../assets/images/logo/appointment.jpeg" width="300" />
                    <h3 class="text-lg font-semibold">
                        Buat Janji Temu
                    </h3>
                    <p class="text-gray-600">
                        Buat janji temu setelah berbincang dengan konsultan. Berbincang, Buat Janji, Bertemu.
                    </p>
                </div>
            </div>
        </section>
        <section class="mb-8">
            <h2 class="text-3xl font-bold mb-4">
                Tentang Kami
            </h2>
            <div class="justify-center grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-1">
                <div class="bg-white p-4 rounded-lg shadow-md flex items-center">
                    <img alt="Logo" class="rounded-lg mb-2 mr-4" height="200" src="../assets/images/logo/logo-unriyo.png" width="300" />
                    <div>
                        <h3 class="text-lg font-semibold">
                            Universitas Respati Yogyakarta
                        </h3>
                        <p class="text-gray-600">
                            Website ini di kembangkan oleh Mahasiswa dari <span class="font-bold"> Universitas Respati Yogyakarta Fakultas Kesehatan dan Fakultas Sains dan Teknologi.</span></br>
                            Website dibuat dan dikembangkan oleh <span class="font-semibold">Mahasiswa Prodi S1 Informatika Universitas Respati Yogyakarta,</span> dan dibantu untuk pengembangan lebih lanjut oleh gabungan <span class="font-semibold">Mahasiswa Fakultas Kesehatan Universitas Respati Yogyakarta.</span>
                        </p>
                    </div>
                </div>
            </div>
        </section>
        <script>
            window.embeddedChatbotConfig = {
                chatbotId: "mIHymK_4c0z_83HwDKmG7",
                domain: "www.chatbase.co"
            }
        </script>
        <script
            src="https://www.chatbase.co/embed.min.js"
            chatbotId="mIHymK_4c0z_83HwDKmG7"
            domain="www.chatbase.co"
            defer>
        </script>
        //Start of Tawk.to Script
            <script type="text/javascript">
            var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
            (function(){
            var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
            s1.async=true;
            s1.src='https://embed.tawk.to/676553bcaf5bfec1dbdedff8/1ifhsu6nj';
            s1.charset='UTF-8';
            s1.setAttribute('crossorigin','*');
            s0.parentNode.insertBefore(s1,s0);
            })();
            </script>
<!--End of Tawk.to Script-->
</body>
<?php include 'footer.php'; ?>
</html>