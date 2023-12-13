<?php
$sayfa = "index";
include 'inc/header.php';
?>

<link rel="stylesheet" href="style/card.css">

<body>
    <div class="container">
        <div class="row">

            <?php
            try {
                $image ="https://i.nefisyemektarifleri.com/2023/03/13/nitelikli-kahve-cekirdegi-cesitleri-ozellikleri.jpg";
                $fetch = [1,2,3,4,5,6,7,8,9,10];
                foreach ($fetch as $row) {
                  
            ?>

<div class="col-md-3" style="padding: 10px;">
    <div class="card">
        <div class="card_image" style="position: relative;">
            <img src="<?=$image?>" alt="Resim">
            <p class="card_price">
                0₺
            </p>
        </div>
        <div class="card_content">
            <h2 class="card_title text-white"><?=$row?></h2>
            <div class="card_text">
                <p>250 Type</p>
            </div>
            <div class="additional_info">
                <div class="input-group mb-2">
                    <input type="number" class="form-control" placeholder="3626 adet kaldı" min="0">
                    <button class="btn btn-success"><i class="fas fa-shopping-cart"></i>Sepete Ekle</button>
                </div>
            </div>
        </div>
    </div>
</div>

            <?php
                }
            } catch (PDOException $e) {
                echo "Hata: " . $e->getMessage();
            }
            ?>

        </div>

</body>


<?php
include 'inc/footer.php';
?>


<script>
    // function toggleCardText(card) {
    //     var cardContent = card.getElementsByClassName('card_content')[0];
    //     // var allCardContents = document.getElementsByClassName('card_content');


    //     cardContent.classList.toggle('open');
    // }
</script>