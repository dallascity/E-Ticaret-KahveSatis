<?php 
function errorAlert($error) {
    $error = htmlspecialchars($error, ENT_QUOTES, 'UTF-8');
    echo "<script>Swal.fire({
        icon: 'error',
        title: '$error',  
    }) </script>";
}
function successAlert($title, $message, $url) {
    echo '<script>
            Swal.fire({
                icon: "success",
                title: "' . $title . '",
                text: "' . $message . '",
                confirmButtonText: "Kapat"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "' . $url . '";
                }
            });
        </script>';
}

function route($route){
    echo "<script>window.location.href = '$route';</script>";
}

function removeExtraSpaces($string)
{
    $string = preg_replace('/\s+/', ' ', $string);
    $string = trim($string);
    return $string;
}


// <!NOT!> Bunlar ekstra olduğundan dolayı bunları veritabanında oluşturmadım
$birim = ["Gram","Kilogram"];

$iller = array('Adana', 'Adıyaman', 'Afyon', 'Ağrı', 'Amasya', 'Ankara', 'Antalya', 'Artvin',
'Aydın', 'Balıkesir', 'Bilecik', 'Bingöl', 'Bitlis', 'Bolu', 'Burdur', 'Bursa', 'Çanakkale',
'Çankırı', 'Çorum', 'Denizli', 'Diyarbakır', 'Edirne', 'Elazığ', 'Erzincan', 'Erzurum', 'Eskişehir',
'Gaziantep', 'Giresun', 'Gümüşhane', 'Hakkari', 'Hatay', 'Isparta', 'Mersin', 'İstanbul', 'İzmir', 
'Kars', 'Kastamonu', 'Kayseri', 'Kırklareli', 'Kırşehir', 'Kocaeli', 'Konya', 'Kütahya', 'Malatya', 
'Manisa', 'Kahramanmaraş', 'Mardin', 'Muğla', 'Muş', 'Nevşehir', 'Niğde', 'Ordu', 'Rize', 'Sakarya',
'Samsun', 'Siirt', 'Sinop', 'Sivas', 'Tekirdağ', 'Tokat', 'Trabzon', 'Tunceli', 'Şanlıurfa', 'Uşak',
'Van', 'Yozgat', 'Zonguldak', 'Aksaray', 'Bayburt', 'Karaman', 'Kırıkkale', 'Batman', 'Şırnak',
'Bartın', 'Ardahan', 'Iğdır', 'Yalova', 'Karabük', 'Kilis', 'Osmaniye', 'Düzce');
?>