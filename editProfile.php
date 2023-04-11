<?php   
    include './main/session.php';   
    include './main/db.php';
       
    $username = $_SESSION['use'];   
    
    $sql= "SELECT username FROM users ";
    $result = mysqli_query($connection,$sql);
    
    $sql2 = "SELECT * FROM users WHERE username = '$username'" ;
    $result2 = mysqli_query($connection,$sql2);
    $row2 = mysqli_fetch_array($result2);
    
    while($row = mysqli_fetch_array($result)){
        $usernames[]=$row[0];
    } 
    
    $sql1= "SELECT username FROM teachers ";
    $result1 = mysqli_query($connection,$sql1);
    
    $sql4 = "SELECT * FROM teachers WHERE username = '$username'" ;
    $result4 = mysqli_query($connection,$sql4);
    $row4 = mysqli_fetch_array($result4);
    
    while($row1 = mysqli_fetch_array($result1)){
        $usernames2[]=$row1[0];
    }
    
    if(isset($_POST["submit"])){
        session_start();
        $new_username = mb_strtolower(mysqli_real_escape_string($connection, $_POST["username"]));
        $name = mysqli_real_escape_string($connection, $_POST["name"]);
        $surname = mysqli_real_escape_string($connection, $_POST["surname"]) ;
        $email = mysqli_real_escape_string($connection, $_POST["email"]);
        $phone = mysqli_real_escape_string($connection, $_POST["phone"]);
        if(in_array($username,$usernames)){
            if($new_username!== $row2['username']){
                $query2 = "UPDATE users SET username='$new_username' WHERE username='$username' ";
                $_SESSION['use'] = $new_username;
                $username = $new_username;
                $result3 = mysqli_query($connection,$query2);
                header("Refresh:0");
            }
            if($name!== $row2['name']){
                $query2 = "UPDATE users SET name='$name' WHERE username='$username' " ;
                $result3 = mysqli_query($connection,$query2);
                header("Refresh:0");
            }
            if($surname!== $row2['surname']){
                $query2 = "UPDATE users SET surname='$surname' WHERE username='$username' " ;
                $result3 = mysqli_query($connection,$query2);
                header("Refresh:0");
            }
            if($email!== $row2['email']){
                $query2 = "UPDATE users SET email='$email' WHERE username='$username' " ;
                $result3 = mysqli_query($connection,$query2);
                header("Refresh:0");
            }
            if($phone!== $row2['tel']){
                $query2 = "UPDATE users SET tel='$phone' WHERE username='$username' " ;
                $result3 = mysqli_query($connection,$query2);
                header("Refresh:0");
            }
        }
        if(in_array($username,$usernames2)){
            if($new_username!== $row4['username']){
                $query2 = "UPDATE teachers SET username='$new_username' WHERE username='$username' ";
                $_SESSION['use'] = $new_username;
                $username = $new_username;
                $result3 = mysqli_query($connection,$query2);
                header("Refresh:0");
            }
            if($name!== $row4['name']){
                $query2 = "UPDATE teachers SET name='$name' WHERE username='$username' " ;
                $result3 = mysqli_query($connection,$query2);
                header("Refresh:0");
            }
            if($surname!== $row4['surname']){
                $query2 = "UPDATE teachers SET surname='$surname' WHERE username='$username' " ;
                $result3 = mysqli_query($connection,$query2);
                header("Refresh:0");
            }
            if($email!== $row4['email']){
                $query2 = "UPDATE teachers SET email='$email' WHERE username='$username' " ;
                $result3 = mysqli_query($connection,$query2);
                header("Refresh:0");
            }
            if($phone!== $row4['tel']){
                $query2 = "UPDATE teachers SET tel='$phone' WHERE username='$username' " ;
                $result3 = mysqli_query($connection,$query2);
                header("Refresh:0");
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once './main/head.php'?>
    <link rel="stylesheet" href="./css/domov.css">
    <link rel="stylesheet" href="./css/editpassword.css">
    <title>Upraviť profil</title>
</head>
<body>
    <?php include './main/header.php' ?>
    <center><div class="container">
        <h2>Zmeniť svoje údaje</h2>
        <form action="editProfile.php" method="post" id="editprof">
            <label for="username" class="inp">
                <input type="text" name="username" id="username" value="<?php if(in_array($username,$usernames2)){echo $row4['username'];}
                                                                              if(in_array($username,$usernames)){echo $row2['username'];}?>" required>
                <span class="label">Prihlasovacie meno</span>
                <span class="focus-bg"></span>
            </label>
            <label for="name" class="inp">
                <input type="text" name="name" id="name" value="<?php if(in_array($username,$usernames2)){echo $row4['name'];}
                                                                      if(in_array($username,$usernames)){echo $row2['name'];}?>" required>
                <span class="label">Tvoje meno</span>
                <span class="focus-bg"></span>
            </label>
            <label for="surname" class="inp">
                <input type="text" name="surname" id="surname" value="<?php if(in_array($username,$usernames2)){echo $row4['surname'];}
                                                                            if(in_array($username,$usernames)){echo $row2['surname'];}?>" required>
                <span class="label">Tvoje priezvisko</span>
                <span class="focus-bg"></span>
            </label>
            <label for="phone" class="inp">
                <input type="text" name="phone" id="phone" value="<?php if(in_array($username,$usernames2)){echo $row4['tel'];}
                                                                        if(in_array($username,$usernames)){echo $row2['tel'];}?>" required>
                <span class="label">Telefónne číslo</span>
                <span class="focus-bg"></span>
            </label>
            <label for="email" class="inp">
                <input type="text" name="email" id="email" value="<?php if(in_array($username,$usernames2)){echo $row4['email'];}
                                                                        if(in_array($username,$usernames)){echo $row2['email'];}?>" required>
                <span class="label">Email</span>
                <span class="focus-bg"></span>
            </label>
            <br>
            <button role="button" type="submit" formmethod="POST" name="submit">Zmeniť</button>
        </form>
    </div></center>
    <?php include './main/footer.php' ?>
</body>
</html>