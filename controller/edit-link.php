<?php

include_once "dao/conexao.php";

$conexao = mysqli_connect($servidor,$usuariobanco,$senhabanco);
$db = mysqli_select_db($conexao, $bancosrv);
if(!$db){
	header("location: ../links.php?edt=2");
    die ('Não foi possivel conectar: '.  mysqli_error($conexao));
}
// fim function conectar

//operação de exclusão por id
$openiframe = 0;
if($_SERVER['REQUEST_METHOD'] == "POST") {
	$id 		= $_POST['id'];
	$titulo 	= $_POST['titulo'];
	$url 		= $_POST['url'];
	$icone 		= $_POST['icone'];
	$txt1 		= $_POST['txt1'];
	$txt2 		= $_POST['txt2'];
	if(isset($_POST['openiframe'])){
		$openiframe = $_POST['openiframe'];
	}

	$sql =  "UPDATE `links` SET `link_titulo` = '".$titulo."', `link_url` = '".$url."', `link_icone` = '".$icone.
			"', `link_txt1` = '".$txt1."', `link_txt2` = '".$txt2."', `link_open` = '".$openiframe."' WHERE `links`.`link_id` = '".$id."';";

	$result = mysqli_query($conexao,$sql);
	if(!$result) {
		die('Erro na exclusao do Link: ' . mysqli_error($conexao));
		header("Refresh: 0; url=../links.php?edt=2");
	} else {
		$urlbuild = 'Refresh: 0; url=../links.php?edt=1&t='.substr (microtime(), -4);
		header($urlbuild);
	} 
} else {
	header("location: ../links.php?edt=3");
}
?>