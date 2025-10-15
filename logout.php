<?php
session_start();

unset($_SESSION['username']);
unset($_SESSION['full_name']);

header("Location: login.php");

exit();
?>
