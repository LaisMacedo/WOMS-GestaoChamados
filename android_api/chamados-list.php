<?php 
if( isset($_GET['format']) && $_GET['format'] == "json" &&
	isset($_GET['tecemail']) && $_GET['tecemail'] != "" ){

	$emai_tecnico = $_GET['tecemail'];

	include_once("connection.php");

	$query  =  "SELECT c.cham_id, est.est_nome, cli.cli_nome, ser.serv_nome, ende.end_bairro, ende.end_cidade 
				FROM chamado_tecnico AS c, cliente AS cli, estatus AS est, servico AS ser, usuario AS usu, endereco AS ende
				WHERE c.cham_cliente = cli.cli_id AND c.cham_status = est.est_id AND 
				c.cham_tecnico = usu.usu_id AND c.cham_servico = ser.serv_id AND
				cli.cli_endereco = ende.end_id AND usu.usu_email like '$emai_tecnico';" ;


	/*"SELECT c.cham_id, c.cham_descricao, c.cham_observacao, est.est_nome, 
			 	ser.serv_nome, ser.serv_descricao, ser.serv_valor, ser.serv_tempo_estimado, ser.serv_tipo,
				tip.tp_serv_nome, tip.tp_serv_descricao, usu.usu_nome, usu.usu_email,
				cli.cli_id, cli.cli_nome, cli.cli_celular, cli.cli_telefone, cli.cli_email, cli.cli_endereco,
				ende.end_bairro, ende.end_cep, ende.end_cidade, ende.end_complemento, ende.end_estado, ende.end_logradouro, 
				ende.end_numero, ende.end_latitude, ende.end_longitude
				FROM chamado_tecnico AS c, cliente AS cli, estatus AS est, 
				servico AS ser, usuario AS usu, endereco AS ende, tipo_servico AS tip
				WHERE c.cham_cliente = cli.cli_id AND c.cham_status = est.est_id AND 
				c.cham_tecnico = usu.usu_id AND c.cham_servico = ser.serv_id AND
				cli.cli_endereco = ende.end_id AND ser.serv_tipo = tip.id_tp_serv AND
				usu.usu_email like '$emai_tecnico' ;";*/

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
	echo "necessario adicionar <i>?format=json</i> e tambem <i>&tecemail=exemple@email.abc</i> no final da URL";
}
?>