<?php
session_start();
session_destroy();

// Hapus Cookie
setcookie('user_login', '', time() - 3600, "/");
setcookie('user_role', '', time() - 3600, "/");
setcookie('user_email', '', time() - 3600, "/");

header("Location: login.php");
exit();