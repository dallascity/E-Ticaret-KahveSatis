<?php
$sayfa = "Menü Oluşturma";
include "inc/header.php";
include "inc/sidebar.php";
include "inc/navbar.php";




?>
</head>
<div class="conatiner-fluid content-inner mt-5 py-0">
    <div>
        <div class="row">
            <div class="col-xl-9 col-lg-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title"><?=$sayfa?></h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="new-user-info">
                            <form method="POST" action="" enctype="multipart/form-data">

                            <div class="row">
                                    <div class="form-group col-md-7">
                                    <label class="form-label" for="add2">Menünün İsmi</label>
                                    <input onkeypress="preventNumbers(event)" type="text" class="form-control" id="add2" name="kategoriIsim" required placeholder="Menü İsmi">
                               

                               
                                    <label for="gorsel" class="form-label">Resim Seçimi</label>
                                    <div class="mb-3 form-check">
                                        <input type="radio" class="form-check-input" id="resimUrl" name="resimSecenek" value="url" ?>
                                        <label class="form-check-label" for="resimUrl">URL</label>
                                    </div>
                                    <div class="mb-3 form-check">
                                        <input type="radio" class="form-check-input" id="resimDosya" name="resimSecenek" value="dosya" ?>
                                        <label class="form-check-label" for="resimDosya">Dosya Yükle</label>
                                    </div>
                                    </div>
                                    <div class="form-group col-md-5">
                                            <div class="card" style="width: 250px;">
                                                <img id="resim-onizleme" src="" class="card-img-top" alt="Resim">
                                            </div>
                                    </div>
                                <div id="resimUrlAlan" style="display: none;">
                                    <div class="mb-3">
                                        <label for="resimUrl" class="form-label">Resim URL</label> 
                                        <input type="text" class="form-control" id="resimUrl" name="resimUrl" oninput="gosterResim(this.value)" >
                                    </div>
                                </div>
                                <div id="resimDosyaAlan" style="display: none;">
                                    <div class="mb-3">
                                        <label for="resimDosya" class="form-label">Resim Yükle</label>
                                        <input type="file" class="form-control" id="resimDosya" name="resimDosya" onchange="onResimSecildi(event)">
                                    </div>
                                </div>
                                </div>


                                <div class="form-group col-md-6">
                                    <label class="switch">
                                        <input name="ap" class="btn btn-primary"  type="checkbox"  data-toggle="switchbutton" data-onlabel="Açık" data-offlabel="Kapalı">
                                        <input id="switch-two" type="checkbox">
                                    </label>
                                </div>


                                <button type="submit" name="ekle" class="btn btn-primary">Oluştur</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</main>






<?php
include "inc/footer.php";
?>


<?php


try {

    if (isset($_POST['ekle'])) {
        $hata = "";
        $durum = 0;
        $foto = null;
        $secenek = "";
        $resimdurum = 0;
        $kategori = $_POST['kategoriIsim'];
        $kategori = removeExtraSpaces($kategori); 
        $kategori = htmlspecialchars($kategori, ENT_QUOTES, 'UTF-8');
        $kategori = mb_strtolower($kategori,'UTF-8');
        if(isset($_POST['resimSecenek'])) $secenek = $_POST['resimSecenek'];
        if (isset($_POST["ap"])) $durum = 1;

        if($kategori != "" ||$kategori != null ){

        if($secenek == 'url' || $secenek == 'URL'){
        $resimdurum = 0;
        $foto = $_POST['resimUrl'];
        $foto = trim($foto);
        $foto = htmlspecialchars($foto);
        if($foto == null || $foto == ""){
            $hata="Resmin URL alanı boş bırakılamaz";
            echo showErrorAlert($hata);
        }
        }
        else if($secenek == "dosya yükle" || $secenek == "Dosya Yükle" || $secenek == 'dosyayükle' || $secenek == 'dosya' && $_FILES["resimDosya"]['name'] != "" && $_FILES["resimDosya"]['name'] != null){

 
            if($_FILES["resimDosya"]['error'] != 0){
                $hata.="Resim yüklenirken hata gerçekleşti";
                echo showErrorAlert($hata);
        
            }
         
            else if(file_exists('../assets/gallery/'.strtolower($_FILES['resimDosya']['name']))){
                $hata.="Aynı resim ismi mevcut";   
                echo showErrorAlert($hata); 
         
            }
            else if($_FILES['resimDosya']['size']>(1024*1024*2)){
                $hata.="Resmin boyutu 2MB'dan büyük olamaz";
                echo showErrorAlert($hata);
            }
            else if(!in_array($_FILES['resimDosya']['type'], array('image/png', 'image/jpeg', 'image/jpg'))){
            $hata.="Hata, resim türü png veya jpeg formatında olmalıdır.";
                echo showErrorAlert($hata);
            }
            else{
                copy($_FILES['resimDosya']['tmp_name'],'../assets/gallery/'.mb_strtolower($_FILES['resimDosya']['name']));
                $foto=mb_strtolower($_FILES['resimDosya']['name']);
                $resimdurum = 1;
            }       
     
        }

        else if ($foto == "" || $foto == null){
            $hata="Resmin URL'si veya Dosya yüklenmedi";
            echo showErrorAlert($hata);
           
        }
        else{
            $hata="Resim seçeneğini belirtmediniz";
                echo  showErrorAlert($hata);
        }

    }
    
    else{
        $hata = "Boş bırakılmış alanlar var";
                echo  showErrorAlert($hata);
    }

         $control = $tadmin->prepare("SELECT isim FROM kategori WHERE isim=:isim");
         $control->bindParam(':isim', $kategori);
         $control->execute();
        if($control->rowCount() == 1){
            $hata="Oluşturulmuş bir menü ismini tekrar oluşturamazsın";
            echo  showErrorAlert($hata);   
        }
        else if ($hata == null || $hata == "") {
            $sirasorgu = $tadmin->prepare('select * from kategori');
            $siracek = $sirasorgu->execute();
            $satirSayisi = $sirasorgu->rowCount();
            $sira = $satirSayisi;

            $sorgu = $tadmin->prepare('INSERT INTO kategori (resim, isim, sira ,durum, resimdurum) VALUES (:resim, :isim, :sira ,:durum, :resimdurum)');

            $sorgu->bindParam(':resim', $foto);
            $sorgu->bindParam(':isim', $kategori);
            $sorgu->bindParam(':sira', $sira);
            $sorgu->bindParam(':durum', $durum);
            $sorgu->bindParam(':resimdurum', $resimdurum);
            $insert = $sorgu->execute();

            echo '<script>
               Swal.fire({
                   icon: "success",
                   title: "Başarılı",
                   text: "Ekleme işleminiz başarıyla gerçekleşti",
                   confirmButtonText: "Kapat"
               }).then((value) => {
                   if (value.isConfirmed) {
                       window.location.href = "panel";
                   }
               });
           </script>';
        }
    }
} catch (PDOException $e) {
    $hata = $e->getMessage();
    catchLog($_SESSION['kadi'],$sayfa,$hata,'INSERT');
    echo showErrorAlert("Hata raporu gönderildi:".$hata);
}
?>



<script>
    document.addEventListener("DOMContentLoaded", function() {
        var resimSecenekler = document.querySelectorAll('input[name="resimSecenek"]');
        resimSecenekler.forEach(function(secenek) {
            secenek.addEventListener('change', function() {
                var secilenSecenek = document.querySelector('input[name="resimSecenek"]:checked').value;
                gosterGizleResimAlan(secilenSecenek);
            });
        });

        // Sayfa yüklendiğinde mevcut seçeneğe göre resim alanını göster veya gizle
        var secilenSecenek = document.querySelector('input[name="resimSecenek"]:checked').value;
        gosterGizleResimAlan(secilenSecenek);

        // Resim alanını göster veya gizle
        function gosterGizleResimAlan(secenek) {
            var resimUrlAlan = document.getElementById('resimUrlAlan');
            var resimDosyaAlan = document.getElementById('resimDosyaAlan');

            if (secenek === 'url') {
                resimUrlAlan.style.display = 'block';
                resimDosyaAlan.style.display = 'none';

            } else if (secenek === 'dosya') {
                resimUrlAlan.style.display = 'none';
                resimDosyaAlan.style.display = 'block';
            }
        }
    });

    function onResimSecildi(event) {
        const dosya = event.target.files[0];
        const dosyaOkuyucu = new FileReader();

        dosyaOkuyucu.onload = function(e) {
            document.getElementById('resim-onizleme').src = e.target.result;
        }

        dosyaOkuyucu.readAsDataURL(dosya);
    }
    function gosterResim(url) {
        var resim = document.getElementById('resim-onizleme');
        resim.src = url;
    }

    function preventNumbers(event) {
    var charCode = event.which ? event.which : event.keyCode;
    if (charCode >= 48 && charCode <= 57) {
        event.preventDefault();
    }
}

</script>