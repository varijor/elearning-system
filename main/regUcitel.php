<?php

    session_start();
    session_unset();  
    include 'db.php';
    $sql= "SELECT username FROM teachers ";
    $result = mysqli_query($connection,$sql);
    
    
    while($row = mysqli_fetch_array($result)){
        $usernames[]=$row[0];
    }
    $username = mb_strtolower(mysqli_real_escape_string($connection, $_POST["username"]));
    $titlefront = mysqli_real_escape_string($connection,$_POST["titlefront"]);
    $name = mysqli_real_escape_string($connection,$_POST["name"]);
    $surname = mysqli_real_escape_string($connection,$_POST["surname"]);
    $titleback = mysqli_real_escape_string($connection,$_POST["titleback"]);
    $school = mysqli_real_escape_string($connection,$_POST["school"]);
    $phone = mysqli_real_escape_string($connection,$_POST["phone"]);
    $email = mysqli_real_escape_string($connection,$_POST["email"]);
    $regpassword = mysqli_real_escape_string($connection,$_POST["regpassword"]);
    $znova_regpassword = mysqli_real_escape_string($connection,$_POST["znovaregpassword"]);
    $token = md5(rand());
    
    if(in_array($username,$usernames)){
        echo '<script type="text/javascript">'; 
        echo 'alert("Toto prihlasovacie meno už je zaregistrované, prosím použite iné!");'; 
        echo 'window.location.href = "../registerUcitel";';
        echo '</script>';
        if($titlefront){
            $_SESSION['titlefront'] = $titlefront;
        }
        if($name){
            $_SESSION['name'] = $name;
        }
        if($surname){
            $_SESSION['surname'] = $surname;
        }
        if($titleback){
            $_SESSION['titleback'] = $titleback;
        }
        if($school){
            $_SESSION['school'] = $school;
        }
        if($phone){
            $_SESSION['phone'] = $phone;
        }
        if($email){
            $_SESSION['email'] = $email;
        }
    } else {
        if($titlefront){
            $_SESSION['titlefront'] = $titlefront;
        }
        if($username){
            $_SESSION['username'] = $username;
        }
        if($name){
            $_SESSION['name'] = $name;
        }
        if($surname){
            $_SESSION['surname'] = $surname;
        }
        if($titleback){
            $_SESSION['titleback'] = $titleback;
        }
        if($school){
            $_SESSION['school'] = $school;
        }
        if($phone){
            $_SESSION['phone'] = $phone;
        }
        if($email){
            $_SESSION['email'] = $email;
        }
        if($username and $name and $surname and $school and $phone and $email and $regpassword){
            if($regpassword == $znova_regpassword){
                $hashed_password = password_hash($regpassword, PASSWORD_DEFAULT);
                if (password_verify($regpassword, $hashed_password)){
                    $query = "INSERT INTO teachers(username,titlefront,name,surname,titleback,email,tel,school,password,token,accountType) VALUES('$username','$titlefront','$name','$surname','$titleback','$email','$phone','$school','$hashed_password','$token','2')";
                    $result = mysqli_query($connection,$query);
                    session_unset();
                    $_SESSION['use']=$username;
                    $_SESSION['acc']=2;
                    echo '<script type="text/javascript">'; 
                    echo 'alert("Úspešne zaregistrovaný!");'; 
                    echo 'window.location.href = "../domov";';
                    echo '</script>';
                } 
            } else {
                echo '<script type="text/javascript">'; 
                echo 'alert("Vaše heslá sa nezhodujú, skúste znova!");';
                echo 'window.location.href = "../registerUcitel";';
                echo '</script>';
            }
        } else {
            echo '<script type="text/javascript">;'; 
            echo 'alert("Nezadali ste všetky potrebné údaje!");';
            echo 'window.location.href = "../registerUcitel"';
            echo '</script>;';
        }
    }
?>