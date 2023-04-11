<?php   
    include './main/session.php';
    include './main/db.php';
       
    $username = $_SESSION['use'];   
       
    $sql= "SELECT username FROM users";
    $result = mysqli_query($connection,$sql);
    while($row = mysqli_fetch_array($result)){
        $usernames[]=$row[0];
    }
    
    $sql2= "SELECT username FROM teachers";
    $result2 = mysqli_query($connection,$sql2);
    while($row2 = mysqli_fetch_array($result2)){
        $usernames2[]=$row2[0];
    }
    
    if(isset($_POST["submit"])){
        session_start();
        $old_password=mysqli_real_escape_string($connection,$_POST["oldpass"]);
        $new_password1=mysqli_real_escape_string($connection,$_POST["newpass1"]);
        $new_password2=mysqli_real_escape_string($connection,$_POST["newpass2"]);
        if (in_array($username,$usernames)){
            $sql= "SELECT password FROM users WHERE username = '$username'" ;
        }
        if (in_array($username,$usernames2)){
            $sql= "SELECT password FROM teachers WHERE username = '$username'" ;
        }
        $result = mysqli_query($connection,$sql);
        $row = mysqli_fetch_array($result);
        if (($new_password1 == $new_password2)) {
            $hashed_password=password_hash($new_password1,PASSWORD_DEFAULT);
            if(strlen($new_password1)<15 && strlen($new_password1)>7){
                if (password_verify($old_password, $row['password'])){
                    if (in_array($username,$usernames)){
                        $query2 = "UPDATE users SET password='$hashed_password' WHERE username='$username' ";
                    }
                    if (in_array($username,$usernames2)){
                        $query2 = "UPDATE teachers SET password='$hashed_password' WHERE username='$username' ";
                    }
                    $result2 = mysqli_query($connection,$query2);
                    echo '<script type="text/javascript">'; 
                    echo 'alert("Úspešne zmenené heslo!");'; 
                    echo '</script>';
                } else {
                    echo '<script type="text/javascript">'; 
                    echo 'alert("Nesprávne staré heslo!");';
                    echo '</script>';
                }
            } else {
                echo '<script type="text/javascript">'; 
                echo 'alert("Tvoje nové heslo má zlý tvar, nebolo zmenené!");';
                echo '</script>';
            }
        } else {
            echo '<script type="text/javascript">'; 
            echo 'alert("Tvoje heslá sa nezhodujú!");';
            echo '</script>';
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once './main/head.php' ?>
    <link rel="stylesheet" href="./css/domov.css">
    <link rel="stylesheet" href="./css/editpassword.css">
    <title>Upraviť heslo</title>
</head>
<body>
    <?php include './main/header.php' ?>
    <center><div class="container">
        <h2>Zmeniť heslo</h2>
        <form action="editPassword.php" method="post" id="editpass">
            <label for="oldpass" class="inp">
                <input type="password" name="oldpass" id="oldpass" placeholder="&nbsp;" required>
                <span class="label">Staré heslo</span>
                <span class="focus-bg"></span>
            </label>
            <label for="oldpass" class="inp">
                <input type="password" name="newpass1" id="newpass1" placeholder="&nbsp;" required>
                <span class="label">Nové heslo (8-14 znakov)</span>
                <span class="focus-bg"></span>
            </label>
            <label for="oldpass" class="inp">
                <input type="password" name="newpass2" id="newpass2" placeholder="&nbsp;" required>
                <span class="label">Znova nové heslo (8-14 znakov)</span>
                <span class="focus-bg"></span>
            </label>
            <br>
            <button role="button" type="submit" formmethod="POST" name="submit">Zmeniť</button>
        </form>
    </div></center>
    <?php include './main/footer.php' ?>
</body>
</html>