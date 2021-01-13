<?php include_once "dao/conexao.php";

$conexao = mysqli_connect($servidor,$usuariobanco,$senhabanco);
$db = mysqli_select_db($conexao, $bancosrv);

if(!$db){
    header("location: ../servico.php?erro=1");
    die ('Não foi possivel conectar: '.  mysqli_error($conexao));
}

$update = false; $create = false; $delete = false; $sql = "";
$id = 0; 
$nome = ""; $desc = ""; 
$valor = ""; $tipo = ""; 

if($_SERVER['REQUEST_METHOD'] == "POST") {
    if(isset($_POST['id'])){
        $id =$_POST['id'];
    }
    $nome =$_POST['nome'];
    $desc = $_POST['desc'];
    $valor = $_POST['valor'];
    $tipo = $_POST['tipo'];

    if(isset($_GET['update'])){
        $update = true;
        $sql = "UPDATE servico SET serv_nome = '".$nome."', serv_descricao = '".$desc."', serv_valor = '".$valor."', serv_tipo = '".$tipo."' WHERE servico.serv_id = ".$id.";";
    }

    if(isset($_GET['create'])){
        $create = true;
        $sql = "INSERT INTO servico (serv_nome, serv_descricao, serv_valor, serv_tipo) VALUES ('".$nome."', '".$desc."', '".$valor."', '".$tipo."');";
    }    

} else {
    if(isset($_GET['delete'])){
        $id = $_GET['delete'];
        $delete = true;
        $sql = "DELETE FROM servico WHERE serv_id = ".$id.";";
    } 
}

$result = mysqli_query($conexao,$sql);

if(!$result) {
    #die('Erro SQL : ' . mysqli_error($conexao) . '<br><br>SQL: ' . $sql); #for debug
    if($create){
        header('Refresh: 0; url=../servicos.php?erro=2');
    }
    if($update){
        header('Refresh: 0; url=../servicos.php?erro=3');
    }
    if($delete){
        if (strpos(mysqli_error($conexao), 'CONSTRAINT ') == true) {
            header('Refresh: 0; url=../servicos.php?erro=4');
        } else {
            header('Refresh: 0; url=../servicos.php?erro=5');
        }
    }
} else {
    #die('Sucesso -> SQL : ' . mysqli_error($conexao) . '<br><br>SQL: ' . $sql); #for debug
    if($create){
        header('Refresh: 0; url=../servicos.php?ok=1');
    }
    if($update){
        header('Refresh: 0; url=../servicos.php?ok=2');
    }
    if($delete){
        header('Refresh: 0; url=../servicos.php?ok=3');
    }
} 
?>