<?php
$sayfa ="sil";
include "../../inc/db.php";
include "../../inc/function.php";
if($_POST){
$id = $_POST['id'];
$table = $_POST['table']; 
$photo = $_POST['url'];
  
try {
    $control = $db->query("SELECT stock from products where product_id=$id");
    $result = $control->fetch(PDO::FETCH_ASSOC);
    $stock = $result['stock'];
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