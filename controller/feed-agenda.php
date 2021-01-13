<?php

require_once('dao/conexao.php');

$con = mysqli_connect($servidor, $usuariobanco, $senhabanco, $bancosrv) or die("Erro: " . mysqli_error($con));

$var = array();
$sql = "SELECT * FROM chamados_agenda";

if ($result = mysqli_query($conexao, $sql))
   {
    while($row = $result->fetch_object())
    {
        foreach($row as $key => $col){
           $col_array[$key] = $col;
        }
        $row_array[] =  $col_array;

    }
    echo json_encode($row_array);
}
mysqli_close($conexao);
?> 