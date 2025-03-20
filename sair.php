<?php
session_start();
unset($_SESSION['id']);
unset($_SESSION['nome']);
unset($_SESSION['cpf']);
unset($_SESSION['email']);
unset($_SESSION['fone']);
unset($_SESSION['user']);

header('Location: login.php');
?>

