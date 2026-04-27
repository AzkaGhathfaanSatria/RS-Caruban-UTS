<?php
session_start();
session_destroy();

setcookie('user_login', '', time() - 7200, "/");
setcookie('user_role', '', time() - 7200, "/");
setcookie('user_email', '', time() - 7200, "/");

header("Location: login.php");
exit();