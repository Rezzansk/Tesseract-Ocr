<?php
session_start();
?>
<!DOCTYPE html>

<head>
  <title>Yonetici Paneli</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src='https://unpkg.com/tesseract.js@v2.0.2/dist/tesseract.min.js'></script>

  <link rel="stylesheet" type="text/css" href="stil.css">
  <?php
    include("db_baglan.php");
  ?>
  <div class="kullanici"> Yonetici: <?php echo $_SESSION['username']; ?> </div>
    
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
  ?> </div>

  <script type="text/javascript" src="isleme.js" defer></script>
  <br>
  <br>
</head>
<body>

<h2>Yonetici Paneli</h2>
<div class="warpper">
  <input class="radio" id="one" name="group" type="radio" checked>
  <input class="radio" id="two" name="group" type="radio">
  <input class="radio" id="three" name="group" type="radio">
  <div class="tabs">
  <label class="tab" id="one-tab" for="one">Kitap Ekle</label>
  <label class="tab" id="two-tab" for="two">Zaman Atla</label>
  <label class="tab" id="three-tab" for="three">Kullanıcı Listeleme</label>
    </div>
  <div class="panels">
  <div class="panel" id="one-panel">
    <form method="POST">
      <div class="panel-title">Kitabın Bilgilerin Giriniz</div>
      <input type="text" name="Kitap" placeholder="Kitap İsmi">
      <input type="text" name="Yazar" placeholder="Yazar İsmi">
      <input type='file' onchange='dosyaoku(event)'>
      <div class="kullanici">FOTOĞRAFI YÜKLEDİKTEN SONRA ISBN KODU EKRANDA GÖZÜKENE KADAR "Kitap Ekle" BUTONUNA BASMAYINIZ.</div>
      <button type="submit"  name="commit" class="btn-hover btn-large">Kitap Ekle</button>

      <br>
        <?php
            if(isset($_POST["commit"])){

              $Kitap = $_POST["Kitap"];
              $Yazar = $_POST["Yazar"];
              $ISBN = $_COOKIE['isbn_kodu'];
              $ekle = $conn->prepare("INSERT INTO kitap SET ismi=?, isbn=?, yazar=?"); 
              $ekle->execute(array("$Kitap","$ISBN","$Yazar")); 
            }

        ?>

    </form>
  </div>
  <div class="panel" id="two-panel">
  <form method="POST">
    <div class="panel-title">Zaman Atla</div>
    <hr>
    <button type="submit"  name="commit_5" class="btn-hover btn-large">20 Gün Zaman Atla</button>
    <br>
    <button type="submit"  name="commit_6" class="btn-hover btn-large">Günümüze Dön</button>
    <hr>
    <?php
    if(isset($_POST["commit_5"])){

      $tarih=date("Y-m-d", strtotime("+20 day"));
      $_SESSION['tarih']=$tarih;
      $_SESSION['zaman']=1;
    }
    if(isset($_POST["commit_6"]))
    {
      $tarih=date("Y-m-d");
      $_SESSION['tarih']=$tarih;
      $_SESSION['zaman']=0;
    }
  
    ?>

</form>
  </div>
  <div class="panel" id="three-panel">
    <div class="panel-title">Kullanıcı Listesi</div>
    <p>
      <?php
        $tablo=$conn->prepare("SELECT *FROM kullanici");
        $tablo->execute();

        foreach($tablo as $yazdir)
        {
              echo "<hr>".$yazdir["id"].". Kullancı Adi: ".$yazdir["isim"];  
              $arama = $yazdir["id"];
              $arama_cubugu = $conn->prepare("SELECT * FROM sahip WHERE id LIKE ? "); 
              $arama_cubugu->bindValue(1, "$arama");
              $arama_cubugu->execute(); 
              $results = $arama_cubugu->fetch();
              echo "  (Kitap Sayısı: ".$results['sayisi'].")";
              echo "<br>ISBN: ".$results['isbn_1']."  || ".$results['isbn_2']."  || ".$results['isbn_3'];
        }       

      ?>
    </p>
  </div>
  </div>
  <a class="tab" id="cikis" href="cikis.php">Çıkış Yap</a>
</div>

</body>
</html>