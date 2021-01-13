<?php include_once "dao/conexao.php";

$conexao = mysqli_connect($servidor,$usuariobanco,$senhabanco);
$db = mysqli_select_db($conexao, $bancosrv);
if(!$db){
    header("location: ../servicos.php?erro=1");
    die ('Não foi possivel conectar: '.  mysqli_error($conexao));
}

$modo = null; $id = null; $nome = null; $celular = null; $telefone = null; $whatsapp = null; 
    $email = null; $rg = null; $cpf = null; $logradouro = null; $numero = null; $complemento = null; 
    $bairro = null; $cep = null; $cidade = null; $estado = null; $result = false;

$update = false; $create = false; $delete = false; $sql = "";

if($_SERVER['REQUEST_METHOD'] == "POST") {
    if(isset($_POST['id'])){
        $id =$_POST['id'];
    }
    $nome        = $_POST['nome'];
    $celular     = $_POST['celular'];
    $telefone    = $_POST['telefone'];
    $email       = $_POST['email'];
    $whatsapp    = $_POST['whatsapp'];
    $rg          = $_POST['rg'];
    $cpf         = $_POST['cpf'];
    $logradouro  = $_POST['logradouro'];
    $numero      = $_POST['numero'];
    $complemento = $_POST['complemento'];
    $bairro      = $_POST['bairro'];
    $cep         = $_POST['cep'];
    $cidade      = $_POST['cidade'];
    $estado      = $_POST['estado'];

    $address = $logradouro." ".$numero." ".$cidade." ".$estado;
    $address = str_replace(" ", "+", $address);
    $url = "http://maps.google.com/maps/api/geocode/json?sensor=false&address=$address";
    $response = file_get_contents($url);
    $json = json_decode($response,TRUE);
    if($latitude = $json['results'][0]['geometry']['location']['lat']){ 
    }else{
        $latitude = '';
    }
    if($longitude = $json['results'][0]['geometry']['location']['lng']){
    }else{
        $longitude = '';
    }

if(isset($_GET['create'])){

    $create = true;
    $sql_novo_endereco = "INSERT INTO endereco (end_logradouro, end_numero, end_complemento, end_bairro, end_cidade, end_cep, end_estado, end_latitude, end_longitude) VALUES ('".$logradouro."','".$numero."','".$complemento."','".$bairro."','".$cidade."','".$cep."','".$estado."','".$latitude."','". $longitude."')";          

    $insereenderco = mysqli_query($conexao, $sql_novo_endereco); //insere endereco
    $endid = mysqli_insert_id($conexao); //pega o id do endereço inserido

    $sql = "INSERT INTO cliente (cli_nome, cli_cpf, cli_rg, cli_celular, cli_email, cli_endereco, cli_telefone, cli_whatsapp) 
            VALUES ('".$nome."','".$cpf."','".$rg."','".$celular."','".$email."','".$endid."','".$telefone."','".$whatsapp."')";

}  

if(isset($_GET['update'])){
    $update = true;
    
    $sql_id_end = "SELECT end_id AS id FROM endereco AS e, cliente AS c WHERE c.cli_endereco = e.end_id AND c.cli_id = ". $id.";";
    $end = mysqli_fetch_assoc(mysqli_query($conexao, $sql_id_end));

    $sql_1 =  "UPDATE endereco SET end_logradouro = '".$logradouro."', end_numero = '".$numero."', end_complemento = '".$complemento."', end_bairro = '".$bairro."', end_cep = '".$cep."', end_cidade = '".$cidade."', end_estado = '".$estado."', end_latitude = '".$latitude."', end_longitude = '".$longitude."' WHERE end_id = ".$end['id'].";";

    $sql_2 = "UPDATE cliente SET cli_nome = '".$nome."', cli_celular = '".$celular."', cli_telefone = '".$telefone."', cli_whatsapp = '".$whatsapp."', cli_email = '".$email."' WHERE cli_id = ".$id.";";
}  

} else {
    if(isset($_GET['delete'])){
        $id = $_GET['delete'];
        $delete = true;
        $sql_1 = "DELETE FROM cliente WHERE cli_id = ".$id.";";

        $sql_id_end = "SELECT end_id AS id FROM endereco AS e, cliente AS c WHERE c.cli_endereco = e.end_id AND c.cli_id = ". $id.";";
        $end = mysqli_fetch_assoc(mysqli_query($conexao, $sql_id_end));
        $sql_2 = "DELETE FROM endereco WHERE end_id = ".$end['id'].";";
    } 
}

if($create){
    $result = mysqli_query($conexao,$sql);
}
if($delete || $update){
    $result = mysqli_query($conexao,$sql_1);
    if($result){
        $result = mysqli_query($conexao,$sql_2);
    }
}

if(!$result) {
    if($create){
        die('Erro SQL : ' . mysqli_error($conexao) . '<br><br>SQL: ' . $sql); #for debug
        header('Refresh: 0; url=../clientes.php?erro=2');
    }
    if($update){
        die('Erro SQL : ' . mysqli_error($conexao) . '<br><br>SQL_1: ' . $sql_1 . '<br>SQL_2: ' . $sql_2); #for debug
        header('Refresh: 0; url=../clientes.php?erro=3');
    }
    if($delete){
        die('Erro SQL : ' . mysqli_error($conexao) . '<br><br>SQL_1: ' . $sql_1 . '<br>SQL_2: ' . $sql_2); #for debug
        if (strpos(mysqli_error($conexao), 'CONSTRAINT ') == true) {
            header('Refresh: 0; url=../clientes.php?erro=4');
        } else {
            header('Refresh: 0; url=../clientes.php?erro=5');
        }
    }
} else {
    #die('Sucesso -> SQL : ' . mysqli_error($conexao) . '<br><br>SQL: ' . $sql); #for debug
    if($create){
        header('Refresh: 0; url=../clientes.php?ok=1');
    }
    if($update){
        header('Refresh: 0; url=../clientes.php?ok=2');
    }
    if($delete){
        header('Refresh: 0; url=../clientes.php?ok=3');
    }
} 
?>