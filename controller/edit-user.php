<?php

require_once('dao/conexao.php');
	$modo = null; $id = null; $nome = null; $cargo = null; $celular = null; $telefone = null; $whatsapp = null;	
	$email = null; $login = null; $nascimento = null; $rg = null; $cpf = null; $facebook = null; $twitter = null;
	$linkedin = null; $logradouro = null; $numero = null; $complemento = null; $bairro = null; $cep = null; 
	$cidade = null; $estado = null; $salt = "U9ynSTe82m";

if($_SERVER['REQUEST_METHOD'] == "POST") {
	$modo		 = $_POST['modo'];
	$id 		 = $_POST['id'];
	$nome 		 = $_POST['nome'];
	$celular 	 = $_POST['celular'];
	$telefone 	 = $_POST['telefone'];
	$whatsapp 	 = $_POST['whatsapp'];
	$email 		 = $_POST['email'];
	$login 		 = $_POST['login'];
	$nascimento  = $_POST['nascimento'];
	$facebook	 = $_POST['facebook'];
	$twitter 	 = $_POST['twitter'];
	$linkedin	 = $_POST['linkedin'];
	$logradouro  = $_POST['logradouro'];
	$numero		 = $_POST['numero'];
	$complemento = $_POST['complemento'];
	$bairro		 = $_POST['bairro'];
	$cep 		 = $_POST['cep'];
	$cidade 	 = $_POST['cidade'];
	$estado		 = $_POST['estado'];
	$senha 	 	 = md5($salt.$_POST['senha']);
	if(isset($_POST['cargo'])){
		$cargo	 = $_POST['cargo'];
	}
	if(isset($_POST['rg'])){
		$rg 	 = $_POST['rg'];
	}
	if(isset($_POST['cpf'])){
		$cpf 	 = $_POST['cpf'];	
	}

	$address = $logradouro." ".$numero." ".$cidade." ".$estado;
	$address = str_replace(" ", "+", $address);
	$url = "http://maps.google.com/maps/api/geocode/json?sensor=false&address=$address";
	$response = file_get_contents($url);
	$json = json_decode($response,TRUE);
	$latitude = $json['results'][0]['geometry']['location']['lat'];
	$longitude = $json['results'][0]['geometry']['location']['lng'];

	#TODO 
	if ($modo == 1) { // monta query para cirar um novo usuario

		$sql_novo_endereco = "INSERT INTO endereco (end_logradouro, end_numero, end_complemento, end_bairro, end_cidade, end_cep, end_estado, end_latitude, end_longitude) 
							  VALUES ('".$logradouro."','".$numero."','".$complemento."','".$bairro."','".$cidade."','".$cep."','".$estado."','".$latitude."','". $longitude."')";			

		$insereenderco = mysqli_query($conexao, $sql_novo_endereco); //insere endereco
    	$endid = mysqli_insert_id($conexao); //pega o id do endereço inserido

    	$sql_novo_usuario = 
    		"INSERT INTO usuario(usu_nome, usu_cpf, usu_rg, usu_celular, usu_login, usu_email, usu_senha, usu_cargo, usu_endereco, usu_telefone, usu_whatsapp, usu_facebook, usu_linkedin, usu_twitter, usu_nascimento) VALUES ('".$nome."','".$cpf."','".$rg."','".$celular."','".$login."','".$email."','".$senha."','".$cargo."','".$endid."','".$telefone."','".$whatsapp."','".$facebook."','".$linkedin."','".$twitter."','".$nascimento."')";

		$insereusuario = mysqli_query($conexao, $sql_novo_usuario);	
		$id = mysqli_insert_id($conexao); //pega o id do usuario inserido

		if(!$insereusuario) {
			die('sql_novo_endereco: ' . $sql_novo_endereco . '<br>' . 'sql_novo_usuario: ' . $sql_novo_usuario . '<br>' . mysqli_error($conexao));
			header('Location: ../usuario.php?new=0&erro=2');
		} else if(!$insereenderco) {
			die('sql_novo_endereco: ' . $sql_novo_endereco . '<br>' . 'sql_novo_usuario: ' . $sql_novo_usuario . '<br>' . mysqli_error($conexao));
			header('Location: ../usuario.php?new=0&erro=3');
		} else {
			header('Location: ../usuario.php?view='.$id.'&ok=1');
		}
	} 

	else if ($modo == 2) { // monta query para alterar o usuario a partir do id
		if(!$cpf || !$rg || !$cargo) {
			if (isset($_POST['senha']) && ($_POST['senha'] != '')){ # editar usuario com alteração de senha 
				$tamanho = strlen($senha);
				if ($tamanho<6) {
					header('Location: ../usuario.php?edit='.$id.'&erro=4');
				}
				$sql_update_usu =  "UPDATE usuario SET usu_nome = '".$nome."', usu_celular = '".$celular."', usu_telefone = '".$telefone."', 
											 usu_whatsapp = '".$whatsapp."', usu_email = '".$email."', usu_senha = '".$senha."', usu_login = '".$login."', usu_nascimento = '".$nascimento."', usu_facebook = '".$facebook."', usu_twitter = '".$twitter."', usu_linkedin = '".$linkedin."' WHERE usu_id = ".$id.";" ;
			} else {
					$sql_update_usu =  "UPDATE usuario SET usu_nome = '".$nome."', usu_celular = '".$celular."', usu_telefone = '".$telefone."', 
											 usu_whatsapp = '".$whatsapp."', usu_email = '".$email."', usu_login = '".$login."', usu_nascimento = '".$nascimento."', usu_facebook = '".$facebook."', usu_twitter = '".$twitter."', usu_linkedin = '".$linkedin."' WHERE usu_id = ".$id.";" ;
			}
		} else {
			if (isset($_POST['senha']) && ($_POST['senha'] != '')){ # editar usuario com alteração de senha 
				$tamanho = strlen($senha);
				if ($tamanho<6) {
					header('Location: ../usuario.php?edit='.$id.'&erro=4');
				}
				$sql_update_usu =  "UPDATE usuario SET usu_nome = '".$nome."', usu_cargo = '".$cargo."', usu_celular = '".$celular."', usu_telefone = '".$telefone."', 
											 usu_whatsapp = '".$whatsapp."', usu_email = '".$email."', usu_senha = '".$senha."', usu_login = '".$login."', usu_nascimento = '".$nascimento."', 
											 usu_rg = '".$rg."', usu_cpf = '".$cpf."', usu_facebook = '".$facebook."', usu_twitter = '".$twitter."', usu_linkedin = '".$linkedin."' WHERE usu_id = ".$id.";" ;
			} else {
					$sql_update_usu =  "UPDATE usuario SET usu_nome = '".$nome."', usu_cargo = '".$cargo."', usu_celular = '".$celular."', usu_telefone = '".$telefone."', 
											 usu_whatsapp = '".$whatsapp."', usu_email = '".$email."', usu_login = '".$login."', usu_nascimento = '".$nascimento."', 
											 usu_rg = '".$rg."', usu_cpf = '".$cpf."', usu_facebook = '".$facebook."', usu_twitter = '".$twitter."', usu_linkedin = '".$linkedin."' WHERE usu_id = ".$id.";" ;
			}			
		}		
			$sql_id_end = "SELECT end_id AS id FROM endereco AS e, usuario AS u WHERE u.usu_endereco = e.end_id AND u.usu_id = ". $id.";";
			$end = mysqli_fetch_assoc(mysqli_query($conexao, $sql_id_end));

			$sql_update_end =  "UPDATE endereco SET end_logradouro = '".$logradouro."', end_numero = '".$numero."', end_complemento = '".$complemento."', end_bairro = '".$bairro."', end_cep = '".$cep."', end_cidade = '".$cidade."', end_estado = '".$estado."' WHERE end_id = ".$end['id'].";";

			$update_usu = mysqli_query($conexao,$sql_update_usu); #executa a query que foi montada para alterar o usuario

			$update_end = mysqli_query($conexao,$sql_update_end); #executa a query que foi montada para alterar o endereço

			if(!$update_usu) {
				die('sql_update_usu: ' . $sql_update_usu . '<br>' . 'sql_update_end: ' . $sql_update_end . '<br>' . mysqli_error($conexao));
				header('Location: ../usuario.php?edit='.$id.'&erro=2');
			} else if(!$update_end) {
				die('sql_update_usu: ' . $sql_update_usu . '<br>' . 'sql_update_end: ' . $sql_update_end . '<br>' . mysqli_error($conexao));
				header('Location: ../usuario.php?edit='.$id.'&erro=3');
			} else {
				header('Location: ../usuario.php?view='.$id.'&ok=1');
			}
	}
} else {
	if(isset($_GET['delete'])){
		$id = $_GET['delete'];
	        $sql_1 = "DELETE FROM usuario WHERE usu_id = ".$id.";";

	        $sql_id_end = "SELECT end_id AS id FROM endereco AS e, usuario AS u WHERE u.usu_endereco = e.end_id AND u.usu_id = ". $id.";";
	        $end = mysqli_fetch_assoc(mysqli_query($conexao, $sql_id_end));
	        $sql_2 = "DELETE FROM endereco WHERE end_id = ".$end['id'].";";

	        $result = mysqli_query($conexao, $sql_1);
	        if ($result){
	        	$result = mysqli_query($conexao, $sql_2);
	        }
			if(!$result) {
					#die('sql_delete_usu: ' . $sql_1 . '<br>' . 'sql_delete_end: ' . $sql_2 . '<br>' . mysqli_error($conexao));
					header('Location: ../usuarios.php?erro=2'); #erro no delete
				} else {
					header('Location: ../usuarios.php?ok=1'); #ok ao deletar
				}
	} else {
		echo "ta dificil";
	}
}
?>