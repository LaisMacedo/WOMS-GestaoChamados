<?php require_once('before_content.php'); ?>
<?php $clientes = mysqli_query($conexao, "select * from clientes_web;"); ?>
<style type="text/css">
   .card-title{
      font-size: 25px;
   }
   #bootstrap-data-table_filter{
      float: right;
      margin-right: 20px;
   }
   #acoes {
      font-size: 18px;
      text-align: center;
      padding: 8px;
   }
   #delete-link:hover{
      color:#dc3545;
   }
   #edit-link:hover{
      color:#007bff;
   }
   #tipos {
      cursor: pointer;
      font-size: 12px;
      padding: 10px 5px;
   }
   #tipos a:hover{
      color:#0056b3!important;
   }
   .centrado{
      margin: auto;
   }
   .mini{
      height: 30px !important; 
      width: 30px !important; 
      border-radius:50% !important;
      margin-right: 6px;
   }
   .sufee-alert{
      margin-left: auto;
      margin-right: auto;
      max-width: 1000px;
   }
   .card{
      max-width: 1000px;
   }
   .card-body{
      padding-left: 0px;
      padding-right: 0px;
   }
   .col-nome{
      min-width: 230px;
   }
   .col-acoes{
      min-width: 80px;
   }
   .col-celular{
      min-width: 150px;
   }

</style>

<?php
$msg_erro = "";
$msg_ok = "";
$erro = false;
$ok = false;

$msg_erro_1 = "Erro na conexão com o banco de dados! tente novamente";
$msg_erro_2 = "Não foi possível criar um novo clinte.";
$msg_erro_3 = "Não foi possível editar o cliente.";
$msg_erro_4 = "Não é possível excluir cliente já associados a chamados técnicos";
$msg_erro_5 = "Não foi possível excluir cliente.";

$msg_ok_1 = "Cliente criado com sucesso!";
$msg_ok_2 = "Cliente editado com sucesso!";
$msg_ok_3 = "Cliente excuido com sucesso!";

$cargo = $_SESSION['usu_cargo'];
$sql_serv = "SELECT p_cli FROM permissoes WHERE p_id = " . $cargo;
$result_perm = mysqli_query($conexao, $sql_serv);
if (!$result_perm) {
   printf("Error: %s\n", mysqli_error($conexao));
   exit();
}
$perm = mysqli_fetch_assoc($result_perm);
$perm = $perm['p_cli'];
$p_view = $perm[0];
$p_edit = $perm[1];     //editar
$p_new  = $perm[2];     //criar
$p_del  = $perm[3];     //excluir

if(isset($_GET['erro'])){
   $erro = $_GET['erro'];
   if ($erro == 1) { $msg_erro = $msg_erro_1; } 
   if ($erro == 2) { $msg_erro = $msg_erro_2; } 
   if ($erro == 3) { $msg_erro = $msg_erro_3; } 
   if ($erro == 4) { $msg_erro = $msg_erro_4; } 
   if ($erro == 5) { $msg_erro = $msg_erro_4; } 
}
if(isset($_GET['ok'])){
   $ok = $_GET['ok'];
   if ($ok == 1) { $msg_ok = $msg_ok_1; } 
   if ($ok == 2) { $msg_ok = $msg_ok_2; } 
   if ($ok == 3) { $msg_ok = $msg_ok_3; } 
}

?>
<div class="row">
   <div class="col-md-12">

   <?php
   if($p_view == 0){
      $erro = 1;
      $msg_erro = "Você não tem permissão para visualizar clientes";
   }
   if($erro){
       echo '<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">';
       echo '<span class="badge badge-pill badge-danger">Erro</span>&nbsp;'.$msg_erro;
       echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>';
   } 
   if($ok){
       echo '<div class="sufee-alert alert with-close alert-success alert-dismissible fade show">';
       echo '<span class="badge badge-pill badge-success">Sucesso</span>&nbsp;'.$msg_ok;
       echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>';
   }
   if($p_view == 1){ ?>
      <div class="card ml-auto mr-auto">
         <div class="card-header">
            <strong class="card-title">Clientes</strong>
            <?php if ($p_new == 1){
                     echo '<a href="cliente.php?new"><button class="float-right btn btn-outline-secondary ml-1 mr-1 mt-1" type="button">';
                     echo '<i class="fa fa-plus-square"></i> Novo</button></a>';
                  } ?>
         </div>
         <div class="card-body">
            <table id="bootstrap-data-table" class="table table-striped table-bordered">
               <thead>
                  <tr>
                     <th class="col-nome">Nome</th>
                     <th class="col-enderco">Endereço</th>
                     <th class="col-email">Email</th>
                     <th class="col-celular">Celular</th>
                     <?php if($p_edit == 1 || $p_del == 1){
                          echo'<th class="col-acoes" id="acoes-t">Ações</th>';
                        } ?>
                  </tr>
               </thead>
               <tbody>
               <?php while($c = mysqli_fetch_assoc($clientes)) { 
                  $endereco = $c['logradouro']." ".$c['numero'].", ".$c['cidade']." - ".$c['estado'];
                  echo '<tr>';
                  echo '   <td id="nome"><a href="cliente.php?view='.$c['id'].'"><strong>'.$c['nome'].'</strong></a></td>';
                  echo '   <td id="end"><a href="mapa.php?lat='.$c['lat'].'&lng='.$c['lng'].'&tipo=3&id='.$c['id'].'">'.$endereco.'</a></td>';
                  echo '   <td id="email"><a href="mailto:'.$c['email'].'?Subject=Olá%20'.$c['nome'].'">'.$c['email'].'</a></td>';
                  echo '   <td id="cel">'.$c['celular'].'</td>';
                  if ($p_edit == 1 || $p_del == 1){
                     echo '   <td id="acoes">';
                     if ($p_edit == 1){ 
                        echo '      <a id="edit-link" href="cliente.php?edit='.$c['id'].'"><i class="fa fa-pencil" style="margin: 0 5px;"></i></a>';
                     }
                     if ($p_del == 1){ 
                        echo '      <a id="delete-link" data-toggle="modal" id="delete-link" data-target="#modal-del-'.$c['id'].'"><i class="fa fa-trash-o" style="margin: 0 5px;"></i></a>';
                     }
                     echo '   </td>';
                  }
                  echo '</tr>'; ?>

                  <?php #modal deletar cliente
                  if ($p_del == 1){ 
                  echo '<div class="modal fade" id="modal-del-'.$c['id'].'" tabindex="-1" role="dialog" aria-labelledby="modaldelLabel" style="display: none;" aria-hidden="true">';?>
                           <div class="modal-dialog modal-sm" role="dialog">
                              <div class="modal-content">
                                 <div class="modal-header">
                                    <h5 class="modal-title" id="modaldelLabel">Confirmar exclusão</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                 </div>
                                 <div class="modal-body">
                                    <?php echo'<p>Tem certeza que deseja excluir o cliente: <strong>'.$c['nome'].'</strong></p>'; ?>         
                                 </div> 
                                 <div class="modal-footer"> 
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Não</button>
                                    <?php echo '<a href="controller/edit-cliente.php?delete='.$c['id'].'"><button class="btn btn-success">Sim</button></a>'; ?>
                                 </div>
                              </div>
                           </div>
                        </div>
                  <?php } #fim if p_del*/?>                  
               <?php } #fim while?>
               </tbody>
            </table>
         </div>
      </div>
      <?php } #fim if view permition?> 
   </div>
</div>

<?php 
logMsg( $_SESSION['usu_login']." entrou em a clientes.php" );
require_once('after_content.php'); ?>


<!--
CREATE OR REPLACE VIEW clientes_web AS (SELECT  c.cli_id AS id, c.cli_nome AS nome, c.cli_rg AS rg, c.cli_cpf AS cpf, c.cli_email AS email, c.cli_telefone AS telefone, c.cli_celular AS celular, c.cli_whatsapp AS whatsapp, c.cli_classificacao AS classificacao, e.end_logradouro AS logradouro, e.end_numero AS numero, e.end_complemento AS complemento, e.end_bairro AS bairro, e.end_cidade AS cidade, e.end_estado AS estado, e.end_cep AS cep, e.end_longitude AS lng, e.end_latitude AS lat, c.cli_endereco AS endereco, e.end_id 
FROM cliente AS c, endereco AS e WHERE c.cli_endereco = e.end_id);
-->