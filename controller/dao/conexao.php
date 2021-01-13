<?php
 //parametros de configuração de banco

    $servidor = "localhost";
    $usuariobanco = "";
    $senhabanco = "";
    $bancosrv = "";
    $path = "";

//conexao com banco

	$conexao = mysqli_connect($servidor,$usuariobanco,$senhabanco);
	$db = mysqli_select_db($conexao, $bancosrv);
    if(!$db){
        die ('Não foi possivel conectar: '.  mysqli_error($conexao));
    }
    return $db;
// fim function conectar

?>
