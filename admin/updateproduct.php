<?php
$sayfa = "Ürünler";
$title = "Ürün Düzenleme";
include "inc/header.php";
?>


</head>
<div class="conatiner-fluid content-inner mt-5 py-0">
    <div>
        <div class="row">
            <div class="col-xl-9 col-lg-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title"><?= $title ?></h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="new-user-info">
                            <?php
                            try {
                                $id = intval($_GET['id']);

                                $query = "SELECT * FROM products WHERE product_id=:id";
                                $result = $db->prepare($query);
                                $result->bindParam(':id', $id);
                                $result->execute();

                                $fetch = $result->fetch(PDO::FETCH_ASSOC);
                                if (!$fetch) route("index.php");
                            ?>
                                <form id="form" method="POST" action="" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="form-group col-md-7">
                                            <label class="form-label" for="add2">Ürün İsmi</label>
                                            <input onkeypress="preventNumbers(event)" type="text" class="form-control" id="product" name="product" required placeholder="Ürün İsmi" maxlength="30" value="<?= $fetch['name'] ?>">
                                            <label class="form-label" for="add2">Açıklama (boş bırakılabilir)</label>
                                            <textarea placeholder="Boş bırakılabilir" onkeypress="" type="text" class="form-control" id="description" name="description" placeholder="Menü İsmi"> <?= $fetch['description'] ?> </textarea>

                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label class="form-label" for="weight">Birim Sayı</label>
                                                        <input onkeypress="allowNumbersAndDot(event)" type="text" class="form-control" id="weight" name="weight" required placeholder="Birim Sayı" maxlength="8" value="<?= $fetch['weight'] ?>">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="city">Birim Tipi</label>
                                                        <select id="select" name="weight_type" id="weight_type" class="form-select">
                                                            <option value="<?= $fetch['weight_type'] ?>"><?= $fetch['weight_type'] ?></option>
                                                            <?php foreach ($birim as $b) echo "<option value='$b'>$b</option>"; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label for="">Fiyatı</label>
                                                        <div class="input-group">
                                                            <input value="<?= $fetch['price'] ?>" onkeypress="allowNumbersAndDot(event)" maxlength="8" type="text" class="form-control" id="price" name="price" placeholder="Ürün Fiyatı" required>
                                                            <span class="input-group-text">TL</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label" for="stock">Stok</label>
                                                        <input value="<?= $fetch['stock'] ?>" type="text" maxlength="8" class="form-control" id="stock" name="stock" required placeholder="Stok Adeti" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                                    </div>
                                                </div>
                                            </div>
                                            <label for="gorsel" class="form-label">Görsel türü seçimi</label>
                                            <div class="mb-3 form-check">
                                                <input type="radio" class="form-check-input" id="resimUrl" name="phototype" value="url" <?= $fetch['photo_type'] == 0 ? 'checked="checked"' : '' ?>>
                                                <label class="form-check-label" for="resimUrl">URL</label>
                                            </div>
                                            <div class="mb-3 form-check">
                                                <input type="radio" class="form-check-input" id="resimDosya" name="phototype" value="dosya"  <?= $fetch['photo_type'] == 1 ? 'checked="checked"' : '' ?>>
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
                                                <input value="<?= $fetch['photo'] ?>" type="text" class="form-control" id="resimUrl" name="photoUrl" oninput="gosterResim(this.value)">
                                            </div>
                                        </div>
                                        <div id="resimDosyaAlan" style="display: none;">
                                            <div class="mb-3">
                                                <label for="resimDosya" class="form-label">Resim Yükle</label>
                                                <input type="file" class="form-control" id="resimDosya" name="photoDoc" onchange="onResimSecildi(event)">
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group col-md-6">
                                        <label class="switch">
                                            <input  <?= $fetch['status'] == 1 ? 'checked="checked"' : ''?> name="status" class="btn btn-primary" type="checkbox" data-toggle="switchbutton" data-onlabel="Açık" data-offlabel="Kapalı">
                                            <input id="switch-two" type="checkbox">
                                        </label>
                                    </div>


                                    <button type="submit" id="update" name="update" class="btn btn-primary">Oluştur</button>
                                </form>
                            <?php
                            } catch (PDOException $e) {
                                errorAlert($e->getMessage());
                            }

                            ?>
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
include "actions/updateproductaction.php";
?>
<script>
    $('#form').submit(function(event) {
        event.preventDefault();
    });



    document.addEventListener("DOMContentLoaded", function() {
        var resimSecenekler = document.querySelectorAll('input[name="phototype"]');
        resimSecenekler.forEach(function(secenek) {
            secenek.addEventListener('change', function() {
                var secilenSecenek = document.querySelector('input[name="phototype"]:checked').value;
                gosterGizleResimAlan(secilenSecenek);
            });
        });

        // Sayfa yüklendiğinde mevcut seçeneğe göre resim alanını göster veya gizle
        var secilenSecenek = document.querySelector('input[name="phototype"]:checked').value;
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

    function allowNumbersAndDot(event) {
        var charCode = event.which ? event.which : event.keyCode;

        // Backspace (8) veya Delete (46) tuşlarını engelleme
        if (charCode === 8 || charCode === 46) {
            return true;
        }

        var input = String.fromCharCode(charCode);
        var allowedChars = /[0-9.]/;

        if (!allowedChars.test(input)) {
            event.preventDefault();
        }
    }
</script>