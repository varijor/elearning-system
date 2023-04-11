<?php
    include '../main/db.php';
    include '../main/session.php';
    $test_Id = $_GET['test'];
    $username = $_SESSION['use'];
    $value = $_GET['asd'];
    $predmet = substr($test_Id,5,-1);

    $query = "INSERT INTO percenta(username,test_Id,percenta,predmet) VALUES('$username','$test_Id','$value','$predmet')";
    $result = mysqli_query($connection,$query);
    
?>
