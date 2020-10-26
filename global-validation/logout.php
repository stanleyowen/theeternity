<?php
   session_start();
   unset($_SESSION['username']);
   unset($_SESSION['role']);
   setcookie('sessionid-1',$cookie_value, time() - 3600,"/","000webhostapp.com",isset($_SERVER["HTTPS"]), true);
   setcookie('sessionid-2',$cookie_value, time() - 3600,"/","000webhostapp.com",isset($_SERVER["HTTPS"]), true);
   setcookie('sessionid-3',$cookie_value, time() - 3600,"/","000webhostapp.com",isset($_SERVER["HTTPS"]), true);
   if(session_destroy()) {
    header("Location: ../index.php");
   }
?>