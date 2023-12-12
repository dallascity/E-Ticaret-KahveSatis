<?php
include 'inc/header.php';
$data= ["1","2","3","4","5","6","7","8","9"];
$img = "https://cdnuploads.aa.com.tr/uploads/Contents/2021/12/05/thumbs_b_c_90af467dfc6f62060d6fd271585c7b55.jpg?v=150655";
?>
<link rel="stylesheet" href="assets/style/card.css">




<body>



  <div class="container">
    <div class="row">
<?php foreach($data As $row){?>
      <div class="col-md-3" style="padding: 10px;">  
      <div class="card card-clickable position-relative border-radius-50 overflow-hidden">
    <div class="aspect-ratio-wrapper">
        <img src="<?=$img?>" alt="Resim" class="card-img img-fluid" style="width: 100%; height: 100%; object-fit: cover;">
    </div>
    <div class="d-flex align-items-center justify-content-center card-overlay bg-dark-opacity-5 position-absolute bottom-0 start-0 end-0">
        <div class="container">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="card-title text-white text-center" style="font-size: 25px; line-height: 1.2;">
                        <?=$row?>
                    </h5>
                    <div class="d-flex flex-column flex-md-row justify-content-md-between align-items-center mt-2">
                        <div class="input-group mb-2 mb-md-0 me-md-2">
                            <input type="number" class="form-control" placeholder="Kilo" min="0">
                        </div>
                        <button class="btn btn-success"><i class="fas fa-shopping-cart"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

      </div>
      <?php } ?>
    </div>





</body>

</html>
<?php
include 'inc/footer.php';
?>

