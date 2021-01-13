<?php 
if( isset($_GET['format']) && $_GET['format'] == "json" &&
	isset($_GET['email']) && $_GET['email'] != "" ){
	$email_tecnico = $_GET['email'];

	include_once("connection.php");

	if(isset($_GET['lat'])&&isset($_GET['lng'])){
		$lat = $_GET['lat'];
		$lng = $_GET['lng'];
		$slq_update_location = "UPDATE usuario SET usu_latitude = $lat, usu_longitude = $lng WHERE usu_email = '$email_tecnico'";
		$update_location = mysqli_query($conn, $slq_update_location);
	}
	if(isset($_GET['token'])){
		$token = $_GET['token'];
		if($token != "TOKEN"){ 
			$sql = "UPDATE usuario SET usu_token = '" . $token . "' WHERE usu_email = '" . $email_tecnico . "';"; 
			$result = $conn->query($sql); 
		}
	}

	$query  =  "SELECT * FROM chamados_android WHERE usu_email like '$email_tecnico';" ;
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
	echo "<h3>A consulta não foi bem sucedida</h3>";
	echo "Parametros necessários (format: e tecemail:) <br>";
	echo "Parametros opcionais (lat: e lng:)";
}

/*** View chamados_android ***
CREATE OR REPLACE VIEW chamados_android AS (
SELECT c.cham_id, est.est_nome, ser.serv_nome, ser.serv_descricao, cli.cli_nome, cli.cli_celular, cli.cli_telefone, 
	   cli.cli_email, ende.end_logradouro, ende.end_numero, ende.end_complemento, ende.end_bairro, ende.end_cidade, 
	   ende.end_estado, ende.end_latitude, ende.end_longitude, DATE_FORMAT(c.cham_agendado, '%d/%m/%Y') AS data_chamado, 
	   DATE_FORMAT(c.cham_agendado, '%H:%i') AS hora_chamado, tip.icon_mobile, usu.usu_id, usu.usu_email
FROM   chamado_tecnico AS c, cliente AS cli, estatus AS est, servico AS ser, endereco AS ende, usuario AS usu , 
	   tipo_servico AS tip 
WHERE  c.cham_cliente = cli.cli_id AND c.cham_status = est.est_id AND c.cham_servico = ser.serv_id AND 
	   cli.cli_endereco = ende.end_id AND c.cham_tecnico = usu.usu_id AND ser.serv_tipo = tip.id_tp_serv AND 
	   est.est_nome NOT LIKE 'finalizado' AND est.est_nome NOT LIKE 'cancelado'); ***/
?>

