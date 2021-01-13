<?PHP
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
  if(isset($_POST['email']) && !empty(isset($_POST['email'])) 
  && isset($_POST['password']) && !empty(isset($_POST['password']))){ 
      include_once("connection.php"); 
      $email = $_POST['email']; 
      $password = $_POST['password']; 
      $created_date = Date('Y-m-d H:m:s'); 
      $status = 1;
      $sql = "INSERT INTO table_user VALUES (NULL, '$email', '$password', '$created_date', $status)"; 
      if ($conn->query($sql) === TRUE) { 
          $last_id = mysqli_insert_id($conn); 
          echo "$last_id"; 
      } else { 
          echo "ErrorInsert"; 
          echo "Error: " . $sql . "<br>" . $conn->error; 
      }
  }
?>