<?php
$sayfa ="sil";
include "../../inc/db.php";
include "../../inc/function.php";
if($_POST){
$id = $_POST['id'];
$table = $_POST['table']; 
$photo = $_POST['url'];
$stock = $_POST['stock'];

try {
    if($stock <= 0){
    $sqlDelete = "DELETE FROM $table WHERE product_id = :id";
    $stmt = $db->prepare($sqlDelete);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    if (is_file($photo) && getimagesize($photo)) unlink($photo); 
    }
    else{
        errorAlert("Stoklarda hala ürün bulunduğundan dolayı ürünü silemezsiniz eğer stok boşsa sayfayı yenileyip tekrar deneyin");
    }

} catch(PDOException $e) {
    $hata = $e->getMessage();
    errorAlert($hata);
    echo "SİLİNEMEDİ";
}


}








?>