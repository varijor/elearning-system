<?php
    include '../main/session.php';   
    include '../main/db.php';
       
    $username = $_SESSION['use'];
?>  
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/domov.css">
    <link rel="shortcut icon" href="../pictures/sos_it_logo.png">
    <link rel="stylesheet" href="quiz.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Známky</title>
</head>
<body>
    <?php
    include "../main/header.php";
    ?>
    <div class="container">
        <div class="bottom">
            <div class="Nazov">
                <h2>Výsledky</h2>
                <h3><?php echo $username; ?></h3>
            </div>
            <hr>
            <table class="tabulkaZ">
                <tr>
                    <th style="width: 20.5%">Predmet</th>
                    <th style="width:15%">Percentá</th>
                    <th style="width:15%">Priemer</th>
                </tr>
                <?php
                    $selectPredmety = "SELECT * FROM predmety ";
                    $vysledokPredmety = mysqli_query($connection,$selectPredmety);
                    while($riadokPredmety = mysqli_fetch_array($vysledokPredmety)){
                        $nazov = $riadokPredmety['nazovPredmetu'];
                        $skratka = $riadokPredmety['skratka'];
                        $selectPercenta = "SELECT percenta FROM percenta WHERE predmet='$skratka' AND username='$username'";
                        $selectPriemer = "SELECT AVG(percenta) AS priemer FROM percenta WHERE predmet='$skratka' AND username='$username'";
                        
                        $vysledokPercenta = mysqli_query($connection,$selectPercenta);
                        $vysledokPriemer = mysqli_query($connection,$selectPriemer);
                        echo "<tr> <td>".$nazov. "</td> <td>";
                        while($riadokPercenta = mysqli_fetch_array($vysledokPercenta)){
                            $percento = $riadokPercenta['percenta'];
                            echo $percento.'% , ';
                        }
                        while($riadokPriemer = mysqli_fetch_array($vysledokPriemer)){
                            $priemer = round($riadokPriemer['priemer'],2);
                        }
                        echo "</td><td>$priemer%</td></tr>";
                    }
                ?>  
            </table>
        </div>
</body>
</html>