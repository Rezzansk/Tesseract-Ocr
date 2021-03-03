<?php
session_start();
?>
<!DOCTYPE html>

<head>
  <title>Kullanıcı Paneli</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src='https://unpkg.com/tesseract.js@v2.0.2/dist/tesseract.min.js'></script>

  <link rel="stylesheet" type="text/css" href="stil.css">
  <script type="text/javascript" src="isleme.js" defer></script>
  
  <?php
    include("db_baglan.php");
  ?>
  <div class="kullanici"> Kullanıcı: <?php echo $_SESSION['username'];?> </div>
  <div class="kullanici"> ID: <?php echo $_SESSION['kullanici_id'];?> </div>
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
  <br>
  <br>
</head>
<body>

<h2>Kullanıcı Paneli</h2>
<div class="warpper">
  <input class="radio" id="one" name="group" type="radio" checked>
  <input class="radio" id="two" name="group" type="radio">
  <input class="radio" id="three" name="group" type="radio">
  <div class="tabs">

  <label class="tab" id="one-tab" for="one">Kitap Ara</label>
  <label class="tab" id="two-tab" for="two">Kitap Al</label>
  <label class="tab" id="three-tab" for="three">Kitap Teslim</label>
    </div>
  <div class="panels">
  <div class="panel" id="one-panel">
    <form method="POST">
      <div class="panel-title">Kitap İsmi & ISBN Yazınız</div>
      <input type="text" name="arama" placeholder="Arama Çubuğu">
      <button type="submit"  name="commit" class="btn-hover btn-large">Kitap İsmi Ara</button>
      <button type="submit"  name="commit_2" class="btn-hover btn-large">ISBN Ara</button>
      <br>
        <?php
            if(isset($_POST["commit"])){
              
              $arama = $_POST["arama"];
              $arama_cubugu = $conn->prepare("SELECT * FROM kitap WHERE ismi LIKE ? "); 
              $arama_cubugu->bindValue(1, "%$arama%");
              $arama_cubugu->execute(); 
              echo "<hr>";
              if($arama_cubugu->rowCount())
              {
                while ($results = $arama_cubugu->fetch())
                {
                    echo "<br>Kitap İsmi: ".$results['ismi'];
                    echo "<br>ISBN: ".$results['isbn']; 
                    echo "<hr>";
                }
              }
              else
              {
                    echo "Arama sonucu bulunamadı.";
                    echo "<hr>";
              }
            }
            if(isset($_POST["commit_2"]))
            {
              $arama = $_POST["arama"];
              $arama_cubugu = $conn->prepare("SELECT * FROM kitap WHERE isbn LIKE ? "); 
              $arama_cubugu->bindValue(1, "%$arama%");
              $arama_cubugu->execute(); 
              echo "<hr>";
              if($arama_cubugu->rowCount())
              {
                while ($results = $arama_cubugu->fetch())
                {
                  echo "<br>Kitap İsmi: ".$results['ismi'];
                  echo "<br>ISBN: ".$results['isbn']; 
                  echo "<hr>";
                }
              }
              else
              {
                    echo "Arama sonucu bulunamadı.";
                    echo "<hr>";
              }
            }
        ?>
    </form>
  </div>
  <form method="POST">
  <div class="panel" id="two-panel">
      <div style="font-weight:bold">Almak İstediğiniz Kitabın ISBN Kodunu Yazınız. Eğer bilmiyorsanız "Kitap Ara" kısmından öğrenebilirsiniz.</div>
      <input type="text" name="isbn_girisi" placeholder="ISBN Kodu Giriniz">
      <button type="submit"  name="commit_3" class="btn-hover btn-large">Kitap Al</button>
      <br>
        <?php
            if(isset($_POST["commit_3"]))
            {
                $isbn_girisi = $_POST["isbn_girisi"];
                $arama_kitap = $conn->prepare("SELECT *FROM kitap WHERE isbn LIKE ?"); 
                $arama_kitap->bindValue(1, "$isbn_girisi");
                $arama_kitap->execute(); 
                echo "<hr>";
                    if($arama_kitap->rowCount())
                    {
                            $sonuc_kitap = $arama_kitap->fetch();
                            echo "<br>Girdiniğiniz ISBN: ".$sonuc_kitap['isbn']."<br>";

                            if($sonuc_kitap['kullanim']==0)
                            {
                              $kullanici=$_SESSION['kullanici_id'];
                              $arama_kullanici = $conn->prepare("SELECT *FROM sahip WHERE id='$kullanici'");
                              $arama_kullanici->execute();
                              $sonuc_kullanici = $arama_kullanici->fetch();
                                    
                                    if(isset($_SESSION['zaman'])==1)
                                    {
                                      $sistem_tarihi=$_SESSION['tarih'];
                                    }
                                    else if(isset($_SESSION['zaman'])==0)
                                    {
                                      $sistem_tarihi=date("Y-m-d");
                                    }
                                    $date1=date_create($sistem_tarihi);
                                    $gecmis_kitap=0;
                                    if($sonuc_kullanici['isbn_1']!=0)
                                    {
                                      $teslim_tarihi_1=$sonuc_kullanici['tarih_1'];
                                      $date2_1=date_create($teslim_tarihi_1);
                                      $diff_1 = $date1->diff($date2_1);
                                      $diffDays_1= intval($diff_1->format("%d"));
                                      if($diffDays_1 > 7) 
                                      {
                                        $gecmis_kitap=$gecmis_kitap+1;
                                      }
                                    }
                                    if($sonuc_kullanici['isbn_2']!=0)
                                    {
                                      $teslim_tarihi_2=$sonuc_kullanici['tarih_2'];
                                      $date2_2=date_create($teslim_tarihi_2);
                                      $diff_2 = $date1->diff($date2_2);
                                      $diffDays_2= intval($diff_2->format("%d"));
                                      if($diffDays_2 > 7) 
                                      {
                                        $gecmis_kitap=$gecmis_kitap+1;
                                      }
                                    }
                                    if($sonuc_kullanici['isbn_3']!=0)
                                    {
                                      $teslim_tarihi_3=$sonuc_kullanici['tarih_3'];
                                      $date2_3=date_create($teslim_tarihi_3);
                                      $diff_3 = $date1->diff($date2_3);
                                      $diffDays_3= intval($diff_3->format("%d"));
                                      if($diffDays_3 > 7) 
                                      {
                                        $gecmis_kitap=$gecmis_kitap+1;
                                      }
                                    }
                              if($gecmis_kitap > 0) 
                              {
                                echo "<div class='kullanici'> TESLİM ETMENİZ GEREKEN KİTAPLAR MEVCUT. LÜTFEN TESLİM ETTİKTEN SONRA TEKRAR DENEYİNİZ.</div>";
                              }
                              else
                              {
                                  if($sonuc_kullanici['sayisi']<3)
                                  {
                                    $kitap_sayisi=$sonuc_kullanici['sayisi']+1; 
                                    $tarih=date("Y-m-d", strtotime("+1 week"));
                                    
                                    if($sonuc_kullanici['isbn_1']==0)
                                    {
                                      $update_sahip = $conn->prepare("UPDATE sahip SET sayisi = :sayisi, isbn_1= :isbn_1, tarih_1= :tarih_1 WHERE id='$kullanici'");
                                      $update_sahip = $update_sahip->execute(array(
                                              "sayisi"=>"$kitap_sayisi",
                                              "isbn_1"=>"$isbn_girisi",     
                                              "tarih_1"=>"$tarih",                                  
                                      ));
                                      $update_kitap = $conn->prepare("UPDATE kitap SET kullanim = :kullanim WHERE isbn='$isbn_girisi'");
                                      $update_kitap = $update_kitap->execute(array(
                                              "kullanim"=>1,                                   
                                      ));
                                      echo "Kitap başarıyla tanımlandı.";
                                    }
                                    else if($sonuc_kullanici['isbn_2']==0)
                                    {
                                      $update_sahip = $conn->prepare("UPDATE sahip SET sayisi = :sayisi, isbn_2= :isbn_2, tarih_2= :tarih_2 WHERE id='$kullanici'");
                                      $update_sahip = $update_sahip->execute(array(
                                              "sayisi"=>"$kitap_sayisi",
                                              "isbn_2"=>"$isbn_girisi",     
                                              "tarih_2"=>"$tarih",                                  
                                      ));
                                      $update_kitap = $conn->prepare("UPDATE kitap SET kullanim = :kullanim WHERE isbn='$isbn_girisi'");
                                      $update_kitap = $update_kitap->execute(array(
                                              "kullanim"=>1,                                   
                                      ));
                                      echo "Kitap başarıyla tanımlandı.";
                                    }
                                    else if($sonuc_kullanici['isbn_3']==0)
                                    {
                                      $update_sahip = $conn->prepare("UPDATE sahip SET sayisi = :sayisi, isbn_3= :isbn_3, tarih_3= :tarih_3 WHERE id='$kullanici'");
                                      $update_sahip = $update_sahip->execute(array(
                                              "sayisi"=>"$kitap_sayisi",
                                              "isbn_3"=>"$isbn_girisi",     
                                              "tarih_3"=>"$tarih",                                  
                                      ));
                                      $update_kitap = $conn->prepare("UPDATE kitap SET kullanim = :kullanim WHERE isbn='$isbn_girisi'");
                                      $update_kitap = $update_kitap->execute(array(
                                              "kullanim"=>1,                                   
                                      ));
                                      echo "Kitap başarıyla tanımlandı.";
                                    }
                                  }
                                  else
                                  {
                                    echo "Maksimum kitap sayısınıza ulaştınız.";
                                    echo "<hr>";
                                  }
                            }
                        }
                        else
                        {
                          echo "Bu kitap şuanda kullanımda.";
                          echo "<hr>";
                        }
                }
                else
                {
                      echo "Böyle bir kitap bulunamadı.";
                      echo "<hr>";
                }
            }
        ?>
          <script>
          function check() {
            document.getElementById("two").checked = true;
          }
        </script>
     </form>
  </div>
  <form method="POST">
  <div class="panel" id="three-panel">
  <div style="font-weight:bold">Vermek İstediğiniz Kitabın Fotoğrafını Yükleyiniz.</div>
      <input type='file' onchange='dosyaoku(event)'>
      <div class="kullanici">FOTOĞRAFI YÜKLEDİKTEN SONRA ISBN KODU EKRANDA GÖZÜKENE KADAR "Kitap Teslim" BUTONUNA BASMAYINIZ.</div>
      <button type="submit"  name="commit_4" class="btn-hover btn-large">Kitap Teslim</button>
      <br>
        <?php
            if(isset($_POST["commit_4"]))
            {
              $kullanici=$_SESSION['kullanici_id'];
              $arama_kullanici = $conn->prepare("SELECT *FROM sahip WHERE id='$kullanici'");
              $arama_kullanici->execute();
              $sonuc_kullanici = $arama_kullanici->fetch();
              
              $isbn_ver = $_COOKIE['isbn_kodu'];
              //$isbn_ver = $_POST["isbn_ver"];
              $kitap_sayisi=$sonuc_kullanici['sayisi']-1; 

                if($sonuc_kullanici['isbn_1']==$isbn_ver)
                {
                  $update_sahip = $conn->prepare("UPDATE sahip SET sayisi = :sayisi, isbn_1= :isbn_1 WHERE id='$kullanici'");
                  $update_sahip = $update_sahip->execute(array(
                          "sayisi"=>"$kitap_sayisi",
                          "isbn_1"=>0,                                      
                  ));
                  $update_kitap = $conn->prepare("UPDATE kitap SET kullanim = :kullanim WHERE isbn='$isbn_ver'");
                  $update_kitap = $update_kitap->execute(array(
                          "kullanim"=>0,                                   
                  ));
                  echo "Kitap, başarıyla kütüphaneye iade edildi.";
                }
                else if($sonuc_kullanici['isbn_2']==$isbn_ver)
                {
                  $update_sahip = $conn->prepare("UPDATE sahip SET sayisi = :sayisi, isbn_2= :isbn_2 WHERE id='$kullanici'");
                  $update_sahip = $update_sahip->execute(array(
                          "sayisi"=>"$kitap_sayisi",
                          "isbn_2"=>0,                                     
                  ));
                  $update_kitap = $conn->prepare("UPDATE kitap SET kullanim = :kullanim WHERE isbn='$isbn_ver'");
                  $update_kitap = $update_kitap->execute(array(
                          "kullanim"=>0,                                   
                  ));
                  echo "Kitap, başarıyla kütüphaneye iade edildi.";
                }
                else if($sonuc_kullanici['isbn_3']==$isbn_ver)
                {
                  $update_sahip = $conn->prepare("UPDATE sahip SET sayisi = :sayisi, isbn_3= :isbn_3 WHERE id='$kullanici'");
                  $update_sahip = $update_sahip->execute(array(
                          "sayisi"=>"$kitap_sayisi",
                          "isbn_3"=>0,                                    
                  ));
                  $update_kitap = $conn->prepare("UPDATE kitap SET kullanim = :kullanim WHERE isbn='$isbn_ver'");
                  $update_kitap = $update_kitap->execute(array(
                          "kullanim"=>0,                                   
                  ));
                  echo "Kitap, başarıyla kütüphaneye iade edildi.";
                }
                else
                {
                      echo "Böyle bir kitap bulunamadı.";
                      echo "<hr>";
                }
            }
        ?>
   </form>
  </div>
  </div>
  <a class="tab" id="cikis" href="cikis.php">Çıkış Yap</a>
</div>


</body>
</html>