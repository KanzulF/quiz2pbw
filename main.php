<?php
    session_start();

    $servername = "localhost";
    
    try {
      $conn = new PDO("mysql:host=$servername;dbname=quizpbw", "root","");
      // set the PDO error mode to exception
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
      echo "Connection failed: " . $e->getMessage();
    }

    $stmt = $conn->prepare("SELECT username, pasword FROM user ");
    $stmt->execute();
  
    // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    foreach ($stmt as $key) {
      $user[$key['username']] = $key['pasword'];
    }
    $daftarUsername = [];
    foreach ($user as $key => $value) {
      array_push($daftarUsername,$key);
    }
    if(isset($_COOKIE['username']) and (isset($_COOKIE['password']) )){
      $username = $_COOKIE['username'];
      $password = $_COOKIE['password'];
      $_SESSION['username'] = $username;
      $_SESSION['password'] = $password;
      $_SESSION['start'] = time();
      $_SESSION['expire'] = $_SESSION['start'] + (30 * 60);
      setcookie('username', $username, time() + 3600, "/");
      setcookie('password', $password, time() + 3600, "/");
      header("location: home.php");
    }
    if(isset($_POST['name']) and (isset($_POST['psw']))){
      $username = $_POST['name'];
      $password = $_POST['psw'];
      if(in_array($username,$daftarUsername)){
        if($password == $user[$username]){
          $_SESSION['username'] = $username;
          $_SESSION['password'] = $password;
          $_SESSION['start'] = time();
          $_SESSION['expire'] = $_SESSION['start'] + (30 * 60);
          setcookie('username', $username, time() + 3600, "/");
          setcookie('password', $password, time() + 3600, "/");
          header("location: home.php");
        }else {
          echo '<script>alert("Password yang anda masukkan salah!")</script>';
          }
      }else{
        echo '<script>alert("Username yang anda masukkan salah!")</script>';
      }}
      
    
      
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {font-family: Arial, Helvetica, sans-serif;}
form {border: 3px solid #f1f1f1;}

input[type=text], input[type=password] {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  box-sizing: border-box;
}
button {
  background-color: #04AA6D;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
}
button:hover {
  opacity: 0.8;
}

.cancelbtn {
  width: auto;
  padding: 10px 18px;
  background-color: #f44336;
}

.imgcontainer {
  text-align: center;
  margin: 24px 0 12px 0;
}

img.avatar {
  width: 40%;
  border-radius: 50%;
}

.container {
  padding: 16px;
}

span.psw {
  float: right;
  padding-top: 16px;
}

/* Change styles for span and cancel button on extra small screens */
@media screen and (max-width: 300px) {
  span.psw {
     display: block;
     float: none;
  }
  .cancelbtn {
     width: 100%;
  }
}
</style>
</head>
<body>
<h2>Form Login</h2>

<form action="/PWEB/quiz2/main.php" method="post">

  <div class="container">
    <label for="uname"><b>Username</b></label>
    <input type="text" placeholder="Enter Username" name="name" required>

    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="psw" required>
    <button type="submit" value="send">Login</button>
    <p><a href='daftar.php'>Belum punya akun?</a></p>
  </div>
</form>
</body>
</html>
