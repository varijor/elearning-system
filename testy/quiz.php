<?php 
    include '../main/session.php';
    include '../main/db.php';
    $username = $_SESSION['use'];

    // $test = $_GET['test'];

    // $sql= "SELECT test_Id,username FROM percenta ";
    // $result = mysqli_query($connection,$sql);
    // while($riadok = mysqli_fetch_array($result)){
    //     $test_Id = $riadok['test_Id'];
    //     $usernames = $riadok['username'];
    //     if ($test == $test_Id && $username == $usernames) {
    //         echo '<script type="text/javascript">'; 
    //         echo 'alert("Tento test si už robil!");'; 
    //         echo 'window.location.href = "testy";';
    //         echo '</script>';
    //     }
    // }
    // $sql = "SELECT nazovTestu FROM testy WHERE idTestu='$test'";
    // $result = mysqli_query($connection,$sql);
    // while($riadok = mysqli_fetch_array($result)){
    //     $nazovTestu = $riadok['nazovTestu'];
    // }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="shortcut icon" href="../pictures/sos_it_logo.png">
    <title>TEST</title>
    <link rel="stylesheet" href="quiz.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js" integrity="sha512-3P8rXCuGJdNZOnUx/03c1jOTnMn3rP63nBip5gOP2qmUh5YAdVAvFZ1E+QLZZbC1rtMrQb+mah3AfYW11RUrWA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>
    <!-- button na štart -->
    <div class="start_btn"><button>Začať test</button></div>

    <!-- pravidla = rules-->
    <div class="info_box">
        <div class="info-title"><span>Pravidlá tohto testu</span></div>
        <div class="info-list">
            <div class="info">1. Máš <span>45 sekúnd</span> na každú otázku.</div>
            <div class="info">2. Na test máš len <span>1 pokus.</span></div>
            <div class="info">3. Body máš len za správne odpovede.</div>
            <div class="info">4. Ak ti vyprší čas, nedostaneš bod.</div>
        </div>
        <div class="buttons">
            <?php 
                echo '<button class="back" onclick="window.location.href=\''.$_SESSION['link'].'testy/testy\'">Zrušiť test</button>';
            ?>
            <button class="quit" >Späť</button>
            <button class="restart">Pokračovať</button>
        </div>
    </div>

    <!-- samotny box na test -->
    <div class="quiz_box">
        <header>
            <div class="title">Test <?php if(isset($nazovTestu)){echo $nazovTestu;}?></div>
            <div class="timer">
                <div class="time_left_txt">Zostavajúci čas</div>
                <div class="timer_sec">45</div>
            </div>
        </header>
        
        <section>
            <div class="que_text"></div>
            <div class="option_list"></div>
        </section>

        <footer>
            <div class="total_que">
            </div>
            <button class="next_btn">Dalšia otázka</button>
        </footer>
    </div>


    <!-- odpovede Box -->
    <div class="center">
        <div class="result_box">
            <div class="complete_text">Dorobil si test, počkaj na vyhodnotenie!</div>
            <div class="score_text"></div>
            <div class="score_textPER"></div>
            <div class="buttons">
                <button class="restart">Opakovať test</button>
                <?php 
                echo '<a href="'.$_SESSION['link'].'testy/testy"><button class="quit">Zrušiť test</button></a>';
                ?>
            </div>

            <div class="answers">
                <h3 onclick="showAnswers()"> Zobraziť výsledky <i class='fas fa-angle-right show'></i></h3>
                <div class="answersList">
                    <div class="popup">
                        
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="js/script.js"></script>

</body>
</html>