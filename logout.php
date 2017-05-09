<?php

session_start();
ob_start();

unset($_SESSION['loggedIn']);
unset($_SESSION['role']);

header('Location: login.php');

?>
