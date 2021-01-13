<?php require_once('before_content.php'); ?>
<style type="text/css">
    /*input:valid {
        border-color: #28a745;
    }*/
    input:invalid{
        border-color: #dc3545;
    }
    input:invalid:focus{
        border-color: #dc3545;
        box-shadow: 0 0 0 .2rem rgba(220,53,69,.25);
    }
    .list-group-item a {
        margin: 2px;
    }
    .list-group-item a:hover {
        color: #cccccc;
    }
</style>

<?php

$msg_erro_1 = "Você não tem permissão para executar esta operação!";
$msg_erro_2 = "O serviço não foi encontrado";
$msg_erro_3 = "Houve um problema na requisição";


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
    $edit_id = false; $new = false; $erro = 0;
    
if(isset($_GET['edit'])){ 
    if ($p_edit == 1){
        $edit_id = $_GET['edit'];
        $servicos = mysqli_query($conexao, "select * from servicos_web WHERE id = ".$edit_id); 
        if($s = mysqli_fetch_assoc($servicos)){
            $erro = 0;
        }else{
            $edit_id = false;
            $erro = 2;
        }
    } else {
        $erro = 1;
    }
}else{
    if(isset($_GET['new'])){
        if ($p_new == 1){
            $erro = 0;
            $new = true;
        } else {
            $new = false;
            $erro = 1;
        }
    } else {
        $erro = 3;
    }
}

if ($erro == 1) { $msg_erro = $msg_erro_1; } // sem permissão
if ($erro == 2) { $msg_erro = $msg_erro_2; } // o serviço não foi encontrado
if ($erro == 3) { $msg_erro = $msg_erro_3; } // get não definido*/

?> 

<div class="row">
    <div class="col-xl-6 col-lg-8 col-md-12 mr-auto ml-auto">

<?php
if($erro){
    echo '<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">'.$msg_erro;
    echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>';
} ?>


<!--Editar-->    
<?php
$sql_tp_serv = "SELECT id_tp_serv, tp_serv_nome FROM tipo_servico;";
$result_tp_serv = mysqli_query($conexao, $sql_tp_serv);

if($edit_id){ 
    logMsg( $_SESSION['usu_login']." entrou em a servico.php?edit" ); ?>
    <aside class="profile-nav alt">
        <section class="card">
            <!-- INICIO HEADER PERFIL -->
            <div class="card-header user-header alt" style="background-color: #f7f7f7"> <!--#004671  <h2 class="text-light"....-->
                <div class="media">
                    <div class="media-body">
                        <h2 class="text display-6 mt-3">Editar serviço</h2>
                    </div>
                </div>
            </div>
            <!-- FIM HEADER PERFIL -->
            <form class="needs-validation p-3" action="controller/edit-servico.php?update" method="POST">
                 <div class="row form-group"><div class="col col-md-3"><label for="text-input" class=" form-control-label">Nome</label></div>
                    <div class="col-12 col-md-9">
                    <?php echo '<input name="id" style="display:none" value="' . $s['id'] . '">'; ?>
                    <?php echo '<input type="text" name="nome" class="form-control" value="' . $s['nome'] . '" required>'; ?>
                    <small class="form-text text-muted">Nome do serviço</small></div>
                 </div>
                 <div class="row form-group"><div class="col col-md-3">
                    <label for="text-input" class=" form-control-label">Descrição</label></div>
                    <?php echo '<div class="col-12 col-md-9"><textarea name="desc" rows="4" class="form-control" required>' . $s['descricao'] . '</textarea></div></div>'; ?>
                 <div class="row form-group"><div class="col col-md-3"><label for="text-input" class=" form-control-label">Valor</label></div>
                    <div class="col-12 col-md-9">
                    <?php echo '<input type="number" min="0" max="500" name="valor" placeholder="R$" class="form-control" value="' . $s['valor'] . '" required>'; ?>
                    <small class="form-text text-muted">Valor do serviço</small></div></div>
                 <div class="row form-group">
                    <div class="col col-md-3"><label for="selectSm" class=" form-control-label">Tipo</label></div><div class="col-12 col-md-9">
                    <select name="tipo" class="form-control-sm form-control">
                       <?php while ($tp = mysqli_fetch_assoc($result_tp_serv)){
                          if ($tp['tp_serv_nome'] == $s['tipo']){
                             echo '<option value="'.$tp['id_tp_serv'].'" selected>'.$tp['tp_serv_nome'].'</option>'; 
                          } else {
                             echo '<option value="'.$tp['id_tp_serv'].'">'.$tp['tp_serv_nome'].'</option>'; 
                          }
                       } ?>
                    </select></div>
                 </div>
                 <div class="form-actions form-group ml-auto mr-3 mt-2 float-right">
                     <a href="chamados.php"><button class="btn btn-danger btn-md mr-1">Cancelar</button></a>
                     <button id="submitForm" type="submit" class="btn btn-primary btn-md ml-1">Guardar</button>
                 </div>
            </form>
        </section>
    </aside>
<?php } ?> 
<!--Editar-->
<!--Novo-->
<?php if($new){ 
    logMsg( $_SESSION['usu_login']." entrou em a servico.php?new" ); ?>
    <aside class="profile-nav alt">
        <section class="card">
            <!-- INICIO HEADER PERFIL -->
            <div class="card-header user-header alt" style="background-color: #f7f7f7">
                <div class="media">
                    <div class="media-body">
                        <h2 class="text display-6 mt-3">Cadastrar serviço</h2>
                    </div>
                </div>
            </div>
            <!-- FIM HEADER PERFIL -->
            <form class="needs-validation p-3" action="controller/edit-servico.php?create" method="POST">
                <div class="row form-group"><div class="col col-md-3"><label for="text-input" class=" form-control-label">Nome</label></div>
                    <div class="col-12 col-md-9">
                    <input type="text" name="nome" class="form-control" required>
                    <small class="form-text text-muted">Nome do serviço</small></div></div>
                <div class="row form-group"><div class="col col-md-3">
                    <label for="text-input" class=" form-control-label">Descrição</label></div>
                    <div class="col-12 col-md-9"><textarea name="desc" rows="4" class="form-control" required></textarea></div></div>
                <div class="row form-group"><div class="col col-md-3"><label for="text-input" class=" form-control-label">Valor</label></div>
                    <div class="col-12 col-md-9"><input type="number" min="0" max="500" name="valor" placeholder="R$" class="form-control" required>
                    <small class="form-text text-muted">Valor do serviço</small></div></div>
                <div class="row form-group">
                    <div class="col col-md-3"><label for="selectSm" class=" form-control-label">Tipo</label></div><div class="col-12 col-md-9">
                    <select name="tipo" class="form-control-sm form-control">
                     <?php while ($tp = mysqli_fetch_assoc($result_tp_serv)){
                        echo '<option value="'.$tp['id_tp_serv'].'">'.$tp['tp_serv_nome'].'</option>'; 
                     } ?>
                    </select></div>
                </div>
                <div class="form-actions form-group ml-auto mr-3 mt-2 float-right">
                    <a href="servicos.php"><button class="btn btn-danger btn-md mr-1">Cancelar</button></a>
                    <button id="submitForm" type="submit" class="btn btn-primary btn-md ml-1">Guardar</button>
                </div>
            </from>
            </form>
        </section>
    </aside>
<?php } ?> <!-- final da condição - if($edit_id) { -->
<!--Novo-->

    </div> <!--row-->
</div> <!--col-->

<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
      'use strict';
      window.addEventListener('load', function() {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function(form) {
          form.addEventListener('submit', function(event) {
            if (form.checkValidity() === false) {
              event.preventDefault();
              event.stopPropagation();
            }
            form.classList.add('was-validated');
          }, false);
        });
      }, false);
    })();
</script>

<?php require_once('after_content.php'); ?>