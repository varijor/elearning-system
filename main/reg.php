<?php 

session_start();
session_unset();

include 'db.php';

$sql= "SELECT username FROM users ";
$result = mysqli_query($connection,$sql);

while($row = mysqli_fetch_array($result)){
    $usernames[]=$row[0];
}

$username = mb_strtolower(mysqli_real_escape_string($connection, $_POST["regusername"]));
$name = mysqli_real_escape_string($connection, $_POST["name"]);
$surname = mysqli_real_escape_string($connection, $_POST["surname"]) ;
$email = mysqli_real_escape_string($connection, $_POST["email"]);
$phone = mysqli_real_escape_string($connection, $_POST["phone"]);
$password = mysqli_real_escape_string($connection, $_POST["regpassword"]);
$znova_password = mysqli_real_escape_string($connection, $_POST["znovaregpassword"]);
$token = md5(rand());

if(in_array($username,$usernames)){
    echo '<script type="text/javascript">'; 
    echo 'alert("Toto prihlasovacie meno už je zaregistrované, prosím použite iné!");'; 
    echo 'window.location.href = "../index.php";';
    echo '</script>';
    if($name){
        $_SESSION['name'] = $name;
    }
    if($surname){
        $_SESSION['surname'] = $surname;
    }
    if($email){
        $_SESSION['email'] = $email;
    }
    if($phone){
        $_SESSION['phone'] = $phone;
    }
} else {
    if($username){
        $_SESSION['username'] = $username;
    }
    if($name){
        $_SESSION['name'] = $name;
    }
    if($surname){
        $_SESSION['surname'] = $surname;
    }
    if($email){
        $_SESSION['email'] = $email;
    }
    if($phone){
        $_SESSION['phone'] = $phone;
    }
  if($username and $name and $surname and $email and $phone and $password and $znova_password and $token){
      if(($password == $znova_password)){
        $hashed_password=password_hash($password,PASSWORD_DEFAULT);
        if (password_verify($password, $hashed_password)) {
            $query = "INSERT INTO users (username,name,surname,email,tel,password,token) VALUES ('$username', '$name','$surname', '$email','$phone', '$hashed_password','$token')";
            $result = mysqli_query($connection, $query); 
            session_unset();
            $_SESSION['use']=$username;
            $_SESSION['acc']=0;
            echo '<script type="text/javascript">'; 
            echo 'alert("Úspešne zaregistrovaný!");'; 
            echo 'window.location.href = "../domov";';
            echo '</script>';
        }
      } else {
        echo '<script type="text/javascript">'; 
        echo 'alert("Vaše heslá sa nezhodujú, skúste znova!");'; 
        echo 'window.location.href = "../index";';
        echo '</script>';
      }
  } else {
      echo '<script type="text/javascript">;'; 
      echo 'alert("Nezadali ste všetky potrebné údaje!");'; 
      echo 'window.location.href = "../index"';
      echo '</script>;';
  }
}

?>