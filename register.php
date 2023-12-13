<?php
$sayfa = "register";
include "inc/header.php";
if (isset($_SESSION["oturum"]) && $_SESSION["oturum"] == 1) route('index.php');


?>

<body>
    <div class="container d-flex justify-content-center align-items-center" style="height: 90vh;">
    <form action="" method="POST" class="p-5 shadow-lg bg-white rounded" style="max-width: 500px;">
    <h1 class="mb-4">Kayıt OL</h1>
    <div class="row mb-3">
        <div class="col-md-6">
            <label for="name" class="form-label">İsim</label>
            <input name="name" type="name" class="form-control" id="name" maxlength="25" required>
        </div>
        <div class="col-md-6">
            <label for="surname" class="form-label">Soyisim</label>
            <input name="surname" type="name" class="form-control" id="surname" maxlength="25" required>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">
            <label for="email" class="form-label">Email address</label>
            <input name="email" type="email" class="form-control" id="email" aria-describedby="emailHelp" required>
        </div>
        <div class="col-md-6">
            <label for="password" class="form-label">Şifre</label>
            <input name="pass" type="password" class="form-control" id="pass" maxlength="16" required>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">
            <label for="password" class="form-label">Tekrar Şifre</label>
            <input name="vpass" type="password" class="form-control" id="vpass" maxlength="16" required>
        </div>
        <div class="col-md-6">
            <label for="city">Şehir Seçin:</label>
            <select name="city" id="city" class="form-select">
                <?php foreach ($iller as $city) echo "<option value='$city'>$city</option>"; ?>
            </select>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">
            <label for="phone" class="form-label">Telefon Numarası</label>
            <input name="phone" type="phone" class="form-control" id="phone" placeholder="+90" maxlength="10" required>
        </div>
        <div class="col-md-6">
            <label for="address" class="form-label">Adres</label>
            <textarea rows="2" name="address" class="form-control" id="address" placeholder="Adresinizi giriniz" required></textarea>
        </div>
    </div>
    <button name="register" id="regBtn" type="button" class="btn btn-primary">Kayıt ol</button>
    <p class="mt-3">
        Zaten hesabın var mı? <a href="login.php">Giriş yap</a>
    </p>
</form>

    </div>
</body>

<script>
        $(document).ready(function() {
                let register = false;
            $('#regBtn').click(function() {
              
                register = true
                var name = $('#name').val();
                var surname = $('#surname').val();
                var pass = $('#pass').val();
                var vpass = $('#vpass').val();
                var city = $('#city').val();
                var phone = $('#phone').val();
                var email = $('#email').val();
                var address = $('#address').val();
            
            
            
                $.ajax({
                    url: 'actions/registeraction.php',
                    method: 'POST',
                    data: {
                        register:register,
                        name:name,
                        surname:surname,
                        pass:pass,
                        vpass:vpass,
                        city:city,
                        email: email,
                        phone:phone,
                        address:address
                    },
                    success: function(result) {
                     
                        $('body').append(result);
                    },
                    error: function(error) {
                        $('body').append(error);
                    }
                });
            });
        });
    </script>

<?php
include "inc/footer.php";
?>