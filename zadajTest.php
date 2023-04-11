<?php   
    session_start();

    if(!isset($_SESSION['use'])) // If session is not set then redirect to Login Page
    {
        header("Location:".$_SESSION['link']);
    }
    if($_SESSION['acc']==0)
    {
        header("Location:".$_SESSION['link']."domov");
    }
       
    include './main/db.php';
?>

<!DOCTYPE html>
<html lang="sk">
<head>
    <link rel="stylesheet" href="css/domov.css">
    <link rel="stylesheet" href="css/testy.css">
    <?php include './main/head.php'?>
    <title>Zadávanie testu</title>
</head>
<body>
    <?php include_once './main/header.php' ?>
    <div id="container">
        <h2>Vytvorenie testu</h2>
        <form id="myForm" method="post" action="./main/form.php">
            <div id="wrapper">
                <div class="box active">
                    <div class="inputs">
                        <h3>Nastavenie</h3>
                        <label for="predmet">Vyber predmet:</label>
                        <select name="predmet" id="predmet">
                            <?php 
                                $sql1 = "SELECT * FROM predmety ";
                                $result1 = mysqli_query($connection,$sql1);
                                while($row1 = mysqli_fetch_array($result1)){
                                    $value1 = $row1['skratka'];
                                    $nazov1 = $row1['nazovPredmetu'];
                                    echo '<option value="'.$value1.'">'.$nazov1.'</option>';
                                } 
                            ?>
                        </select>
                        <label for="tema">Vyber tému:</label>
                        <select name="tema" id="tema">
                            <?php 
                                $sql2 = "SELECT * FROM temy ";
                                $result2 = mysqli_query($connection,$sql2);
                                while($row2 = mysqli_fetch_array($result2)){
                                    $value2 = $row2['idTemy'];
                                    $nazov2 = $row2['nazovTemy'];
                                    echo '<option value="'.$value2.'">'.$nazov2.'</option>';
                                } 
                            ?>
                        </select>
                        <label for="rocnik">Vyber ročník:</label>
                        <select name="rocnik" id="rocnik">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                        </select>
                        <input class="ins" type="text" placeholder="Názov testu" name="nazovTestu">
                        <br>
                        <h6>Vymazanie otázky znamená že posledná otázka sa vymaže!</h6>
                    </div>
                </div>
            </div>

           <!-- <br>
            
            <label for="typeOfQuestion">Vyber typ ďaľšej otázky:</label>
            <select name="typeOfQuestion" id="typeOfQuestion">
                <option value="anoNie">Áno / Nie</option>
                <option value="spajanie">Spájanie</option>
                <option value="doplnovacka">Doplňovanie</option>
                <option value="iy">I / y</option>
            </select> 
            <br>-->
            <div class="buttons">
                <button type="button" onclick="prevQuestion()" class="basic">Späť</button>
                <button type="button" onclick="nextQuestion()" class="basic">Ďalej</button>
                <div class="hidden-buttons">
                    <br>
                    <button type="button" onclick="removeQuestion()" class="red">Vymazať otázku</button>
                    <br>
                    <button type="submit" id="submit-btn">Hotovo</button>
                </div>
            </div>
        </form>
    </div>
    <script src="./js/testy.js"></script>
</body>
</html>