<?php 
include "../inc/db.php";
include "../inc/function.php";
try{
if(isset($_POST['register'])){

    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $vpass = $_POST['vpass'];
    $city = $_POST['city'];
    $phone = $_POST['phone'];
    $adress = $_POST['address'];
    $authority = 0;
    
    $error = null;

 
if($name != null && $surname != null && $email != null && $pass != null && $vpass != null && $city != null && $phone != null && $adress != null)
{   
    $name = htmlspecialchars(removeExtraSpaces(mb_strtolower($name)),ENT_QUOTES,'UTF-8');
    $surname = htmlspecialchars(removeExtraSpaces(mb_strtolower($surname)),ENT_QUOTES,'UTF-8');
    $email = htmlspecialchars(removeExtraSpaces(mb_strtolower($email)),ENT_QUOTES,'UTF-8');
    $pass = htmlspecialchars(removeExtraSpaces(mb_strtolower($pass)),ENT_QUOTES,'UTF-8');
    $vpass = htmlspecialchars(removeExtraSpaces(mb_strtolower($vpass)),ENT_QUOTES,'UTF-8');
    $city = htmlspecialchars(removeExtraSpaces($city),ENT_QUOTES,'UTF-8');
    $phone = htmlspecialchars(removeExtraSpaces($phone),ENT_QUOTES,'UTF-8');
    $adress = htmlspecialchars(removeExtraSpaces(mb_strtolower($adress)),ENT_QUOTES,'UTF-8');
    // Validation
    if (!preg_match('/^[a-zA-Z]+$/u', $name)) {
        $error = "İsim boşluksuz ve isimde sadece harf kullanılmalıdır";
       errorAlert($error);
    }
    else if (!preg_match('/^[a-zA-Z]+$/u', $name)) {
        $error = "Soyisim boşluksuz ve soyisimde sadece harf kullanılmalıdır";
       errorAlert($error);
    }
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Geçerli bir email adresi girin.";
        errorAlert($error);
    }
    else if (strlen($pass) < 6){
        $error = "Şifre en az 6 haneli olmalı";
        errorAlert($error);
    }
    else if ($pass != $vpass){
        $error = "Şifreler uyuşmuyor";
        errorAlert($error);
    }
    else if (!in_array($city, $iller)) {
        $error = "Geçersiz bir şehir ismi";
        errorAlert($error);
    }
    else if (substr($phone, 0, 1) === '0' && strlen($phone) !== 10 && !preg_match('/^\d+$/', $phone)) {
        $error = "Telefon numarası hatalı. Lütfen geçerli bir numara girin.";
        errorAlert($error);
    }
    else if (preg_match('/[@\?!><\'^+%&\()?_$£#>½{[\]}\\\\]/', $adress)) {
        $error = "Adres uygunsuz karakterler içeriyor.";
        errorAlert($error);
    }

    else{
        $mailcontrol = $db->prepare('select mail from users where mail=:mail');
        $mailcontrol->bindParam(':mail', $email);
        $mailcontrol->execute();
        if($mailcontrol->rowCount() >= 1){
            $error = "Aynı mail adresiyle oluşturulmuş zaten bir hesap var";
            errorAlert($error);
        }
        // INSERT
        else if($error == null){
            $pass = md5(md5("16" . htmlspecialchars($pass, ENT_QUOTES, 'UTF-8') . "16"));
            $query = $db->prepare('INSERT INTO users (name, surname, city ,adress, mail, pass, phone, authority) VALUES (:name, :surname, :city ,:adress, :mail, :pass, :phone, 0)');
            $query->bindParam(':name', $name);
            $query->bindParam(':surname', $surname);
            $query->bindParam(':city', $city);
            $query->bindParam(':adress', $adress);
            $query->bindParam(':mail', $email);
            $query->bindParam(':pass', $pass);
            $query->bindParam(':phone', $phone);
            $insert = $query->execute();
            
            successAlert("Kayıt Tamamlandı","Giriş sayfasından giriş yapabilirsiniz","index.php");
            
        }
        else{
            errorAlert("Beklenmedik bir hata oluştu");
        }
    }
    
} 
else
{
    errorAlert("Kayıt işleminde boş alan bırakamazsınız");
}    
    
    }
}
catch(PDOException $e){
    errorAlert($e->getMessage());
}


?>