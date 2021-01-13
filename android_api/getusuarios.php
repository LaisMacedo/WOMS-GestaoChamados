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

	$query  =  "SELECT u.usu_id, u.usu_nome, u.usu_celular, u.usu_whatsapp, c.cargo_nome 
	FROM usuario AS u, cargo AS c 
	WHERE u.usu_cargo = c.cargo_id AND usu_email NOT LIKE '$email_tecnico';" ;

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
	echo "A consulta não foi bem sucedida <BR> Parametros necessários (format: e me:)";
}
?>