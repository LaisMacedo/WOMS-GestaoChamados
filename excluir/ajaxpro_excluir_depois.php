<?php 

$data = $_POST['image'];
$id = $_POST['id'];

list($type, $data) = explode(';', $data);
list(, $data)      = explode(',', $data);

$data = base64_decode($data);
$imageName = time().'.png';
file_put_contents('upload/'.$imageName, $data);


include_once('dao/conexao.php'); 

	$sql =  "UPDATE usuario SET usu_foto = '" . $imageName . "' WHERE usu_id = " . $id . ";";
		
    $result = mysqli_query($conexao, $sql));

	if(!$result) {
		die('Erro na alteração da foto de perfil: ' . mysqli_error($conexao));
		header("location: perfil.php?erro=1"); //imagem não gravada bo banco
	} else {
		header("location: perfil.php?ok=1"); //imagem gravada no banco
	} 

echo 'done';




?>