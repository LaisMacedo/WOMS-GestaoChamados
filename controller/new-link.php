<?php
//parametros de configuração de banco

    $servidor = "localhost";
    $usuariobanco = "u894051160_admin";
    $senhabanco = "yamakasi";
    $bancosrv = "u894051160_sgct";
    $path = "";

//conexao com banco

	$conexao = mysqli_connect($servidor,$usuariobanco,$senhabanco);
	$db = mysqli_select_db($conexao, $bancosrv);
    if(!$db){
        die ('Não foi possivel conectar: '.  mysqli_error($conexao));
    }

// fim function conectar

//operação de exclusão por id
if($_SERVER['REQUEST_METHOD'] == "POST") {
	$titulo 	= $_POST['titulo'];
	$url 		= $_POST['url'];
	$icone 		= $_POST['icone'];
	$txt1 		= $_POST['txt1'];
	$txt2 		= $_POST['txt2'];
	if(!isset($_POST['openiframe'])){
		$openiframe = 0;
	} else {
	 	$openiframe = $_POST['openiframe'];
	}

	$sql = "INSERT INTO `links` (`link_titulo`, `link_url`, `link_icone`, `link_txt1`, `link_txt2`, `link_open`) 
			VALUES ('".$titulo."', '".$url."', '".$icone."', '".$txt1."', '".$txt2."', '".$openiframe."');";
	$result = mysqli_query($conexao,$sql);
	if(!$result) {
		die('Erro na exclusao do Link: ' . mysqli_error($conexao));
		header("Refresh: 0; url=../links.php?new=2");
	} else {
		$urlbuild = 'Refresh: 0; url=../links.php?new=1&t='.substr (microtime(), -4);
		header($urlbuild);
	} 
}else {
	header("location: ../links.php?new=3");
}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>inserção de link</title>
	</head>
	<body>
		<h5>inserindo dados no Banco</h5>
	</body>
</html>
<!--
INSERT INTO 'links' ('link_id', 'link_titulo', 'link_url', 'link_icone', 'link_txt1', 'link_txt2', 'link_open') VALUES ('1', 'AAA', 'AAA', 'fa-arrow-circle-o-right', 'Link sem Descrição', 'Link sem Detalhes', '1'), ('2', 'BBB', 'BBB', 'fa-arrow-circle-o-right', 'Link sem Descrição', 'Link sem Detalhes', '1'),('3', 'CCC', 'CCC', 'fa-arrow-circle-o-right', 'Link sem Descrição', 'Link sem Detalhes', '1'), ('4', 'DDD', 'DDD', 'fa-arrow-circle-o-right', 'Link sem Descrição', 'Link sem Detalhes', '1'),('5', 'EEE', 'EEE', 'fa-arrow-circle-o-right', 'Link sem Descrição', 'Link sem Detalhes', '1'), ('6', 'FFF', 'FFF', 'fa-arrow-circle-o-right', 'Link sem Descrição', 'Link sem Detalhes', '1'),('7', 'GGG', 'GGG', 'fa-arrow-circle-o-right', 'Link sem Descrição', 'Link sem Detalhes', '1'), ('8', 'HHH', 'HHH', 'fa-arrow-circle-o-right', 'Link sem Descrição', 'Link sem Detalhes', '1');
-->