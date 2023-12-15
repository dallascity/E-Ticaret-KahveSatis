<?php 
include "../../inc/db.php";
include "../../inc/function.php";
try{
if(isset($_POST['insert'])){
    $currentDate = date("Y-m-d");
    $discount = $_POST['discount'];
    $count = $_POST['limit'];
    $endDate = $_POST['endDate'];
    $error = null;

    echo generatePromotionCode();
    die();
    if($endDate == "0"){
        $error = "Tarih boş bırakılamaz";
        errorAlert($error);
    }
    else if(!empty($discount) || !empty($count)){
        
        if(!in_array($discount,$percent)){
            $error="İndirim türü geçersiz";
            errorAlert($error);
        }
        else if(!preg_match('/^[0-9]+$/', $count)){
            $error = "Lütfen limide tam sayı giriniz";
            errorAlert($error);
        }
        else if($currentDate > $endDate){
            $error = "Geçmiş tarihi yapamazsınız";
            errorAlert($error);
        }
        if($error == null){
            $discount = str_replace("%", "", $discount);
            $discount = trim($discount);

           $query = $db->prepare('INSERT INTO promotions (promotions, discount_percentage ,create_date,finish_date, count, status) VALUES (:promotions,:dis,:created,:finish,count,true)');

           $query->bindParam(':promotions', $promotions);
           $query->bindParam(':dis', $discount);
           $query->bindParam(':created', $currentDate);
           $query->bindParam(':finish', $endDate);
           $query->bindParam(':count', $count);
           $query->bindParam(':status', $status,PDO::PARAM_BOOL);
        }
        
    }
    else{
        $error = "Boş bırakılmış alanlar var";
        errorAlert($error);
    }

}
}
catch(PDOException $e){
    $error = $e->getMessage();
    errorAlert($e);
}

function generatePromotionCode() {
    $promotionCode = '';

    // Rastgele bir kod oluşturana kadar devam et
    
        // Kupon kodunu baştan oluştur
        $promotionCode = '';

    while (strlen($promotionCode) <= 10){
        $promotionCode .= rand(0, 9);
        for ($i = 0; $i < 3; $i++) {
            $promotionCode .= 'T';
        }
        if(strlen($promotionCode) == 10) break;
        
    }

    return $promotionCode;
}






?>