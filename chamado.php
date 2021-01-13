<?php require_once('before_content.php'); ?>
<link rel="stylesheet" href="assets/scss/socials.css">
<script src="js/msdropdown/jquery-1.3.2.min.js" type="text/javascript"></script>
<script src="js/msdropdown/jquery.dd.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="css/msdropdown/dd.css" />
<style type="text/css">
    /*input:valid {
        border-color: #28a745;
    }*/
    .sufee-alert{
        max-width: 900px;
    }
    .c-seta{
        cursor: context-menu;
    }
    .c-seta:hover{
        color:#878787 !important;
    }
    .c-link{
        cursor: poiter;
    }
    .c-link:hover{
        color:#cccccc !important;
    }
    input:invalid{
        border-color: #dc3545;
    }
    input:invalid:focus{
        border-color: #dc3545;
        box-shadow: 0 0 0 .2rem rgba(220,53,69,.25);
    }
    .list-group-item {
        margin: 0px;
    }
    .list-group-item a {
        margin: 2px;
    }
    .list-group-item a:hover {
        color: #cccccc;
    }
    .media-body{
        margin-left: auto !important;
        margin-right: auto !important;
    }
    .card-body{
        padding: 0px;
    }
    .card-body .not-hover:hover{
        color: #878787;
    }
    .info-box{
        padding: 0px;
    }
    .info-box ul{
        margin: 0px;
    }
    .info-box i{
        color: #878787 !important;
        width: 30px;
    }
    .info-box .idata{
        width: 16px;
        margin-right: 10px;
        margin-left: 10px;
    }
    .info-box .nome {
        color: #878787;
        font-size: 18px;
        font-weight: 700;
        cursor: pointer;
    }
    .info-box .nome:hover{
        color: #cccccc;
    }
    .info-box a:hover{
        color: #878787;
    }
    .count {
        font-weight: bold;
        border-radius: 4px;
        color: #fff;
        font-size: 11px;
        height: 15px;
        line-height: 15px;
        margin-top: 14px;
        margin-left: 10px;
        padding-left: 4px;
        padding-right: 4px;
        position: absolute;
    }  
    .media-body{
        text-align:left;
    }
    .card{
        max-width: 900px;
    }
    .infoicon i{
        color: #007bff;
    }
    #nome-cli{
        padding-top: 23px !important;
        padding-bottom: 24px !important;
    }
    .info-box select{
        display: inline;
        padding-top: 10px;
        padding-bottom: 10px;
        border: none;
        width: calc(100% - 75px);
    }
    .edit .card-body .btn{
        margin-top: 7px;
        padding: 3px 0;
    }
    .edit .card-body .btn i{
        color: #fff !important;
    }
    .media-body h4{
        width: 400px !important;
        display: inline-block !important;
    }
    .h6{
        text-align: center;
        width: 300px;
        padding: 13px 0px 2px 0px;
    }
    .data{
        padding-top: 12px;
        display: inline-block;
        width: 160px;
    }
    .hora{
        padding-top: 12px;
        display: inline-block;
        width: 100px;
    }
    .dataehora{
        padding-bottom: 10px;
        width: 300px;
        border-bottom: 1px solid #ced4da;
        border-top: 1px solid #ced4da;
    }
    .dataehora h6{
        margin-left: 4px;
    }
    .dataehora select{
        border: none;
        background-color: #f8f9fa;
    }

    #st_1{ background-color: #ffc107; }
    #st_2{ background-color: #868e96; }
    #st_3{ background-color: #17a2b8; }
    #st_4{ background-color: #007bff; }
    #st_5{ background-color: #28a745; }
    #st_6{ background-color: #dc3545; }

    #select_st, #st_1, #st_2, #st_3, 
    #st_4, #st_5, #st_6{
        color: #fff;
        font-weight: 700;
    }
    .select_status{
        border-radius: 4px;
        border:none;
        font-weight: 700;
    }
    .update_chamado input{
        display: none!important;
    }
    .fotoChamado{
    	display: inline;
    	max-height: 252px;
    	/*width: 200px;*/
    	margin: 3px;
    	/*transform: rotate(90deg);*/
    }
    .fotos{
     	overflow: auto;   	
    }

    @media print{
        #left-panel, #header{
            display: none;
        }
        .card {
            width: 100%;
            position: fixed;
            top: 0;
            left:0;
            right: 0;
            margin: 0;
            padding: 15px;
            font-size: 14px;
            line-height: 18px;
        }  
        .card li{
            padding: 5px;
        }      
        .tecnico, .atendente{
            width: 50%;
            display: inline;
        }
    }
</style>

<?php 
    $msg_erro_1 = "Houve um problema na conexão com o banco!, tente novamente.";
    $msg_erro_2 = "A alteração não pode ser executada! tente novamente.";
    $msg_erro_3 = "Erro na requesição contate o administrador!";
    $msg_erro_4 = "A senha deve ter no minimo 6 caracteres, tente novamente!";
    $msg_erro_5 = "A imagem não pode ser inserida/alterada, tente novamente!";
    $msg_erro_6 = "Você não tem permissão para criar novos usuários!";

    $msg_ok_1 = "O chamado foi alterado com sucesso!";
    $msg_ok_2 = "O usuário criado com sucesso!";
    $msg_ok_3 = "A imagem foi inserida/alterada com sucesso!";

    $erro = null; $ok = null; $view_id = 0; $edit_id = 0; $new = 0; $cargo = $_SESSION['usu_cargo']; $sql_update = ""; 
    #permissões por status do chamado e cargo;

    $sql_perm = "SELECT p_cham FROM permissoes WHERE p_id = " . $cargo;
    $result_perm = mysqli_query($conexao, $sql_perm);
    if (!$result_perm) {
        printf("Error: %s\n", mysqli_error($conexao));
        exit();
    }
    $perm = mysqli_fetch_assoc($result_perm);
    $perm = $perm['p_cham'];
            $p_view = $perm[0];     //ver
            $p_edit = $perm[1];     //editar
            $p_new  = $perm[2];     //criar
            $p_del  = $perm[3];     //excluir
    if($_SERVER['REQUEST_METHOD'] == "GET") {   // requisição via get (VIEW ou EDIT passando pelo parametro o ID)  
        if(isset($_GET['edit'])){               // GET -> EDIT
            if ($p_edit == 1){                  // verifica se tem permissao editar
                $edit_id = $_GET['edit'];       // SIM então atribui o ID a variavel de controle $edit_id
            }else{                              // se não tiver permissão
                $view_id = $_GET['edit'];       // NÃO então tenta ver o chamado atribuindo o ID em $view_id
            }
        }
        if(isset($_GET['view'])||$view_id!=0){  // GET -> VIEW ou falha na permissao do GET -> EDIT 
            if ($p_view == 1){                  // entao verifica se pode ver
                if($view_id == 0) {             // se nao tiver ocorrido erro no EDIT a variavel $view_id ainda é 0
                    $view_id = $_GET['view'];   // entao a tentativa inicial era VIEW atribui o ID a $view_id
                }                               // se veio de uma tentativa de edição nao permitida e pode ver não altera o view_id
            } else {                            // se também nao tiver permissão ver então volta par o index com erro = 1
                $view_id = 0; $edit_id = 0; #header('Location: index.php?erro=2');
            }
        }
        if(isset($_GET['new'])){
            if($p_new != 1){
                $view_id = $_GET['new'];
            } else {
                $new = 1;
            }
        }
        if(isset($_GET['erro'])){   
            $erro = $_GET['erro'];    
            if ($erro == 1) { $msg_erro = $msg_erro_1; }
            if ($erro == 2) { $msg_erro = $msg_erro_2; }
            if ($erro == 3) { $msg_erro = $msg_erro_3; }
            if ($erro == 4) { $msg_erro = $msg_erro_4; }
            if ($erro == 5) { $msg_erro = $msg_erro_5; }
        }
        if(isset($_GET['ok']))  {   
            $ok = $_GET['ok'];     
            if ($ok == 1) { $msg_ok = $msg_ok_1; }
            if ($ok == 2) { $msg_ok = $msg_ok_2; }
            if ($ok == 3) { $msg_ok = $msg_ok_3; }
        }
    } else {
        $view_id = 0; $edit_id = 0; #header('Location: index.php?erro=2');
    }
?> 

<div class="row">
    <div class="col-12 ml-auto">

<?php
    if($erro){
        echo '<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show ml-auto mr-auto">'.$msg_erro;
        echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>';
    }
    if($ok){
        echo '<div class="sufee-alert alert with-close alert-success alert-dismissible fade show ml-auto mr-auto">';
        echo '<span class="badge badge-pill badge-success">Sucesso</span>&nbsp;'.$msg_ok;
        echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>';
    }    



/* <!-- VIEW INICIO -->
 *
 *
 *
 *
 *
 */
if($view_id!=0) { 
    logMsg( $_SESSION['usu_login']." entrou em a chamdo.php?view" );
    //inicia as consultas no bancoe faz as atribuições dos badges

    $sql_chamado = "SELECT * FROM chamados_web WHERE cham_id = " . $view_id . ";";
    $chamado = mysqli_fetch_assoc(mysqli_query($conexao, $sql_chamado));

    $sql_data_hora = "SELECT * FROM chamados_data_hora WHERE cham_id = " . $view_id . ";";
    $datahora = mysqli_fetch_assoc(mysqli_query($conexao, $sql_data_hora));

                                  $class_status = "badge-light";        //caso ocorra um erro   - lable branco 
    if ($chamado['est_id'] == 1){ $class_status = "badge-warning"; }    //1 - designar tecnico  - lable amarelo
    if ($chamado['est_id'] == 2){ $class_status = "badge-secondary"; }  //2 - em espera         - lable cinza escuro
    if ($chamado['est_id'] == 3){ $class_status = "badge-info"; }       //3 - em deslocamento   - lable azul claro
    if ($chamado['est_id'] == 4){ $class_status = "badge-primary"; }    //4 - em execução       - lable azul escuro
    if ($chamado['est_id'] == 5){ $class_status = "badge-success"; }    //5 - finalizado        - lable verde
    if ($chamado['est_id'] == 6){ $class_status = "badge-danger"; }     //6 - cancelado         - lable vermelho ?>
    <aside class="profile-nav alt">
        <section class="card ml-auto mr-auto">
            <!-- INICIO HEADER CHAMADO VIEW -->
            <div class="card-header user-header alt bg-dark c-seta">
                <!--div class="media col-lg-6">
                    <div class="media-body"-->
                        <?php #echo '<h4 class="text-light display-6 mt-2>'.$chamado['cham_id']. ' - ' .$chamado['serv_nome'].'</h4>'?>
                    <!--/div-->

                <div class="media-body pl-3 pb-3 col-8">
                    <?php echo '<h2 class="text-light mt-2">#' .$chamado['cham_id']. ' - ' .$chamado['serv_nome']. '</h2>'; 
                          echo '<h5 class="text-light"><span class="badge ' . $class_status . ' mt-2 mr-2">' . $chamado['est_nome'] . '</span>  '.$datahora['data_agendado'].' - '.$datahora['hora_agendado'].'<h5>'; ?>
                </div>
                <div class="col-4 pt-4">
                    <button class="btn btn-secondary float-right" type="button" id="printButton" onclick="printPage()"><i class="fa fa-print"></i></button>
                    <?php 
                        if ($chamado['est_id'] == 5){   //chamados finalizados não podem ser editados ou excluidos por nenhum usuario
                            echo '<button class="btn btn-secondary float-right mr-2" type="button" disabled><i class="fa fa-pencil"></i> Editar</button>';                            
                            echo '<button class="btn btn-secondary float-right mr-2" type="button" disabled><i class="fa fa-trash"></i></button>';
                        } else {                        //os restantes estados de chamados obedecem às permissões definidas no banco 
                            if($p_edit == 1){
                               echo '<a href="chamado.php?edit='.$view_id.'"><button class="btn btn-secondary float-right mr-2" type="button">';
                               echo '<i class="fa fa-pencil"></i> Editar</button></a>';
                            } else {
                               echo '<button class="btn btn-secondary float-right mr-2" type="button" disabled>';
                               echo '<i class="fa fa-pencil"></i> Editar</button>';
                            }
                            if($p_del == 1){
                                echo '<a data-toggle="modal" id="bt-delete" data-target="#delete-modal"><button class="btn btn-secondary float-right mr-2" type="button"><i class="fa fa-trash"></i></button></a>';
                            } else {
                                echo '<button class="btn btn-secondary float-right mr-2" type="button" disabled><i class="fa fa-trash"></i></button>';
                            }
                            if($p_new == 1){
                                echo '<a href="chamado.php?new='.$view_id.'"><button class="btn btn-secondary float-right mr-2" type="button"><i class="fa fa-plus-square"></i></button></a>';
                            } else {
                                echo '<button class="btn btn-secondary float-right mr-2" type="button" disabled><i class="fa fa-plus-square"></i></button>';
                            }
                        }
                    ?>
                </div>
                <!-- MODAL CONFIRMAR EXCLUSÃO -->
                <?php echo '<div class="modal fade" id="delete-modal" tabindex="-1" role="dialog"';
                      echo '  aria-labelledby="smallModalLabel" style="display: none;" aria-hidden="true">'; ?>
                    <div class="modal-dialog modal-sm" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="smallModalLabel">Confirmar exclusão</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <?php echo '<p>Tem certeza que deseja excluir o Chamado: <strong>#' . $chamado['cham_id'] . " - " . $chamado['serv_nome']. '</strong></p>';?>
                            </div>
                            <div class="modal-footer">   
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Não</button>
                                <?php echo '<a href="controller/edit-chamado.php?delete=' . $chamado['cham_id'] . '">';
                                      echo '<button type="button" class="btn btn-success">Sim</button></a>'; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- MODAL CONFIRMAR EXCLUSÃO -->
            </div>
            <!-- FIM HEADER CHAMDO VIEW -->
            <!-- INICIO CARDS CHAMADO VIEW -->
            <div class="card-body p-0">

                <!--primeira linha (cliente e tecnico)-->
                <div class="col-12 p-0">
                    <!--card cliente-->
                    <div class="cliente info-box col-md-12 col-lg-6 p-0">
                        <ul class=" list-group list-group-flush">
                            <li class="list-group-item bg-secondary text-light">
                                <h4 class="text-center">Cliente</h4>
                            </li>
                            <li id="nome-cli" class="list-group-item" >
                            <?php echo '<a class="nome mt-3 ml-1" href="cliente.php?view='.$chamado['cli_id'].'"><i class="fa fa-user"></i>'.$chamado['cli_nome'] . '</a>';?>
                            </li>
                            <?php if($chamado['cli_telefone'] != null && $chamado['cli_telefone'] != ""){?> 
                                <li class="list-group-item">
                                    <a class="c-seta" href="#"> <i class="fa fa-phone"></i><strong> Telefone: </strong>
                                    <?php echo $chamado['usu_telefone'] . ' </a></li>'; ?>
                            <?php }?>
                            <li class="list-group-item">
                                <a class="c-seta" href="#"> <i class="fa fa-tablet"></i><strong> Celular: </strong>
                                <?php echo $chamado['usu_celular'] . ' </a></li>'; ?>
                            <?php if($chamado['cli_whatsapp'] != null && $chamado['cli_whatsapp'] != ""){?> 
                                <li class="list-group-item">
                                    <a class="c-link" href="#"> <i class="fa fa-whatsapp"></i><strong> WhatsApp: </strong>
                                    <?php echo $chamado['cli_whatsapp'] . ' </a></li>'; ?>
                            <?php }?>
                            <li class="list-group-item">
                                <a class="c-link" href="#"> <i class="fa fa-envelope-o"></i><strong> Email: </strong>
                                <?php echo $chamado['cli_email'] . ' </span></a></li>'; ?>
                            <li class="list-group-item">
                                <?php //converte o endereço do cliente em latitude e longitude atravez da API do Google Maps
                                echo '<a class="c-link" href="mapa.php?lat='.$chamado['end_latitude'].'&lng='.$chamado['end_longitude'].'&tipo=3&id='.$chamado['cli_id'].'">';
                                echo '<i class="fa fa-map-marker"></i><strong> Endereço: </strong>';
                                echo $chamado['end_logradouro'].', '.$chamado['end_numero'].' ('.$chamado['end_complemento'].') - ';
                                echo $chamado['end_cidade'].', '.$chamado['end_estado'].'</a></li>'; 
                                ?>
                        </ul>
                    </div>
                    <!--fim do card cliente-->
                    <!--card serviço-->
                    <div class="servico info-box col-md-12 col-lg-6 p-0">
                        <?php 
                            $sql_serv_tipo = "SELECT icon_web AS icon FROM tipo_servico WHERE id_tp_serv = " . $chamado['serv_id'] . ";";
                            $serv_tipo = mysqli_fetch_assoc(mysqli_query($conexao, $sql_serv_tipo));

                            #$sql_n_andamento = 'SELECT count(cham_id) AS andamento FROM chamado_tecnico WHERE cham_status != 5 AND cham_status != 6 AND cham_tecnico = '.$tec['usu_id'].';';
                            #$ctAndamento = mysqli_fetch_assoc(mysqli_query($conexao, $sql_n_andamento));
                            #$cham_andamento  = $ctAndamento['andamento'];
                        ?>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item bg-secondary text-light">
                                <h4 class="text-center">Serviço</h4>
                            </li>
                            <li class="list-group-item">
                                <?php   #echo '<a href="usuario.php?view='.$tecnico['usu_id'].'">';
                                echo '<img style="width: 50px; height: 50px; border-radius:50%;" src="images/icons/'.$serv_tipo['icon'].'"></img>';
                                echo '<a class="nome mt-3 ml-3" href="usuario.php?view=">'.$chamado['serv_nome'].'</a>';
                                echo '<a class="infoicon ml-3 c-link" data-toggle="modal" data-target="#modal-info"><i class="fa fa-info-circle"></i></a>'; ?>
                                    <div class="modal fade" id="modal-info" tabindex="-1" role="dialog" aria-labelledby="modalinfoLabel" style="display: none;"  aria-hidden="true">
                                        <div class="modal-dialog modal-sm" role="dialog"><div class="modal-content"><div class="modal-header">
                                            <h5 class="modal-title" id="modalinfoLabel"><i class="fa fa-info-circle"></i><?php echo $chamado['serv_nome']; ?></h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></div>
                                            <div class="modal-body"><p><?php echo $chamado['serv_descricao']; ?></p></div></div>
                                        </div>
                                    </div><!--Modal info serviço-->
                            </li>
                            <?php if($chamado['cham_agendado'] != null){?> 
                                <li class="list-group-item">
                                    <a class="c-seta" href=""><strong>Agendamento: </strong>
                                    <?php echo '<div class="float-right"><i class="fa fa-calendar idata"></i> ';
                                          echo $datahora['data_agendado'].' <i class="fa fa-clock-o idata"/></i> '.$datahora['hora_agendado'].'</div></a></li>'; ?>
                            <?php }?>
                            <?php if($chamado['cham_iniciado'] != null){?> 
                                <li class="list-group-item">
                                    <a class="c-seta" href=""></i><strong>Iniciado: </strong>
                                    <?php echo '<div class="float-right"><i class="fa fa-calendar idata"></i> ';
                                          echo $datahora['data_iniciado'].' <i class="fa fa-clock-o idata"/></i> '.$datahora['hora_iniciado'].'</div></a></li>'; ?>
                            <?php }?>
                            <?php if($chamado['cham_finalizado'] != null){?> 
                                <li class="list-group-item">
                                    <a class="c-seta" href=""><strong>Finalizado: </strong>
                                    <?php echo '<div class="float-right"><i class="fa fa-calendar idata"></i> ';
                                          echo $datahora['data_finalizado'].' <i class="fa fa-clock-o idata"/></i> '.$datahora['hora_finalizado'].'</div></a></li>'; ?>
                            <?php }?>
                            <?php if($chamado['cham_descricao'] != null && $chamado['cham_descricao'] != ""){?> 
                            <li class="list-group-item">
                                <a class="c-seta" href=""> <i class="fa fa-ellipsis-h" style="width: 30px"></i><strong></strong>
                                <?php echo $chamado['cham_descricao'] . ' </span></a></li>'; ?>
                            <?php }?>
                            <?php if($chamado['cham_observacao'] != null && $chamado['cham_observacao'] != ""){?> 
                                <li class="list-group-item">
                                    <a class="c-seta" href=""> <i class="fa fa-info" style="width: 30px"></i><strong>Obs: </strong>
                                    <?php echo $chamado['cham_observacao'] . ' </a></li>'; ?>
                            <?php }?>
                            <?php if($chamado['cham_descricao_final'] != null && $chamado['cham_descricao_final'] != ""){?> 
                                <li class="list-group-item">
                                    <a class="c-seta" href=""> <i class="fa fa-check-square-o" style="width: 30px"></i>
                                    <?php echo $chamado['cham_descricao_final'] . ' </a></li>'; ?>
                            <?php }?>
                        </ul>            
                    </div>
                    <!--fim do card serviço-->
                </div>

                <!--segunda linha (tecnico e atendente)-->
                <div class="col-12 p-0">
                    <!--card tecnico-->
                    <div class="tecnico info-box col-md-12 col-lg-6 p-0">
                        <?php
                            if ($chamado['cham_tecnico']!=null){ 
                                $sql_tecnico = "SELECT * FROM usuario WHERE usu_id = " . $chamado['cham_tecnico'] . ";";
                                $tec = mysqli_fetch_assoc(mysqli_query($conexao, $sql_tecnico));

                                $sql_n_andamento = 'SELECT count(cham_id) AS andamento FROM chamado_tecnico WHERE cham_status != 5 AND cham_status != 6 AND cham_tecnico = '.$tec['usu_id'].';';
                                $ctAndamento = mysqli_fetch_assoc(mysqli_query($conexao, $sql_n_andamento));
                                $cham_andamento  = $ctAndamento['andamento'];
                            }
                        ?>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item bg-secondary text-light">
                                <h4 class="text-center">Técnico</h4>
                            </li>
                            <?php if ($chamado['cham_tecnico']!=null){ ?>
                                <li class="list-group-item">
                                    <?php   #echo '<a href="usuario.php?view='.$tecnico['usu_id'].'">';
                                    echo '<img style="width: 50px; height: 50px;" src="upload/'.$tec['usu_foto'].'"></img>';
                                    echo '<a class="nome mt-3 ml-3" href="usuario.php?view='.$tec['usu_id'].'">'.$tec['usu_nome'] . '</a>';
                                    echo '<a href="chamados.php?tec=asc&st2=1&st3=1&st4=1&id='.$tec['usu_id'].'"><span class="count bg-primary">'.$cham_andamento.'</span></a>'; ?>
                                </li>
                                <li class="list-group-item">
                                    <?php echo '<a class="c-link" href="mailto:'.$tec['usu_email'].'?Subject=Olá%20'.$tec['usu_nome'].'">'; 
                                          echo '<i class="fa fa-envelope-o"></i><strong> Email: </strong>';
                                          echo $tec['usu_email'] . ' </span></a></li>'; ?>
                                <li class="list-group-item">
                                    <?php echo '<a class="c-link" href="mapa.php?lat='.$tec['usu_latitude'].'&lng='.$tec['usu_longitude'].'&tipo=2&id='.$tec['usu_id'].'">';
                                    echo '<i class="fa fa-location-arrow"></i><strong>Local</strong>';
                                    echo '<span class="badge badge-pill badge-secondary ml-3">Lat</span> '.$tec['usu_latitude']; 
                                    echo '<span class="badge badge-pill badge-secondary ml-2">Lng</span> '.$tec['usu_longitude'].' </a></li>'; 
                             } else { 
                                echo '<li class="list-group-item">';
                                echo '<img style="width: 50px; height: 50px;" src="upload/undefined-user.png"></img>';
                                echo '<a class="nome mt-3 ml-3" href="chamado.php?edit='.$view_id.'">Técnico a definir</a>';
                                echo '</li>';
                             }?>
                        </ul>
                    </div>
                    <!--fim do card tecnico-->
                    <!--card atendente-->
                    <div class="atendente info-box col-md-12 col-lg-6 p-0">
                        <?php 
                            $sql_atendente = "SELECT * FROM usuario WHERE usu_id = " . $chamado['cham_atendente'] . ";";
                            $atend = mysqli_fetch_assoc(mysqli_query($conexao, $sql_atendente));

                            $sql_n_atendendo = 'SELECT count(cham_id) AS atendendo FROM chamado_tecnico WHERE cham_status != 5 AND cham_status != 6 AND cham_atendente = '.$atend['usu_id'].';';
                            $ctAtendendo = mysqli_fetch_assoc(mysqli_query($conexao, $sql_n_atendendo));
                            $cham_atendendo  = $ctAtendendo['atendendo'];
                        ?>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item bg-secondary text-light">
                                <h4 class="text-center">Atendente</h4>
                            </li>
                            <li class="list-group-item">
                                <?php   #echo '<a href="usuario.php?view='.$tecnico['usu_id'].'">';
                                if($atend['usu_cargo'] == 1){ $bg_cor = "bg-warning";}
                                if($atend['usu_cargo'] == 2){ $bg_cor = "bg-info";}
                                echo '<img style="width: 50px; height: 50px;" src="upload/'.$atend['usu_foto'].'"></img>';
                                echo '<a class="nome mt-3 ml-3" href="usuario.php?view='.$atend['usu_id'].'">'.$atend['usu_nome'] . '</a>';
                                echo '<a href="chamados.php?tec=asc&st2=1&st3=1&st4=1&id='.$atend['usu_id'].'"><span class="count '.$bg_cor.'">'.$cham_atendendo.'</span></a>'; ?>
                            </li>
                            <li class="list-group-item">
                                <?php echo '<a class="c-link" href="mailto:'.$atend['usu_email'].'?Subject=Olá%20'.$atend['usu_nome'].'">'; 
                                      echo '<i class="fa fa-envelope-o"></i><strong> Email: </strong>';
                                      echo $atend['usu_email'] . ' </span></a></li>'; ?>
                            <li class="list-group-item">
                                <?php $atend['usu_whatsapp'] = preg_replace("/[^0-9]/", "", $atend['usu_whatsapp']);
                                echo '<a href="https://api.whatsapp.com/send?phone='.$atend['usu_whatsapp'].'text=Olá '.$atend['usu_nome'].'">';
                                echo '<i class="fa fa-whatsapp"></i><strong> WhatsApp: </strong>' . $atend['usu_whatsapp'] . ' </a></li>'; ?>
                        </ul>
                    </div>
                    <!--fim do card atendente-->


                    <!-- Se o chamado possiur fotos exibe uma nova sessão Fotos -->
					<?php 
                        $sql_fotos = "SELECT cham_foto1 AS fotos FROM chamado_tecnico WHERE cham_id = " . $chamado['cham_id'] . ";";
                        $f = mysqli_fetch_assoc(mysqli_query($conexao, $sql_fotos));
                        if ($f['fotos'] != null){
                    ?>
                    <!--card fotos-->
                    <div class="atendente info-box col-12 p-0">
                        
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item bg-secondary text-light">
                                <h4 class="text-center">Fotos</h4>
                            </li>
                            <li class="list-group-item fotos">
                                <?php $arr_fotos = explode(';', $f['fotos']);
									  for ($i = 0; $i < sizeof($arr_fotos); $i++) {
								    	  $foto = $arr_fotos[$i];
								    	  echo '<img class="fotoChamado" src="upload/chamados-fotos/'.$foto.'"/>';
									  }
                                ?>
                            </li>
                        </ul>
                    </div>
                    <!--fim do card fotos-->
                    <?php } ?>

                </div>
            </div>
            <!-- FIM CARDS CHAMADO VIEW -->
        </section>
    </aside>
<?php } 
/*
 *
 *
 *
 *
 *
 */
?> <!-- VIEW FIM -->




<?php
/* <!-- EDIT INICIO -->
 *
 *
 *
 *
 *
 */
if($edit_id!=0){

    logMsg( $_SESSION['usu_login']." entrou em a chamdo.php?edit" );

    //inicia as consultas no bancoe faz as atribuições dos badges
    $sql_chamado = "SELECT * FROM chamados_web WHERE cham_id = " . $edit_id . ";";
    $chamado = mysqli_fetch_assoc(mysqli_query($conexao, $sql_chamado));

    $sql_data_hora = "SELECT * FROM chamados_data_hora WHERE cham_id = " . $edit_id . ";";
    $datahora = mysqli_fetch_assoc(mysqli_query($conexao, $sql_data_hora));

                                  $class_status = "badge-light";        //caso ocorra um erro   - lable branco 
    if ($chamado['est_id'] == 1){ $class_status = "badge-warning"; }    //1 - designar tecnico  - lable amarelo
    if ($chamado['est_id'] == 2){ $class_status = "badge-secondary"; }  //2 - em espera         - lable cinza escuro
    if ($chamado['est_id'] == 3){ $class_status = "badge-info"; }       //3 - em deslocamento   - lable azul claro
    if ($chamado['est_id'] == 4){ $class_status = "badge-primary"; }    //4 - em execução       - lable azul escuro
    if ($chamado['est_id'] == 5){ $class_status = "badge-success"; }    //5 - finalizado        - lable verde
    if ($chamado['est_id'] == 6){ $class_status = "badge-danger"; }     //6 - cancelado         - lable vermelho
    ?>
    <aside class="profile-nav alt edit">
        <form id="update_chamados" action="controller/edit-chamado.php?update" method="POST">
        <section class="card ml-auto mr-auto">
            <!-- INICIO HEADER CHAMADO VIEW -->
            <div class="card-header user-header alt bg-light c-seta">
                <!--div class="media col-lg-6">
                    <div class="media-body"-->
                        <?php #echo '<h4 class="text-light display-6 mt-2>'.$chamado['cham_id']. ' - ' .$chamado['serv_nome'].'</h4>'?>
                    <!--/div-->
                    <style type="text/css">
                    </style>

                <div class="media-body pl-3 pb-3 col-9">
            
                    <?php echo '<h4 class="mt-2">Chamado Técnico #' .$chamado['cham_id']. ' - ' .$chamado['serv_nome']. '</h4>'; 
                          echo '<input id="input_id" name="id" style="display:none;" value="'.$chamado['cham_id'].'"></input>'
                    ?>


                    <select id="select_st" name="status" onchange="change_tecnico();" class="select_status mt-2 mr-2" >
                        <?php
                        $sql_status = "SELECT est_id, est_nome FROM estatus";
                        $status_result = mysqli_query($conexao, $sql_status);
                        while($status = mysqli_fetch_assoc($status_result)){
                            if($status['est_id'] == $chamado['est_id']){
                                echo '<option id="st_'.$status['est_id'].'" value="'.$status['est_id'].'" selected>'.$status['est_nome'].'</option>';
                            } else {
                                echo '<option id="st_'.$status['est_id'].'" value="'.$status['est_id'].'">'.$status['est_nome'].'</option>';
                            }
                        }
                        ?>
                    </select>
                    <h6 class="h6">Agendamento</h6>
                    <div class="dataehora">
                        <div class="data ml-2">
                            <h6><i class="fa fa-calendar"></i> Data:</h6>
                            <?php 
                                echo '<select name="dia">';
                                $dma = explode("/", $datahora['hora_agendado']);
                                for ($dia = 1; $dia <= 31; $dia++) {
                                    if($dia == $dma[0]){ 
                                        echo '<option value="'.$dia.'" selected>'.$dia.'</option>';
                                    } else { 
                                        echo '<option value="'.$dia.'">'.$dia.'</option>';
                                    }
                                }
                                echo '</select>/';
                                echo '<select name="mes">';
                                for ($mes = 1; $mes <= 12; $mes+=1) {
                                    if($mes == $dma[1]){
                                        echo '<option value="'.$mes.'" selected>'.$mes.'</option>';
                                    } else {
                                        echo '<option value="'.$mes.'">'.$mes.'</option>';
                                    }
                                }
                                echo '</select>/';
                                echo '<select name="ano">';
                                for ($ano = 2018; $ano <= 2030; $ano+=1) {
                                    if($ano == $dma[2]){
                                        echo '<option value="'.$ano.'">'.$ano.'</option>';
                                    } else {
                                        echo '<option value="'.$ano.'">'.$ano.'</option>';
                                    }
                                }
                                echo'</select>'; 
                            ?>
                        </div>
                        <div class="hora ml-2">
                            <h6><i class="fa fa-clock-o"></i> Hora:</h6>
                            <?php 
                                echo'<select name="hora">';
                                $hm = explode(":", $datahora['hora_agendado']);
                                for ($hora = 8; $hora < 20; $hora++) {
                                    if($hora == $hm[0]){ echo '<option value="'.$hora.'" selected>'.$hora.'</option>';
                                    } else { echo '<option value="'.$hora.'">'.$hora.'</option>';
                                    }
                                }
                                echo '</select>:';
                                echo '<select name="min">';
                                    for ($min = 0; $min < 60; $min+=5) {
                                        if($min == $hm[1]){
                                            if ($min < 10){ echo '<option value="'.$min.'" selected>0'.$min.'</option>';}
                                            else { echo '<option class="minuto" value="'.$min.'" selected>'.$min.'</option>'; }
                                        }else{
                                            if ($min < 10){ echo '<option value="'.$min.'">0'.$min.'</option>';}
                                            else { echo '<option value="'.$min.'">'.$min.'</option>'; }
                                        }
                                    }
                                echo'</select>';
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-3 pt-4 form-action">
                        <button type="submit" class="btn btn-secondary float-right mr-2"  ><i class="fa fa-save"></i> Salvar</button>
                </div>
                <div class="row form-group col-md-6 ml-2">
                    <div class="col-md-12 col-lg-4 pr-0 pl-1"><i class="fa fa-ellipsis-h mr-2"></i><label for="textarea-input" class=" form-control-label"> Descrição</label></div>
                    <div class="col-md-12 col-lg-8 p-0">
                        <textarea name="desc" id="textarea-desc" rows="4" placeholder="" class="form-control"><?php echo $chamado['cham_descricao'];?></textarea>
                    </div>
                </div>
                <div class="row form-group col-md-6 ml-2">
                    <div class="col-md-12 col-lg-4 pr-0 pl-1"><i class="fa fa-ellipsis-h mr-2"></i><label for="textarea-input" class=" form-control-label"> Observação</label></div>
                    <div class="col-md-12 col-lg-8 p-0">
                        <textarea name="obs" id="textarea-obs" rows="4" placeholder="" class="form-control"><?php echo $chamado['cham_observacao'];?></textarea>
                    </div>
                </div>
            </div>
   
            <!-- FIM HEADER CHAMDO VIEW -->
            <!-- INICIO CARDS CHAMADO VIEW -->
            <div class="card-body p-0">
                <!--primeira linha (cliente e serviço)-->
                <div class="col-12 p-0">
                    <!--card cliente-->
                    <div class="cliente info-box col-md-12 col-lg-6 p-0">
                        <?php  
                            $sql_cli = "SELECT cli_id, cli_nome FROM cliente ORDER BY cli_nome";
                            $clientes = mysqli_query($conexao, $sql_cli);
                        ?>
                        <ul class=" list-group list-group-flush">
                            <li class="list-group-item bg-secondary text-light">
                                <h4 class="text-center">Cliente</h4>
                            </li>
                            <li class="list-group-item">
                                <a class="nome"><i class="fa fa-user"></i></a>
                                <select id="select_cli" name="cli" class="nome">
                                    <?php 
                                        while($cli = mysqli_fetch_assoc($clientes)) { 
                                            if ($cli['cli_id']==$chamado['cham_cliente']){ 
                                                echo '<option class="nome float-right" value="'.$cli['cli_id'].'" selected>'.$cli['cli_nome'].'</option>';
                                            } else{
                                                echo '<option class="nome float-right" value="'.$cli['cli_id'].'">'.$cli['cli_nome'].'</option>';
                                            }
                                        }
                                    ?>                                                         
                                </select>
                                <a href="cliente.php?new&return='.$edit_id.'"><button class="btn btn-secondary float-right" type="button"><i class="fa fa-plus-square"></i></button></a>
                            </li>
                        </ul>
                    </div>
                    <!--fim do card cliente-->
                    <!--card serviço-->
                    <div class="servico info-box col-md-12 col-lg-6 p-0">
                        <?php  
                            $sql_serv = "SELECT serv_id, serv_nome FROM servico ORDER BY serv_nome";
                            $servicos = mysqli_query($conexao, $sql_serv);
                        ?>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item bg-secondary text-light">
                                <h4 class="text-center">Serviço</h4>
                            </li>
                            <li class="list-group-item">
                                <a class="nome"><i class="fa fa-sign-out"></i></a>
                                <select id="select_serv" name="serv" class="nome">
                                    <?php 
                                        while($serv = mysqli_fetch_assoc($servicos)) { 
                                            if ($serv['serv_id']==$chamado['cham_servico']){ 
                                                echo '<option class="nome float-right" value="'.$serv['serv_id'].'" selected>'.$serv['serv_nome'].'</option>';
                                            } else{
                                                echo '<option class="nome float-right" value="'.$serv['serv_id'].'">'.$serv['serv_nome'].'</option>';
                                            }
                                        }
                                    ?>                                                         
                                </select>
                                <a href="servico.php?new&return='.$edit_id.'"><button class="btn btn-secondary float-right" type="button"><i class="fa fa-plus-square"></i></button></a>
                            </li>
                        </ul>            
                    </div>
                    <!--fim do card serviço-->
                </div>

                <!--segunda linha (tecnico e atendente)-->
                <div class="col-12 p-0">
                    <!--card tecnico-->
                    <div class="tecnico info-box col-md-12 col-lg-6 p-0">
                        <?php $sql_tec = "SELECT usu_id, usu_nome FROM usuario WHERE usu_cargo = 3 ORDER BY usu_nome";
                              $tecnicos = mysqli_query($conexao, $sql_tec);  ?>
                        <ul class=" list-group list-group-flush">
                            <li class="list-group-item bg-secondary text-light">
                                <h4 class="text-center">Técnico</h4>
                            </li>
                            <li class="list-group-item">
                                <a class="nome"><i class="fa fa-user"></i></a>
                                <select id="select_tec" name="tec" class="nome" onchange="change_status()">
                                    <option class="nome float-right" value="0"></option>'
                                    <?php while($tec = mysqli_fetch_assoc($tecnicos)) { 
                                                if ($tec['usu_id']==$chamado['cham_tecnico']){ 
                                                    echo '<option class="nome float-right" value="'.$tec['usu_id'].'" selected>'.$tec['usu_nome'].'</option>';
                                                } else{
                                                    echo '<option class="nome float-right" value="'.$tec['usu_id'].'">'.$tec['usu_nome'].'</a></option>';
                                                }
                                          }
                                    ?>                                                         
                                </select>
                                <?php if($_SESSION['usu_cargo'] == 1){
                                    echo '<a href="usuario.php?new&return='.$edit_id.'"><button class="btn btn-secondary float-right" type="button"><i class="fa fa-plus-square"></i></button></a>';
                                }?>
                            </li>
                        </ul>
                    </div>
                    <!--fim do card tecnico-->
                    <!--card atendente-->
                    <div class="atendente info-box col-md-12 col-lg-6 p-0">
                            <ul class=" list-group list-group-flush">
                                <li class="list-group-item bg-secondary text-light">
                                    <h4 class="text-center">Atendente</h4>
                                </li>
                                <?php if ($_SESSION['usu_cargo'] == 1){
                                    $sql_atend = "SELECT usu_id, usu_nome FROM usuario WHERE usu_cargo = 2 OR usu_cargo = 1 ORDER BY usu_nome";
                                    $atendentes = mysqli_query($conexao, $sql_atend);  ?>
                                    <li class="list-group-item">
                                    <a class="nome"><i class="fa fa-user"></i></a>
                                    <select id="select_atd" name="atd" class="nome">
                                      <?php while($atend = mysqli_fetch_assoc($atendentes)) { 
                                                if ($atend['usu_id']==$chamado['cham_atendente']){ 
                                                    echo '<option class="nome float-right" value="'.$atend['usu_id'].'" selected>'.$atend['usu_nome'].'</option>';
                                                } else{
                                                    echo '<option class="nome float-right" value="'.$atend['usu_id'].'">'.$atend['usu_nome'].'</a></option>';
                                                }
                                            }
                                        ?>                                                         
                                    </select>
                                    	<a href="usuario.php?new&return='.$edit_id.'"><button class="btn btn-secondary float-right" type="button"><i class="fa fa-plus-square"></i></button></a>
                                    </li>
                                <?php } else {?> 
                                    <li class="list-group-item" style="padding-top:20px" >
                                    <a class="nome"><i class="fa fa-user"></i></a>
                                    <?php   #echo '<a href="usuario.php?view='.$tecnico['usu_id'].'">';
                                    $sql_atendente = "SELECT usu_id, usu_nome, usu_cargo FROM usuario WHERE usu_id = " . $chamado['cham_atendente'] . ";";
                                    $atend = mysqli_fetch_assoc(mysqli_query($conexao, $sql_atendente));
                                    $sql_n_atendendo = 'SELECT count(cham_id) AS atendendo FROM chamado_tecnico WHERE cham_status != 5 AND cham_status != 6 AND cham_atendente = '.$atend['usu_id'].';';
                                    $ctAtendendo = mysqli_fetch_assoc(mysqli_query($conexao, $sql_n_atendendo));
                                    $cham_atendendo  = $ctAtendendo['atendendo'];
                                    if($atend['usu_cargo'] == 1){ $bg_cor = "bg-warning";}
                                    if($atend['usu_cargo'] == 2){ $bg_cor = "bg-info";}
                                    echo '<a class="nome mt-5 ml-3" href="usuario.php?view='.$atend['usu_id'].'">'.$atend['usu_nome'] . '</a>';
                                    echo '<a href="chamados.php?tec=asc&st2=1&st3=1&st4=1&id='.$atend['usu_id'].'"><span class="count '.$bg_cor.'" style="margin-top:6px">'.$cham_atendendo.'</span></a>'; ?>
                                    </li>
                                <?php }?>      
                            </ul>

                    </div>
                    <!--fim do card atendente-->
                </div>
            </div>
            <!-- FIM CARDS CHAMADO VIEW -->
        </section>
        </form>
    </aside>
<?php } 
/* 
 *
 *
 *
 *
 *
 */?> <!-- EDIT FIM -->





<?php
/* <!-- EDIT INICIO -->
 *
 *
 *
 *
 *
 */
if($new!=0){ 
logMsg( $_SESSION['usu_login']." entrou em a chamdo.php?new" );
    ?>
    <aside class="profile-nav alt edit">
        <form id="new_chamados" action="controller/edit-chamado.php?create" method="POST">
        <section class="card ml-auto mr-auto">
            <!-- INICIO HEADER CHAMADO CREATE -->
            <div class="card-header user-header alt bg-light c-seta">
                    <style type="text/css">
                    </style>
                    <?php
                        $sql_prox_id = 'SELECT max(cham_id)+1 AS prox_id FROM chamado_tecnico';
                        $proximo_id = mysqli_fetch_assoc(mysqli_query($conexao, $sql_prox_id));
                        $prox_id  = $proximo_id['prox_id'];
                        echo '<input id="input_id" name="id" style="display:none;" value="'.$prox_id.'"></input>' 
                    ?>

                <div class="media-body pl-3 pb-3 col-9">
            
                    <?php echo '<h4 class="mt-2">Chamado Técnico #' .$prox_id. '</h4>'; ?>
                    <select id="select_st" name="status" onchange="change_tecnico();" class="select_status mt-2 mr-2" >
                        <?php #################################################################################################################################################
                        $sql_status = "SELECT est_id, est_nome FROM estatus";
                        $status_result = mysqli_query($conexao, $sql_status);
                        while($status = mysqli_fetch_assoc($status_result)){
                            echo '<option id="st_'.$status['est_id'].'" value="'.$status['est_id'].'">'.$status['est_nome'].'</option>';
                        }
                        ?>
                    </select>

                    <h6 class="h6">Agendamento</h6>
                    <div class="dataehora">
                        <div class="data ml-2">
                            <h6>Data:</h6>
                            <?php 
                                echo '<select name="dia">';
                                $dma = explode("-", date("d-m-Y"));
                                for ($dia = 1; $dia <= 31; $dia++) {
                                    if($dia == $dma[0]+1){  //seleciona amanha por padrao
                                        echo '<option value="'.$dia.'" selected>'.$dia.'</option>';
                                    } else { 
                                        echo '<option value="'.$dia.'">'.$dia.'</option>';
                                    }
                                }
                                echo '</select>/';
                                echo '<select name="mes">';
                                for ($mes = 1; $mes <= 12; $mes+=1) {
                                    if($mes == $dma[1]){
                                        echo '<option value="'.$mes.'" selected>'.$mes.'</option>';
                                    } else {
                                        echo '<option value="'.$mes.'">'.$mes.'</option>';
                                    }
                                }
                                echo '</select>/';
                                echo '<select name="ano">';
                                for ($ano = 2018; $ano <= 2030; $ano+=1) {
                                    if($ano == $dma[2]){
                                        echo '<option value="'.$ano.'">'.$ano.'</option>';
                                    } else {
                                        echo '<option value="'.$ano.'">'.$ano.'</option>';
                                    }
                                }
                                echo'</select>'; 
                            ?>
                        </div>
                        <div class="hora ml-2">
                            <h6>Hora:</h6>
                            <?php 
                                echo'<select name="hora">';
                                for ($hora = 8; $hora < 20; $hora++) {
                                    echo '<option value="'.$hora.'">'.$hora.'</option>';
                                }
                                echo '</select>:';
                                echo '<select name="min">';
                                    for ($min = 0; $min < 60; $min+=5) {
                                        if ($min < 10){ echo '<option value="'.$min.'">0'.$min.'</option>';}
                                        else { echo '<option value="'.$min.'">'.$min.'</option>'; }
                                    }
                                echo'</select>';
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-3 pt-4 form-action">
                        <button type="submit" class="btn btn-secondary float-right mr-2"  ><i class="fa fa-save"></i> Salvar</button>
                </div>
                <div class="row form-group col-md-6 ml-2">
                    <div class="col-md-12 col-lg-4 pr-0 pl-1"><i class="fa fa-ellipsis-h mr-2"></i><label for="textarea-input" class=" form-control-label"> Descrição</label></div>
                    <div class="col-md-12 col-lg-8 p-0">
                        <textarea name="desc" id="textarea-desc" rows="4" placeholder="" class="form-control"></textarea>
                    </div>
                </div>
                <div class="row form-group col-md-6 ml-2">
                    <div class="col-md-12 col-lg-4 pr-0 pl-1"><i class="fa fa-ellipsis-h mr-2"></i><label for="textarea-input" class=" form-control-label"> Observação</label></div>
                    <div class="col-md-12 col-lg-8 p-0">
                        <textarea name="obs" id="textarea-obs" rows="4" placeholder="" class="form-control"></textarea>
                    </div>
                </div>
            </div>
   
            <!-- FIM HEADER CHAMDO NEW -->
            <!-- INICIO CARDS CHAMADO NEW -->
            <div class="card-body p-0">
                <!--primeira linha (cliente e serviço)-->
                <div class="col-12 p-0">
                    <!--card cliente-->
                    <div class="cliente info-box col-md-12 col-lg-6 p-0">
                        <?php  
                            $sql_cli = "SELECT cli_id, cli_nome FROM cliente ORDER BY cli_nome";
                            $clientes = mysqli_query($conexao, $sql_cli);
                        ?>
                        <ul class=" list-group list-group-flush">
                            <li class="list-group-item bg-secondary text-light">
                                <h4 class="text-center">Cliente</h4>
                            </li>
                            <li class="list-group-item">
                                <a class="nome"><i class="fa fa-user"></i></a>
                                <select id="select_cli" name="cli" class="nome">
                                    <?php 
                                        while($cli = mysqli_fetch_assoc($clientes)) { 
                                            echo '<option class="nome float-right" value="'.$cli['cli_id'].'">'.$cli['cli_nome'].'</option>';
                                        }
                                    ?>                                                         
                                </select>
                                <button class="btn btn-secondary float-right" type="button"><i class="fa fa-plus-square"></i></button>
                            </li>
                        </ul>
                    </div>
                    <!--fim do card cliente-->
                    <!--card serviço-->
                    <div class="servico info-box col-md-12 col-lg-6 p-0">
                        <?php  
                            $sql_serv = "SELECT serv_id, serv_nome FROM servico ORDER BY serv_nome";
                            $servicos = mysqli_query($conexao, $sql_serv);
                        ?>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item bg-secondary text-light">
                                <h4 class="text-center">Serviço</h4>
                            </li>
                            <li class="list-group-item">
                                <a class="nome"><i class="fa fa-sign-out"></i></a>
                                <select id="select_serv" name="serv" class="nome">
                                    <?php 
                                        while($serv = mysqli_fetch_assoc($servicos)) { 
                                            echo '<option class="nome float-right" value="'.$serv['serv_id'].'">'.$serv['serv_nome'].'</option>';
                                        }
                                    ?>                                                         
                                </select>
                                <button class="btn btn-secondary float-right" type="button"><i class="fa fa-plus-square"></i></button>
                            </li>
                        </ul>            
                    </div>
                    <!--fim do card serviço-->
                </div>

                <!--segunda linha (tecnico e atendente)-->
                <div class="col-12 p-0">
                    <!--card tecnico-->
                    <div class="tecnico info-box col-md-12 col-lg-6 p-0">
                        <?php $sql_tec = "SELECT usu_id, usu_nome FROM usuario WHERE usu_cargo = 3 ORDER BY usu_nome";
                              $tecnicos = mysqli_query($conexao, $sql_tec);  ?>
                        <ul class=" list-group list-group-flush">
                            <li class="list-group-item bg-secondary text-light">
                                <h4 class="text-center">Técnico</h4>
                            </li>
                            <li class="list-group-item">
                                <a class="nome"><i class="fa fa-user"></i></a>
                                <select id="select_tec" name="tec" class="nome" onchange="change_status()">
                                    <option class="nome float-right" value="0"></option>'
                                    <?php while($tec = mysqli_fetch_assoc($tecnicos)) { 
                                            echo '<option class="nome float-right" value="'.$tec['usu_id'].'">'.$tec['usu_nome'].'</a></option>';
                                        }
                                    ?>                                                         
                                </select>
                                <?php if($_SESSION['usu_cargo'] == 1){
                                    echo '<a href="usuario.php?new&return='.$edit_id.'"><button class="btn btn-secondary float-right" type="button"><i class="fa fa-plus-square"></i></button>';
                                }?>
                            </li>
                        </ul>
                    </div>
                    <!--fim do card tecnico-->
                    <!--card atendente-->
                    <div class="atendente info-box col-md-12 col-lg-6 p-0">
                            <ul class=" list-group list-group-flush">
                                <li class="list-group-item bg-secondary text-light">
                                    <h4 class="text-center">Atendente</h4>
                                </li>
                                <?php if ($_SESSION['usu_cargo'] == 1){
                                        $sql_atend = "SELECT usu_id, usu_nome FROM usuario WHERE usu_cargo = 2 OR usu_cargo = 1 ORDER BY usu_nome";
                                        $atendentes = mysqli_query($conexao, $sql_atend);  ?>
                                        <li class="list-group-item">
                                        <a class="nome"><i class="fa fa-user"></i></a>
                                        <select id="select_atd" name="atd" class="nome">
                                          <?php while($atend = mysqli_fetch_assoc($atendentes)) { 
                                                    echo '<option class="nome float-right" value="'.$atend['usu_id'].'">'.$atend['usu_nome'].'</a></option>';
                                                }
                                            ?>                                                         
                                        </select>
                                        <button class="btn btn-secondary float-right" type="button"><i class="fa fa-plus-square"></i></button>
                                        </li>
                                <?php } else {?> 
                                        <li class="list-group-item" style="padding-top:20px" >
                                        <a class="nome"><i class="fa fa-user"></i></a>
                                        <?php
                                        $sql_n_atendendo = 'SELECT count(cham_id) AS atendendo FROM chamado_tecnico WHERE cham_status != 5 AND cham_status != 6 AND cham_atendente = '.$$_SESSION['usu_id'].';';
                                        $ctAtendendo = mysqli_fetch_assoc(mysqli_query($conexao, $sql_n_atendendo));
                                        $cham_atendendo  = $ctAtendendo['atendendo'];
                                        echo '<a class="nome mt-5 ml-3" href="usuario.php?view='.$_SESSION['usu_id'].'">'.$_SESSION['usu_nome'].'</a>';
                                        echo '<a href="chamados.php?tec=asc&st2=1&st3=1&st4=1&atd='.$_SESSION['usu_id'].'"><span class="count bg_info" style="margin-top:6px">'.$cham_atendendo.'</span></a>'; ?>
                                        </li>
                                <?php }?>      
                            </ul>

                    </div>
                    <!--fim do card atendente-->
                </div>
            </div>
            <!-- FIM CARDS CHAMADO VIEW -->
        </section>
        </form>
    </aside>
<?php } 
/* 
 *
 *
 *
 *
 *
 */?>
</div>
</div>
<!--editavel-->

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

    $('select.select_status').change(function () {
        $(this).css('background-color', $(this).find('option:selected').css('background-color'));
        }).change();

    function normaliza_cor(){
    	var select = document.getElementById("select_st");
		var status = select.options[select.selectedIndex].value;
    	//var status = document.getElementById("select_st").selected.value;
        if(status == 1){document.getElementById("select_st").style.backgroundColor = "#ffc107";}
        if(status == 2){document.getElementById("select_st").style.backgroundColor = "#868e96";}
        if(status == 3){document.getElementById("select_st").style.backgroundColor = "#17a2b8";}
        if(status == 4){document.getElementById("select_st").style.backgroundColor = "#007bff";}
        if(status == 5){document.getElementById("select_st").style.backgroundColor = "#28a745";}
        if(status == 6){document.getElementById("select_st").style.backgroundColor = "#dc3545";}  
    }

    
    
    function change_tecnico() {
        var status = document.getElementById("select_st").value;
        var tecnico = document.getElementById("select_tec").value;
        if(status == 1){
            document.getElementById("select_tec").selectedIndex = "0";
            document.getElementById("select_st").style.backgroundColor = "#ffc107";
        }
        if(status == 2){
            document.getElementById("select_st").style.backgroundColor = "#868e96";
        }
        if(status == 3){
            document.getElementById("select_st").style.backgroundColor = "#17a2b8";
        }
        if(status == 4){
            document.getElementById("select_st").style.backgroundColor = "#007bff";
        }
        if(status == 5){
            document.getElementById("select_st").style.backgroundColor = "#28a745";
        }
        if(status == 6){
            document.getElementById("select_st").style.backgroundColor = "#dc3545";
        }        
        if(status != 1 && tecnico == 0){
            document.getElementById("select_tec").selectedIndex = "1";
        }
    }  

    function change_status() {
        var tecnico = document.getElementById("select_tec").value;
        var status = document.getElementById("select_st").value;
        if(tecnico == 0){
            document.getElementById("select_st").selectedIndex = "0";
            document.getElementById("select_st").style.backgroundColor = "#ffc107";
        }
        if(tecnico != 0 && status==1){
            document.getElementById("select_st").selectedIndex = "1";
            document.getElementById("select_st").style.backgroundColor = "#868e96";
        }
    }   

    /*    	
    var e = document.getElementById("select_st");
	var opcao = e.options[e.selectedIndex].style.getPropertyValue('background-color');
	document.getElementById('select_st').style.backgroundColor = opcao;
	*/


</script>

<script type="text/javascript">
	window.onload = normaliza_cor;
    $('#exemplo').datepicker({  
        format: "dd/mm/yyyy",   
        language: "pt-BR",
        startDate: '+0d',
        maxViewMode: 1,
        todayBtn: "linked",
        daysOfWeekHighlighted: "0",
        todayHighlight: true
    });
</script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.0/jquery.mask.js"></script>

<!--script src="assets/js/lib/chosen/chosen.jquery.min.js"></script-->

<!--
SELECT cham_id, cham_cliente, cham_descricao, cham_observacao, cham_descricao_final, cham_status, cham_atendente, cham_tecnico, cham_servico, cham_quantidade, cham_valor_total, cham_agendado, cham_iniciado, cham_finalizado, cham_foto1, cham_foto2, cham_assinatura, cli_nome, cli_cpf, cli_rg, cli_celular, cli_telefone, cli_email, cli_endereco, cli_classificacao, est_nome, usu_nome, usu_celular, usu_email, usu_cargo, usu_foto, usu_telefone, usu_whatsapp, usu_chamado_in, usu_latitude, usu_longitude, usu_facebook, usu_linkedin, usu_twitter, serv_nome, serv_descricao, serv_valor, serv_tempo_estimado, serv_tipo, end_logradouro, end_numero, end_complemento, end_bairro, end_cidade, end_cep, end_estado, end_latitude, end_longitude, cargo_nome FROM chamado_tecnico , cliente, estatus, chamado, servico, endereco, cargo WHERE chamado_tecnico.cham_cliente = cliente.cli_id AND chamado_tecnico.cham_status = estatus.est_id AND chamado_tecnico.cham_atendente = chamado.usu_id AND chamado_tecnico.cham_servico = servico.serv_id AND chamado.usu_cargo = cargo.cargo_id AND cliente.cli_endereco = endereco.end_id;


CREATE OR REPLACE VIEW chamados_web AS(
SELECTcham_id, cham_cliente, cham_descricao, cham_observacao, cham_descricao_final, cham_status, cham_atendente, cham_tecnico, cham_servico, cham_quantidade, cham_valor_total, cham_agendado, cham_iniciado, cham_finalizado, cham_foto1, cham_foto2, cham_assinatura, cli_id, cli_nome, cli_cpf, cli_rg, cli_celular, cli_whatsapp, cli_telefone, cli_email, cli_endereco, cli_classificacao, est_id, est_nome, usu_nome, usu_id, usu_celular, usu_email, usu_cargo, usu_foto, usu_telefone, usu_whatsapp, usu_chamado_in, usu_latitude, usu_longitude, usu_facebook, usu_linkedin, usu_twitter, serv_id, serv_nome, serv_descricao, serv_valor, serv_tempo_estimado, serv_tipo, end_id, end_logradouro, end_numero, end_complemento, end_bairro, end_cidade, end_cep, end_estado, end_latitude, end_longitude, cargo_id, cargo_nome FROM  chamado_tecnico,  cliente,  estatus,  usuario,  servico,  endereco,  cargo 
WHERE chamado_tecnico.cham_cliente = cliente.cli_id AND chamado_tecnico.cham_status = estatus.est_id AND chamado_tecnico.cham_atendente = usuario.usu_id AND chamado_tecnico.cham_servico = servico.serv_id AND usuario.usu_cargo = cargo.cargo_id AND cliente.cli_endereco = endereco.end_id;);

CREATE VIEW chamados_data_hora AS (SELECT c.cham_id, 
DATE_FORMAT(c.cham_aberto, '%d/%m/%Y') AS data_aberto, DATE_FORMAT(c.cham_aberto, '%H:%i') AS hora_aberto,
DATE_FORMAT(c.cham_agendado, '%d/%m/%Y') AS data_agendado, DATE_FORMAT(c.cham_agendado, '%H:%i') AS hora_agendado,
DATE_FORMAT(c.cham_caminho, '%d/%m/%Y') AS data_caminho, DATE_FORMAT(c.cham_caminho, '%H:%i') AS hora_caminho,
DATE_FORMAT(c.cham_iniciado, '%d/%m/%Y') AS data_iniciado, DATE_FORMAT(c.cham_iniciado, '%H:%i') AS hora_iniciado,
DATE_FORMAT(c.cham_finalizado, '%d/%m/%Y') AS data_finalizado, DATE_FORMAT(c.cham_finalizado, '%H:%i') AS hora_finalizado
FROM chamado_tecnico AS c); 
-->

<?php require_once('after_content.php'); ?>