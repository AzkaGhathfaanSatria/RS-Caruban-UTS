<?php
// Memulai session
session_start();
// Menghapus seluruh session
session_destroy();

// Diarahkan kembali ke halaman login.php
header("Location: login.php");
exit;
?>