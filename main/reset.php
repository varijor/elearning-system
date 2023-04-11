<?php 
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

include 'db.php';

$sql= "SELECT username FROM users";
$result = mysqli_query($connection,$sql);
while($row = mysqli_fetch_array($result)){
    $usernames[]=$row[0];
}

$sql2= "SELECT username FROM teachers";
$result2 = mysqli_query($connection,$sql2);
while($row2 = mysqli_fetch_array($result2)){
    $usernames2[]=$row2[0];
}


function send_reset_password($get_name,$get_email,$token){
    $mail = new PHPMailer(true);
    try {
        //server setup
        $mail->SMTPDebug = 2;									
        $mail->isSMTP();											
        $mail->Host = "ssl://smtp.googlemail.com";				
        $mail->SMTPAuth = true;							
        $mail->Username   = "sids6fsk@gmail.com";
        $mail->Password   = "axlixqocgzuzwhmu";						
        $mail->SMTPSecure = 'ssl';	
        $mail->Port	 = 465;
    
        //Recipients
        $mail->setFrom('sids6fsk@gmail.com', 'E-Learning System');
        $mail->addAddress($get_email);
        //$mail->addReplyTo('info@example.com', 'Information');
    
        $body = "
        <h2>Ahoj, <br> $get_name</h2>
        <h3>Tento mail je automaticky vygenerovaný lebo sme dostali požiadavku na obnovenie hesla pre váš účet.</h3>
        <br>
        <a href='https://elearning-system.eu/resetPassword.php?token=$token&email=$get_email'>Stlač na presmerovanie</a>
        <br> <br>
        <p>V prípade že tento link nefunguje skúste tento:</p>
        <p> https://elearning-system.eu/resetPassword.php?token=$token&email=$get_email </p>
        ";
    
        //Content
        $mail->isHTML(true);
        $mail->Subject = "Resetovanie Hesla";
        $mail->Body = $body;
    
        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
    }
}

if(isset($_POST['submit-email'])){
    $email = mysqli_real_escape_string($connection,$_POST["email"]);
    $token = md5(rand());

    $check_email= "SELECT * FROM users WHERE email='$email' LIMIT 1" ;
    $check_email_teachers = "SELECT * FROM teachers WHERE email='$email' LIMIT 1" ;
    $check_email_run = mysqli_query($connection,$check_email);
    $check_email_run_teachers = mysqli_query($connection,$check_email_teachers);

    if(mysqli_num_rows($check_email_run)>0){

        $sql= "SELECT * FROM users WHERE email='$email'";
        $result = mysqli_query($connection,$sql);
        $row = mysqli_fetch_array($result);
        $name = $row['name'].' '.$row['surname'];

        $update_token = "UPDATE users SET token='$token' WHERE email='$email' " ;
        $update_token_run = mysqli_query($connection,$update_token);

        if($update_token_run){
            send_reset_password($name,$email,$token);
            $_SESSION['message'] = 'Poslali sme ti email s linkom na resetovanie hesla.';
            header("Location: ../resetRequest");
            exit(0);
        } else {
            $_SESSION['message'] = 'Niečo sa pokazilo!';
            header("Location: ../resetRequest");
            exit(0);
        }

    } else {
        if(mysqli_num_rows($check_email_run_teachers)>0){
    
            $sql= "SELECT * FROM teachers WHERE email='$email'";
            $result = mysqli_query($connection,$sql);
            $row = mysqli_fetch_array($result);
            $name = $row['name'].' '.$row['surname'];
    
            $update_token = "UPDATE teachers SET token='$token' WHERE email='$email' " ;
            $update_token_run = mysqli_query($connection,$update_token);
    
            if($update_token_run){
                send_reset_password($name,$email,$token);
                $_SESSION['message'] = 'Poslali sme ti email s linkom na resetovanie hesla.';
                header("Location: ../resetRequest");
                exit(0);
            } else {
                $_SESSION['message'] = 'Niečo sa pokazilo!';
                header("Location: ../resetRequest");
                exit(0);
            }
    
        } else {
             $_SESSION['message'] = 'Nenašiel sa váš email! Skúste znova.';
             header("Location: ../resetRequest");
             exit(0);
        }
    }
}

if(isset($_POST['submit-password'])){
    $email = mysqli_real_escape_string($connection,$_POST["email"]);
    $newpassword = mysqli_real_escape_string($connection,$_POST["new-password"]);
    $newpassword_confirm = mysqli_real_escape_string($connection,$_POST["new-password-confirm"]);
    $token = mysqli_real_escape_string($connection,$_POST["token"]);
    if(!empty($token)){
        if(!empty($newpassword)&& !empty($newpassword_confirm) && !empty($email)){
            $check_token = "SELECT token FROM users WHERE token='$token'";
            $check_token_teachers = "SELECT token FROM teachers WHERE token='$token'";
            $check_token_run = mysqli_query($connection,$check_token);
            $check_token_run_teachers = mysqli_query($connection,$check_token_teachers);

            if(mysqli_num_rows($check_token_run)>0){
                if($newpassword == $newpassword_confirm){
                    $hashed_password=password_hash($newpassword,PASSWORD_DEFAULT);
                    $update_password = "UPDATE users SET password='$hashed_password' WHERE token='$token' LIMIT 1";
                    $update_password_run = mysqli_query($connection,$update_password);

                    if($update_password_run){
                        $new_token = md5(rand());
                        $update_new_token = "UPDATE users SET token='$new_token' WHERE token='$token' LIMIT 1";
                        $update_new_token_run = mysqli_query($connection,$update_new_token);
                        if($update_new_token_run) {
                            echo '<script type="text/javascript">'; 
                            echo 'alert("Heslo bolo úspešne zmenené!");';
                            echo 'window.location.href = "../index";';
                            echo '</script>';
                            exit(0);
                        } else {
                            $_SESSION['message'] = 'Heslo sa nepodarilo zmeniť!';
                            header("Location: ../resetPassword?token=$token&email=$email");
                            exit(0);
                        }
                    }else{
                        $_SESSION['message'] = 'Heslo sa nepodarilo zmeniť!';
                        header("Location: ../resetPassword?token=$token&email=$email");
                        exit(0);
                    }
                } else {
                    $_SESSION['message'] = 'Heslá sa nezhodujú! Skúste znova.';
                    header("Location: ../resetPassword?token=$token&email=$email");
                    exit(0);
                }
            } else {
               if(mysqli_num_rows($check_token_run_teachers)>0){
                if($newpassword == $newpassword_confirm){
                    $hashed_password=password_hash($newpassword,PASSWORD_DEFAULT);
                    $update_password = "UPDATE teachers SET password='$hashed_password' WHERE token='$token' LIMIT 1";
                    $update_password_run = mysqli_query($connection,$update_password);

                    if($update_password_run){
                        $new_token = md5(rand());
                        $update_new_token = "UPDATE teachers SET token='$new_token' WHERE token='$token' LIMIT 1";
                        $update_new_token_run = mysqli_query($connection,$update_new_token);
                        if($update_new_token_run) {
                            echo '<script type="text/javascript">'; 
                            echo 'alert("Heslo bolo úspešne zmenené!");';
                            echo 'window.location.href = "../index";';
                            echo '</script>';
                            exit(0);
                        } else {
                            $_SESSION['message'] = 'Heslo sa nepodarilo zmeniť!';
                            header("Location: ../resetPassword?token=$token&email=$email");
                            exit(0);
                        }

                    }else{
                        echo "asasdsadada";
                        $_SESSION['message'] = 'Heslo sa nepodarilo zmeniť!';
                        header("Location: ../resetPassword?token=$token&email=$email");
                        exit(0);
                    }

                } else {
                    $_SESSION['message'] = 'Heslá sa nezhodujú! Skúste znova.';
                    header("Location: ../resetPassword?token=$token&email=$email");
                    exit(0);
                }
            } else {
                $_SESSION['message'] = 'Neplatný token! Skúste otvoriť link znova!';
                header("Location: ../resetPassword?token=$token&email=$email");
                exit(0);
                }
            }
        } else {
            $_SESSION['message'] = 'Neboli vyplnené všetky inputy!';
            header("Location: ../resetPassword?token=$token&email=$email");
            exit(0);
        }
    } else {
        $_SESSION['message'] = 'Nedá sa získať token!';
        header("Location: resetRequest");
        exit(0);
    }
}
?>