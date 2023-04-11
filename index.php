<?php session_start();

if ($_SERVER['SERVER_ADMIN'] == 'hostmaster@hostcreators.sk'){
    $_SESSION['link'] = 'https://elearning-system.eu/';
} else {
    $_SESSION['link'] = 'http://localhost/elearning%20system/';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Prihlásenie/Registrácia</title>
    <?php include_once './main/head.php'?>
    <link rel="stylesheet" href="./css/login.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="./js/verify.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css"/>
    <script src="./js/tel.js"></script>
</head>
<body>
    <div class="container login" id="container">
        <div class="form-container sign-up-container">
            <form action="./main/reg.php" method="post" id="regform" onsubmit="event.preventDefault(); verifyReg();">
                <h1>Vytvoriť účet</h1>

                <input type="text" id="regusername" placeholder="Prihlasovacie meno" name="regusername" value="<?php if(isset($_SESSION['username'])){echo $_SESSION['username'];}?>" required/>
                <label for="regusername" class="hidden" id="hidden-username">6-12 znakov</label>

                <input type="text" id="name" placeholder="Tvoje meno" name="name" value="<?php if(isset($_SESSION['name'])){echo $_SESSION['name'];}?>" required/>
                <label for="name" class="hidden" id="hidden-name">3-14 znakov</label>

                <input type="text" id="surname" placeholder="Tvoje priezvisko" name="surname" value="<?php if(isset($_SESSION['surname'])){echo $_SESSION['surname'];}?>" required/>
                <label for="surname" class="hidden" id="hidden-surname">3-14 znakov</label>

                <input id="phone" type="tel" name="phone" pattern="[0-9]{10}" value="<?php if(isset($_SESSION['phone'])){echo $_SESSION['phone'];}?>" required/>

                <input type="email" id="email" placeholder="Email" name="email" required onchange="verifyEmail()" value="<?php if(isset($_SESSION['email'])){echo $_SESSION['email'];}?>" />
                <label for="email" class="hidden" id="hidden-email">Platný email (xxx@xxx.xxx)</label>
                
                <input type="password" id="regpassword" placeholder="Heslo 6-14 znakov" name="regpassword" required/>
                <label for="password" class="hidden" id="hidden-password">Heslo 6-14 znakov</label>
                
                <input type="password" id="znovaregpassword" placeholder="Znova zadaj heslo" name="znovaregpassword" required/>
                <label for="znovaregpassword" class="hidden" id="hidden-password-again">Heslá sa nezhodujú!</label>

                <button id="SignUp">Registrovať</button>
            </form>
        </div>
        <div class="form-container sign-in-container">
            <form action="./main/login.php" method="post">
                <h1>Prihlásiť sa</h1>
                <input type="text" id="logusername" placeholder="Prihlasovacie meno" name="logusername" required/>
                <input type="password" id="logpassword" placeholder="Heslo" name="logpassword" required/>
                <a href="resetRequest.php">Zabudnuté heslo?</a>
                <button id="SignIn" role="button" type="submit" formmethod="POST" name="submit">Prihlásiť</button>
            </form>
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Vitaj späť!</h1>
                    <p>Aby si sa dostal ďalej, prihlás sa:</p>
                    <button class="ghost" id="signIn">Prihlásiť sa</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Ešte nie si registrovaný?</h1>
                    <p>Vyplň registračný formulár a objav náš svet:</p>
                    <button class="ghost" id="signUp">Registrovať</button>
                    <a href="registerUcitel">Registrovať sa ako učiteľ</a>
                </div>
            </div>
        </div>
    </div>
    <h1 id="hideme">x</h1>
    <script>
    const phoneInputField = document.querySelector("#phone");
    const phoneInput = window.intlTelInput(phoneInputField, {
        utilsScript:"./js/utilstel.js",});
    </script>
</body>
</html>