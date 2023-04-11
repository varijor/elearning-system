<?php 

include 'db.php';

if(isset($_POST["submit"])){
    session_start();
    $username=mysqli_real_escape_string($connection,$_POST["logusername"]);
    $password=mysqli_real_escape_string($connection,$_POST["logpassword"]);

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
    
if(in_array($username,$usernames)){
        $sql1= "SELECT * FROM users WHERE username = '$username'";
        $result1 = mysqli_query($connection,$sql1);
        $check = mysqli_num_rows($result1);
        if ($check>0) {
        $row1 = mysqli_fetch_array($result1);
        $accountType = $row1['accountType'];
        if (password_verify($password, $row1['password'])) {
            $_SESSION['use']=$username;
            $_SESSION['acc']=$accountType;
            echo '<script type="text/javascript">'; 
            echo 'window.location.href = "../domov";';
            echo '</script>';
        } else {
            echo '<script type="text/javascript">'; 
            echo 'alert("Zlé prihlasovacie údaje, skúste znova!");'; 
            echo 'window.location.href = "../index";';
            echo '</script>';
        }
        }
    } else {
        if(in_array($username,$usernames2)){
            $sql3= "SELECT * FROM teachers WHERE username = '$username'";
            $result3 = mysqli_query($connection,$sql3);
            $check3 = mysqli_num_rows($result3);
            if ($check3>0) {
            $row3 = mysqli_fetch_array($result3);
            $accountType = $row3['accountType'];
                if (password_verify($password, $row3['password'])) {
                    $_SESSION['use']=$username;
                    $_SESSION['acc']=$accountType;
                    echo '<script type="text/javascript">'; 
                    echo 'window.location.href = "../domov";';
                    echo '</script>';
                } else {
                    echo '<script type="text/javascript">'; 
                    echo 'alert("Zlé prihlasovacie údaje, skúste znova!");'; 
                    echo 'window.location.href = "../index";';
                    echo '</script>';
                }
        }
    }else{
        echo '<script type="text/javascript">'; 
        echo 'alert("Zlé prihlasovacie údaje, skúste znova!");'; 
        echo 'window.location.href = "../index";';
        echo '</script>';
    }

}
}

?>