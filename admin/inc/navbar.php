
<main class="main-content">
        <div class="position-relative">  
  <nav class="nav navbar navbar-expand-lg navbar-light iq-navbar">
                <div class="container-fluid navbar-inner">
                    <a href="index.php" class="navbar-brand">
                     
                    </a>

           
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto  navbar-list mb-2 mb-lg-0 align-items-center">
                           
                        
                            <li class="nav-item dropdown">
                                <a class="nav-link py-0 d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="https://images.squarespace-cdn.com/content/v1/5a73eecbe5dd5b61a30921f6/1626305816569-60YHH6SN7PBA455EE9P2/SteamIconCilantro1.png" alt="User-Profile" class="img-fluid avatar avatar-50 avatar-rounded">
                                    <div class="caption ms-3 d-none d-md-block ">
                                        <h6 class="mb-0 caption-title"><?=$_SESSION['name']. " " . $_SESSION['surname']?></h6>
                                    </div>
                            
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="../index.php">Anasayfa</a>
                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">Çıkış Yap</a>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            
            <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Çıkış</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Çıkış yapmak istediğinize emin misiniz?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">İptal</button>
                    <a href="actions/logout.php" class="btn btn-primary">Çıkış Yap</a>
                </div>
            </div>
        </div>
    </div>