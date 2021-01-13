<?php require_once('before_content.php'); ?>

<link rel="stylesheet" href="assets/scss/socials.css">
<style type="text/css">
    .list-group-item a {
        margin: 2px;
    }
    .list-group-item a:hover {
        color: #cccccc;
    }
</style>

<?php 
//inici das consultas no bancoe atribuições
    $sql_user = "SELECT usu.usu_nome, car.cargo_id, car.cargo_nome, ende.end_cidade, ende.end_estado, 
                        usu.usu_telefone, usu.usu_celular, usu.usu_whatsapp, usu.usu_email, usu.usu_facebook, 
                        usu.usu_twitter, usu.usu_linkedin, usu.usu_latitude, usu.usu_longitude,  usu.usu_foto
                FROM usuario AS usu, cargo AS car, endereco AS ende 
                WHERE usu.usu_cargo = car.cargo_id AND usu.usu_endereco = ende.end_id AND usu.usu_id = " .$_SESSION['usu_id'] . ";";

    $usuario = mysqli_fetch_assoc(mysqli_query($conexao, $sql_user));

    $class_cargo = "badge-success";
    if ($usuario['cargo_id'] == 1) //1 - administrador - lable amarelo
        $class_cargo = "badge-warning";
    if ($usuario['cargo_id'] == 2) //2 - atendente - lable azul claro
        $class_cargo = "badge-info";
    if ($usuario['cargo_id'] ==3 ) //3 - tecnico - lable branco
        $class_cargo = "badge-light";
//fim das consultas no bancoe atribuições

    $erro = 0; $ok = 0;
    if($_SERVER['REQUEST_METHOD'] == "GET") {
        if(isset($_GET['erro'])){
            $erro = $_GET['erro'];
        }
        if(isset($_GET['ok'])){
            $ok = $_GET['ok'];
        }
    }
    $msg_erro_1 = "A imagem não pode ser inserida/alterada, tente novamente!";
    $msg_ok_1 = "A imagem foi inserida/alterada com sucesso!"
?> 

<div class="row">
    <div class="col-md-6 offset-md-3 mr-auto ml-auto">
        <?php
            if($erro!=0){
              echo'<script>$( "#result" ).load( "ajax/test.html" );</script>';
                if($erro == 1){
                    echo '<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">'.$msg_erro_1;
                    echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>';}
            }
            if($ok!=0){
                if($ok == 1){ 
                    echo '<div class="sufee-alert alert with-close alert-success alert-dismissible fade show">';
                    echo '<span class="badge badge-pill badge-success">Sucesso</span>&nbsp;'.$msg_ok_1;
                    echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>';}
            } //msgs delete 
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
                            <?php echo '<h2 class="text-light display-6 mt-2">' . $usuario['usu_nome'] . '</h2>'; ?> 
                            <i class="text-light fa fa-pencil pull-right"></i>
                            <?php echo '<h5><span class="badge ' . $class_cargo . ' pull-left mt-2">' . $usuario['cargo_nome'] . '</span><h5>'; ?>
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
                        <a href="#"> <i class="fa fa-envelope-o" style="width: 30px"></i><strong> Email: </strong>
                        <?php echo $usuario['usu_email'] . ' </span></a>'; ?>
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
                                <a href="#"> <i class="fa fa-tasks" style="width: 30px"></i><strong> Chamados Técnicos Concluidos </strong><span class="badge badge-success pull-right">154</span></a>
                            </li>
                            <li class="list-group-item">
                                <a href="#"> <i class="fa fa-calendar-times-o" style="width: 30px"></i><strong> Chamados Técnicos Cancelados </strong><span class="badge badge-danger pull-right">3</span></a>
                            </li>
                            <li class="list-group-item">
                                <a href="#"> <i class="fa fa-clock-o" style="width: 30px"></i><strong> Chamados Técnicos em Espera </strong><span class="badge badge-warning pull-right r-activity">3</span></a>
                            </li>
                            <li class="list-group-item">
                                <a href="#"><i class="fa fa-location-arrow" style="width: 30px"></i><strong>Localização</strong>
                                <span class="badge badge-pill badge-secondary ml-3">Lat</span> 
                                <?php if ($usuario['usu_latitude']){ echo $usuario['usu_latitude']; } else { echo 'indisponível'; } ?> 
                                <span class="badge badge-pill badge-secondary ml-2">Lng</span> 
                                <?php if ($usuario['usu_longitude']){ echo $usuario['usu_longitude']; } else { echo 'indisponível'; } ?></a>
                            </li>
                    <?php }     ?> <!-- fim da condição se usuario for tecnico -->

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
                        ?>
                    </li>
                </ul>
                <!-- FIM INFORMAÇÕES PERFIL -->

            </section>
        </aside>
    </div>

<?php require_once('after_content.php'); ?>