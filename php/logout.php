<?php
session_start();
session_destroy();
header("Location: ../user/login.html"); // Updated path to login.html
exit();
?>
