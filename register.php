<?php
$sayfa = "register";
include "inc/header.php";
if (isset($_SESSION["oturum"]) && $_SESSION["oturum"] == 1) route('index.php');


?>

<body>
    <div class="container d-flex justify-content-center align-items-center" style="height: 90vh;">
        <form action="login.php" method="POST" class="p-5 shadow-lg bg-white rounded" style="max-width: 500px;">
            <h1 class="mb-4">Kayıt OL</h1>
            <div class="mb-3">
                <label for="name" class="form-label">İsim</label>
                <input name="name" type="name" class="form-control" id="name" required>
            </div>
            <div class="mb-3">
                <label for="surname" class="form-label">Soyisim</label>
                <input name="surname" type="name" class="form-control" id="surname" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input name="email" type="email" class="form-control" id="email" aria-describedby="emailHelp" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Şifre</label>
                <input name="pass" type="password" class="form-control" id="password" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Tekrar Şifre</label>
                <input name="vpass" type="password" class="form-control" id="password" required>
            </div>
            <div class="mb-3">
                <label for="city">Şehir Seçin:</label>
                <select name="city" id="city">
                    <?php foreach($iller as $city) echo " <option value='$city'>$city</option>"; ?>
                    <!-- <option value=""></option> -->
                </select>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Telefon Numarası</label>
                <input name="phone" type="phone" class="form-control" id="phone" placeholder="+90" required>
            </div>

            <button name="register" type="submit" class="btn btn-primary">Kayıt ol</button>
            <p class="mt-3">
                Hesabın yok mu? <a href="login.php">Kayıt ol</a>
            </p>
        </form>
    </div>
</body>




<?php
$sayfa = "register";
include "inc/footer.php";
?>