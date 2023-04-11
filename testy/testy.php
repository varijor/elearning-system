<?php   
    include '../main/session.php';   
    include '../main/db.php';
    
   	$listRocniky = [];
    $asd = [];
	if(isset($_POST['1'])){array_push($listRocniky,'1');$_SESSION['rocnik1']="active";}else{$_SESSION['rocnik1']="not";}
	if(isset($_POST['2'])){array_push($listRocniky,'2');$_SESSION['rocnik2']="active";}else{$_SESSION['rocnik2']="not";}
	if(isset($_POST['3'])){array_push($listRocniky,'3');$_SESSION['rocnik3']="active";}else{$_SESSION['rocnik3']="not";}
	if(isset($_POST['4'])){array_push($listRocniky,'4');$_SESSION['rocnik4']="active";}else{$_SESSION['rocnik4']="not";}
	if(count($listRocniky)!==0){
        foreach($listRocniky as $rocnik) {
            array_push($asd,"'$rocnik'");
        }
    $rocniky = implode(',',$asd);
    $query = ' rocnik IN ('.$rocniky.')';
	}

    $selectPredmetyId = "SELECT skratka FROM predmety";
    $selectTemyId = "SELECT idTemy FROM temy";
    $vysledokPredmetyId = mysqli_query($connection,$selectPredmetyId);
    $vysledokTemyId = mysqli_query($connection,$selectTemyId);
    $x=0;
    $y=0;
    $predmet = false;
    $tema = false;
    if(isset($_POST["submit-search"]) and count($_POST)>1){
        $queryTesty = "SELECT * FROM testy WHERE";
        $queryTemy = "SELECT * FROM testy WHERE";
        while($riadokPredmetyId = mysqli_fetch_array($vysledokPredmetyId)){
            $skratka = $riadokPredmetyId['skratka'];
            if(isset($_POST[$skratka])){
                $_SESSION[$skratka] = 'active';
                $x++;
                if($x<=1){
                    $queryTesty = $queryTesty." prislusnostTestu LIKE '%$skratka%'";
                } else {
                    $queryTesty = $queryTesty." OR prislusnostTestu LIKE '%$skratka%'";
                }
                $predmet = true;
            } else {
                unset($_SESSION[$skratka]);
            }
        }
        while($riadokTemyId = mysqli_fetch_array($vysledokTemyId)){
            $idTemy = $riadokTemyId['idTemy'];
            if(isset($_POST[$idTemy])){
                $_SESSION[$idTemy] = 'active';
                $y++;
                if($y<=1){
                    $queryTemy = $queryTemy." prislusnostTestu='$idTemy'";
                } else {
                    $queryTemy = $queryTemy." OR prislusnostTestu='$idTemy'";
                }
                $tema = true;
            } else {
                unset($_SESSION[$idTemy]);
            }
        }
        $checking = true;
        if($tema or $predmet){
            if($tema){
                $selectTesty = $queryTemy;
            } else {
                if($predmet){
                    $selectTesty = $queryTesty;
                }
            }
            if(isset($query)){
                $checking = false;
                $selectTesty = $selectTesty.'AND'.$query;
            }
        } else {
            $selectTesty = "SELECT * FROM testy";
        }
        if(isset($query) and $checking){
            $selectTesty = $selectTesty.' WHERE '.$query;
        }
    } else {
        if(count($_POST)<=1){
        $selectTesty = "SELECT * FROM testy";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="quiz.css">
    <link rel="stylesheet" href="../css/domov.css">
    <?php include_once '../main/head.php' ?>
    <link rel="shortcut icon" href="../pictures/sos_it_logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Všetky testy</title>
</head>
<body>
    <?php include_once '../main/header.php'?>
    <div class="container">
        <div class="bottom">
            <h2>Filter testov</h2>
            <hr>
            <form action="testy.php" method="post">
            <div class="flex">
                <div>
                    <label class="nazov" for="rocnik">Ročník: </label>
                    <label class="rocniky" for="1">1.</label>
                    <input class ="roc_inp" type="checkbox" id="1" name="1" 
                    <?php if($_SESSION['rocnik1']=="active"){echo 'checked';}?>>
                    <label class="rocniky" for="2">2.</label>
                    <input class ="roc_inp" type="checkbox" id="2" name="2" 
                    <?php if($_SESSION['rocnik2']=="active"){echo 'checked';}?>>
                    <label class="rocniky" for="3">3.</label>
                    <input class ="roc_inp" type="checkbox" id="3" name="3" 
                    <?php if($_SESSION['rocnik3']=="active"){echo 'checked';}?>>

                    <label class="rocniky" for="4">4.</label>
                    <input class ="roc_inp" type="checkbox" id="4" name="4" 
                    <?php if($_SESSION['rocnik4']=="active"){echo 'checked';}?>>

                </div>
                <div>
                    <label class="nazov" for="rocnik">Predmety:</label>
                    <?php 
                        $selectPredmety = "SELECT * FROM predmety";
                        $vysledokPredmety = mysqli_query($connection,$selectPredmety);
                        while($riadokPredmety = mysqli_fetch_array($vysledokPredmety)){
                            $skratka = $riadokPredmety['skratka'];
                            echo '<label class="rocniky" for="'.$skratka.'">'.$skratka.'</label>';
                            if(isset($_SESSION[$skratka])){echo '<input class ="roc_inp" type="checkbox" id="'.$skratka.'" name="'.$skratka.'" checked>';} else {
                                echo '<input class ="roc_inp" type="checkbox" id="'.$skratka.'" name="'.$skratka.'">';
                            }
                        } 
                    ?>
                    
                </div>
                <div class="temy">
                    <label class="nazov" for="tema">Témy:</label>
                    <?php 
                        $selectTema = "SELECT * FROM temy ";
                        $vysledokTema = mysqli_query($connection,$selectTema);
                        while($riadokTema = mysqli_fetch_array($vysledokTema)){
                            $nazovTemy = $riadokTema['nazovTemy'];
                            $idTemy = $riadokTema['idTemy'];
                            echo '<label class="rocniky" for="'.$nazovTemy.'">'.$nazovTemy.'</label>';
                            if(isset($_SESSION[$idTemy])){echo '<input class ="roc_inp" type="checkbox" id="'.$nazovTemy.'" name="'.$idTemy.'" checked>';} else {
                                echo '<input class ="roc_inp" type="checkbox" id="'.$nazovTemy.'" name="'.$idTemy.'">';
                            }
                        } 
                    ?>
                </div>
            </div>
            <button class="search" type="submit" name="submit-search"><i class="fa fa-search"></i></button> 
            </form>
            <div class="wrapper">
                <div class="box">
                    <div><h3>Názov</h3></div>
                    <div><h3>Téma</h3></div>
                    <div><h3>Predmet</h3></div>
                    <div><h3>Autor</h3></div>
                    <div><h3>Otázok</h3></div>
                    <div><h3>Ročník</h3></div>
                    <button type="submit"><i class="fa fa-play"></i></button>
                </div>
                <?php 
                    include 'box.php';
                ?>
            </div>
        </div>
    </div>
</body>
</html>
                    