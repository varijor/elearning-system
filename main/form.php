<?php  session_start();

include 'db.php';

$user = $_SESSION['use'];

$nazovTestu = mysqli_real_escape_string($connection, $_POST["nazovTestu"]);
$subject = mysqli_real_escape_string($connection, $_POST["predmet"]);
$tema = mysqli_real_escape_string($connection, $_POST["tema"]);
$rocnik = mysqli_real_escape_string($connection, $_POST["rocnik"]);

$cisloOtazky = 0;
$q = 'q';
$opt1='opt1';
$opt2='opt2';
$opt3='opt3';
$opt4='opt4';
$s = 'spravna';
$y = true;

$sql= "SELECT idTestu FROM testy WHERE prislusnostTestu LIKE '%$subject%'";
$result = mysqli_query($connection,$sql);
$ids = [];

while($row = mysqli_fetch_array($result)){
    $ids[] = $row['idTestu'];
} 

sort($ids);

for ($i = 0;  $i < count($ids); $i++) {
    $idTestu = "TEST_".$subject;
    if(substr($ids[$i],0,8) == $idTestu){
        $last = substr(end($ids),8);
    }
}
$last++;
$idTestu = $idTestu.$last;

for ($x = 0; $x < (count($_POST)-4)/6; $x++) {
    $cisloOtazky++;
    ${"q$cisloOtazky"} =  $_POST['q'.$cisloOtazky];
    ${"q$cisloOtazky"."opt1"} = $_POST['q'.$cisloOtazky.'opt1'];
    ${"q$cisloOtazky"."opt2"} = $_POST['q'.$cisloOtazky.'opt2'];
    ${"q$cisloOtazky"."opt3"} = $_POST['q'.$cisloOtazky.'opt3'];
    ${"q$cisloOtazky"."opt4"} = $_POST['q'.$cisloOtazky.'opt4'];
    ${"spravnaOdpoved$cisloOtazky"} = $_POST['spravnaOdpoved'.$cisloOtazky];
    if(${"spravnaOdpoved$cisloOtazky"}==1){
        ${"spravna$cisloOtazky"} = ${"q$cisloOtazky"."opt1"};
    }
    if(${"spravnaOdpoved$cisloOtazky"}==2){
        ${"spravna$cisloOtazky"} = ${"q$cisloOtazky"."opt2"};
    }
    if(${"spravnaOdpoved$cisloOtazky"}==3){
        ${"spravna$cisloOtazky"} = ${"q$cisloOtazky"."opt3"};
    }
    if(${"spravnaOdpoved$cisloOtazky"}==4){
        ${"spravna$cisloOtazky"} = ${"q$cisloOtazky"."opt4"};
    }
    if(${"q$cisloOtazky"} && ${"q$cisloOtazky"."opt1"} && ${"q$cisloOtazky"."opt2"} && ${"q$cisloOtazky"."opt3"} && ${"q$cisloOtazky"."opt4"} && ${"spravna$cisloOtazky"}){
        $question = ${$q.$cisloOtazky};
        $opt1 = ${$q.$cisloOtazky.'opt1'};
        $opt2 = ${$q.$cisloOtazky.'opt2'};
        $opt3 = ${$q.$cisloOtazky.'opt3'};
        $opt4 = ${$q.$cisloOtazky.'opt4'};
        $spravna = ${$s.$cisloOtazky};
        /* tu moze byt error na pri zmene db */
        $db = new PDO('mysql:host=sql9.hostcreators.sk:3314;dbname=d21572_sids', 'u21572_asd123asd', '356H9Lz#yWAiiArUn7&9');
        /* */
        $stmt = $db->prepare('INSERT INTO otazky (question,opt1,opt2,opt3,opt4,spravnaOdpoved,prislusnostOtazky) VALUES (:question,:opt1,:opt2,:opt3,:opt4,:spravnaOdpoved,:prislusnostOtazky)');
        $stmt->bindParam(':question',$question);
        $stmt->bindParam(':opt1',$opt1);
        $stmt->bindParam(':opt2',$opt2);
        $stmt->bindParam(':opt3',$opt3);
        $stmt->bindParam(':opt4',$opt4);
        $stmt->bindParam(':spravnaOdpoved',$spravna);
        $stmt->bindParam(':prislusnostOtazky',$idTestu);
        $stmt->execute();
    } else {
        $y = false;
    }
}

if ($y){
    $query = "INSERT INTO testy (idTestu,nazovTestu,prislusnostTestu,creator,rocnik) VALUES ('$idTestu','$nazovTestu','$tema','$user','$rocnik')";
    $result = mysqli_query($connection, $query);
    echo '<script type="text/javascript">';
    echo 'alert("Test úspešne vytvorený!");';
    echo 'window.location.href = "'.$_SESSION['link'].'testy/testy.php";';
    echo '</script>';
} else {
    echo '<script type="text/javascript">';
    echo 'alert("Ospravedlňujeme sa ale niečo sa pokazilo!")';
    echo 'window.location.href = "'.$_SESSION['link'].'zadajTest.php";';
    echo '</script>';
}

?>