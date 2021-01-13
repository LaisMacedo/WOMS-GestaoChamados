<?PHP
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
  if(isset($_POST['email'])
    && !empty(isset($_POST['email'])) 
    && isset($_POST['password']) 
    && !empty(isset($_POST['password']))){ 
        include_once("connection.php");
        $email = $_POST['email']; 
        $password = $_POST['password'];
        $sql = "SELECT usu_nome, usu_id FROM usuario WHERE usu_login = '$email' AND usu_senha = '$password'"; 
        $result = $conn->query($sql); 

        if ($result->num_rows > 0) { 
            echo "LoginSuccess"; 
            //TODO json passando nome e id do usuario e status da transação!
        } 
        else { 
            echo "Error: " . $sql . "<br>" . $conn->error; 
        }
  }
?>