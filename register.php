<?php 
$sayfa = "register";
include "inc/header.php";
if (isset($_SESSION["oturum"]) && $_SESSION["oturum"] == 1) route('index.php');

  
?>

<body>
    <div class="container d-flex justify-content-center align-items-center" style="height: 90vh;">
        <form action="login.php" method="POST" class="p-5 shadow-lg bg-white rounded" style="max-width: 500px;">
            <h1 class="mb-4">Login</h1>
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input name="email" type="email" class="form-control" id="email" aria-describedby="emailHelp" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input name="pass" type="password" class="form-control" id="password" required>
            </div>
            <div class="mb-3 form-check">
                <input name="remember" type="checkbox" class="form-check-input" id="remember">
                <label class="form-check-label" for="remember">Beni hatırla</label>
            </div>
            <button name="login" type="submit" class="btn btn-primary">Login</button>
            <p class="mt-3">
                Hesabın yok mu? <a href="#">Kayıt ol</a>
            </p>
        </form>
    </div>
</body>




<?php 
$sayfa = "register";
include "inc/footer.php";
?>