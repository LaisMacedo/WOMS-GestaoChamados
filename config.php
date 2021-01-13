<?php require_once('before_content.php'); ?>

<?php 
if($_SESSION['usu_cargo'] == 1){
?>

<?php if (isset($_GET['backup'])){
		  $file = $_GET['backup'];
		  echo '<iframe width="1" height="1" frameborder="0" src="assets/dbbackup/backups/'.$file.'"></iframe>';
	  } ?>

<style type="text/css">
    .diskete{
        font-size: 25px;
    }
    @media (max-width: 1120px) 
	{ 	td, th {
			transition: 0.5s;
    		padding: 5px !important;
			font-size: 14px;
		}
		.card .card-header strong {
    		display: inline-block !important;
    	} 
    	.table{
    		margin-bottom: 2px;
    	}
    	.alert{
    		font-size: 14px;
    		padding: 10px !important;
    	}
    	.alerta{
    		padding: 0px !important;
    	}
    	button, .btn{
    		font-size: 14px;
    	}
	}
</style>

<div class="card-body">
    <a class="btn btn-outline-secondary mt-2" href="assets/dbbackup/backup.php"><i class="fa fa-cloud-download"></i> Backup Database</a>
    <a class="btn btn-outline-secondary mt-2" href="main.log" download><i class="fa fa-download"></i> Log de Registros</a>
    <a class="btn btn-outline-secondary mt-2" href="error_log" download><i class="fa fa-download"></i> Log de Erros</a>
</div>

<div class="alerta col-12 pl-3 pr-3">
<?php 	if(isset($_GET['ok'])){
			echo '<div class="sufee-alert alert with-close alert-success alert-dismissible fade show col-12">';
			echo '<span class="badge badge-pill badge-success">Sucesso!</span> As configurações foram alteradas.';
		    echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>';
	   	}
	   	if(isset($_GET['erro'])){
			echo '<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show col-12">';
			echo '<span class="badge badge-pill badge-danger">Erro!</span> Ocurreu um erro durante a alteração.';
	    	echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>';
	   	} ?>
</div>
<form action="controller/edit-perm.php" method="POST">
	<div class="col-md-12 col-lg-6">
		<div class="card">
	        <div class="card-header">
	            <i class="mr-2 fa fa-check-square-o"></i>
	            <strong class="card-title">Permissões de Atendentes</strong>
	        </div>
	        <div class="card-body p-0">
	            <table class="table">
	                <thead>
	                    <tr>
	                        <th scope="col"></th>
	                        <th scope="col">Ver</th>
	                        <th scope="col">Editar</th>
	                        <th scope="col">Criar</th>
	                        <th scope="col">Excluir</th>
	                    </tr>
	                </thead>
	                <tbody>
	                    <tr>
	                        <th scope="row">Chamados</th>
	                        <td><label class="switch switch-3d switch-success mb-0" size="sm">
	                            <?php echo '<input type="checkbox" name="a_cham_view" class="switch-input" size="sm"'.$a_cham_view.'>'; ?>
	                            <span class="switch-label" size="sm"></span><span class="switch-handle" size="sm"></span></label></td>
	                        <td><label class="switch switch-3d switch-primary mb-0">
	                            <?php echo '<input type="checkbox" name="a_cham_edit" class="switch-input" size="sm"'.$a_cham_edit.'>'; ?>
	                            <span class="switch-label"></span><span class="switch-handle"></span></label></td>
	                        <td><label class="switch switch-3d switch-warning mb-0">
	                            <?php echo '<input type="checkbox" name="a_cham_new" class="switch-input" size="sm"'.$a_cham_new.'>'; ?>
	                            <span class="switch-label"></span><span class="switch-handle"></span></label></td>
	                        <td><label class="switch switch-3d switch-danger mb-0">
	                            <?php echo '<input type="checkbox" name="a_cham_del" class="switch-input" size="sm"'.$a_cham_del.'>'; ?>
	                            <span class="switch-label"></span><span class="switch-handle"></span></label></td>
	                    </tr>
	                    <tr>
	                        <th scope="row">Usuários</th>
	                        <td><label class="switch switch-3d switch-success mb-0">
	                            <?php echo '<input type="checkbox" name="a_usu_view" class="switch-input" '.$a_usu_view.'>'; ?>
	                            <span class="switch-label"></span><span class="switch-handle"></span></label></td>
	                        <td><label class="switch switch-3d switch-primary mb-0">
	                            <?php echo '<input type="checkbox" name="a_usu_edit" class="switch-input" '.$a_usu_edit.'>'; ?>
	                            <span class="switch-label"></span><span class="switch-handle"></span></label></td>
	                        <td><label class="switch switch-3d switch-warning mb-0">
	                            <?php echo '<input type="checkbox" name="a_usu_new" class="switch-input" '.$a_usu_new.'>'; ?>
	                            <span class="switch-label"></span><span class="switch-handle"></span></label></td>
	                        <td><label class="switch switch-3d switch-danger mb-0">
	                            <?php echo '<input type="checkbox" name="a_usu_del" class="switch-input" '.$a_usu_del.'>'; ?>
	                            <span class="switch-label"></span><span class="switch-handle"></span></label></td>
	                    </tr>
	                    <tr>
	                        <th scope="row">Clientes</th>
	                        <td><label class="switch switch-3d switch-success mb-0">
	                            <?php echo '<input type="checkbox" name="a_cli_view" class="switch-input" '.$a_cli_view.'>'; ?>
	                            <span class="switch-label"></span><span class="switch-handle"></span></label></td>
	                        <td><label class="switch switch-3d switch-primary mb-0">
	                            <?php echo '<input type="checkbox" name="a_cli_edit" class="switch-input" '.$a_cli_edit.'>'; ?>
	                            <span class="switch-label"></span><span class="switch-handle"></span></label></td>
	                        <td><label class="switch switch-3d switch-warning mb-0">
	                            <?php echo '<input type="checkbox" name="a_cli_new" class="switch-input" '.$a_cli_new.'>'; ?>
	                            <span class="switch-label"></span><span class="switch-handle"></span></label></td>
	                        <td><label class="switch switch-3d switch-danger mb-0">
	                            <?php echo '<input type="checkbox" name="a_cli_del" class="switch-input" '.$a_cli_del.'>'; ?>
	                            <span class="switch-label"></span><span class="switch-handle"></span></label></td>
	                    </tr>
	                    <tr>
	                        <th scope="row">Serviços</th>
	                        <td><label class="switch switch-3d switch-success mb-0">
	                            <?php echo '<input type="checkbox" name="a_serv_view" class="switch-input" '.$a_serv_view.'>'; ?>
	                            <span class="switch-label"></span><span class="switch-handle"></span></label></td>
	                        <td><label class="switch switch-3d switch-primary mb-0">
	                            <?php echo '<input type="checkbox" name="a_serv_edit" class="switch-input" '.$a_serv_edit.'>'; ?>
	                            <span class="switch-label"></span><span class="switch-handle"></span></label></td>
	                        <td><label class="switch switch-3d switch-warning mb-0">
	                            <?php echo '<input type="checkbox" name="a_serv_new" class="switch-input" '.$a_serv_new.'>'; ?>
	                            <span class="switch-label"></span><span class="switch-handle"></span></label></td>
	                        <td><label class="switch switch-3d switch-danger mb-0">
	                            <?php echo '<input type="checkbox" name="a_serv_del" class="switch-input" '.$a_serv_del.'>'; ?>
	                            <span class="switch-label"></span><span class="switch-handle"></span></label></td>
	                    </tr>
	                    <tr>
	                        <th scope="row">Links</th>
	                        <td><label class="switch switch-3d switch-success mb-0">
	                            <?php echo '<input type="checkbox" name="a_link_view" class="switch-input" '.$a_link_view.'>'; ?>
	                            <span class="switch-label"></span><span class="switch-handle"></span></label></td>
	                        <td><label class="switch switch-3d switch-primary mb-0">
	                            <?php echo '<input type="checkbox" name="a_link_edit" class="switch-input" '.$a_link_edit.'>'; ?>
	                            <span class="switch-label"></span><span class="switch-handle"></span></label></td>
	                        <td><label class="switch switch-3d switch-warning mb-0">
	                            <?php echo '<input type="checkbox" name="a_link_new" class="switch-input" '.$a_link_new.'>'; ?>
	                            <span class="switch-label"></span><span class="switch-handle"></span></label></td>
	                        <td><label class="switch switch-3d switch-danger mb-0">
	                            <?php echo '<input type="checkbox" name="a_link_del" class="switch-input" '.$a_link_del.'>'; ?>
	                            <span class="switch-label"></span><span class="switch-handle"></span></label></td>
	                    </tr>
	                </tbody>
	            </table>
	        </div>
	    </div>
	</div>

	<div class="col-md-12 col-lg-6">
	    <div class="card">
	        <div class="card-header">
	            <i class="mr-2 fa fa-check-square-o"></i>
	            <strong class="card-title">Permissões de Técnicos</strong>
	        </div>
	        <div class="card-body p-0">
	            <table class="table">
	                <thead>
	                    <tr>
	                        <th scope="col"></th>
	                        <th scope="col">Ver</th>
	                        <th scope="col">Editar</th>
	                        <th scope="col">Criar</th>
	                        <th scope="col">Excluir</th>
	                    </tr>
	                </thead>
	                <tbody>
	                    <tr>
	                        <th scope="row">Chamados</th>
	                        <td><label class="switch switch-3d switch-success mb-0">
	                            <?php echo '<input type="checkbox" name="t_cham_view" class="switch-input" '.$t_cham_view.'>'; ?>
	                            <span class="switch-label"></span><span class="switch-handle"></span></label></td>
	                        <td><label class="switch switch-3d switch-primary mb-0">
	                            <?php echo '<input type="checkbox" name="t_cham_edit" class="switch-input" '.$t_cham_edit.'>'; ?>
	                            <span class="switch-label"></span><span class="switch-handle"></span></label></td>
	                        <td><label class="switch switch-3d switch-warning mb-0">
	                            <?php echo '<input type="checkbox" name="t_cham_new" class="switch-input" '.$t_cham_new.'>'; ?>
	                            <span class="switch-label"></span><span class="switch-handle"></span></label></td>
	                        <td><label class="switch switch-3d switch-danger mb-0">
	                            <?php echo '<input type="checkbox" name="t_cham_del" class="switch-input" '.$t_cham_del.'>'; ?>
	                            <span class="switch-label"></span><span class="switch-handle"></span></label></td>
	                    </tr>
	                    <tr>
	                        <th scope="row">Usuários</th>
	                        <td><label class="switch switch-3d switch-success mb-0">
	                            <?php echo '<input type="checkbox" name="t_usu_view" class="switch-input" '.$t_usu_view.'>'; ?>
	                            <span class="switch-label"></span><span class="switch-handle"></span></label></td>
	                        <td><label class="switch switch-3d switch-primary mb-0">
	                            <?php echo '<input type="checkbox" name="t_usu_edit" class="switch-input" '.$t_usu_edit.'>'; ?>
	                            <span class="switch-label"></span><span class="switch-handle"></span></label></td>
	                        <td><label class="switch switch-3d switch-warning mb-0">
	                            <?php echo '<input type="checkbox" name="t_usu_new" class="switch-input" '.$t_usu_new.'>'; ?>
	                            <span class="switch-label"></span><span class="switch-handle"></span></label></td>
	                        <td><label class="switch switch-3d switch-danger mb-0">
	                            <?php echo '<input type="checkbox" name="t_usu_del" class="switch-input" '.$t_usu_del.'>'; ?>
	                            <span class="switch-label"></span><span class="switch-handle"></span></label></td>
	                    </tr>
	                    <tr>
	                        <th scope="row">Clientes</th>
	                        <td><label class="switch switch-3d switch-success mb-0">
	                            <?php echo '<input type="checkbox" name="t_cli_view" class="switch-input" '.$t_cli_view.'>'; ?>
	                            <span class="switch-label"></span><span class="switch-handle"></span></label></td>
	                        <td><label class="switch switch-3d switch-primary mb-0">
	                            <?php echo '<input type="checkbox" name="t_cli_edit" class="switch-input" '.$t_cli_edit.'>'; ?>
	                            <span class="switch-label"></span><span class="switch-handle"></span></label></td>
	                        <td><label class="switch switch-3d switch-warning mb-0">
	                            <?php echo '<input type="checkbox" name="t_cli_new" class="switch-input" '.$t_cli_new.'>'; ?>
	                            <span class="switch-label"></span><span class="switch-handle"></span></label></td>
	                        <td><label class="switch switch-3d switch-danger mb-0">
	                            <?php echo '<input type="checkbox" name="t_cli_del" class="switch-input" '.$t_cli_del.'>'; ?>
	                            <span class="switch-label"></span><span class="switch-handle"></span></label></td>
	                    </tr>
	                    <tr>
	                        <th scope="row">Serviços</th>
	                        <td><label class="switch switch-3d switch-success mb-0">
	                            <?php echo '<input type="checkbox" name="t_serv_view" class="switch-input" '.$t_serv_view.'>'; ?>
	                            <span class="switch-label"></span><span class="switch-handle"></span></label></td>
	                        <td><label class="switch switch-3d switch-primary mb-0">
	                            <?php echo '<input type="checkbox" name="t_serv_edit" class="switch-input" '.$t_serv_edit.'>'; ?>
	                            <span class="switch-label"></span><span class="switch-handle"></span></label></td>
	                        <td><label class="switch switch-3d switch-warning mb-0">
	                            <?php echo '<input type="checkbox" name="t_serv_new" class="switch-input" '.$t_serv_new.'>'; ?>
	                            <span class="switch-label"></span><span class="switch-handle"></span></label></td>
	                        <td><label class="switch switch-3d switch-danger mb-0">
	                            <?php echo '<input type="checkbox" name="t_serv_del" class="switch-input" '.$t_serv_del.'>'; ?>
	                            <span class="switch-label"></span><span class="switch-handle"></span></label></td>
	                    </tr>
	                    <tr>
	                        <th scope="row">Links</th>
	                        <td><label class="switch switch-3d switch-success mb-0">
	                            <?php echo '<input type="checkbox" name="t_link_view" class="switch-input" '.$t_link_view.'>'; ?>
	                            <span class="switch-label"></span><span class="switch-handle"></span></label></td>
	                        <td><label class="switch switch-3d switch-primary mb-0">
	                            <?php echo '<input type="checkbox" name="t_link_edit" class="switch-input" '.$t_link_edit.'>'; ?>
	                            <span class="switch-label"></span><span class="switch-handle"></span></label></td>
	                        <td><label class="switch switch-3d switch-warning mb-0">
	                            <?php echo '<input type="checkbox" name="t_link_new" class="switch-input" '.$t_link_new.'>'; ?>
	                            <span class="switch-label"></span><span class="switch-handle"></span></label></td>
	                        <td><label class="switch switch-3d switch-danger mb-0">
	                            <?php echo '<input type="checkbox" name="t_link_del" class="switch-input" '.$t_link_del.'>'; ?>
	                            <span class="switch-label"></span><span class="switch-handle"></span></label></td>
	                    </tr>
	                </tbody>
	            </table>
	        </div>
	    </div>
	</div>
	<div class="col-12">
	    <button class="form-perm btn btn-secondary pull-right mt-1 mb-1" type="submit"><i class="fa fa-save"></i> Salvar</button>
	</div>
</form>

<?php 
} else {
	echo '<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show"><span class="badge badge-pill badge-danger">Erro!</span>';
    echo 'Você não tem permissão para alterar configurações.';
    echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>';
}
logMsg( $_SESSION['usu_login']." entrou em a config.php");
require_once('after_content.php'); ?>