<?php 
if( isset($_GET['format']) && $_GET['format'] == "json" &&
	isset($_GET['id']) && $_GET['id'] != "" &&
	isset($_GET['status']) && $_GET['status'] != ""){

	$id = $_GET['id'];
	$status = $_GET['status'];

	include_once("connection.php");

	$sql  =  "UPDATE chamado_tecnico SET cham_status = $status WHERE cham_id = $id" ;

	if ($conn->query($sql) === TRUE) {
    	$response = "Atualizado com sucesso!";
	} else {
    	$response = "Ocorreu um problema na atualização - ERRO: " . $conn->error;
	}

	echo json_encode($response);
}
else{
	echo "A consulta não foi bem sucedida <BR> Parametros necessários (format; id; status:)";
}
?>