<?php require_once('before_content.php'); ?> 
<?php
$msg_erro_banco = 'Ocorreu um erro na conexão com o Banco de Dados e não foi possível realizar a alteração';
$msg_erro_exec = 'Ocorreu um erro durante a execução das tarefas solicitadas, aperte SHIFT + F5 e tente novamente';
$msg_ok_delete = ' O Link foi removido com sucesso!';
$msg_ok_edit = ' O Link foi alterado com sucesso!';
$msg_ok_new =  ' O Link foi cirado com sucesso!';
?>
<style type="text/css">
  .icon-link{
    color:#868e96 !important;
    font-size: 60px;
    transition: 0.3s;
  }
  .icon-link:hover{
    color:#2196f3 !important;
    transition: 0.3s;
  }
  .stat-widget-one a:hover{
    color:#2196f3 !important;
    transition: 0.3s;
  }
  .card-title a{
    cursor: pointer;
  }
  .card-title{
    cursor: default;
  }
  
</style>

<script type="text/javascript">
  //$(document).ready(function(){
    // HOME
   // $('#conteudo').load('links.php');
  //});
</script>

<?php 
$del = 0; $new = 0; $edt = 0;
if($_SERVER['REQUEST_METHOD'] == "GET") {
  if(isset($_GET['status'])){
    $del = $_GET['status'];
  }
  if(isset($_GET['new'])){
    $new = $_GET['new'];
  }
  if(isset($_GET['edt'])){
    $edt = $_GET['edt'];
  }
}

$links = mysqli_query($conexao, "SELECT * FROM links"); 
$opcoes = mysqli_query($conexao, "SELECT op_colunas_links FROM opcoes WHERE op_id = 1"); 
$coluna = mysqli_fetch_assoc($opcoes);
$colunas = $coluna['op_colunas_links'];

if($del!=0){
  echo'<script>$( "#result" ).load( "ajax/test.html" );</script>';
  if($del == 1){ 
    echo '<div class="sufee-alert alert with-close alert-success alert-dismissible fade show">';
    echo '<span class="badge badge-pill badge-success">Sucesso</span>&nbsp;'.$msg_ok_delete;
    echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>';}
  if($del == 2){
    echo '<div class="sufee-alert alert with-close alert-warning alert-dismissible fade show">'.$msg_erro_banco;
    echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>';}
  if($del == 3){
    echo '<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">'.$msg_erro_exec;
    echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>';}
} //msgs delete
if($new!=0){
  echo'<script>$( "#result" ).load( "ajax/test.html" );</script>';
  if($new == 1){ 
    echo '<div class="sufee-alert alert with-close alert-success alert-dismissible fade show">';
    echo '<span class="badge badge-pill badge-success">Sucesso</span>&nbsp;'.$msg_ok_new;
    echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>';}
  if($new == 2){
    echo '<div class="sufee-alert alert with-close alert-warning alert-dismissible fade show">'.$msg_erro_banco;
    echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>';}
  if($new == 3){
    echo '<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">'.$msg_erro_exec;
    echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>';}
} //msgs new
if($edt!=0){
  echo'<script>$( "#result" ).load( "ajax/test.html" );</script>';
  if($edt == 1){ 
    echo '<div class="sufee-alert alert with-close alert-success alert-dismissible fade show">';
    echo '<span class="badge badge-pill badge-success">Sucesso</span>&nbsp;'.$msg_ok_edit;
    echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>';}
  if($edt == 2){
    echo '<div class="sufee-alert alert with-close alert-warning alert-dismissible fade show">'.$msg_erro_banco;
    echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>';}
  if($edt == 3){
    echo '<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">'.$msg_erro_exec;
    echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>';}
} //msgs edit

?>
<div class="col col-lg-12">
    <a data-toggle="modal" id="bt-new" data-target="#new-modal"><button type="button" class="btn btn-outline-secondary btn-sm" style="margin-bottom: 25px">
    <i class="fa fa-plus"></i>&nbsp; adicionar</button></a>
</div>

<?php
//foreach gera o card
while($link = mysqli_fetch_assoc($links)) {
	$id_card = $link['link_id'];
	$titulo_card = $link['link_titulo'];
	$link_url = $link['link_url'];
	$icone_nome = $link['link_icone'];
	$texto_destaque = $link['link_txt1'];
	$texto_secundario = $link['link_txt2'];
	$link_open = $link['link_open']; //1 link convencional 2 link para janela com iframe passando id do link por get


	echo '<div class="col-md-' . (12/$colunas) . '">';
	echo '<div class="card border border-secondary">';
	echo '<div class="card-header">';
	echo '<strong class="card-title">' . $titulo_card . '<span class="float-right mt-1">';
	echo '    <a data-toggle="modal" id="bt-delete" data-target="#delete-modal' . $id_card . '">';
	echo '			<i class="fa fa-trash text-danger"></i></a>&nbsp;';
	echo '    <a data-toggle="modal" id="bt-edit" data-target="#edit-modal' . $id_card . '">';
	echo '			<i class="fa fa-edit text-primary"></i></a></span></strong>';
	echo '</div>';
	echo '	<div class="card-body">';
  if($link_open == 2){
    $link_href = 'href="/iframe.php?id=' . $id_card . '"';
  }else{
    $link_href = 'href="'. $link_url .'" target="_blank"';
  }
	echo '		<div class="stat-widget-one">';
	echo '       		<a '.$link_href.'><i class="icon-link fa ' . $icone_nome . ' text-info "></i></a>'; //border-info
	echo '	        	<div class="stat-content dib">';
	echo '	            	<div class="stat-heading"><a '.$link_href.'>' . $texto_destaque . '</a></div>';
	echo '	            	<div class="stat-text"><a '.$link_href.'>' . $texto_secundario . '</a></div>';
	echo '	        	</div>';
	echo '    	</div>';
  echo '  </a>';
	echo '</div>';

	echo '</div>';
	echo '</div>';
?>

<!-- MODAL CONFIRMAR EXCLUSÃO -->
<?php echo '<div class="modal fade" id="delete-modal' . $id_card . '" tabindex="-1" role="dialog"';
	  echo '		aria-labelledby="smallModalLabel" style="display: none;" aria-hidden="true">'; ?>
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="smallModalLabel">Confirmar exclusão</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <?php echo '<p>Tem certeza que deseja excluir o Link: <strong>' . $titulo_card. '</strong></p>';?>
            </div>
            <div class="modal-footer">   
                <button type="button" class="btn btn-danger" data-dismiss="modal">Não</button>
                <?php echo '<a href="controller/delete-link.php?id=' . $id_card . '"><button type="button" class="btn btn-success">Sim</button></a>'; ?>
            </div>
        </div>
    </div>
</div>

<!-- MODAL EDITAR O LINK -->
<?php echo '<div class="modal fade" id="edit-modal' . $id_card . '" tabindex="-1" role="dialog"';
	  echo 'aria-labelledby="mediumModalLabel" style="display: none;" aria-hidden="true">'; ?>
    <?php echo'<form action="controller/edit-link.php" method="post" class="">'; ?>
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mediumModalLabel">Editar Link</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <?php echo '<input type="text" id="id" name="id" class="form-control" value="' . $id_card . '" style="display:none">'; ?>
                </div>
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-addon">Titulo</div>
                    <?php echo '<input type="text" id="titulo" name="titulo" class="form-control" value="' . $titulo_card . '">'; ?>
                    <div class="input-group-addon"><i class="fa fa-bold"></i></div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-addon">URL</div>
                    <?php echo '<input type="text" id="url" name="url" class="form-control" value="' . $link_url . '">'; ?>
                    <div class="input-group-addon"><i class="fa fa-link"></i></div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-addon">Icone (Font Awesome)</div>
                    <?php echo '<input type="text" id="icone" name="icone" class="form-control" value="' . $icone_nome . '">'; ?>
                    <div class="input-group-addon"><a href="listaicones.php" target="_blank"><i class="fa fa-question-circle"></i></a></div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-addon">Descição</div>
                    <?php echo '<input type="text" id="txt1" name="txt1" class="form-control" value="' . $texto_destaque . '">'; ?>
                    <div class="input-group-addon"><i class="fa fa-align-left"></i></div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-addon">Detalhes</div>
                    <?php echo '<input type="text" id="txt2" name="txt2" class="form-control" value="' . $texto_secundario . '">'; ?>
                    <div class="input-group-addon"><i class="fa fa-align-left"></i></div>
                  </div>
                </div>
                <div class="form-check">
                  <div class="checkbox">
                    <label for="openiframe" class="form-check-label ">
                      <?php echo '<input type="checkbox" id="openiframe" name="openiframe" value="'.$link_open.'" class="form-check-input">';
                            echo 'Abrir em um Iframe';?>
                    </label>
                  </div>
                </div>                        
            </div>
            <div class="form-actions form-group">
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Alterar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
    </form>
</div>
<?php }?>

<!-- MODAL NOVO LINK -->
<div class="modal fade" id="new-modal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" style="display: none;" aria-hidden="true">
    <form action="controller/new-link.php" method="post" class="">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mediumModalLabel">Criar Link</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-addon">Titulo</div>
                    <input type="text" id="titulo" name="titulo" class="form-control" value=""> <!--titulo-->
                    <div class="input-group-addon"><i class="fa fa-bold"></i></div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-addon">URL</div>
                    <input type="text" id="url" name="url" class="form-control" value=""> <!--url-->
                    <div class="input-group-addon"><i class="fa fa-link"></i></div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-addon">Icone (Font Awesome)</div>
                    <input type="text" id="icone" name="icone" class="form-control" value=""> <!--icone-->
                    <div class="input-group-addon"><a href="listaicones.php" target="_blank"><i class="fa fa-question-circle"></i></a></div> 
                  </div> 
                </div>
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-addon">Descição</div>
                    <input type="text" id="txt1" name="txt1" class="form-control" value=""> <!--txt1-->
                    <div class="input-group-addon"><i class="fa fa-align-left"></i></div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-addon">Detalhes</div>
                    <input type="text" id="txt2" name="txt2" class="form-control" value=""> <!--txt2-->
                    <div class="input-group-addon"><i class="fa fa-align-left"></i></div>
                  </div>
                </div>
                <div class="form-check">
                  <div class="checkbox">
                    <label for="openiframe" class="form-check-label ">
                      <input type="checkbox" id="openiframe" name="openiframe" value="" class="form-check-input">Abrir em um Iframe <!--openiframe-->
                    </label>
                  </div>
                </div>                        
            </div>
            <div class="form-actions form-group">
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Criar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
    </form>
</div>


<?php
logMsg( $_SESSION['usu_login']." entrou em a links.php");
require_once('after_content.php'); ?>