<?php
session_start();

unset($_SESSION['username']);
unset($_SESSION['kullanici_id']);
//session_destroy();
header ("Location:index.php");

?>