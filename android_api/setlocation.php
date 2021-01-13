<?php 
if( isset($_GET['tecemail']) && $_GET['tecemail'] != "" &&
	isset($_GET['lat']) && $_GET['lat'] != "" &&
	isset($_GET['lng']) && $_GET['lng'] != ""){

	$email = $_GET['email'];
	$lat = $_GET['lat'];
	$lng = $_GET['lng'];

	include_once("connection.php");

	$sql  =  "UPDATE usuario SET usu_latitude = $lat, usu_longitude = $lng WHERE usu_email = $email" ;

	if ($conn->query($sql) === TRUE) {
    	$response = "Atualizado com sucesso!";
	} else {
    	$response = "Ocorreu um problema na atualização - ERRO: " . $conn->error;
	}
	echo json_encode($response);
}
else{
	echo "A consulta não foi bem sucedida <BR> Parametros necessários (email; lat; lng)";
}
?>