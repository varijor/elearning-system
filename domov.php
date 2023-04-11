<?php   
    include './main/session.php';
    include './main/db.php';
?>

<!DOCTYPE html>
<html lang="sk" dir="ltr">
    <head>
        <title>Domov</title>
        <?php include_once './main/head.php'?>
        <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
        <link rel="stylesheet" href="./css/domov.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    </head>
   <body>
      <?php include_once './main/header.php' ?>
      <!--domov-->
      <section class="home" id="home">
        <div class="content">
           <!-- <h1><a href="https://forms.gle/57ENk1mzh5TmLBwB7" target="_blank">Vyplňte formulár</a></h1>-->
            
           <div class="text-1">Čo je E-learning alebo online vzdelávanie?</div>
            <div class="text-2">
                <p>„E-Learning“ predstavuje najmodernejší spôsob výučby na akomkoľvek digitálnom zariadení. 
                Je to implementácia informačných technológií do vývoja, distribúcie a riadenia vzdelávania alebo výučby.
                </p>
                <p>
                E-learning umožňuje študentom prístup k širokému spektru online kurzov a materiálov, ktoré sú k dispozícii na internete. 
                Tieto materiály môžu zahŕňať video lekcie, interaktívne hry a testy, ako aj príručky a návody na riešenie konkrétnych problémov.
                </p>
                <p>
                Celkovo je však e-learning stále veľmi prospešný pre mnohých študentov, ktorí hľadajú nové a inovatívne spôsoby vzdelávania, ktoré im umožnia získať nové vedomosti
                </p>
            </div>
        </div>
      </section>

    <section class="tests" id="tests">
        <h2 class="title">Testy</h2>
        <div class="content">
        <div class="swiper mySwiper container">
            <div class="swiper-wrapper content">
            <?php 
                $i = 0;
                $selectTesty = "SELECT * FROM testy";
                $vysledokTesty = mysqli_query($connection,$selectTesty);
                while(($riadokTesty = mysqli_fetch_array($vysledokTesty))){
                    if($i==6){
                        break;
                    }
                    $i++;
                    $nazovTestu = $riadokTesty['nazovTestu'];
                    $prislusnostTestu = $riadokTesty['prislusnostTestu'];
                    $idTestu = $riadokTesty['idTestu'];
                    $username = $riadokTesty['creator'];
                    $rocnik = $riadokTesty['rocnik'];
                    $selectTemy = "SELECT * FROM temy WHERE idTemy='$prislusnostTestu'";
                    $vysledokTemy = mysqli_query($connection,$selectTemy);
                    $riadokTemy = mysqli_fetch_array($vysledokTemy);
                    $nazovTemy = $riadokTemy['nazovTemy'];
                    $selectTeachers = "SELECT * FROM teachers WHERE username='$username'";
                    $vysledokTeachers = mysqli_query($connection,$selectTeachers);
                    $riadokTeachers = mysqli_fetch_array($vysledokTeachers);
                    $name = $riadokTeachers['name'];
                    $surname = $riadokTeachers['surname'];
                    $autor = $name.' '.$surname;
                    echo '<div class="swiper-slide card">
                        <div class="card-content">
                            <div class="name">
                            <span class="testTitle">'.$nazovTestu.'</span>
                            <span class="description">'.$nazovTemy.'</span>
                        </div>
                            <div class="rating">
                            <span class="rocnik">Test pre '.$rocnik.'. ročník</span>
                            </div>
                            <div class="button">
                                <form action="./testy/quiz.php" method="get">
                                <input type="hidden" name="test" value="'.$idTestu.'">
                                <button class="aboutMe" type="submit">Spustiť Test</button>
                                </form>
                            </div>
                        </div>
                    </div>';
                } 
            ?>
            </div>
        <div class="swiper-pagination"></div>
        </div>
        </div>
        <center>
            <div class="button">
                <?php 
                    echo '<button class="aboutMe" id="vsetkyTesty" onclick="window.location.href=\''.$_SESSION['link'].'testy/testy.php \'">Zobraziť všetky testy</button>';
                ?>
            </div>
        </center>
    </section>

    <!-- Swiper JS -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

    <!-- Initialize Swiper -->
    <script src="./js/slider.js"></script>

    <section class="about" id="about">
        <h2 class="title">O <span> nás</span></h2>
        <div class="content">
            <div class="column left">
                <img src="./pictures/profile.jpeg" alt="">
                <div class="text">Samuel Chovanec</div>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nam iure quo dolore corrupti commodi quidem, 
                    tempore debitis amet necessitatibus, asperiores reiciendis quisquam voluptas enim, laboriosam quam sequi repudiandae 
                    omnis! Velit, ab libero. Obcaecati ullam minima ea laudantium architecto, illo quae, sint reprehenderit voluptate, quam 
                    tenetur officia porro sequi dignissimos? Maiores!
                </p>
                </div>
            <div class="column right">
                <img src="./pictures/profile.jpeg" alt="">
                <div class="text"> Roman Kuriš</div>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nam iure quo dolore corrupti commodi quidem, tempore debitis amet 
                    necessitatibus, asperiores reiciendis quisquam voluptas enim, laboriosam quam sequi repudiandae omnis! Velit, ab libero. 
                    Obcaecati ullam minima ea laudantium architecto, illo quae, sint reprehenderit voluptate, quam tenetur officia porro sequi dignissimos? Maiores!
                </p>
                </div>
            </div>
        </div>
    </section>

    <section class="contact" id="contact">
        <h2 class="title">Kontakt</h2>
        <div class="content">
            <div class="column left">
                <h4 class="second-title">Ak máte nejaké otázky, napíšte nám!</h4>
                <img src="pictures/contact.png" alt="Image" class="contact-img">
            </div>
            <div class="column right">
                <form action="#" method="post" id="contactForm">
                    <div class="fields">
                        <div class="field">
                            <input class="contact-inputs" type="text" placeholder="Vaše meno" required>
                        </div>
                        <div class="field">
                            <input class="contact-inputs" type="email" placeholder="Email" required>
                        </div>
                        <div class="field">
                            <input class="contact-inputs" type="text" placeholder="Predmet" required>
                        </div>
                        <div class="field">
                            <textarea class="contact-inputs" cols="30" rows="5" placeholder="Opíšte nám..." required></textarea>
                        </div>
                        <center>
                        <div class="field button">
                            <button type="submit">Odoslať</button>
                        </div>
                        </center>
                    </div>
                </form>
            </div>
        </div>
    </section>
      
      <?php include_once './main/footer.php' ?>
   </body>
</html>