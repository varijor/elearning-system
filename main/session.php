<?php

session_start();

if(!isset($_SESSION['use'])) // If session is not set then redirect to Login Page
   {
       header("Location:https://elearning-system.eu");  
   }

if ($_SERVER['SERVER_ADMIN'] == 'hostmaster@hostcreators.sk'){
    $_SESSION['link'] = 'https://elearning-system.eu/';
} else {
    $_SESSION['link'] = 'http://localhost/elearning%20system/';
} 
?>