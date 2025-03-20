<?php
//session_start();
unset($_SESSION['id']);
unset($_SESSION['nome']);
unset($_SESSION['cpf']);
unset($_SESSION['email']);
unset($_SESSION['fone']);
unset($_SESSION['user']);

unset($_SESSION['expire']);

session_destroy();

echo "<meta http-equiv='refresh' content='0; url=index.php?pg=login'>";

//header('Location: ../index.php?pg=login');
?>

