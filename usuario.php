<?php require_once('before_content.php'); ?>

<link rel="stylesheet" href="assets/scss/socials.css">
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
//fim das consultas no bancoe atribuições

    $msg_erro_1 = "Houve um problema com a solicitação, tente novamente!";
    $msg_erro_2 = "Nao foi possivel manipular os dados usuario, tente novamente!";
    $msg_erro_3 = "Nao foi possivel manipular o endereço do usuário, tente novamente!";
    $msg_erro_4 = "A senha deve ter no minimo 6 caracteres, tente novamente!";
    $msg_erro_5 = "A imagem não pode ser inserida/alterada, tente novamente!";
    $msg_erro_6 = "Você não tem permissão para criar novos usuários!";

    $msg_ok_1 = "O usuário foi alterado com sucesso!";
    $msg_ok_2 = "O usuário criado com sucesso!";
    $msg_ok_3 = "A imagem foi inserida/alterada com sucesso!";

    $erro = null; $ok = null; $view_id = null; $edit_id = null; $adm = false; $new = false;

    if($_SERVER['REQUEST_METHOD'] == "GET") { //requisição via get (ver ou editar passando parametro modo e id)
        if(isset($_GET['view'])){   
            $view_id = $_GET['view']; 
            $uid = $view_id;  
        }
        if(isset($_GET['edit'])){ 
            if($_SESSION['usu_cargo'] == 1)  {   
                $edit_id = $_GET['edit'];  
                $uid = $edit_id;
                $adm = true; 
            }   //se for adm pode editar qualquer usuario
            else {    
                $edit_id = $_SESSION['usu_id'];  
                $uid = $edit_id;    
            }   //se nao for adm so pode editar o seu proprio perfil
        }
        if(isset($_GET['new'])){ 
            if($_SESSION['usu_cargo'] == 1)  {   
                $new = true; //se for adm pode criar novos usuarios
            } else {    
                $view_id = $_SESSION['usu_id'];  
                $uid = $view_id;    
                $erro = 6;
                $msg_erro = $msg_erro_6;
                //se nao for adm redireciona par ao seu perfil com o erro 6
            }   
        }
        if(isset($_GET['erro'])){   
            $erro = $_GET['erro'];    
            if ($erro == 1) { 
                $msg_erro = $msg_erro_1;
                logMsg( $_SESSION['usu_login']." abriu usuario.php com erro 1", 'erro' ); }
            if ($erro == 2) { 
                $msg_erro = $msg_erro_2;
                logMsg( $_SESSION['usu_login']." abriu usuario.php com erro 2", 'erro' ); }
            if ($erro == 3) { 
                $msg_erro = $msg_erro_3;
                logMsg( $_SESSION['usu_login']." abriu usuario.php com erro 3", 'erro' ); }
            if ($erro == 4) { 
                $msg_erro = $msg_erro_4;
                logMsg( $_SESSION['usu_login']." abriu usuario.php com erro 4", 'erro' ); }
            if ($erro == 5) { 
                $msg_erro = $msg_erro_5;
                logMsg( $_SESSION['usu_login']." abriu usuario.php com erro 5", 'erro' ); }
            if ($erro == 6) { 
                $msg_erro = $msg_erro_6;
                logMsg( $_SESSION['usu_login']." abriu usuario.php com erro 6", 'erro' ); }
        }
        if(isset($_GET['ok']))  {   
            $ok = $_GET['ok'];     
            if ($ok == 1) { $msg_ok = $msg_ok_1; }
            if ($ok == 2) { $msg_ok = $msg_ok_2; }
            if ($ok == 3) { $msg_ok = $msg_ok_3; }
        }
    } else {
        $view_id = $_SESSION['usu_id'];
        $uid = $view_id;
    }
?> 

<div class="row">
    <div class="col-xl-6 col-lg-8 col-md-12 mr-auto ml-auto">

<?php
    if($erro){
            echo '<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">'.$msg_erro;
            echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>';
    }

    if($ok){
        echo '<div class="sufee-alert alert with-close alert-success alert-dismissible fade show">';
        echo '<span class="badge badge-pill badge-success">Sucesso</span>&nbsp;'.$msg_ok;
        echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>';
    }        


    if($view_id) { 

        $sql_n_concluidos = 'SELECT count(cham_id) AS concluidos FROM chamado_tecnico WHERE cham_status = 5 AND cham_tecnico = ' . $uid . ';';
        $ctConcluidos = mysqli_fetch_assoc(mysqli_query($conexao, $sql_n_concluidos));
        $cham_conlcuidos = $ctConcluidos['concluidos'];

        $sql_n_cancelados = 'SELECT count(cham_id) AS cancelados FROM chamado_tecnico WHERE cham_status = 6  AND cham_tecnico = ' . $uid . ';';
        $ctCancelados = mysqli_fetch_assoc(mysqli_query($conexao, $sql_n_cancelados));
        $cham_cancelados = $ctCancelados['cancelados'];

        $sql_n_andamento = 'SELECT count(cham_id) AS andamento FROM chamado_tecnico WHERE cham_status != 5 AND cham_status != 6 AND cham_tecnico = ' . $uid . ';';
        $ctAndamento = mysqli_fetch_assoc(mysqli_query($conexao, $sql_n_andamento));
        $cham_andamento  = $ctAndamento['andamento'];    

    //inici das consultas no bancoe atribuições
    $sql_user = "SELECT usu.usu_id, usu.usu_nome, car.cargo_id, car.cargo_nome, ende.end_cidade, ende.end_estado, 
                        usu.usu_telefone, usu.usu_celular, usu.usu_whatsapp, usu.usu_email, usu.usu_facebook, 
                        usu.usu_twitter, usu.usu_linkedin, usu.usu_latitude, usu.usu_longitude,  usu.usu_foto
                FROM usuario AS usu, cargo AS car, endereco AS ende 
                WHERE usu.usu_cargo = car.cargo_id AND usu.usu_endereco = ende.end_id AND usu.usu_id = " . $view_id . ";";

    $usuario = mysqli_fetch_assoc(mysqli_query($conexao, $sql_user));

    $class_cargo = "badge-success";
    if ($usuario['cargo_id'] == 1) //1 - administrador - lable amarelo
        $class_cargo = "badge-warning";
    if ($usuario['cargo_id'] == 2) //2 - atendente - lable azul claro
        $class_cargo = "badge-info";
    if ($usuario['cargo_id'] == 3 ) //3 - tecnico - lable branco
        $class_cargo = "badge-light";
    ?>

    <aside class="profile-nav alt">
    <section class="card">
        <!-- INICIO HEADER PERFIL -->
        <div class="card-header user-header alt" style="background-color: #004671">
            <div class="media">
                <a href="#">
                    <?php echo '<img class="align-self-center rounded-circle mr-3" style="width:90px; height:90px;" alt="" src="upload/'.$usuario['usu_foto'].'">'; ?>
                </a>
                <div class="media-body">
                    <?php echo '<h2 class="text-light display-6 mt-2">' . $usuario['usu_nome'] . '</h2>'; 
                    echo '<a href="usuario.php?edit=' . $usuario['usu_id'] . '"><i class="text-light fa fa-pencil pull-right"></i><a>';
                    echo '<h5><span class="badge ' . $class_cargo . ' pull-left mt-2">' . $usuario['cargo_nome'] . '</span><h5>'; ?>
                </div>
            </div>
        </div>
        <!-- FIM HEADER PERFIL -->

        <!-- INICIO INFORMAÇÕES PERFIL -->
        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                <a href="#"> <i class="fa fa-map-marker" style="width: 30px"></i><strong> Local: </strong>
                <?php echo $usuario['end_cidade'] . ', ' . $usuario['end_estado'] . '</a>'; ?>
            </li>
            <li class="list-group-item">
                <?php
                    echo '<a href="mailto:'.$usuario['usu_email'].'?Subject=Olá%20'.$usuario['usu_nome'].'"> <i class="fa fa-envelope-o" style="width: 30px"></i><strong> Email: </strong>';
                    echo $usuario['usu_email'] . ' </span></a>'; ?>
            </li>

            <?php 
                if($usuario['usu_telefone']){
                    echo '<li class="list-group-item">';
                    echo '<a href="#"> <i class="fa fa-phone" style="width: 30px"></i><strong> Telefone: </strong>';
                    echo $usuario['usu_telefone'] . ' </a></li>';
                }
                if($usuario['usu_celular']){
                    echo '<li class="list-group-item">';
                    echo '<a href="#"> <i class="fa fa-tablet" style="width: 30px"></i><strong> Celular: </strong>';
                    echo $usuario['usu_celular'] . ' </a></li>';
                }
                if($usuario['usu_whatsapp']){
                    echo '<li class="list-group-item">';
                    echo '<a href="#"> <i class="fa fa-whatsapp" style="width: 30px"></i><strong> WhatsApp: </strong>';
                    echo $usuario['usu_whatsapp'] . ' </a></li>';
                }
                if($usuario['cargo_id']==3) { ?> <!-- se usuario for tecnico gera informções de chamados tecnicos -->
                    <li class="list-group-item">
                        <a href="#"> <i class="fa fa-tasks" style="width: 30px"></i><strong>
                        <?php echo 'Chamados Técnicos Concluidos </strong><span class="badge badge-success pull-right">'.$cham_conlcuidos.'</span></a>'; ?>
                    </li>
                    <li class="list-group-item">
                        <a href="#"> <i class="fa fa-calendar-times-o" style="width: 30px"></i><strong>
                        <?php echo 'Chamados Técnicos Cancelados </strong><span class="badge badge-danger pull-right">'.$cham_cancelados.'</span></a>';?> 
                    </li>
                    <li class="list-group-item">
                        <a href="#"> <i class="fa fa-clock-o" style="width: 30px"></i><strong>
                        <?php echo 'Chamados Técnicos em Andamento </strong><span class="badge badge-warning pull-right r-activity">'.$cham_andamento.'</span></a>'; ?>
                    </li>
                    <li class="list-group-item">
                        <?php $url = 'mapa.php?lat='.$usuario['usu_latitude'].'&lng='.$usuario['usu_longitude'].'&tipo=2&id='.$usuario['usu_id'];
                        echo'<a href="'.$url.'"><i class="fa fa-location-arrow" style="width: 30px"></i><strong>Localização</strong>'; ?>
                        <span class="badge badge-pill badge-secondary ml-3">Lat</span> 
                        <?php if ($usuario['usu_latitude']){ echo $usuario['usu_latitude']; } else { echo 'indisponível'; } ?> 
                        <span class="badge badge-pill badge-secondary ml-2">Lng</span> 
                        <?php if ($usuario['usu_longitude']){ echo $usuario['usu_longitude']; } else { echo 'indisponível'; } ?></a>
                    </li>
                <?php }     ?> <!-- fim da condição se usuario for tecnico -->

                <? if($usuario['cargo_id']==2) { #<!-- se usuario for atendente gera informções de chamados tecnicos que atendeu-->
                    $sql_n_atendidos = 'SELECT COUNT(cham_id) AS atendidos FROM chamado_tecnico WHERE cham_atendente = ' . $uid . ';';
                    $ctAtendidos = mysqli_fetch_assoc(mysqli_query($conexao, $sql_n_atendidos));
                    $cham_atendidos = $ctAtendidos['atendidos']; ?>
                    <li class="list-group-item">
                        <a href="#"> <i class="fa fa-tasks" style="width: 30px"></i><strong>
                        <?php echo 'Chamados Técnicos Atendidos </strong><span class="badge badge-info pull-right">'.$cham_atendidos.'</span></a>'; ?>
                    </li>
                <?php }     ?><!-- fim da condição se usuario for tecnico -->

            <li class="list-group-item">
                <?php //gera butao com link para as redes sociais que o usuario tiver cadastradas
                    if($usuario['usu_facebook']){
                        echo '<a href="' . $usuario['usu_facebook'] . '"';
                        echo '<button type="button" class="btn btn-sm social facebook" style="margin-bottom: 4px">';
                        echo '   <i class="fa fa-facebook"></i> <span>Facebook</span> </button> </a>'; 
                    }
                    if($usuario['usu_twitter']){ 
                        echo '<a href="' . $usuario['usu_twitter'] . '"';
                        echo '<button type="button" class="btn btn-sm social twitter" style="margin-bottom: 4px">';
                        echo '<i class="fa fa-twitter"></i> <span>Twitter</span> </button> </a>';
                    }
                    if($usuario['usu_linkedin']){     
                        echo '<a href="' . $usuario['usu_linkedin'] . '"';
                        echo '<button type="button" class="btn btn-sm social linkedin" style="margin-bottom: 4px">';
                        echo '<i class="fa fa-linkedin"></i> <span>LinkedIn</span> </button> </a>';
                    }

                    /* FOR DEBUGING
                    echo '<br>erro: ' . $erro . '<br>'; 
                    echo 'ok: ' . $ok . '<br>'; 
                    echo 'uid: ' . $uid . '<br>';
                    echo 'view_id: ' . $view_id . '<br>'; 
                    echo 'edit_id: ' . $edit_id . '<br>'; 
                    echo 'adm: ' . $adm . '<br>';
                    echo 'get_view: ' . $_GET['view'] . '<br>'; */
                ?>
            </li>
        </ul>
        <!-- FIM INFORMAÇÕES PERFIL -->

    </section>
    </aside>
<?php } ?> <!-- final da condição - if($view_id) { -->





<!--editavel-->

<?php
if($edit_id){
    $sql_user = "SELECT usu.usu_id, usu.usu_nome, car.cargo_id, car.cargo_nome, usu.usu_rg, usu.usu_cpf, usu.usu_telefone, usu.usu_celular, usu.usu_foto, 
                usu.usu_nascimento, usu.usu_whatsapp, usu.usu_email, usu.usu_login, usu.usu_facebook, usu.usu_twitter, usu.usu_linkedin, usu.usu_latitude, 
                usu.usu_longitude, ende.end_logradouro, ende.end_numero, ende.end_complemento, ende.end_bairro, ende.end_cep, ende.end_cidade, ende.end_estado
                FROM usuario AS usu, cargo AS car, endereco AS ende 
                WHERE usu.usu_cargo = car.cargo_id AND usu.usu_endereco = ende.end_id AND usu.usu_id = " .$edit_id . ";";

    $usuario = mysqli_fetch_assoc(mysqli_query($conexao, $sql_user));

    $class_cargo = "badge-success";
    if ($usuario['cargo_id'] == 1) //1 - administrador - lable amarelo
        $class_cargo = "badge-warning";
    if ($usuario['cargo_id'] == 2) //2 - atendente - lable azul claro
        $class_cargo = "badge-info";
    if ($usuario['cargo_id'] == 3) //3 - tecnico - lable branco
        $class_cargo = "badge-light";

    $cargos = mysqli_query($conexao,"SELECT cargo_id, cargo_nome FROM cargo");

    $estados = mysqli_query($conexao,"SELECT * FROM estados"); //id sigla nome

    ?>

<aside class="profile-nav alt">
    <section class="card">
        <!-- INICIO HEADER PERFIL -->
        <div class="card-header user-header alt" style="background-color: #004671">
            <div class="media">
                
                <?php echo ' <a data-toggle="modal" data-target="#modal-update-foto"><div id="img-refresh">';
                      echo '   <img class="align-self-center rounded-circle mr-3" style="width:90px; height:90px;" src="upload/'.$usuario['usu_foto'].'">';
                      echo ' </div></a>';
                      echo '   <input id="id-update-foto" style="display: none" value="'.$usuario['usu_id'].'"></input>' ;
                      echo '   <input id="str-refresh-foto" style="display: none" value=\'<img class="align-self-center rounded-circle mr-3" style="width:90px; height:90px;"\'></input>' ;                      
                ?>
                <div class="media-body">
                    <?php echo '<h2 class="text-light display-6 mt-2">' . $usuario['usu_nome'] . '</h2>'; 
                    echo '<a href="usuario.php?edit=' . $usuario['usu_id'] . '"><i class="text-light fa fa-pencil pull-left"></i><a>';
                    echo '<h5><span class="badge ' . $class_cargo . ' pull-left mt-2">' . $usuario['cargo_nome'] . '</span><h5>'; ?>
                </div>
            </div>
        </div>
        <!-- FIM HEADER PERFIL -->
        <form class="needs-validation" action="controller/edit-user.php" method="POST">
        <div class="card-body card-block">
      <?php echo '<div class="form-group invisible"><input id="modo" name="modo" style="display: none" value="2">editar</div>';
            echo '<div class="form-group invisible"><input id="id" name="id"style="display: none" value="'.$usuario['usu_id'].'"></div>';
            echo '<div class="form-group"><label for="nome" class=" form-control-label">Nome</label>';
            echo '<input id="nome" name="nome" class="form-control" type="text" placeholder="Introduza o nome" value="'.$usuario['usu_nome'].'" required></div>';
            #cargo ! adm
            if ($adm){
                echo '<div class="form-group col-md-6 pl-0"><label for="nome" class=" form-control-label">Cargo</label>';
                echo '<select name="cargo" id="cargo" name="cargo" class="form-control">';
                    while ($cargo = mysqli_fetch_assoc($cargos)) {
                        if ($usuario['cargo_id'] == $cargo['cargo_id']) {
                            echo '<option value="' . $cargo['cargo_id'] . '" selected>' . $cargo['cargo_nome'] . '</option>';
                        } else {
                            echo '<option value="' . $cargo['cargo_id'] . '">' . $cargo['cargo_nome'] . '</option>';
                        }
                    }
                echo '</select></div>';
                #celular
                echo '<div class="form-group col-md-6 pr-0 pl-1"><label for="celular" class=" form-control-label">Celular</label>';
                echo '   <input id="celular" name="celular" placeholder="(DDD) numero de celular" class="form-control" type="text" value="' . $usuario['usu_celular'] . '" required></div>';
            } else {
	            #celular
	            echo '<div class="form-group"><label for="celular" class=" form-control-label">Celular</label>';
	            echo '   <input id="celular" name="celular" placeholder="(DDD) numero de celular" class="form-control" type="text" value="' . $usuario['usu_celular'] . '" required></div>';
            }
            #telefone
            echo '<div class="form-group col-md-6 pl-0"><label for="telefone" class=" form-control-label">Telefone</label>';
            echo '   <input id="telefone" name="telefone" placeholder="(DDD) numero de telefone" class="form-control" type="text"value="' . $usuario['usu_telefone'] . '"></div>';
            #whatsapp
            echo '<div class="form-group col-md-6 pr-0 pl-1"><label for="whatsapp" class=" form-control-label">WhatsApp</label>';
            echo '   <input id="whatsapp" name="whatsapp" placeholder="(DDD) numero do whatsapp" class="form-control" type="text" value="' . $usuario['usu_whatsapp'] . '"></div>';
            #email
            echo '<div class="form-group col-md-6 pl-0"><label for="email" class=" form-control-label">Email</label>';
            echo '   <input id="email" name="email" placeholder="Introduza o Email" class="form-control" type="text" value="' . $usuario['usu_email'] . '" required></div>';
            #login
            echo '<div class="form-group col-md-6 pr-0 pl-1"><label for="login" class=" form-control-label">Login</label>';
            echo '   <input id="login" name="login" placeholder="Introduza o Login" class="form-control" type="text" value="' . $usuario['usu_login'] . '" required></div>';
            #nascimento
            echo '<div class="form-group col-md-5 pl-0"><label for="nascimento" class=" form-control-label">Data de Nascimento</label>';
            echo '   <input id="nascimento" name="nascimento"  class="form-control" type="text" placeholder="AAAA-MM-DD" value="' . $usuario['usu_nascimento'] . '"></div>';
            #senha
            echo '<div class="form-group col-md-7 pr-0 pl-1">  <label for="senha">Senha</label>';
            echo '   <div class="input-group">';
            echo '   <input id="senha" name="senha" name="senha" placeholder="Itroduza a nova senha" class="form-control" type="password" minlength=4>';
            echo '<div onclick="mostraEsconde()" class="input-group-addon"> Mostrar</div></div></div>';
            if ($adm){
                #rg ! adm
                echo '<div class="form-group col-md-6 pl-0"><label for="rg" class=" form-control-label">RG</label>';
                echo '   <input id="rg" name="rg" placeholder="Instroduza o RG" class="form-control" type="text" value="' . $usuario['usu_rg'] . '"></div>';
                #cpf ! adm
                echo '<div class="form-group col-md-6 pr-0 pl-1"><label for="cpf" class=" form-control-label">CPF</label>';
                echo '   <input id="cpf" name="cpf" placeholder="Instroduza o CPF" class="form-control" type="text"value="' . $usuario['usu_cpf'] . '" required></div>';
            }
            #logradouro
            echo '<div class="form-group col-md-9 pl-0"><label for="logradouro" class=" form-control-label">Logradouro</label>';
            echo '   <input id="logradouro" name="logradouro" placeholder="Instroduza o nome da Rua" class="form-control" type="text" value="' . $usuario['end_logradouro'] . '"></div>';
            #numero
            echo '<div class="form-group col-md-3 pr-0 pl-1"><label for="numero" class=" form-control-label">Numero</label>';
            echo '   <input id="numero" name="numero" class="form-control" type="text"value="' . $usuario['end_numero'] . '" ></div>';
            #complemento
            echo '<div class="form-group col-md-5 pl-0"><label for="complemento" class=" form-control-label">Complemento</label>';
            echo '   <input id="complemento" name="complemento" placeholder="Instroduza o complemento " class="form-control" type="text" value="' . $usuario['end_complemento'] . '"></div>';
            #bairro
            echo '<div class="form-group col-md-7 pr-0 pl-1"><label for="bairro" class=" form-control-label">Bairro</label>';
            echo '   <input id="bairro" name="bairro" class="form-control" type="text"value="' . $usuario['end_bairro'] . '" ></div>';
            #cep
            echo '<div class="form-group col-md-3 pl-0"><label for="cep" class=" form-control-label">CEP</label>';
            echo '   <input id="cep" name="cep" class="form-control" type="text"value="' . $usuario['end_cep'] . '" ></div>';
            #cidade
            echo '<div class="form-group col-md-4 pr-0 pl-0"><label for="cidade" class=" form-control-label">Cidade</label>';
            echo '   <input id="cidade" name="cidade" placeholder="Instroduza a cidade " class="form-control" type="text" value="' . $usuario['end_cidade'] . '" required></div>';
            #estado
            echo '<div class="form-group col-md-5 mb-3 pr-0"><label for="estado" class=" form-control-label">Estado</label>';
            echo '<select name="estado" id="estado" name="estado" class="form-control">';
            while ($estado = mysqli_fetch_assoc($estados)) {
                if ($usuario['end_estado'] == $estado['nome']) {
                    echo '<option value="' . $estado['nome'] . '" selected>' . $estado['nome'] . ' (' . $estado['sigla'] . ')</option>';
                } else {
                    echo '<option value="' . $estado['nome'] . '">' . $estado['nome'] . ' (' . $estado['sigla'] . ')</option>';
                }   
            }
            echo '</select></div>';
            #facebook
            echo '<div class="form-group"><a href="'.$usuario['usu_facebook'].'"><div class="input-group"><div class="input-group-addon"><i class="fa fa-facebook mr-1"></i></div></a>';
            echo '    <input id="facebook" name="facebook" placeholder="https://faceb..." class="form-control" type="text" value="'.$usuario['usu_facebook'].'"></div></div>';
            #twitter
            echo '<div class="form-group"><a href="'.$usuario['usu_twitter'].'"><div class="input-group"><div class="input-group-addon"><i class="fa fa-twitter"></i></div></a>';
            echo '    <input id="twitter" name="twitter" placeholder="https://twitt..." class="form-control" type="text" value="'.$usuario['usu_twitter'].'"></div></div>';
            #linkedin
            echo '<div class="form-group"><a href="'.$usuario['usu_linkedin'].'"><div class="input-group"><div class="input-group-addon"><i class="fa fa-linkedin"></i></div></a>';
            echo '    <input id="linkedin" name="linkedin" placeholder="https://linke..." class="form-control" type="text" value="'.$usuario['usu_linkedin'].'"></div></div>';
            
            echo '<div class="row">';
            echo '<div class="form-actions form-group ml-auto mr-auto mt-2">';
            echo '    <a href="usuario.php?view='. $usuario['usu_id'] .'" class="btn btn-danger btn-md mr-1">Cancelar</a>';
            echo '    <button type="submit" class="btn btn-primary btn-md ml-1">Guardar</button></div>';
            echo '</div>';
            ?>  
            </div>
        </form>
    </section>
</aside>




<?php } ?> <!-- final da condição - if($edit_id) { -->
<!--editavel-->






<!--novo-->
<?php
if($new){
    $cargos = mysqli_query($conexao,"SELECT cargo_id, cargo_nome FROM cargo");
    $estados = mysqli_query($conexao,"SELECT * FROM estados"); //id sigla nome
    $next_usu = mysqli_fetch_assoc(mysqli_query($conexao,"SELECT max(usu_id) + 1 as id FROM usuario"));
?>

<aside class="profile-nav alt">
    <section class="card">
        <!-- INICIO HEADER PERFIL -->
        <div class="card-header user-header alt" style="background-color: #004671">
            <div class="media">
            <?php     echo ' <a data-toggle="modal" data-target="#modal-update-foto"><div id="img-refresh">';
                      echo '   <img class="align-self-center rounded-circle mr-3" style="width:90px; height:90px;" src="images/user-photo.png">';
                      echo ' </div></a>';
                      echo '   <input id="id-update-foto" style="display: none" value="'.$next_usu['id'].'"></input>' ;
                      echo '   <input id="str-refresh-foto" style="display: none" value=\'<img class="align-self-center rounded-circle mr-3" style="width:90px; height:90px;"\'></input>' ;                      
                ?>
                <div class="media-body">
                    <h2 class="text-light display-6 mt-3">Novo Usuário</h2> 
                </div>
            </div>
        </div>
        <!-- FIM HEADER PERFIL -->
        <form class="needs-validation" action="controller/edit-user.php" method="POST">
        <div class="card-body card-block">
            <div class="form-group invisible"><input id="modo" name="modo" style="display: none" value="1">novo</div>
            <div class="form-group"><label for="nome" class=" form-control-label">Nome</label>
            <input id="nome" name="nome" class="form-control" type="text" placeholder="Introduza o nome" value="" required></div>
            <!-- #cargo -->
            <div class="form-group col-md-6 pl-0"><label for="nome" class=" form-control-label">Cargo</label>
            <select name="cargo" id="cargo" name="cargo" class="form-control">
            <?php   while ($cargo = mysqli_fetch_assoc($cargos)) {
                        echo '<option value="' . $cargo['cargo_id'] . '">' . $cargo['cargo_nome'] . '</option>';
                    } 
            ?>
            </select></div>
            <!--#celular-->
            <div class="form-group col-md-6 pr-0 pl-1"><label for="celular" class="form-control-label">Celular</label>
               <input id="celular" name="celular" placeholder="(DDD) numero de celular" class="form-control" type="text" value="" required></div>
            <!--#telefone-->
            <div class="form-group col-md-6 pl-0"><label for="telefone" class=" form-control-label">Telefone</label>
               <input id="telefone" name="telefone" placeholder="(DDD) numero de telefone" class="form-control" type="text"value=""></div>
            <!--#whatsapp-->
            <div class="form-group col-md-6 pr-0 pl-1"><label for="whatsapp" class=" form-control-label">WhatsApp</label>
               <input id="whatsapp" name="whatsapp" placeholder="(DDD) numero do whatsapp" class="form-control" type="text" value=""></div>
            <!--#email-->
            <div class="form-group col-md-6 pl-0"><label for="email" class=" form-control-label">Email</label>
               <input id="email" name="email" placeholder="Introduza o Email" class="form-control" type="text" value="" required></div>
            <!--#login-->
            <div class="form-group col-md-6 pr-0 pl-1"><label for="login" class=" form-control-label">Login</label>
               <input id="login" name="login" placeholder="Introduza o Login" class="form-control" type="text" value="" required></div>
            <!--#nascimento-->
            <div class="form-group col-md-5 pl-0"><label for="nascimento" class=" form-control-label">Data de Nascimento</label>
               <input id="nascimento" name="nascimento"  class="form-control" type="text" placeholder="AAAA-MM-DD" value=""></div>
            <!--#senha-->
            <div class="form-group col-md-7 pr-0 pl-1">  <label for="senha">Senha</label>
               <div class="input-group">
               <input id="senha" name="senha" name="senha" placeholder="Itroduza a nova senha" class="form-control" type="password" minlength=6 required>
            <div onclick="mostraEsconde()" class="input-group-addon"> Mostrar</div></div></div>
            <!--#rg ! adm-->
            <div class="form-group col-md-6 pl-0"><label for="rg" class=" form-control-label">RG</label>
               <input id="rg" name="rg" placeholder="Instroduza o RG" class="form-control" type="text" value=""></div>
            <!--#cpf ! adm-->
            <div class="form-group col-md-6 pr-0 pl-1"><label for="cpf" class=" form-control-label">CPF</label>
               <input id="cpf" name="cpf" placeholder="Instroduza o CPF" class="form-control" type="text"value="" required></div>
            <!--#logradouro-->
            <div class="form-group col-md-9 pl-0"><label for="logradouro" class=" form-control-label">Logradouro</label>
               <input id="logradouro" name="logradouro" placeholder="Instroduza o nome da Rua" class="form-control" type="text" value="" required></div>
            <!--#numero-->
            <div class="form-group col-md-3 pr-0 pl-1"><label for="numero" class=" form-control-label">Numero</label>
               <input id="numero" name="numero" class="form-control" type="text"value="" required></div>
            <!--#complemento-->
            <div class="form-group col-md-5 pl-0"><label for="complemento" class=" form-control-label">Complemento</label>
               <input id="complemento" name="complemento" placeholder="Instroduza o complemento " class="form-control" type="text" value=""></div>
            <!--#bairro-->
            <div class="form-group col-md-7 pr-0 pl-1"><label for="bairro" class=" form-control-label" required>Bairro</label>
               <input id="bairro" name="bairro" class="form-control" type="text"value="" ></div>
            <!--#cep-->
            <div class="form-group col-md-3 pl-0"><label for="cep" class=" form-control-label">CEP</label>
               <input id="cep" name="cep" class="form-control" type="text"value="" ></div>
            <!--#cidade-->
            <div class="form-group col-md-4 pr-0 pl-0"><label for="cidade" class=" form-control-label">Cidade</label>
               <input id="cidade" name="cidade" placeholder="Instroduza a cidade " class="form-control" type="text" value="" required></div>
            <!--#estado-->
            <div class="form-group col-md-5 mb-3 pr-0"><label for="estado" class=" form-control-label">Estado</label>
            <select name="estado" id="estado" name="estado" class="form-control">
            <?php   while ($estado = mysqli_fetch_assoc($estados)) {
                            echo '<option value="' . $estado['nome'] . '">' . $estado['nome'] . ' (' . $estado['sigla'] . ')</option>'; 
                    }
            ?>
            </select></div>
            <!--#facebook-->
            <div class="form-group"><a href="'.$usuario['usu_facebook'].'"><div class="input-group"><div class="input-group-addon"><i class="fa fa-facebook mr-1"></i></div></a>
                <input id="facebook" name="facebook" placeholder="https://faceb..." class="form-control" type="text" value=""></div></div>
            <!--#twitter-->
            <div class="form-group"><a href="'.$usuario['usu_twitter'].'"><div class="input-group"><div class="input-group-addon"><i class="fa fa-twitter"></i></div></a>
                <input id="twitter" name="twitter" placeholder="https://twitt..." class="form-control" type="text" value=""></div></div>
            <!--#linkedin-->
            <div class="form-group"><a href="'.$usuario['usu_linkedin'].'"><div class="input-group"><div class="input-group-addon"><i class="fa fa-linkedin"></i></div></a>
                <input id="linkedin" name="linkedin" placeholder="https://linke..." class="form-control" type="text" value=""></div></div>
            
            <div class="row">
            <div class="form-actions form-group ml-auto mr-auto mt-2">
                <a href="usuarios.php" class="btn btn-danger btn-md mr-1">Cancelar</a>
                <button type="submit" class="btn btn-primary btn-md ml-1">Guardar</button></div>
            </div>
            </div>
        </form>
    </section>
</aside>

<?php } ?> <!-- final da condição - if($edit_id) { -->
<!--Novo-->



<?php require_once('modal-update-foto.php'); ?>



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

    function mostraEsconde(){
        var passwordField = $('#senha');
        var passwordFieldType = passwordField.attr('type');
        if(passwordFieldType == 'password')
        {   passwordField.attr('type', 'text');
            $(this).val('Esconder');
        } else {
            passwordField.attr('type', 'password');
            $(this).val('Mostrar');
        }
    }

    $(document).ready(function () { 
            
            var $CPF = $("#cpf");
            $CPF.mask('000.000.000-00', {reverse: true});
            
            var $NASC = $("#nascimento");
            $NASC.mask('0000-00-00', {reverse: true});
            
            var $CELULAR = $("#celular");
            $CELULAR.mask('(00) 00000-0000', {reverse: true});
            
            var $TELEFONE = $("#telefone");
            $TELEFONE.mask('(00) 0000-0000', {reverse: true});
            
            var $CEP = $("#cep");
            $CEP.mask('00000-000', {reverse: true});
    });
</script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.0/jquery.mask.js"></script>

<?php require_once('after_content.php'); ?>















<!--
                echo '<a data-toggle="modal" data-target="#smallmodal"><i class="fa fa-info-circle"></i></a>'; ?>

                <div class="modal fade" id="modal-info" tabindex="-1" role="dialog" aria-labelledby="modalinfoLabel" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog modal-sm" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalinfoLabel"></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body"><p></p></div>
                            <div class="modal-footer"><button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button></div>
                        </div>
                    </div>
                </div>






                <li class="list-group-item">
                        <a href="#" class="not-hover c-seta"> <i class="fa fa-phone"></i><strong> Telefone: </strong>
                        <?php #echo $tec['usu_telefone'] . ' </a></li>'; ?>
                    <li class="list-group-item">
                        <a href="#" class="not-hover c-seta"> <i class="fa fa-tablet"></i><strong> Celular: </strong>
                        <?php #echo $tec['usu_celular'] . ' </a></li>'; ?>
                    <li class="list-group-item">
                        <a href="#"> <i class="fa fa-whatsapp"></i><strong> WhatsApp: </strong>
                        <?php #echo $tec['usu_whatsapp'] . ' </a></li>'; ?>

-->
