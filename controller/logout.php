<?php
session_start();

//Se tiver o usuario registrado na session,
if(isset($_SESSION['usu_login'])){
	session_destroy();
	header('Location: ../login.php');
	exit();
} else {
	header('Location: ../login.php');
}
?>