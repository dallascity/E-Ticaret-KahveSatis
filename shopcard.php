<?php
$sayfa = "sepet";
include "inc/header.php";


?>
<style> 
.color-danger{
    color:red
}
.itemcount{
    width: 50px;
    text-align: center;
}
td{
    vertical-align: middle;
}
</style>
<body>

<div class="container">
    <?php if($totalCount >0){?>
    <h2 class="text-center">Sepetinizde <strong class="color-danger"><?=$totalCount?></strong> adet ürün bulunmaktadır </h2> 
   <?php } else{?>
    <div class="alert alert-info"><strong>Sepetinizde henüz bir ürün bulunmamaktadıdır.Eklemek için <a href="index.php">Tıklayınız </a></strong></div>
    <?php } ?>
</div>
<div class="row justify-content-center">
    <div class="col-md-8">
        <table class="table table-hover table-bordered table-striped">
            <thead>
                <th class="text-center">Ürün resmi</th>
                <th class="text-center">Ürün adı</th>
                <th class="text-center">Paket</th>
                <th class="text-center">Fiyatı</th>
                <th class="text-center">Adeti</th>
                <th class="text-center">Toplam</th>
                <th class="text-center">Sepetten Çıkar</th>
            </thead>

            <tbody>
                
                <?php
                try{
                foreach($products as $row){ ?>
                <tr>
                    <td class="text-center"><img src="<?= $row->photo_type == true ? 'assets/gallery/' . $row->photo: $row->photo?>"alt="Photo" width="70"></td>
                <td class="text-center"><?= $row->name?></td>
                <td class="text-center"><?= $row->weight." ".$row->weight_type?></td>
                <td class="text-center"><?= $row->price?></td>
                <td class="text-center">
                    <button class='incCount btn btn-sm btn-success' id="<?=$row->product_id?>" class="btn btn-sm btn-success"><span class="fa fa-plus"></span></button>
                    <input type="text" class="itemcount" value="<?= $row->count?>" readonly>
                    <button class='decCount btn btn-sm btn-danger' id="<?=$row->product_id?>" class="btn btn-sm btn-danger"><span class="fa fa-minus"></span></button>
                </td>
                <td class="text-center"><?= $row->total_price?></td>
                <td class="text-center">
                    <button id='<?=$row->product_id?>' class="btn btn-danger btn-sm removeCartBtn">Sepetten Çıkar</button>
                </td>
                </tr>
                <?php }}catch(Exception $e){
                    echo $e->getMessage();
                } ?>

            </tbody>
            <tfoot>
                <th> Promosyon Kodu:
                 <input type="text" name="promocode" placeholder="Zorunlu değil">
                </th>
                <th colspan="4" class="text-end">Toplam Ürün <span class="color-danger"> <?=$totalCount?></span></th>
                <th colspan="1" >Toplam Fiyat :  <span class="color-danger"> <?=$totalPrice?></span></th>
                <th colspan="2" class="text-end" ><button class="btn btn-success  ">Sepeti Onayla</button></th>
            </tfoot>
 
               
   
        </table>
    </div>
</div>
</body>
<?php
include "inc/footer.php";
?>

<script>

$(document).ready(function(){
    function handleAction(processType, productId) {
    var url = "actions/shopcartaction.php";
    var data = {
        process: processType,
        product_id: productId,
    };

    $.post(url, data, function(response) {
        
        window.location.reload();
    });
}

$(".removeCartBtn").click(function() {
    var productId = $(this).attr("id");
    handleAction("removeCart", productId);
});

$(".incCount").click(function() {
    var productId = $(this).attr("id");
    handleAction("incCount", productId);
});

$(".decCount").click(function() {
    var productId = $(this).attr("id");
    handleAction("decCount", productId);
});

})


</script>