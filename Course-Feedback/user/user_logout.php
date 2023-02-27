<?php
  session_start();
  session_unset();
  
  print_r($_SESSION);
  header("Location: /../home.php");
  exit();
?>