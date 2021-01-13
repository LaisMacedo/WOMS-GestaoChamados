<?php require_once('before_content.php'); ?>
<style type="text/css">
    .small, small {
        font-size: 65% !important;
    }
	.card-text .fa{
		font-size: 25px;
	}
	.card img{
		height: 50px;
		width:50px;
	}
	.card a i{ color:#878787; }
	#lapis :hover { color:#d64a3a; !important }
	#email	  :hover { color:#d64a3a; }
	#celular  :hover { color:#f89c0e; }
	#whatsapp :hover { color:#4ac958; }
	#facebook :hover { color:#3b5998; }
	#twitter  :hover { color:#1bb2e9; }
	#linkedin :hover { color:#0077b5; }
</style>

<?php 
$usuarios = mysqli_query($conexao, "SELECT usu_id, usu_nome, usu_foto, usu_email, usu_celular, usu_whatsapp, usu_facebook, usu_linkedin, usu_twitter, cargo_nome, usu_cargo 
									FROM usuario, cargo WHERE usu_cargo = cargo_id AND usu_id <> 0 ORDER BY cargo_id");

    $total_users = mysqli_fetch_assoc(mysqli_query($conexao, "SELECT count(usu_id) AS total FROM usuario;"));
    $total = $total_users['total'];

    $tecni_users = mysqli_fetch_assoc(mysqli_query($conexao, "SELECT count(usu_id) AS tecnicos FROM usuario WHERE usu_cargo = 3 AND usu_id <> 0;"));
    $tecni = $tecni_users['tecnicos'];

    $atend_users = mysqli_fetch_assoc(mysqli_query($conexao, "SELECT count(usu_id) AS atendesntes FROM usuario WHERE usu_cargo = 2;"));
    $atend = $atend_users['atendesntes'];

    $admin_users = mysqli_fetch_assoc(mysqli_query($conexao, "SELECT count(usu_id) AS administradores FROM usuario WHERE usu_cargo = 1;"));
    $admin = $admin_users['administradores'];
?>
    <?php 
    if($_SESSION['usu_cargo'] == 1){
        echo '<div class="col-md-12 col-lg-2 mb-3">';
        echo '<a href="usuario.php?new"><button type="button" class="btn btn-lg btn-secondary ml-3"><i class="fa fa-plus-square"></i>&nbsp; Cadastrar</button></a>';
        echo '</div>';
        echo '<div class="col-md-12 col-lg-10 mb-3">';
    } else {
        echo '<div class="col-12">';
    }
    ?>
    <div class="col-lg-3 col-md-6 col-sm-12">
        <div class="card">
            <div class="p-0 clearfix">
                <i class="fa fa-users bg-dark p-3 font-2xl mr-1 float-left text-light"></i>
                <?php echo '<div class="h5 text-secondary mb-0 pt-1">' . $total . '</div>'; ?>
                <div class="text-muted text-uppercase font-xs small">Total de Usuários</div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-12">
        <div class="card">
            <div class="p-0 clearfix">
                <i class="fa fa-gavel bg-warning p-3 font-2xl mr-1 float-left text-light"></i>
                <?php echo '<div class="h5 text-secondary mb-0 pt-1">' . $admin . '</div>'; ?>
                <div class="text-muted text-uppercase font-xs small">Administradores</div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-12">
        <div class="card">
            <div class="p-0 clearfix">
                <i class="fa fa-phone bg-info p-3 font-2xl mr-1 float-left text-light"></i>
                <?php echo '<div class="h5 text-secondary mb-0 pt-1">' . $atend . '</div>'; ?>
                <div class="text-muted text-uppercase font-xs small">Atendentes</div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-12">
        <div class="card">
            <div class="p-0 clearfix">
                <i class="fa fa-male bg-primary p-3 font-2xl mr-1 float-left text-light"> </i>
                <?php echo '<div class="h5 text-secondary mb-0 pt-1">' . $tecni . '</div>'; ?>
                <div class="text-muted text-uppercase font-xs small">Técnicos</div>
            </div>
        </div>
    </div>
</div>


<?php 
while($usuario = mysqli_fetch_assoc($usuarios)) { 
    $class_cargo = "badge-success";
    if ($usuario['usu_cargo'] == 1) //1 - administrador - lable amarelo
        $class_cargo = "badge-warning";
    if ($usuario['usu_cargo'] == 2) //2 - atendente - lable azul claro
        $class_cargo = "badge-info";
    if ($usuario['usu_cargo'] == 3 ) //3 - tecnico - lable branco
        $class_cargo = "badge-primary";

	    $vnome = explode(' ', $usuario['usu_nome']); //reduz o nome do usuario
	    if(sizeof($vnome) > 1){
	    	$pos = sizeof($vnome);
	    	$nome1 = $vnome[0];
	    	$nome2 = $vnome[$pos-1];
	    	$nome = $nome1." ".$nome2;
	    } else {
	    	$nome = $vnome[0];
	    }
	    
	    $celular = null;
    ?>

    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="card">
            <?php echo '<a href="usuario.php?view='.$usuario['usu_id'].'">'; ?>
	            <div class="card-header bg-dark">
	                <div class="media">
	                    <?php echo '<img class="align-self-center rounded-circle mr-3 mt-1" alt="" src="upload/'.$usuario['usu_foto'].'">'; ?>
	                	<div class="media-body">
	                    <?php echo '<h5 class="text-light display-6">' . $nome . '</h5>'; 
	                    if($_SESSION['usu_cargo'] == 1){ //o administrador edita todos os usuarios
	                    	echo '<a id="lapis" href="usuario.php?edit=' . $usuario['usu_id'] . '"><i  class="text-light fa fa-pencil pull-right"></i><a>';
                            if($usuario['usu_id']!=$_SESSION['usu_id']){ //mas não se pode excluir a si mesmo
                                echo '<a id="lixeira" data-toggle="modal" id="delete-link" data-target="#modal-del-'.$usuario['usu_id'].'"><i  class="text-light fa fa-trash-o pull-right"></i><a>';
                            }
	                    }
	                    else if($usuario['usu_id']==$_SESSION['usu_id']){ //os restantes usuarios so podem editar o seu proprio perfil
	                    		echo '<a id="lapis" href="usuario.php?edit=' . $usuario['usu_id'] . '"><i class="text-light fa fa-pencil pull-right"></i><a>';
	                    }
	                    
	                    echo '<h5><span class="badge ' . $class_cargo . ' pull-left mt-2">' . $usuario['cargo_nome'] . '</span><h5>'; ?>
	                	</div>
	            	</div>
	            </div>
            </a>
            <div class="card-body">
            </div>
            <div class="card-text text-center pb-3">
            <?php
            	$celular = celFormat($usuario['usu_celular']); #remove caracteres e espaços do numero de celular

            	if ($usuario['usu_email']) {
            		echo '<a id="email" href="mailto:'.$usuario['usu_email'].'?Subject=Olá%20'.$usuario['usu_nome'].'" target="_blank"><i class="fa fa-envelope-o pr-1 pl-1"></i></a>'; }
                if ($usuario['usu_celular']) {
                	echo '<a id="celular" data-toggle="modal" data-target="#modalcontato'.$usuario['usu_id'].'"><i  class="fa fa-tablet pr-1 pl-1"></i></a>'; }
                if ($usuario['usu_whatsapp']) {
                	echo '<a id="whatsapp" href="http://api.whatsapp.com/send?1=pt_BR&phone=55'.$celular.'"><i class="fa fa-whatsapp pr-1 pl-1"></i></a>'; }
                if ($usuario['usu_facebook']) {
                	echo '<a id="facebook" href="'.$usuario['usu_facebook'].'" target="_blank"><i class="fa fa-facebook pr-1 pl-1"></i></a>'; }
                if ($usuario['usu_twitter']) {
                	echo '<a id="twitter" href="'.$usuario['usu_twitter'].'" target="_blank"><i class="fa fa-twitter pr-1 pl-1"></i></a>'; }
                if ($usuario['usu_linkedin']) { 
                	echo '<a id="linkedin" href="'.$usuario['usu_linkedin'].'" target="_blank"><i class="fa fa-linkedin pr-1 pl-1"></i></a>'; }
            ?>
            </div>
        </div>
    </div>



<?php echo '<div class="modal fade" id="modalcontato'.$usuario['usu_id'].'" tabindex="-1" role="dialog" aria-labelledby="modalcontatoL" style="display: none;" aria-hidden="true">';?>
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <?php echo '<h5 class="modal-title" id="modalcontatoL">'.$usuario['usu_nome'].'</h5>'?>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <?php echo '<p>'.$usuario['usu_celular'].'</p>'; ?>
            </div>
            <!--div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div-->
        </div>
    </div>
</div>


<?php #modal deletar cliente
  echo '<div class="modal fade" id="modal-del-'.$usuario['usu_id'].'" tabindex="-1" role="dialog" aria-labelledby="modaldelLabel" style="display: none;" aria-hidden="true">';?>
           <div class="modal-dialog modal-sm" role="dialog">
              <div class="modal-content">
                 <div class="modal-header">
                    <h5 class="modal-title" id="modaldelLabel">Confirmar exclusão</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                 </div>
                 <div class="modal-body">
                    <?php echo'<p>Tem certeza que deseja excluir o cliente: <strong>'.$usuario['usu_nome'].'</strong></p>'; ?>         
                 </div> 
                 <div class="modal-footer"> 
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Não</button>
                    <?php echo '<a href="controller/edit-user.php?delete='.$usuario['usu_id'].'"><button class="btn btn-success">Sim</button></a>'; ?>
                 </div>
              </div>
           </div>
        </div>

<?php } //fim do php 

function celFormat($valor){
	$caracteres = array("(", ")", "-", " ", "/");
	$result = str_replace($caracteres, "", $valor);
	return $result;
}

?> 

<?php 
logMsg( $_SESSION['usu_login']." entrou em a usuarios.php" );
require_once('after_content.php'); ?>