<?php 
if( isset($_GET['format']) && $_GET['format'] == "json" &&
	isset($_GET['id']) && $_GET['id'] != null ){

	$id_chamado = $_GET['id'];

	include_once("connection.php");

	$query  =  "SELECT c.cham_id, est.est_nome, ende.end_latitude, ende.end_longitude,
				cli.cli_nome, cli.cli_celular, cli.cli_telefone, cli.cli_email, ende.end_logradouro,
				ende.end_numero, ende.end_complemento, ende.end_bairro, ende.end_cidade,  ende.end_estado,
				ser.serv_nome, ser.serv_descricao
				FROM chamado_tecnico AS c, cliente AS cli, estatus AS est, servico AS ser, endereco AS ende
				WHERE c.cham_cliente = cli.cli_id AND c.cham_status = est.est_id AND 
				c.cham_servico = ser.serv_id AND cli.cli_endereco = ende.end_id AND 
				c.cham_id = '$id_chamado';";

	$resultOfQuery = mysqli_query($conn, $query);

	$myArray = array();

	while ($row = $resultOfQuery->fetch_array(MYSQL_ASSOC)) {
		$myArray[] = $row;
	}

	echo json_encode($myArray);

	$resultOfQuery->close();

	exit;
}
else{
	echo "necessario adicionar <i>?format=json</i> e tambem <i>&id=(id_chamado)</i> no final da URL";
}
?>