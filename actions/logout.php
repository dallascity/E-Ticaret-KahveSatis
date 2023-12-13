<?php 
try{
    session_start();
    ob_start();
    setcookie("cookie", "", time() - 3600, "/ttcase");
    session_destroy();
     header("location: ../login.php");
    exit;
    }
     catch (Exception $e) {
      echo $e->getMessage();
    }
?>