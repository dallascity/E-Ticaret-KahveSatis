<?php
try{
if ($_POST) { 
    include("../inc/dbaglanti.php"); 

 
    $id = (int)$_POST['id'];
    $durum = (int)$_POST['durum'];
    $tablo = $_POST['tablo'];

    $sorgu = $tadmin->query("UPDATE $tablo SET durum=$durum WHERE  id=$id");
}
} catch (PDOException $e) {
    echo "Hata: " . $e->getMessage();
  }
?>