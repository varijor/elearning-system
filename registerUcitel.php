<?php 
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once './main/head.php'?>
    <title>Registrovanie ako učiteľ</title>
    <link rel="stylesheet" href="./css/login.css">
    <link rel="stylesheet" href="./css/reset.css">
    <script src="./js/verify.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css"/>
    <script src="./js/tel.js"></script>
</head>
<body>
    <center><div class="container registerUcitel">
        <h2>Registrácia učiteľa</h2>
            <form action="./main/regUcitel.php" method="post" id="regucitel" onsubmit="event.preventDefault(); verifyRegTeacher();">
                <div>
                    <input type="text" id="regusername" placeholder="Prihlasovacie meno" name="username" value="<?php if(isset($_SESSION['username'])){echo $_SESSION['username'];}?>" required/>
                    <label for="regusername" class="hidden" id="hidden-username">5-15 písmen (bez znakov, čísel)</label>
              
                    <input type="text" id="pred" placeholder="Titul pred menom" name="titlefront" value="<?php if(isset($_SESSION['titlefront'])){echo $_SESSION['titlefront'];}?>"/>
                    <label for="pred" class="hidden" id="hidden-titlefront"></label>
                    
                    <input type="text" id="name" placeholder="Meno" name="name" value="<?php if(isset($_SESSION['name'])){echo $_SESSION['name'];}?>" required/>
                    <label for="name" class="hidden" id="hidden-name">3-14 písmen (bez znakov, čísel)</label>
                    
                    <input type="text" id="surname" placeholder="Priezvisko" name="surname" value="<?php if(isset($_SESSION['surname'])){echo $_SESSION['surname'];}?>" required />
                    <label for="surname" class="hidden" id="hidden-surname">3-14 písmen (bez znakov, čísel)</label>
                
                    <input type="text" id="za" placeholder="Titul za menom" name="titleback" value="<?php if(isset($_SESSION['titleback'])){echo $_SESSION['titleback'];}?>"/>
                    <label for="za" class="hidden" id="hidden-titleback"></label>

                    <input type="text" id="school" placeholder="Škola" name="school" value="<?php if(isset($_SESSION['school'])){echo $_SESSION['school'];}?>" required/>
                    <label for="school" class="hidden" id="hidden-school">Celý názov školy</label>

                    <input id="phone" type="tel" name="phone" pattern="[0-9]{10}" value="<?php if(isset($_SESSION['phone'])){echo $_SESSION['phone'];}?>" required/>

                    <input type="email" id="email" placeholder="Email" name="email" value="<?php if(isset($_SESSION['email'])){echo $_SESSION['email'];}?>" onchange="verifyEmail()" required/>
                    <label for="email" class="hidden" id="hidden-email">Platný email (x@x.x)</label>
                
                    <input type="password" id="regpassword" placeholder="Heslo 8-14 znakov" name="regpassword" required/>
                    <label for="password" class="hidden" id="hidden-password">Heslo 6-14 znakov</label>
                
                    <input type="password" id="znovaregpassword" placeholder="Znova zadaj heslo" name="znovaregpassword" required/>
                    <label for="znovaregpassword" class="hidden" id="hidden-password-again">Heslá sa nezhodujú!</label>
                </div>

                <button id="signUp">Registrovať</button>
                <?php 
                    echo '<a href="'.$_SESSION['link'].'">Späť na prihlasovanie</a>';
                ?>
            </form>
    </div></center>


    <script>
        const phoneInputField = document.querySelector("#phone");
        const phoneInput = window.intlTelInput(phoneInputField, {
            utilsScript:"./js/utilstel.js",});
      </script>
</body>
</html>