<?php include_once "dao/conexao.php";

$conexao = mysqli_connect($servidor,$usuariobanco,$senhabanco);
$db = mysqli_select_db($conexao, $bancosrv);

if(!$db){
    header("location: ../chamado?erro=1");
    die ('Não foi possivel conectar: '.  mysqli_error($conexao));
}
$update = false; $create = false; $delete = false; $sendNotification = false;
$ano = ""; $mes = ""; $dia = ""; $hora = ""; $min = ""; $status = ""; 
$desc = ""; $obs = ""; $tec = ""; $cli = ""; $serv = ""; $id = "";

if($_SERVER['REQUEST_METHOD'] == "POST") {
    $_atd_ = "";
    if(isset($_POST['id'])){ 
        $id = $_POST['id'];
    }
    $ano =$_POST['ano'];
    $mes = $_POST['mes'];
    $dia = $_POST['dia'];
    $hora = $_POST['hora'];
    $min = $_POST['min'];
    $status = $_POST['status'];
    $desc =$_POST['desc'];
    $obs = $_POST['obs'];
    if(isset($_POST['tec'])){
        $tec = $_POST['tec'];
        $tecnico = mysqli_fetch_assoc(mysqli_query($conexao, "SELECT usu_token AS token FROM usuario WHERE usu_id = ".$tec.";"));
        $registrationIds = $tecnico['token'];
    }
    $cli = $_POST['cli'];
    $serv = $_POST['serv'];
    if(isset($_POST['atd'])){ 
        $atd = $_POST['atd'];
        $_atd_ = ", cham_atendente = '".$_POST['atd']."'"; 
    }
    #API access key from Google API's Console
    define( 'API_ACCESS_KEY', 'AAAAXZTE6sE:APA91bF4bf1hNDYOy_4hXt001iALde71Ilbr_6ZbZKcZbA8h9jlUpEUDNX4ISoPwAj0x7nddZi8Z3qYiCz8G0f-OAC75Qc84E7k-3m0Ebg8b1m7NfUvhIBaNntyd8urL-fK_D7LZeHOu' );
    //$registrationIds = 'ex0aezuyqGg:APA91bFBa44IEjLmaMuQWmipDjzqPtff-yLwmqe-yWokozeyvG6RYdFxysLTpv3k7jgcEXt3RGbauIkqJO7EfuiGS29_ZMGEJekPGPF5Aa9a7j6fsM1e4PQUmL6pdwZX8W1dhJ1daMLw'; //lais

    $data = $ano."-".$mes."-".$dia." ".$hora.":".$min;

    if(isset($_GET['update'])){
        $update = true;
        $sql_tec_change = "SELECT cham_tecnico AS tec FROM chamado_tecnico WHERE cham_id = ".$id.";";
        $old_tec = mysqli_fetch_assoc(mysqli_query($conexao, $sql_tec_change));
        if ($old_tec['tec'] == $tec){
            $msg = array ('body' => 'Um chamado técnico sofreu alterações', 'title' => 'Chamado Técinco Alterado', 'icon' => 'myicon', 'sound' => 'mySound');
        } else {
            $msg = array ('body' => 'Um novo chamado foi designado em sua agenda', 'title' => 'Novo Chamado Técinco', 'icon' => 'myicon', 'sound' => 'mySound');
        }
        $sql = "UPDATE chamado_tecnico SET cham_cliente = '".$cli."', cham_status = '".$status."'".$_atd_.", cham_tecnico = '".$tec."', cham_servico = '".$serv."', cham_agendado = '".$data."', cham_descricao = '".$desc."', cham_observacao = '".$obs."' WHERE chamado_tecnico.cham_id = ".$id.";";

            #prep the bundle
            $fields = array ('to' => $registrationIds, 'notification'   => $msg);
            $headers = array ('Authorization: key=' . API_ACCESS_KEY, 'Content-Type: application/json');
            $sendNotification = true;
    }

    if(isset($_GET['create'])){
        $create = true;
        $now = date("Y-m-d h:i");
            $sql = "INSERT INTO chamado_tecnico (cham_id, cham_cliente, cham_descricao, cham_observacao, cham_status, cham_atendente, cham_tecnico, cham_servico, cham_aberto, cham_agendado) VALUES ('".$id."', '".$cli."', '".$desc."', '".$obs."', '".$status."', '".$atd."', '".$tec."', '".$serv."', '".$now."', '".$data."');";

            #prep the bundle
            $msg = array ('body' => 'Um novo chamado foi designado em sua agenda', 'title' => 'Novo Chamado Técinco', 'icon' => 'myicon', 'sound' => 'mySound');
            $fields = array ('to' => $registrationIds, 'notification'   => $msg);
            $headers = array ('Authorization: key=' . API_ACCESS_KEY, 'Content-Type: application/json');
            $sendNotification = true;
        }
} else {
    if(isset($_GET['delete'])){
        $id = $_GET['delete'];
        $delete = true;
        $sql = "DELETE FROM chamado_tecnico WHERE cham_id = ".$id.";";
    } else {
        header('Refresh: 0; url=../chamado.php?edit='.$id.'&erro=3');
    }
}
    #die('SQL: ' . $sql); #for debug  
    $result = mysqli_query($conexao,$sql);

if(!$result) {
    #die('Erro no UPDATE: ' . mysqli_error($conexao) . '<br><br>SQL: ' . $sql); #for debug
    if($create){
        header('Refresh: 0; url=../chamados.php?&erro=1');
    }
    if($update){
        header('Refresh: 0; url=../chamado.php?edit='.$id.'&erro=2');
    }
    if($delete){
        header('Refresh: 0; url=../chamados.php?&erro=2');
    }
} else {
    if($sendNotification){
        #Send Reponse To FireBase Server    
        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ));
        $result = curl_exec($ch );
        curl_close( $ch );
        #echo $result;   die();   #for debug
    }
    if($create){
        header('Refresh: 0; url=../chamado.php?view='.$id.'&ok=1');
    }
    if($update){
        header('Refresh: 0; url=../chamado.php?view='.$id.'&ok=2');
    }
    if($delete){
        header('Refresh: 0; url=../chamados.php?ok=1');
    }
} 
?>


