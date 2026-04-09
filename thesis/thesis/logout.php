<?php
session_start();
session_unset(); // 清除所有 session 變數
session_destroy(); // 銷毀 session
header("Location: /thesis/login1.php"); // 重新導向至登入頁面
exit();
?>