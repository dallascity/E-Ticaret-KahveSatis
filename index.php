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
                $query = "SELECT * FROM products ORDER BY product_id";
                $result = $db->query($query);
                $fetch = $result->fetchAll(PDO::FETCH_ASSOC);
                foreach ($fetch as $row) {
                  
            ?>

<div class="col-md-3" style="padding: 10px;">
    <div class="card">
        <div class="card_image" style="position: relative;">
            <img src="<?= $row['photo_type'] == 1 ? 'assets/gallery/' . $row['photo'] : $row['photo'] ?>" alt="Resim">
            <p class="card_price">
                <?=$row['price']?>TL
            </p>
        </div>
        <div class="card_content">
            <h2 class="card_title text-white"><?=$row['name']?></h2>
            <div class="card_text">
                <p><?=$row['description']?><br><?= $row['weight']." ".$row['weight_type']?></p>
            </div>
            <div class="additional_info">
                    
                    <button  class="btn btn-success adToCartBtn" id="<?=$row['product_id']?>"><i class="fas fa-shopping-cart "></i>Sepete Ekle</button>
              
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
$(document).ready(function(){

    $(".adToCartBtn").click(function(){
        var url = "actions/shopcartaction.php";
        var data = {
            process:"addToCart",
            product_id:$(this).attr("id"),
        }
        $.post(url,data,function(response){
            $(".cart-price").text(response+"TL");
        })
    })
     
})
 
</script>