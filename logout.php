<?php
session_start();
session_destroy();
header("Location: login.php"); // Redirigir de nuevo a la página de login
exit();
?>