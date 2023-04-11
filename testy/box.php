<?php 

$vysledokTesty = mysqli_query($connection,$selectTesty);
while($riadokTesty = mysqli_fetch_array($vysledokTesty)){
        $nazovTestu = $riadokTesty['nazovTestu'];
        $prislusnostTestu = $riadokTesty['prislusnostTestu'];
        $idTestu = $riadokTesty['idTestu'];
        $username = $riadokTesty['creator'];
        $rocnik = $riadokTesty['rocnik'];
        $selectTemy = "SELECT * FROM temy WHERE idTemy='$prislusnostTestu'";
        $vysledokTemy = mysqli_query($connection,$selectTemy);
        $riadokTemy = mysqli_fetch_array($vysledokTemy);
        $nazovTemy = $riadokTemy['nazovTemy'];
        $prislusnostTemy = $riadokTemy['prislusnostTemy'];
        $selectTeachers = "SELECT * FROM teachers WHERE username='$username'";
        $vysledokTeachers = mysqli_query($connection,$selectTeachers);
        $riadokTeachers = mysqli_fetch_array($vysledokTeachers);
        $name = $riadokTeachers['name'];
        $surname = $riadokTeachers['surname'];
        $autor = $name.' '.$surname;
        $selectOtazky = "SELECT idOtazky FROM otazky WHERE prislusnostOtazky='$idTestu'";
        $vysledokOtazky = mysqli_query($connection,$selectOtazky);
        $counter = [];
        while($riadokOtazky = mysqli_fetch_array($vysledokOtazky)){
            $counter[] = $riadokOtazky['idOtazky'];
        }
        $pocetOtazok = count($counter);
        echo '<div class="box">';
        echo '<div><h2>'.$nazovTestu.'</h2></div>';
        echo '<div><h3>'.$nazovTemy.'</h3></div>';
        echo '<div><h3>'.$prislusnostTemy.'</h3></div>';
        echo '<div><h3>'.$autor.'</h3></div>';
        echo '<div><h3>'.$pocetOtazok.'</h3></div>';
        echo '<div><h3>'.$rocnik.'</h3></div>';
        echo '<form action="quiz" method="get">';
        echo '<input type="hidden" name="test" value="'.$idTestu.'">';
        echo '<button class="aboutMe" type="submit"><i class="fa fa-play"></i></button>';
        echo '</form>';
        echo '</div>';
    }

?>