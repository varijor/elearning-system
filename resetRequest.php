<!DOCTYPE html>
<html lang="en">
<head>
    <title>Požiadať o reset hesla</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/normalize.css">
    <link rel="stylesheet" href="./css/login.css">
    <link rel="shortcut icon" href="./pictures/sos_it_logo.png">
    <link rel="stylesheet" href="./css/reset.css">
</head>
<body>
    <?php 
        session_start();
        if(isset($_SESSION['message'])){
            ?>
            <div class="alert success">
                <h5><?= $_SESSION['message']; ?></h5>
            </div>
            <?php unset($_SESSION['message']);
        }    
    ?>

    <center><div class="container reset">
        <h2>Zadajte váš email</h2>
        <form action="./main/reset.php" method="post" id="editpass">
            <label class="inp">
                <input type="email" name="email" id="email" placeholder="Email" required>
            </label>
            <button role="button" type="submit" formmethod="POST" name="submit-email">Potvrdiť</button>
            <?php 
                echo '<a href="'.$_SESSION['link'].'">Späť na prihlasovanie</a>'
            ?>
        </form>
    </div></center>
</body>
</html>