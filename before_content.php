<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Gestão de Chamados</title>
    <meta name="description" content="Gestão de Chamados">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="apple-icon.png">
    <link rel="shortcut icon" href="favicon.ico">

    <link rel="stylesheet" href="assets/css/normalize.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/flag-icon.min.css">
    <link rel="stylesheet" href="assets/css/cs-skin-elastic.css">
    <!-- <link rel="stylesheet" href="assets/css/bootstrap-select.less"> -->
    <link rel="stylesheet" href="assets/scss/style.css">
    <link href="https://fonts.googleapis.com/css?family=Pacifico" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.css">
    <!--link rel="stylesheet" href="http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css"-->
	<script src="http://code.jquery.com/jquery-1.8.3.js"></script>


<style type="text/css">
	.separador{
		width: 100%;
		height: 0;
		border-bottom: 1px solid #8b939b;
		margin: 10px 0;
	}
	#menuToggle{
		background-color: #20a8d8 !important;
	}
	.logo{
		font-size: 28px !important;
     	border-bottom: 1px solid #8b939b !important;
     	padding: 15px 0 !important;
	}
	@media (max-width: 575.99px){
		aside.left-panel .navbar .navbar-header {
    		height: 70px !important;
		}
		.logo{
			border-bottom: 0px !important;
		}
		aside.left-panel .navbar .navbar-toggler{
			margin-top: 20px !important;
			color: #ffffff;
		}
	}
</style>
    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/html5shiv/3.7.3/html5shiv.min.js"></script> -->

<?php  // verificação de sessão e login via post
    
    include_once('controller/dao/conexao.php'); 
    include_once('controller/browser-info.php'); 

    session_start();
    $error = "";

    if($_SERVER['REQUEST_METHOD'] == "POST") {
        if(isset($_POST['email']) && isset($_POST['password'])){
            $email     = $_POST['email'];
            $salt = "U9ynSTe82m";
            $password  = md5($salt.$_POST['password']);

            $sqlq = "SELECT usu_login, usu_nome, usu_id, usu_empresa, usu_cargo, usu_foto FROM usuario WHERE usu_senha='$password' AND usu_email='$email'";
            $query = mysqli_query($conexao, $sqlq);
            $rows = mysqli_num_rows($query);
            if ($rows == 1) {
                while ($row = mysqli_fetch_array($query)) {
                    $_SESSION['usu_login'] = $row['usu_login']; // Initializing Session
                    $_SESSION['usu_id'] = $row['usu_id'];
                    $_SESSION['usu_nome'] = $row['usu_nome'];
                    $_SESSION['usu_empresa'] = $row['usu_empresa'];
                    $_SESSION['usu_cargo'] = $row['usu_cargo'];
                    $_SESSION['usu_foto'] = $row['usu_foto'];
                    logMsg($_SESSION['usu_login'] . " Logou no sistema", 'login');
                    logMsg($browserinfo);
                }
            } else {
                logMsg( "Credencial errada" . $_POST['email'] . " | " . $_POST['senha'] . " ERRO 2", 'warning' );
                session_destroy();
                header("location: login.php?erro=2"); //credencial invalida
            }
        } else {
            logMsg( "Credencial inválida" . $_POST['email'] . " | " . $_POST['senha'] . " ERRO 1", 'warning' );
            session_destroy();
            header("location: login.php?erro=1"); //campo vazio
        }
    } else {
        if(!isset($_SESSION['usu_login'])){ 
            session_destroy();
            header("location: login.php"); //sessão inválida ou expirou
        }
    }

    $class_cargo = "badge-success";
    if ($_SESSION['usu_cargo'] == 1) //1 - administrador - lable amarelo
        $class_cargo_sessao = "badge-warning";
    if ($_SESSION['usu_cargo'] == 2) //2 - atendente - lable azul claro
        $class_cargo_sessao = "badge-info";
    if ($_SESSION['usu_cargo'] == 3 ) //3 - tecnico - lable branco
        $class_cargo_sessao = "badge-light";


    function logMsg( $msg, $level = 'info', $file = 'main.log' )
    {
        $levelStr = '';
        switch ( $level )
        {
            case 'login':
                $levelStr = 'LOGIN';
                break;
            case 'info':
                $levelStr = 'INFO';
                break;
            case 'warning':
                $levelStr = 'WARNING';
                break;
            case 'error':
                $levelStr = 'ERROR';
                break;
        }
        $date = date( 'd-m-Y H:i:s' );
        $msg = sprintf( "[%s] [%s]: %s%s", $levelStr, $date, $msg, PHP_EOL );
        file_put_contents( $file, $msg, FILE_APPEND );
    }

        $sql_atend = "SELECT * FROM permissoes WHERE p_id = 2";
        $atend = mysqli_query($conexao, $sql_atend);
        $p_atend = mysqli_fetch_assoc($atend);
        $a_cham = $p_atend['p_cham'];
        if($a_cham == 0){$a_cham = '0000';}
        if($a_cham[0] == 1){ $a_cham_view = 'checked';} else {$a_cham_view = '';}
        if($a_cham[1] == 1){ $a_cham_edit = 'checked';} else {$a_cham_edit = '';}
        if($a_cham[2] == 1){ $a_cham_new = 'checked'; } else {$a_cham_new = '' ;}
        if($a_cham[3] == 1){ $a_cham_del = 'checked'; } else {$a_cham_del = '' ;}
        $a_usu = $p_atend['p_usu'];
        if($a_usu == 0){$a_usu = '0000';}
        if($a_usu[0] == 1){ $a_usu_view = 'checked';} else {$a_usu_view = '';}
        if($a_usu[1] == 1){ $a_usu_edit = 'checked';} else {$a_usu_edit = '';}
        if($a_usu[2] == 1){ $a_usu_new = 'checked'; } else {$a_usu_new = '' ;}
        if($a_usu[3] == 1){ $a_usu_del = 'checked'; } else {$a_usu_del = '' ;}
        $a_cli = $p_atend['p_cli'];
        if($a_cli == 0){$a_cli = '0000';}
        if($a_cli[0] == 1){ $a_cli_view = 'checked';} else {$a_cli_view = '';}
        if($a_cli[1] == 1){ $a_cli_edit = 'checked';} else {$a_cli_edit = '';}
        if($a_cli[2] == 1){ $a_cli_new = 'checked'; } else {$a_cli_new = '' ;}
        if($a_cli[3] == 1){ $a_cli_del = 'checked'; } else {$a_cli_del = '' ;}
        $a_serv = $p_atend['p_serv'];
        if($a_serv == 0){$a_serv = '0000';}
        if($a_serv[0] == 1){ $a_serv_view = 'checked';} else {$a_serv_view = '';}
        if($a_serv[1] == 1){ $a_serv_edit = 'checked';} else {$a_serv_edit = '';}
        if($a_serv[2] == 1){ $a_serv_new = 'checked'; } else {$a_serv_new = '' ;}
        if($a_serv[3] == 1){ $a_serv_del = 'checked'; } else {$a_serv_del = '' ;}
        $a_link = $p_atend['p_link'];
        if($a_link == 0){$a_link = '0000';}
        if($a_link[0] == 1){ $a_link_view = 'checked';} else {$a_link_view = '';}
        if($a_link[1] == 1){ $a_link_edit = 'checked';} else {$a_link_edit = '';}
        if($a_link[2] == 1){ $a_link_new = 'checked'; } else {$a_link_new = '' ;}
        if($a_link[3] == 1){ $a_link_del = 'checked'; } else {$a_link_del = '' ;}

        $sql_tec = "SELECT * FROM permissoes WHERE p_id = 3";
        $tec = mysqli_query($conexao, $sql_tec);
        $p_tec = mysqli_fetch_assoc($tec);
        $t_cham = $p_tec['p_cham'];
        if($t_cham == 0){$t_cham = '0000';}
        if($t_cham[0] == 1){ $t_cham_view = 'checked';} else {$t_cham_view = '';}
        if($t_cham[1] == 1){ $t_cham_edit = 'checked';} else {$t_cham_edit = '';}
        if($t_cham[2] == 1){ $t_cham_new = 'checked'; } else {$t_cham_new = ''; }
        if($t_cham[3] == 1){ $t_cham_del = 'checked'; } else {$t_cham_del = ''; }
        $t_usu = $p_tec['p_usu'];
        if($t_cham == 0){$t_cham = '0000';}
        if($t_usu[0] == 1){ $t_usu_view = 'checked';} else {$t_usu_view = '';}
        if($t_usu[1] == 1){ $t_usu_edit = 'checked';} else {$t_usu_edit = '';}
        if($t_usu[2] == 1){ $t_usu_new = 'checked'; } else {$t_usu_new = '' ;}
        if($t_usu[3] == 1){ $t_usu_del = 'checked'; } else {$t_usu_del = '' ;}
        $t_cli = $p_tec['p_cli'];
        if($t_cham == 0){$t_cham = '0000';}
        if($t_cli[0] == 1){ $t_cli_view = 'checked';} else {$t_cli_view = '';}
        if($t_cli[1] == 1){ $t_cli_edit = 'checked';} else {$t_cli_edit = '';}
        if($t_cli[2] == 1){ $t_cli_new = 'checked'; } else {$t_cli_new = '' ;}
        if($t_cli[3] == 1){ $t_cli_del = 'checked'; } else {$t_cli_del = '' ;}
        $t_serv = $p_tec['p_serv'];
        if($t_cham == 0){$t_cham = '0000';}
        if($t_serv[0] == 1){ $t_serv_view = 'checked';} else {$t_serv_view = '';}
        if($t_serv[1] == 1){ $t_serv_edit = 'checked';} else {$t_serv_edit = '';}
        if($t_serv[2] == 1){ $t_serv_new = 'checked'; } else {$t_serv_new = '' ;}
        if($t_serv[3] == 1){ $t_serv_del = 'checked'; } else {$t_serv_del = '' ;}
        $t_link = $p_tec['p_link'];
        if($t_cham == 0){$t_cham = '0000';}
        if($t_link[0] == 1){ $t_link_view = 'checked';} else {$t_link_view = '';}
        if($t_link[1] == 1){ $t_link_edit = 'checked';} else {$t_link_edit = '';}
        if($t_link[2] == 1){ $t_link_new = 'checked'; } else {$t_link_new = '' ;}
        if($t_link[3] == 1){ $t_link_del = 'checked'; } else {$t_link_del = '' ;}

        if($_SESSION['usu_cargo'] == 1){ $adm = true; $atend = false; $tec = false; } 
        if($_SESSION['usu_cargo'] == 2){ $adm = false; $atend = true; $tec = false; }
        if($_SESSION['usu_cargo'] == 3){ $adm = false; $atend = false; $tec = true; }
?>

</head>
<body>
    <!-- Left Panel -->
    <aside id="left-panel" class="left-panel">
        <nav class="navbar navbar-expand-sm navbar-default" style="background-color: #004671; border: 0;">

            <div class="navbar-header">
                <button id="bolinha" class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-bars"></i>
                </button> <!-- TODO ALTERAR LOGOS  -->
                <a class="logo navbar-brand" href="./">Gestão Chamados<!--img src="images/logo.png" alt="Logo"--></a>
                <!--<a class="navbar-brand hidden" href="./">--><!--img src="images/logo2.png" alt="Logo"--></a>
            </div>

            <div id="main-menu" class="main-menu collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="active"><br><a href="index.php"><i class="menu-icon ti-home"></i> Painel Administrativo</a></li>
                    <!--<br><h1 class="menu-title"></h1><br>--><!--SEPARADOR-->
                    <div class="separador"></div>
                    <?php 
                    if ($adm){ echo '<li><a href="chamados.php"><i class="menu-icon ti-notepad"></i> Chamados</a></li>'; }
                    if ($atend){ if($a_cham_view === 'checked'){ echo '<li><a href="chamados.php"><i class="menu-icon ti-notepad"></i> Chamados</a></li>'; } }
                    if ($tec){ if($t_cham_view === 'checked'){ echo '<li><a href="chamados.php"><i class="menu-icon ti-notepad"></i> Chamados</a></li>'; } }
                    echo '<li><a href="agenda.php"><i class="menu-icon fa fa-calendar"></i> Agenda</a></li>';
                    echo '<li><a href="mapa.php"><i class="menu-icon ti-map-alt"> </i> Mapa</a></li>';
                    echo '<div class="separador"></div>';
                    if ($adm){ echo '<li><a href="clientes.php"><i class="menu-icon ti-user"></i> Clientes</a></li>'; } 
                    if ($atend){ if($a_cli_view === 'checked'){ echo '<li><a href="clientes.php"><i class="menu-icon ti-user"></i> Clientes</a></li>'; } }
                    if ($tec){ if($t_cli_view === 'checked'){ echo '<li><a href="clientes.php"><i class="menu-icon ti-user"></i> Clientes</a></li>'; } }
                    if ($adm){ echo '<li><a href="servicos.php"><i class="menu-icon fa fa-wrench"></i> Serviços</a></li>'; } 
                    if ($atend){ if($a_serv_view === 'checked'){ echo '<li><a href="servicos.php"><i class="menu-icon fa fa-wrench"></i> Serviços</a></li>'; } }
                    if ($tec){ if($t_serv_view === 'checked'){ echo '<li><a href="servicos.php"><i class="menu-icon fa fa-wrench"></i> Serviços</a></li>'; } }
                    if ($adm){ echo '<li><a href="usuarios.php"><i class="menu-icon ti-id-badge"></i> Usuários</a></li>'; } 
                    if ($atend){ if($a_usu_view === 'checked'){ echo '<li><a href="usuarios.php"><i class="menu-icon ti-id-badge"></i> Usuários</a></li>'; } }
                    if ($tec){ if($t_usu_view === 'checked'){ echo '<li><a href="usuarios.php"><i class="menu-icon ti-id-badge"></i> Usuários</a></li>'; } }
                    if ($adm){
                        echo '<div class="separador"></div>'; 
                        echo '<li><a href="links.php?token=' . substr (microtime(), -4) . '"><i class="menu-icon fa fa-code"></i>Links úteis </a></li>'; } 
                    if ($atend){ if($a_link_view === 'checked'){ 
                        echo '<div class="separador"></div>';
                        echo '<li><a href="links.php?token=' . substr (microtime(), -4) . '"><i class="menu-icon fa fa-code"></i>Links úteis </a></li>'; } }
                    if ($tec){ if($t_link_view === 'checked'){ 
                        echo '<div class="separador"></div>';
                        echo '<li><a href="links.php?token=' . substr (microtime(), -4) . '"><i class="menu-icon fa fa-code"></i>Links úteis </a></li>'; } }
                    if($adm){ echo '<li><a href="config.php"><i class="menu-icon fa fa-cogs"></i> Configurações</a></li>'; } 
                    ?>
                </ul>
            </div><!-- /.navbar-collapse -->
        </nav>
    </aside><!-- /#left-panel -->
    <!-- Left Panel -->

    <!-- Right Panel -->
    <div id="right-panel" class="right-panel">
    <?  $sqlusu = "SELECT usu_id, usu_nome, usu_foto, usu_cargo FROM usuario WHERE usu_id = ". $_SESSION['usu_id'].";";
        $query = mysqli_query($conexao, $sqlusu);
        $usu = mysqli_fetch_assoc($query); ?>

        <!-- Header-->
        <header id="header" class="header" style="padding: 10px 25px 10px 35px">
            <div class="header-menu">
                <div class="" style="margin-top: 6px; ">
                    <a id="menuToggle" class="menutoggle pull-left";><i class="fa fa-tasks"></i></a>
                    <div class="header-left"></div>
                    <div class="user-area dropdown float-right">
                        <a class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php 
                            echo '<img class="user-avatar rounded-circle" src="upload/' . $usu['usu_foto'] . '" alt="User Avatar" style="height: 50px; width: 50px;">'; ?>
                        </a>
                        <div class="user-menu dropdown-menu">
                                <?php echo '<a class="nav-link" href="usuario.php?view=' . $usu['usu_id'] . '"><i class="fa fa-user"> </i>  Meu perfil</a>'; 
                                    if ($_SESSION['usu_cargo'] == 1){
                                        echo '<a class="nav-link" href="config.php"><i class="fa fa-cog"> </i>  Configurações</a>';
                                    } ?>
                                <a class="nav-link" href="controller/logout.php"><i class="fa fa-power-off"> </i>  Sair</a>
                        </div>
                    </div>
                    <?php echo '<a id="nameUser" href="usuario.php?view='.$_SESSION['usu_id'].'"><p style="padding: 15px 15px 0px 15px; float: right; cursor: pointer;">'.$usu['usu_nome'].'</p></a>'; ?>
	            </div>
            </div>
        </header><!-- /header -->
        <!-- Header-->

        <div id="conteudo" class="content mt-3"  style="margin-top: 10px;">

        <!-- CONTENT AFTER THAT TAG -->