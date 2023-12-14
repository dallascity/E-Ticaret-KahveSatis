<?php 
include("../../inc/db.php"); 
try{
if ($_POST) { 

   $column = $_POST['column'];
   $id = $_POST['id'];
   $stock = $_POST['newstock'];
   $stock = str_replace(" ","",$stock);




    if($stock != null && preg_match("/^[0-9]+$/", $stock) && $stock >= 0){
      if ($db->query("UPDATE products SET $column = '$stock' WHERE product_id=$id")) 
      {
         echo true; 
      }
      else
      {
         echo false;
      }
    }
    else{
        echo false;
    }

}
}
catch(PDOException $e){
    $hata = $e->getMessage();
    echo "Fiyat Güncellenmedi Yapılmadı";
}

?>