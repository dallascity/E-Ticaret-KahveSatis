<?php
$host      =  "localhost";
$dbname    =  "kahveci";
$username  =  "root";
$password  =  "";
$charset   =  "utf8";
//$collate = 'utf8_unicode_ci';
$dsn = "mysql:host=$host; dbname=$dbname; charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_PERSISTENT =>false,
    PDO::ATTR_EMULATE_PREPARES =>false,
    PDO::ATTR_DEFAULT_FETCH_MODE =>PDO::FETCH_ASSOC,

];

try {
    $db = new PDO($dsn, $username, $password, $options);
    $db ->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Bağlantı Hatası:'.$e->getMessage();
    exit;
}
?>