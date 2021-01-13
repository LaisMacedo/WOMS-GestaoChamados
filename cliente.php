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
    .form-control:disabled {
        background-color: #f7f7f7;
        border:none;
    }
</style>

<?php

$msg_erro_1 = "Você não tem permissão para executar esta operação!";
$msg_erro_2 = "O cliente não foi encontrado";
$msg_erro_3 = "Houve um problema na requisição";


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
    $view_id = false; $edit_id = false; $new = false; $erro = 0;
    
if(isset($_GET['view'])){ 
    if ($p_view == 1){
        $view_id = $_GET['view'];
        $clientes = mysqli_query($conexao, "select * from cliente WHERE cli_id = ".$view_id); 
        if($cli = mysqli_fetch_assoc($clientes)){
            $erro = 0;
        }else{
            $view_id = false;
            $erro = 2;
        }
    } else {
        $erro = 1;
    }
}
if(isset($_GET['edit'])){ 
    if ($p_edit == 1){
        $edit_id = $_GET['edit'];
        $clientes = mysqli_query($conexao, "select * from cliente WHERE cli_id = ".$edit_id); 
        if($cli = mysqli_fetch_assoc($clientes)){
            $erro = 0;
        }else{
            $edit_id = false;
            $erro = 2;
        }
    } else {
        $erro = 1;
    }
}
if(isset($_GET['new'])){
    if ($p_new == 1){
        $erro = 0;
        $new = true;
    } else {
        $new = false;
        $erro = 1;
    }
} 
if(isset($_GET['view']) && isset($_GET['edit']) && isset($_GET['new'])){
    $erro = 3;
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
$estados = mysqli_query($conexao,"SELECT * FROM estados"); //id sigla nome

if($view_id){ 
    $c = mysqli_fetch_assoc(mysqli_query($conexao, "select * from cliente WHERE cli_id = ".$view_id));
    $e = mysqli_fetch_assoc(mysqli_query($conexao, "select * from endereco WHERE end_id = ".$c['cli_endereco']));
    logMsg( $_SESSION['usu_login']." entrou em a cliente.php?view" ); ?>
    <aside class="profile-nav alt">
        <section class="card">
            <!-- INICIO HEADER PERFIL -->
            <div class="card-header user-header alt" style="background-color: #f7f7f7"> <!--#004671  <h2 class="text-light"....-->
                <div class="media">
                    <div class="media-body">
                        <h2 class="text display-6 mt-3"><?php echo $c['cli_nome']; ?></h2>
                    </div>
                </div>
            </div>
            <!-- FIM HEADER PERFIL -->
            <form class="needs-validation" action="controller/clientes.php" method="POST">
        <div class="card-body card-block">
      <?php #celular
            echo '<div class="form-group col-md-6 pl-0"><label for="celular" class=" form-control-label">Celular</label>';
            echo '   <input id="celular" name="celular" class="form-control" type="text" value="' . $c['cli_celular'] . '" disabled></div>';
            #telefone
            echo '<div class="form-group col-md-6 pr-0 pl-1"><label for="telefone" class=" form-control-label">Telefone</label>';
            echo '   <input id="telefone" name="telefone" class="form-control" type="text"value="' . $c['cli_telefone'] . '" disabled></div>';
            #email
            echo '<div class="form-group col-md-6 pl-0"><label for="email" class=" form-control-label">Email</label>';
            echo '   <a href="mailto:'.$c['cli_email'].'?Subject=Olá%20'.$c['cli_nome'].'" >';
            echo '<input id="email" name="email" class="form-control" style="cursor:pointer" type="text" value="' . $c['cli_email'] . '" disabled></a></div>';
            #whatsapp
            echo '<div class="form-group col-md-6 pr-0 pl-1"><label for="whatsapp" class=" form-control-label">WhatsApp</label>';
            echo '   <input id="whatsapp" name="whatsapp" class="form-control" type="text" value="' . $c['cli_whatsapp'] . '" disabled></div>';
            #rg
            echo '<div class="form-group col-md-6 pl-0"><label for="rg" class=" form-control-label">RG</label>';
            echo '   <input id="rg" name="rg" class="form-control" type="text" value="' . $c['cli_rg'] . '" disabled></div>';
            #cpf ! adm
            echo '<div class="form-group col-md-6 pr-0 pl-1"><label for="cpf" class=" form-control-label">CPF</label>';
            echo '   <input id="cpf" name="cpf" class="form-control" type="text"value="' . $c['cli_cpf'] . '" disabled></div>';
            #logradouro
            echo '<div class="form-group col-md-9 pl-0"><label for="logradouro" class=" form-control-label">Logradouro</label>';
            echo '   <input id="logradouro" name="logradouro" class="form-control" type="text" value="' . $e['end_logradouro'] . '" disabled></div>';
            #numero
            echo '<div class="form-group col-md-3 pr-0 pl-1"><label for="numero" class=" form-control-label">Numero</label>';
            echo '   <input id="numero" name="numero" class="form-control" type="text"value="' . $e['end_numero'] . '" disabled></div>';
            #complemento
            echo '<div class="form-group col-md-5 pl-0"><label for="complemento" class=" form-control-label">Complemento</label>';
            echo '   <input id="complemento" name="complemento" class="form-control" type="text" value="' . $e['end_complemento'] . '" disabled></div>';
            #bairro
            echo '<div class="form-group col-md-7 pr-0 pl-1"><label for="bairro" class=" form-control-label">Bairro</label>';
            echo '   <input id="bairro" name="bairro" class="form-control" type="text"value="' . $e['end_bairro'] . '" disabled></div>';
            #cep
            echo '<div class="form-group col-md-3 pl-0"><label for="cep" class=" form-control-label">CEP</label>';
            echo '   <input id="cep" name="cep" class="form-control" type="text"value="' . $e['end_cep'] . '" disabled></div>';
            #cidade
            echo '<div class="form-group col-md-5 pr-0 pl-0"><label for="cidade" class=" form-control-label">Cidade</label>';
            echo '   <input id="cidade" name="cidade" class="form-control" type="text" value="' . $e['end_cidade'] . '" disabled></div>';
            #estado
            echo '<div class="form-group col-md-4 mb-3 pr-0"><label for="estado" class=" form-control-label">Estado</label>';
            echo '<input class="form-control" value="' . $e['end_estado'] . '" disabled></div>';
            
            echo '<div class="form-actions form-group float-right mt-2">';
            echo '    <a href="clientes.php" class="btn btn-danger btn-md mr-1">Cancelar</a>';
            if($p_edit){
                echo '    <a href="cliente.php?edit='. $c['cli_id'] .'" class="btn btn-primary btn-md ml-1">Editar</a>';
            }
            ?>  
            </div>
        </form>
        </section>
    </aside>
<?php }


if($edit_id){ 
    $c = mysqli_fetch_assoc(mysqli_query($conexao, "select * from cliente WHERE cli_id = ".$edit_id));
    $e = mysqli_fetch_assoc(mysqli_query($conexao, "select * from endereco WHERE end_id = ".$c['cli_endereco']));
    logMsg( $_SESSION['usu_login']." entrou em a cliente.php?edit" ); ?>
    <aside class="profile-nav alt">
        <section class="card">
            <!-- INICIO HEADER PERFIL -->
            <div class="card-header user-header alt" style="background-color: #f7f7f7"> <!--#004671  <h2 class="text-light"....-->
                <div class="media">
                    <div class="media-body">
                        <h2 class="text display-6 mt-3">Editar Cliente</h2>
                    </div>
                </div>
            </div>
            <!-- FIM HEADER PERFIL -->
            <form class="needs-validation" action="controller/edit-cliente.php?update" method="POST">
        <div class="card-body card-block">
      <?php echo '<div class="form-group invisible"><input id="id" name="id" style="display: none" value="'.$c['cli_id'].'"></div>';
            #nome
            echo '<div class="form-group"><label for="nome" class=" form-control-label">Nome</label>';
            echo '<input id="nome" name="nome" class="form-control" type="text" placeholder="Introduza o nome" value="'.$c['cli_nome'].'" required></div>';
            #celular
            echo '<div class="form-group col-md-6 pl-0"><label for="celular" class=" form-control-label">Celular</label>';
            echo '   <input id="celular" name="celular" placeholder="(DDD) numero de celular" class="form-control" type="text" value="' . $c['cli_celular'] . '" required></div>';
            #telefone
            echo '<div class="form-group col-md-6 pr-0 pl-1"><label for="telefone" class=" form-control-label">Telefone</label>';
            echo '   <input id="telefone" name="telefone" placeholder="(DDD) numero de telefone" class="form-control" type="text"value="' . $c['cli_telefone'] . '"></div>';
            #email
            echo '<div class="form-group col-md-6 pl-0"><label for="email" class=" form-control-label">Email</label>';
            echo '   <input id="email" name="email" placeholder="Introduza o Email" class="form-control" type="text" value="' . $c['cli_email'] . '" required></div>';
            #whatsapp
            echo '<div class="form-group col-md-6 pr-0 pl-1"><label for="whatsapp" class=" form-control-label">WhatsApp</label>';
            echo '   <input id="whatsapp" name="whatsapp" placeholder="(DDD) numero do whatsapp" class="form-control" type="text" value="' . $c['cli_whatsapp'] . '"></div>';
            #rg
            echo '<div class="form-group col-md-6 pl-0"><label for="rg" class=" form-control-label">RG</label>';
            echo '   <input id="rg" name="rg" placeholder="Instroduza o RG" class="form-control" type="text" value="' . $c['cli_rg'] . '"></div>';
            #cpf ! adm
            echo '<div class="form-group col-md-6 pr-0 pl-1"><label for="cpf" class=" form-control-label">CPF</label>';
            echo '   <input id="cpf" name="cpf" placeholder="Instroduza o CPF" class="form-control" type="text"value="' . $c['cli_cpf'] . '" required></div>';
            #logradouro
            echo '<div class="form-group col-md-9 pl-0"><label for="logradouro" class=" form-control-label">Logradouro</label>';
            echo '   <input id="logradouro" name="logradouro" placeholder="Instroduza o nome da Rua" class="form-control" type="text" value="' . $e['end_logradouro'] . '"></div>';
            #numero
            echo '<div class="form-group col-md-3 pr-0 pl-1"><label for="numero" class=" form-control-label">Numero</label>';
            echo '   <input id="numero" name="numero" class="form-control" type="text"value="' . $e['end_numero'] . '" ></div>';
            #complemento
            echo '<div class="form-group col-md-5 pl-0"><label for="complemento" class=" form-control-label">Complemento</label>';
            echo '   <input id="complemento" name="complemento" placeholder="Instroduza o complemento " class="form-control" type="text" value="' . $e['end_complemento'] . '"></div>';
            #bairro
            echo '<div class="form-group col-md-7 pr-0 pl-1"><label for="bairro" class=" form-control-label">Bairro</label>';
            echo '   <input id="bairro" name="bairro" class="form-control" type="text"value="' . $e['end_bairro'] . '" ></div>';
            #cep
            echo '<div class="form-group col-md-3 pl-0"><label for="cep" class=" form-control-label">CEP</label>';
            echo '   <input id="cep" name="cep" class="form-control" type="text"value="' . $e['end_cep'] . '" ></div>';
            #cidade
            echo '<div class="form-group col-md-4 pr-0 pl-0"><label for="cidade" class=" form-control-label">Cidade</label>';
            echo '   <input id="cidade" name="cidade" placeholder="Instroduza a cidade " class="form-control" type="text" value="' . $e['end_cidade'] . '" required></div>';
            #estado
            echo '<div class="form-group col-md-5 mb-3 pr-0"><label for="estado" class=" form-control-label">Estado</label>';
            echo '<select name="estado" id="estado" name="estado" class="form-control">';
            while ($estado = mysqli_fetch_assoc($estados)) {
                if ($e['end_estado'] == $estado['nome']) {
                    echo '<option value="' . $estado['nome'] . '" selected>' . $estado['nome'] . ' (' . $estado['sigla'] . ')</option>';
                } else {
                    echo '<option value="' . $estado['nome'] . '">' . $estado['nome'] . ' (' . $estado['sigla'] . ')</option>';
                }   
            }
            echo '</select></div>';
            
           
            echo '<div class="form-actions form-group float-right mt-2">';
            echo '    <a href="cliente.php?view='. $c['cli_id'] .'" class="btn btn-danger btn-md mr-1">Cancelar</a>';
            echo '    <button type="submit" class="btn btn-primary btn-md ml-1">Guardar</button></div>';

            ?>  
            </div>
        </form>
        </section>
    </aside>
<?php } ?> 
<!--Editar-->
<!--Novo-->
<?php if($new){ 
    logMsg( $_SESSION['usu_login']." entrou em a cliente.php?new" ); ?>
    <aside class="profile-nav alt">
        <section class="card">
            <!-- INICIO HEADER PERFIL -->
            <div class="card-header user-header alt" style="background-color: #f7f7f7">
                <div class="media">
                    <div class="media-body">
                        <h2 class="text display-6 mt-3">Cadastrar Cliente</h2>
                    </div>
                </div>
            </div>
            <!-- FIM HEADER PERFIL -->
            <form class="needs-validation" action="controller/edit-cliente.php?create" method="POST">
            <div class="card-body card-block">
            <div class="form-group invisible"><input id="modo" name="modo" style="display: none" value="2">editar</div>
            <div class="form-group invisible"><input id="id" name="id"style="display: none" value=""></div>
            <!--nome-->
            <div class="form-group"><label for="nome" class=" form-control-label">Nome</label>
            <input id="nome" name="nome" class="form-control" type="text" placeholder="Introduza o nome" value="" required></div>
            <!--celular-->
            <div class="form-group col-md-6 pl-0"><label for="celular" class=" form-control-label">Celular</label>
               <input id="celular" name="celular" placeholder="(DDD) numero de celular" class="form-control" type="text" value="" required></div>
            <!--telefone-->
            <div class="form-group col-md-6 pr-0 pl-1"><label for="telefone" class=" form-control-label">Telefone</label>
               <input id="telefone" name="telefone" placeholder="(DDD) numero de telefone" class="form-control" type="text"value=""></div>
            <!--email-->
            <div class="form-group col-md-6 pl-0"><label for="email" class=" form-control-label">Email</label>
               <input id="email" name="email" placeholder="Introduza o Email" class="form-control" type="text" value="" required></div>
            <!--whatsapp-->
            <div class="form-group col-md-6 pr-0 pl-1"><label for="whatsapp" class=" form-control-label">WhatsApp</label>
               <input id="whatsapp" name="whatsapp" placeholder="(DDD) numero do whatsapp" class="form-control" type="text" value=""></div>
            <!--rg-->
            <div class="form-group col-md-6 pl-0"><label for="rg" class=" form-control-label">RG</label>
               <input id="rg" name="rg" placeholder="Instroduza o RG" class="form-control" type="text" value=""></div>
            <!--cpf-->
            <div class="form-group col-md-6 pr-0 pl-1"><label for="cpf" class=" form-control-label">CPF</label>
               <input id="cpf" name="cpf" placeholder="Instroduza o CPF" class="form-control" type="text"value="" required></div>
            <!--logradouro-->
            <div class="form-group col-md-9 pl-0"><label for="logradouro" class=" form-control-label">Logradouro</label>
               <input id="logradouro" name="logradouro" placeholder="Instroduza o nome da Rua" class="form-control" type="text" value="" required></div>
            <!--numero-->
            <div class="form-group col-md-3 pr-0 pl-1"><label for="numero" class=" form-control-label">Numero</label>
               <input id="numero" name="numero" class="form-control" type="text"value="" required></div>
            <!--complemento-->
            <div class="form-group col-md-5 pl-0"><label for="complemento" class=" form-control-label">Complemento</label>
               <input id="complemento" name="complemento" placeholder="Instroduza o complemento " class="form-control" type="text" value=""></div>
            <!--bairro-->
            <div class="form-group col-md-7 pr-0 pl-1"><label for="bairro" class=" form-control-label">Bairro</label>
               <input id="bairro" name="bairro" class="form-control" type="text"value="" ></div>
            <!--cep-->
            <div class="form-group col-md-3 pl-0"><label for="cep" class=" form-control-label">CEP</label>
               <input id="cep" name="cep" class="form-control" type="text"value="" ></div>
            <!--cidade-->
            <div class="form-group col-md-4 pr-0 pl-0"><label for="cidade" class=" form-control-label">Cidade</label>
               <input id="cidade" name="cidade" placeholder="Instroduza a cidade " class="form-control" type="text" value="" required></div>
            <!--estado-->
            <div class="form-group col-md-5 mb-3 pr-0"><label for="estado" class=" form-control-label">Estado</label>
            <select name="estado" id="estado" name="estado" class="form-control">
            <?php
            while ($estado = mysqli_fetch_assoc($estados)) {
               echo '<option value="' . $estado['nome'] . '">' . $estado['nome'] . ' (' . $estado['sigla'] . ')</option>';  
            } ?> 
            </select></div>

            <div class="form-actions form-group float-right mt-2">
                <a href="clientes.php" class="btn btn-danger btn-md mr-1">Cancelar</a>
                <button type="submit" class="btn btn-primary btn-md ml-1">Guardar</button></div>
             
            </div>
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