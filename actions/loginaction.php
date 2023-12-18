
<?php
session_start();
ob_start();
include "../inc/db.php";
include "../inc/function.php";
try {
    if (isset($_POST['login'])) {
        $email = $_POST['email'];
        $pass = $_POST['pass'];
        if ($email != null || $pass != null) {
            $email = trim($email);
            $email = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
            $email = mb_strtolower($email);

            $pass = md5(md5("16" . htmlspecialchars($pass, ENT_QUOTES, 'UTF-8') . "16"));

            $control = $db->prepare("SELECT * FROM users WHERE mail=:mail and pass=:pass");
            $control->bindParam(':mail', $email);
            $control->bindParam(':pass', $pass);
            $control->execute();


            if ($control->rowCount() == 1) {
                $userdata = $control->fetch();
                $_SESSION["id"] = $userdata['id'];
                $_SESSION["name"] = ucfirst($userdata['name']);
                $_SESSION["surname"] = ucfirst($userdata['surname']);
                $_SESSION['authority'] = $userdata['authority'];
                $_SESSION['mail'] = $userdata['mail'];
                $_SESSION['oturum'] = 1;
                echo $_SESSION['oturum'];
                if (isset($_POST["remember"])) setcookie("cookie", md5("aa" . $userdata['id'] . "bb"), time() + (60 * 60 * 24 * 1), "/ttcase");

                route('index.php');
            } else {
                errorAlert("Mail adresiniz veya şifre hatalı");
            }
        } else {
            errorAlert("Mail adresiniz veya şifreniz boş");
        }
    }
} catch (PDOException $e) {
    errorAlert($e->getMessage());
}



?>