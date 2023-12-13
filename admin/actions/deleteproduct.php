<?php
$sayfa ="sil";
include "../inc/dbaglanti.php";
$id = $_POST['id'];
$table = $_POST['table'];
$sira = $_POST['sira'];  
$resim = $_POST['url'];
$kategori = $_POST['kat'];

try {
    


    $sqlSelect = "SELECT sira FROM $table WHERE sira = :sira";
    $stmt = $tadmin->prepare($sqlSelect);
    $stmt->bindParam(':sira', $sira);
    $stmt->execute();
    $sira = $stmt->fetchColumn();
  



    $sqlDelete = "DELETE FROM $table WHERE id = :id";
    $stmt = $tadmin->prepare($sqlDelete);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    echo $resim;
    if (is_file($resim) && getimagesize($resim)) unlink($resim); 
  
    
    $sqlUpdate = "UPDATE $table SET sira = sira - 1 WHERE sira > :sira";
    $stmt = $tadmin->prepare($sqlUpdate);
    $stmt->bindParam(':sira', $sira);
    $stmt->execute();

// PRODUCT İÇERİĞİ SİLME 
    $sqlSelectorder = "SELECT id,kategori,resim FROM menu WHERE kategori=:kat";
    $stmt = $tadmin->prepare($sqlSelectorder);
    $stmt->bindParam(':kat', $kategori);
    $stmt->execute();
    $menu = $stmt->fetchAll();
    foreach($menu as $row){

        $menuresmi='../../assets/gallery/' . $row['resim'];
        if (is_file($menuresmi) && getimagesize($menuresmi)) unlink($menuresmi);          
    
    }
 
    
    $menusqlDelete = "DELETE FROM menu WHERE kategori = :kategori";
    $stmt = $tadmin->prepare($menusqlDelete);
    $stmt->bindParam(':kategori', $kategori);
    $stmt->execute();





} catch(PDOException $e) {
    $hata = $e->getMessage();
    catchLog('Bilinmiyor','menudelete.php',$hata,'DELETE');
    echo "SİLİNEMEDİ";
}








?>