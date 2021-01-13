<?php 
session_start();
require_once('dao/conexao.php');
if($_SESSION['usu_cargo'] != 1){
	header('Refresh: 0; url=../config.php?erro');
}

$a_cham = "" ; $a_usu = "" ; $a_cli = "" ; $a_serv = "" ; $a_link = "" ;
$t_cham = "" ; $t_usu = "" ; $t_cli = "" ; $t_serv = "" ; $t_link = "" ;
$a_cham_view = 0; $a_cham_edit = 0; $a_cham_new = 0; $a_cham_del = 0; 
$a_usu_view  = 0; $a_usu_edit  = 0; $a_usu_new  = 0; $a_usu_del  = 0; 
$a_cli_view  = 0; $a_cli_edit  = 0; $a_cli_new  = 0; $a_cli_del  = 0; 
$a_serv_view = 0; $a_serv_edit = 0; $a_serv_new = 0; $a_serv_del = 0; 
$a_link_view = 0; $a_link_edit = 0; $a_link_new = 0; $a_link_del = 0; 
$t_cham_view = 0; $t_cham_edit = 0; $t_cham_new = 0; $t_cham_del = 0; 
$t_usu_view  = 0; $t_usu_edit  = 0; $t_usu_new  = 0; $t_usu_del  = 0; 
$t_cli_view  = 0; $t_cli_edit  = 0; $t_cli_new  = 0; $t_cli_del  = 0; 
$t_serv_view = 0; $t_serv_edit = 0; $t_serv_new = 0; $t_serv_del = 0; 
$t_link_view = 0; $t_link_edit = 0; $t_link_new = 0; $t_link_del = 0; 

if(isset($_POST['a_cham_view'])) { $a_cham_view = $_POST['a_cham_view']; } 
if(isset($_POST['a_cham_edit'])) { $a_cham_edit = $_POST['a_cham_edit']; } 
if(isset($_POST['a_cham_new']))  { $a_cham_new 	= $_POST['a_cham_new'];  } 
if(isset($_POST['a_cham_del']))  { $a_cham_del 	= $_POST['a_cham_del'];  } 
if(isset($_POST['a_usu_view']))  { $a_usu_view 	= $_POST['a_usu_view'];  } 
if(isset($_POST['a_usu_edit']))  { $a_usu_edit 	= $_POST['a_usu_edit'];  } 
if(isset($_POST['a_usu_new']))   { $a_usu_new 	= $_POST['a_usu_new'];   } 
if(isset($_POST['a_usu_del']))   { $a_usu_del 	= $_POST['a_usu_del'];   } 
if(isset($_POST['a_cli_view']))  { $a_cli_view 	= $_POST['a_cli_view'];  } 
if(isset($_POST['a_cli_edit']))  { $a_cli_edit 	= $_POST['a_cli_edit'];  } 
if(isset($_POST['a_cli_new']))   { $a_cli_new 	= $_POST['a_cli_new'];   } 
if(isset($_POST['a_cli_del']))   { $a_cli_del 	= $_POST['a_cli_del'];   } 
if(isset($_POST['a_serv_view'])) { $a_serv_view = $_POST['a_serv_view']; } 
if(isset($_POST['a_serv_edit'])) { $a_serv_edit = $_POST['a_serv_edit']; } 
if(isset($_POST['a_serv_new']))  { $a_serv_new 	= $_POST['a_serv_new'];  } 
if(isset($_POST['a_serv_del']))  { $a_serv_del 	= $_POST['a_serv_del'];  } 
if(isset($_POST['a_link_view'])) { $a_link_view = $_POST['a_link_view']; } 
if(isset($_POST['a_link_edit'])) { $a_link_edit = $_POST['a_link_edit']; } 
if(isset($_POST['a_link_new']))  { $a_link_new 	= $_POST['a_link_new'];  } 
if(isset($_POST['a_link_del']))  { $a_link_del 	= $_POST['a_link_del'];  } 
if(isset($_POST['t_cham_view'])) { $t_cham_view = $_POST['t_cham_view']; } 
if(isset($_POST['t_cham_edit'])) { $t_cham_edit = $_POST['t_cham_edit']; } 
if(isset($_POST['t_cham_new']))  { $t_cham_new 	= $_POST['t_cham_new'];  } 
if(isset($_POST['t_cham_del']))  { $t_cham_del 	= $_POST['t_cham_del'];  } 
if(isset($_POST['t_usu_view']))  { $t_usu_view 	= $_POST['t_usu_view'];  } 
if(isset($_POST['t_usu_edit']))  { $t_usu_edit 	= $_POST['t_usu_edit'];  } 
if(isset($_POST['t_usu_new']))   { $t_usu_new 	= $_POST['t_usu_new'];   } 
if(isset($_POST['t_usu_del']))   { $t_usu_del 	= $_POST['t_usu_del'];   } 
if(isset($_POST['t_cli_view']))	 { $t_cli_view 	= $_POST['t_cli_view'];  } 
if(isset($_POST['t_cli_edit']))	 { $t_cli_edit 	= $_POST['t_cli_edit'];  } 
if(isset($_POST['t_cli_new']))   { $t_cli_new 	= $_POST['t_cli_new'];   } 
if(isset($_POST['t_cli_del']))   { $t_cli_del 	= $_POST['t_cli_del'];   } 
if(isset($_POST['t_serv_view'])) { $t_serv_view = $_POST['t_serv_view']; } 
if(isset($_POST['t_serv_edit'])) { $t_serv_edit = $_POST['t_serv_edit']; } 
if(isset($_POST['t_serv_new']))  { $t_serv_new 	= $_POST['t_serv_new'];  } 
if(isset($_POST['t_serv_del']))  { $t_serv_del 	= $_POST['t_serv_del'];  } 
if(isset($_POST['t_link_view'])) { $t_link_view = $_POST['t_link_view']; } 
if(isset($_POST['t_link_edit'])) { $t_link_edit = $_POST['t_link_edit']; } 
if(isset($_POST['t_link_new']))  { $t_link_new 	= $_POST['t_link_new'];  } 
if(isset($_POST['t_link_del']))  { $t_link_del	= $_POST['t_link_del'];  } 

$a_cham_view === 'on' ? $a_cham_view = 1 : $a_cham_view = 0 ;
$a_cham_edit === 'on' ? $a_cham_edit = 1 : $a_cham_edit = 0 ;
$a_cham_new  === 'on' ? $a_cham_new  = 1 : $a_cham_new  = 0 ;
$a_cham_del  === 'on' ? $a_cham_del  = 1 : $a_cham_del  = 0 ;
$a_usu_view  === 'on' ? $a_usu_view  = 1 : $a_usu_view  = 0 ;
$a_usu_edit  === 'on' ? $a_usu_edit  = 1 : $a_usu_edit  = 0 ;
$a_usu_new   === 'on' ? $a_usu_new   = 1 : $a_usu_new   = 0 ;
$a_usu_del   === 'on' ? $a_usu_del   = 1 : $a_usu_del   = 0 ;
$a_cli_view  === 'on' ? $a_cli_view  = 1 : $a_cli_view  = 0 ;
$a_cli_edit  === 'on' ? $a_cli_edit  = 1 : $a_cli_edit  = 0 ;
$a_cli_new   === 'on' ? $a_cli_new   = 1 : $a_cli_new   = 0 ;
$a_cli_del   === 'on' ? $a_cli_del   = 1 : $a_cli_del   = 0 ;
$a_serv_view === 'on' ? $a_serv_view = 1 : $a_serv_view = 0 ;
$a_serv_edit === 'on' ? $a_serv_edit = 1 : $a_serv_edit = 0 ;
$a_serv_new  === 'on' ? $a_serv_new  = 1 : $a_serv_new  = 0 ;
$a_serv_del  === 'on' ? $a_serv_del  = 1 : $a_serv_del  = 0 ;
$a_link_view === 'on' ? $a_link_view = 1 : $a_link_view = 0 ;
$a_link_edit === 'on' ? $a_link_edit = 1 : $a_link_edit = 0 ;
$a_link_new  === 'on' ? $a_link_new  = 1 : $a_link_new  = 0 ;
$a_link_del  === 'on' ? $a_link_del  = 1 : $a_link_del  = 0 ;
$t_cham_view === 'on' ? $t_cham_view = 1 : $t_cham_view = 0 ;
$t_cham_edit === 'on' ? $t_cham_edit = 1 : $t_cham_edit = 0 ;
$t_cham_new  === 'on' ? $t_cham_new  = 1 : $t_cham_new  = 0 ;
$t_cham_del  === 'on' ? $t_cham_del  = 1 : $t_cham_del  = 0 ;
$t_usu_view  === 'on' ? $t_usu_view  = 1 : $t_usu_view  = 0 ;
$t_usu_edit  === 'on' ? $t_usu_edit  = 1 : $t_usu_edit  = 0 ;
$t_usu_new   === 'on' ? $t_usu_new   = 1 : $t_usu_new   = 0 ;
$t_usu_del   === 'on' ? $t_usu_del   = 1 : $t_usu_del   = 0 ;
$t_cli_view  === 'on' ? $t_cli_view  = 1 : $t_cli_view  = 0 ;
$t_cli_edit  === 'on' ? $t_cli_edit  = 1 : $t_cli_edit  = 0 ;
$t_cli_new   === 'on' ? $t_cli_new   = 1 : $t_cli_new   = 0 ;
$t_cli_del   === 'on' ? $t_cli_del   = 1 : $t_cli_del   = 0 ;
$t_serv_view === 'on' ? $t_serv_view = 1 : $t_serv_view = 0 ;
$t_serv_edit === 'on' ? $t_serv_edit = 1 : $t_serv_edit = 0 ;
$t_serv_new  === 'on' ? $t_serv_new  = 1 : $t_serv_new  = 0 ;
$t_serv_del  === 'on' ? $t_serv_del  = 1 : $t_serv_del  = 0 ;
$t_link_view === 'on' ? $t_link_view = 1 : $t_link_view = 0 ;
$t_link_edit === 'on' ? $t_link_edit = 1 : $t_link_edit = 0 ;
$t_link_new  === 'on' ? $t_link_new  = 1 : $t_link_new  = 0 ;
$t_link_del  === 'on' ? $t_link_del  = 1 : $t_link_del  = 0 ;

$a_cham = $a_cham_view . $a_cham_edit . $a_cham_new . $a_cham_del;
$a_usu  = $a_usu_view  . $a_usu_edit  . $a_usu_new  . $a_usu_del;
$a_cli  = $a_cli_view  . $a_cli_edit  . $a_cli_new  . $a_cli_del;
$a_serv = $a_serv_view . $a_serv_edit . $a_serv_new . $a_serv_del;
$a_link = $a_link_view . $a_link_edit . $a_link_new . $a_link_del;
$t_cham = $t_cham_view . $t_cham_edit . $t_cham_new . $t_cham_del;
$t_usu  = $t_usu_view  . $t_usu_edit  . $t_usu_new  . $t_usu_del;
$t_cli  = $t_cli_view  . $t_cli_edit  . $t_cli_new  . $t_cli_del;
$t_serv = $t_serv_view . $t_serv_edit . $t_serv_new . $t_serv_del;
$t_link = $t_link_view . $t_link_edit . $t_link_new . $t_link_del;

$sql_atend = "UPDATE permissoes SET p_cham = '".$a_cham."', p_usu = '".$a_usu."', p_cli = '".$a_cli."', p_serv = '".$a_serv."', p_link = '".$a_link."' WHERE p_id = 2;" ; 
$sql_tec   = "UPDATE permissoes SET p_cham = '".$t_cham."', p_usu = '".$t_usu."', p_cli = '".$t_cli."', p_serv = '".$t_serv."', p_link = '".$t_link."' WHERE p_id = 3;" ; 

$result_atend = mysqli_query($conexao, $sql_atend);
$result_tec   = mysqli_query($conexao, $sql_tec);

#die("ERRO<br>sql_atend: " . $sql_atend . "<br>sql_tec: " . $sql_tec); #for debug

if(!$result_tec || !$result_atend){
   	header('Refresh: 0; url=../config.php?erro');
} else {
	header('Refresh: 0; url=../config.php?ok');
}


?>
