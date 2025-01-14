<?php
session_start();

// Set flash message sebelum session dihancurkan
$_SESSION['flash_message'] = 'Anda berhasil logout. Silakan login kembali untuk melanjutkan.';

// Hancurkan session dan redirect ke login
session_destroy();
header('Location: login.php');
exit();
?>
