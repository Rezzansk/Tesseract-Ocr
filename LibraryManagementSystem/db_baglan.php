<?php
    $server="localhost";
    $username="root";
    $password="";
    $dbname="db_kutup";

    try{
      $conn = new PDO("mysql:host=$server; dbname=$dbname;",$username,$password);
      $conn ->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
      echo"Veritabanına başarıyla bağlandı.";
    }
    catch(PDOException $e){
      echo "Hata: ".$e->getMessage();
    }
?>