<?php 

$data = $_POST['image'];
$id = $_POST['iduser'];
$mini = $_POST['mini'];

list($type, $data) = explode(';', $data);
list(, $data)      = explode(',', $data);

$data = base64_decode($data);

$imageName = 'user-'.$id.'.png';
file_put_contents('../../upload/'.$imageName, $data);


createThumbnail('../../upload/', '../../upload/mini/', 'user-'.$id, 'png', 30);

function createThumbnail($source_folder, $thumbs_folder, $source_file, $extension, $thumbHeight){
	if ($extension == 'gif') {
		$imgt = "ImageGIF";
		$imgcreatefrom = "ImageCreateFromGIF";
	} else if($extension == 'jpg' || $extension == 'jpeg') {
		$imgt = "ImageJPEG";
		$imgcreatefrom = "ImageCreateFromJPEG";
	} else if ($extension == 'png') {
		$imgt = "ImagePNG";
		$imgcreatefrom = "ImageCreateFromPNG";
	}

	if ($imgt) {
		$img = $imgcreatefrom( $source_folder.$source_file.'.'.$extension );
		$width = imagesx( $img );
		$height = imagesy( $img );
 // keep aspect ratio with these operations...
		$new_width = floor( $width * ( $thumbHeight / $height ) );
		$new_height = $thumbHeight;
		$tmp_img = imagecreatetruecolor( $new_width, $new_height );
		if($extension == 'png'){
			// Disable alpha mixing and set alpha flag if is a png file
			imagealphablending($tmp_img, false);
			imagesavealpha($tmp_img, true);
		}
		imagecopyresized( $tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );
		$imgt( $tmp_img, $thumbs_folder.('m_'.$source_file.'.'.$extension));
	}
}

include_once "../../controller/dao/conexao.php";

$conexao = mysqli_connect($servidor,$usuariobanco,$senhabanco);
$db = mysqli_select_db($conexao, $bancosrv);

if(!$db){
    header("location: http://developintech.com/gestaochamados-v2/servico.php?erro=1");
    die ('Não foi possivel conectar: '.  mysqli_error($conexao));
} else {
	$sql_update_img = "UPDATE usuario SET usu_foto = '".$imageName."' WHERE usuario.usu_id = ".$id.";";
	$result = mysqli_query($conexao,$sql_update_img);
	if(!$result) {
    	die('Erro SQL : ' . mysqli_error($conexao) . '<br><br>SQL: ' . $sql); #for debug
    } else {
    	echo '<script>console.log("Foto atualizada no banco de dados");</script>';
    }
}

echo 'done';

?>