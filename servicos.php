<?php require_once('before_content.php'); ?>
<?php $servicos = mysqli_query($conexao, "select * from servicos_web;"); ?>
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
</style>

<?php
$msg_erro = "";
$msg_ok = "";
$erro = false;
$ok = false;

$msg_erro_1 = "Erro na conexão com o banco de dados! tente novamente";
$msg_erro_2 = "Não foi possível criar um novo serviço.";
$msg_erro_3 = "Não foi possível editar o serviço.";
$msg_erro_4 = "Não é possível excluir seriços já associados a chamados técnicos";
$msg_erro_5 = "Não foi possível excluir seriços.";

$msg_ok_1 = "Serviço criado com sucesso!";
$msg_ok_2 = "Serviço editado com sucesso!";
$msg_ok_3 = "Serviço excuido com sucesso!";

$cargo = $_SESSION['usu_cargo'];
$sql_serv = "SELECT p_serv FROM permissoes WHERE p_id = " . $cargo;
$result_perm = mysqli_query($conexao, $sql_serv);
if (!$result_perm) {
   printf("Error: %s\n", mysqli_error($conexao));
   exit();
}
$perm = mysqli_fetch_assoc($result_perm);
$perm = $perm['p_serv'];
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
   if($erro){
       echo '<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">';
       echo '<span class="badge badge-pill badge-danger">Erro</span>&nbsp;'.$msg_erro;
       echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>';
   } 
   if($ok){
       echo '<div class="sufee-alert alert with-close alert-success alert-dismissible fade show">';
       echo '<span class="badge badge-pill badge-success">Sucesso</span>&nbsp;'.$msg_ok;
       echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>';
   }?>
      <div class="card ml-auto mr-auto">
         <div class="card-header">
            <strong class="card-title">Serviços</strong>
            <?php if ($p_new == 1){
                     echo '<a href="servico.php?new"><button class="float-right btn btn-outline-secondary ml-1 mr-1 mt-1" type="button">';
                     echo '<i class="fa fa-plus-square"></i> Novo</button></a>';
                  } ?>
         </div>
         <div class="card-body">
            <table id="bootstrap-data-table" class="table table-striped table-bordered">
               <thead>
                  <tr>
                     <th style="min-width: 200px">Nome</th>
                     <th>Descrição</th>
                     <th>Valor</th>
                     <th style="min-width: 150px">Tipo</th>
                     <?php if ($p_edit == 1 || $p_del == 1){
                              echo'  <th>Ações</th>';
                           } ?>
                  </tr>
               </thead>
               <tbody>
               <?php while($s = mysqli_fetch_assoc($servicos)) {
                  echo '<tr>';
                  echo '   <td id="nome"><strong>' . $s['nome'] . '</strong></td>';
                  echo '   <td id="desc">' . $s['descricao'] . '</td>';
                  echo '   <td id="valor">' . $s['valor'] . '</td>';
                  echo '   <td  id="tipos"><div class="centrado"><a data-toggle="modal" data-target="#modal-info-' . $s['id'] . '">';
                  echo '      <img class="mini" src="images/icons/' . $s['icone'] . '"></img>' . $s['tipo'] . ' ' . '</a></div>';
                  echo '   </td>';
                  if ($p_edit == 1 || $p_del == 1){
                     echo '   <td id="acoes">';
                     if ($p_edit == 1){ 
                        echo '      <a id="edit-link" href="servico.php?edit='.$s['id'].'"><i class="fa fa-pencil" style="margin: 0 5px;"></i></a>';
                     }
                     if ($p_del == 1){ 
                        echo '      <a id="delete-link" data-toggle="modal" id="delete-link" data-target="#modal-del-'.$s['id'].'"><i class="fa fa-trash-o" style="margin: 0 5px;"></i></a>';
                     }
                     echo '   </td>';
                  }
                  echo '</tr>'; ?>
                     
                  <?php #modal descrição tipo de serviço
                  echo '<div class="modal fade" id="modal-info-'. $s['id'] .'" tabindex="-1" role="dialog" aria-labelledby="modalinfoLabel" style="display: none;" aria-hidden="true">';
                  echo '   <div class="modal-dialog modal-sm" role="dialog"><div class="modal-content"><div class="modal-header">';
                  echo '   <img class="mini" src="images/icons/' . $s['icone'] . '"></img><h5 class="modal-title" id="modalinfoLabel">' . $s['tipo'] . '</h5>';
                  echo '   <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></div>';
                  echo '   <div class="modal-body"><p>' . $s['descricao_tipo'] . '</p></div></div></div>';
                  echo '</div><!--Modal info serviço-->'; ?>

                  <?php #modal deletar serviço
                  if ($p_del == 1){ 
                  echo '<div class="modal fade" id="modal-del-'.$s['id'].'" tabindex="-1" role="dialog" aria-labelledby="modaldelLabel" style="display: none;" aria-hidden="true">';?>
                           <div class="modal-dialog modal-sm" role="dialog">
                              <div class="modal-content">
                                 <div class="modal-header">
                                    <h5 class="modal-title" id="modaldelLabel">Confirmar exclusão</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                 </div>
                                 <div class="modal-body">
                                    <?php echo'<p>Tem certeza que deseja excluir o serviço: <strong>'.$s['nome'].'</strong></p>'; ?>         
                                 </div> 
                                 <div class="modal-footer"> 
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Não</button>
                                    <?php echo '<a href="controller/edit-servico.php?delete='.$s['id'].'"><button class="btn btn-success">Sim</button></a>'; ?>
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
   </div>
</div>


<?php 
logMsg( $_SESSION['usu_login']." entrou em a servicos.php" );
require_once('after_content.php'); ?>

<!-- VIEW servicos_web
CREATE OR REPLACE VIEW servicos_web AS (SELECT s.serv_id AS id, s.serv_nome AS nome, s.serv_descricao AS descricao, s.serv_valor AS valor, t.tp_serv_nome AS tipo, t.tp_serv_descricao AS descricao_tipo, t.icon_web AS icone FROM servico AS s, tipo_servico as t WHERE s.serv_tipo = t.id_tp_serv);
 -->

<!--
<button type="button" class="btn btn-info" data-toggle="modal" data-target="#contact_dialog">Contact</button>

<div class="modal fade" id="contact_dialog" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Enter your name</h4>
            </div>
                <div class="modal-body">
                    <form id="contact_form" action="/onlinejson/test.php" method="POST">
                        First name: <input type="text" name="first_name"><br/>
                        Last name: <input type="text" name="last_name"><br/>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" id="submitForm" class="btn btn-default">Send</button>
                </div>
            </div>
        </div>
    </div>

<script>
/* must apply only after HTML has loaded */
$(document).ready(function () {
    $("#contact_form").on("submit", function(e) {
        var postData = $(this).serializeArray();
        var formURL = $(this).attr("action");
        $.ajax({
            url: formURL,
            type: "POST",
            data: postData,
            success: function(data, textStatus, jqXHR) {
                $('#contact_dialog .modal-header .modal-title').html("Result");
                $('#contact_dialog .modal-body').html(data);
                $("#submitForm").remove();
            },
            error: function(jqXHR, status, error) {
                console.log(status + ": " + error);
            }
        });
        e.preventDefault();
    });
     
    $("#submitForm").on('click', function() {
        $("#contact_form").submit();
    });
});
</script> 
-->