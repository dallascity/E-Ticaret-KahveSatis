<?php
try{
if ($_POST) { 
    include("../../inc/db.php"); 

 
    $id = (int)$_POST['id'];
    $status = $_POST['status'];
    $table = $_POST['table'];

    $query = $db->query("UPDATE $table SET status=$status WHERE  product_id=$id");
}
} catch (PDOException $e) {
    echo "Hata: " . $e->getMessage();
  }
?>