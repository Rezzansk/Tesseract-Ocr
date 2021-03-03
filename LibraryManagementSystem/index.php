<?php
session_start();
?>

<html>
<head>
   
  <title>Kutuphane Otomasyon</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="stil.css">
 </head>

  <?php
    include("db_baglan.php");
  ?>
  
<div class="kullanici">
<?php 
if(isset($_SESSION['zaman'])==1)
{
  echo $_SESSION['tarih'];
}
else
{
  echo date("Y-m-d");
}
?> 
</div>
 <body>

 <div class="login">    <!-- https://codepen.io/ sitesinden alınma -->

	<h1>Kütüphane Paneli</h1>
    <form method="post" action="">
    	<input type="text" name="username" placeholder="Kullanıcı Adı" required="required" />
        <input type="password" name="password" placeholder="Şifre" required="required" />
        <button type="submit"  name="commit" class="btn btn-primary btn-block btn-large">Kullanıcı Girişi</button>
        <br>
        <button type="submit_2" name="commit_2"  class="btn btn-primary btn-block btn-large">Yönetici Girişi</button>
    </form>
  <?php
    if(isset($_POST["commit"])){

      $isim = $_POST["username"];
      $password = $_POST["password"];
      $login = $conn->prepare("SELECT *FROM kullanici WHERE isim='$isim' AND sifre='$password'");
      $login->execute(array($isim, $password));
      
      if($login->rowCount())
      {
        $_SESSION['username']=$_POST["username"];
        $results = $login->fetch();
        $_SESSION['kullanici_id']=$results['id'];
        header ("Location:kullanici.php");
      }
      else
      {
        echo "Giriş başarısız. Lütfen giriş bilgilerinizi kontrol edip tekrar deneyiniz.";
      }  
    }

    if(isset($_POST["commit_2"])){

      $isim = $_POST["username"];
      $password = $_POST["password"];

      $login = $conn->prepare("SELECT *FROM yonetici WHERE isim='$isim' AND sifre='$password'");
      $login->execute(array($isim, $password));

      if($login->rowCount())
      {
        $_SESSION['username']=$_POST["username"];
        header ("Location:yonetici.php");
      }
      else
      {
        echo "Giriş başarısız. Lütfen giriş bilgilerinizi kontrol edip tekrar deneyiniz.";
      }
    }
  ?>


</div>

</div>
</body>
</html>
