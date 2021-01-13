<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

if($_SERVER['REQUEST_METHOD'] == "POST") {
		if ($_POST['chamadoId'] !== ''){
			include_once("connection.php");
			$id = $_POST['chamadoId'];
			$sql = "SELECT cham_foto1 AS fotos FROM chamado_tecnico WHERE cham_id = ".$id; 
			$result = mysqli_fetch_assoc(mysqli_query($conn, $sql));
			if ($result['fotos'] == NULL){
				$prox = 1;
			} else {
				$array_fotos = explode(';', $result['fotos']);
		    	$prox = sizeof($array_fotos) + 1;
			}
			if (($_POST['name'] !== '') && ($_POST['image'] !== '')){
				// get and save picture 1
				$name  = $_POST['name'] . $prox . '.png';
				$image = $_POST['image'];
				$decodedImg = base64_decode($image);
				file_put_contents('../upload/chamados-fotos/'.$name, $decodedImg);
			}		
			if ($prox != 1){
				array_push($array_fotos, $name);
				$fotosStr = implode(';', $array_fotos);
			} else {
				$fotosStr = $name;
			}			

			// set the pictures names in the database chamados
			$sql = "UPDATE chamado_tecnico SET cham_foto1 = '" . $fotosStr . "' WHERE cham_id = " . $id . ";"; 
			
			// if the query can update send "UploadSuccess"
			$result = mysqli_query($conn, $sql);
			if ($result){
				echo "UploadSuccess";
			} else {
				echo "UploadFails";
			}
		}
} else {
	// if POST parameters not set
	echo "Error on request methods";
}
?>