<?php
$sayfa ="login";
include "inc/header.php";
try{
if (isset($_SESSION["oturum"]) && $_SESSION["oturum"] == 1) route('index.php');

  
 else if (isset($_COOKIE["cookie"])){
 
    $cookiecontrol = $db->prepare("Select id,authority,name,surname from users");
    $cookiecontrol->execute();

    while($check=$cookiecontrol->fetch()){
        if ($check && $_COOKIE["cookie"] == md5("aa".$check["id"]."bb")) {

            $_SESSION["oturum"] = 1;
            $_SESSION["id"] = $check['id'];
            $_SESSION["name"] = $check['name'];
            $_SESSION["surname"] = $check['surname'];
            $_SESSION['authority'] = $check['authority'];

            if($_SESSION['authority'] == 1) route('admin/index.php');
            else route('index.php');

        }
    }
}
?>
<body>
    <div class="container d-flex justify-content-center align-items-center" style="height: 90vh;">
        <form action="" method="POST" class="p-5 shadow-lg bg-white rounded" style="max-width: 500px;">
            <h1 class="mb-4">Login</h1>
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input name="email" type="email" class="form-control" id="email" aria-describedby="emailHelp" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Şifre</label>
                <input name="pass" type="password" class="form-control" id="password" required>
            </div>
            <div class="mb-3 form-check">
                <input name="remember" type="checkbox" class="form-check-input" id="remember">
                <label class="form-check-label" for="remember">Beni hatırla</label>
            </div>
            <button id='loginBtn' name="login" type="button" class="btn btn-primary">Login</button>
            <p class="mt-3">
                Hesabın yok mu? <a href="register.php">Kayıt ol</a>
            </p>
        </form>
    </div>
</body>

<script>
        $(document).ready(function() {
                let login = false;
            $('#loginBtn').click(function() {
              
                login = true
                var email = $('#email').val();
                var password = $('#password').val();
                var remember = $('#remember').is(':checked');
            
                $.ajax({
                    url: 'actions/loginaction.php',
                    method: 'POST',
                    data: {
                        login:login,
                        email: email,
                        pass: password,
                        remember: remember
                    },
                    success: function(result) {
                        $('body').append(result);
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });
        });
    </script>

<?php 
}
// echo  md5(md5("16" . htmlspecialchars($pass,ENT_QUOTES,'UTF-8') . "16"));
catch(PDOException $e){
   errorAlert($e->getMessage());
}
include "inc/footer.php";
?>