<?php

include_once "dao/conexao.php";

$conexao = mysqli_connect($servidor,$usuariobanco,$senhabanco);
$db = mysqli_select_db($conexao, $bancosrv);
if(!$db){
    die ('Não foi possivel conectar: '.  mysqli_error($conexao));
}

//fim function conectar

//operação de exclusão por id
if($_SERVER['REQUEST_METHOD'] == "GET") {
	$sql = 'DELETE FROM links WHERE link_id = ' . $_GET['id'] ;
	$result = mysqli_query($conexao,$sql);
	if(!$result) {
		die('Erro na exclusao do Link: ' . mysqli_error($conexao));
		header("Refresh: 0; url=../links.php?status=2");
	} else {
		$urlbuild = 'Refresh: 0; url=../links.php?status=1&t='.substr (microtime(), -4);
		header($urlbuild);
	} 
}else {
	header("location: ../links.php?status=3");
}

?>