<nav class="navbar">
    <script id="import" src="./js/header.js"></script>
    
    <label for="btn" class="icon">
        <span class="fa fa-bars"></span>
    </label>
    <?php
        echo '<div class="logo" onclick="location.href=\''.$_SESSION['link'].'domov\';">E-learning <span>System</span></div>';
    ?>
    <div class="list">
     <input type="checkbox" id="btn">
     <ul>
        <?php 
            echo '<li><a href="'.$_SESSION['link'].'domov#home">Domov</a></li>';
            echo '<li><a href="'.$_SESSION['link'].'domov#tests">Testy</a></li>';
            echo '<li><a href="'.$_SESSION['link'].'domov#about">O nás</a></li>';
            echo '<li><a href="'.$_SESSION['link'].'domov#contact">Kontakt</a></li>';
        ?>
        <li>
           <label for="btn-5" class="show">Môj účet ↓</label>
            <a href="#">Môj účet ↓</a>
            <input type="checkbox" id="btn-5">
            <ul>
                <?php
                    echo '<li><a href="'.$_SESSION['link'].'editProfile">Upraviť profil</a></li>';
                    echo '<li><a href="'.$_SESSION['link'].'editPassword">Zmeniť heslo</a></li>';
                    echo '<li><a href="'.$_SESSION['link'].'testy/testy">Všetky testy</a></li>';
                    echo '<li><a href="'.$_SESSION['link'].'testy/znamky">Výsledky</a></li>';
               
                    $accType = $_SESSION['acc'];
                    if($accType == 1 or $accType == 2){
                    echo '<li><a href=\''.$_SESSION['link'].'zadajTest\'>Vytvoriť test</a></li>';
                    }
                    echo '<li><a href=\''.$_SESSION['link'].'main/logout\'>Odhlásiť sa</a></li>';
               ?>
            </ul>
        </li>
     </ul>
    </div>
</nav>