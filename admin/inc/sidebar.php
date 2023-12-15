<aside class="sidebar sidebar-default navs-shape">
        <div class="sidebar-header d-flex align-items-center justify-content-start">
            <a href="panel" class="navbar-brand d-flex justify-content-center align-items-center">
        
            <i class="fa fa-coffee" aria-hidden="true"></i>
        
            <h3 class="logo-title ms-2 text-primary">Kahve Dükkanı</h3>
            </a>
            <div class="sidebar-toggle" data-toggle="sidebar" data-active="true">
                <i class="icon">
                    <svg width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4.25 12.2744L19.25 12.2744" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M10.2998 18.2988L4.2498 12.2748L10.2998 6.24976" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </i>
            </div>
        </div>
        <div class="sidebar-body pt-0 data-scrollbar">
            <div class="collapse navbar-collapse" id="sidebar-parent">
                <ul class="navbar-nav iq-main-menu py-4">
                    <li class="nav-item">
                        <a class="nav-link <?=$sayfa == "Ürünler" ? 'active' : '' ?>" aria-current="page" href="index.php">
                            <i class="icon">
                             <i class="fa-solid fa-bars"></i>
                            </i>
                            <span class="item-name">Ürünler</span>
                        </a>
                    </li>                
                    <li class="nav-item">
                        <a class="nav-link <?=$sayfa == "Kampanya" ? 'active' : '' ?>" href="promotions.php">
                            <i class="icon">
                             <i class="fa-solid fa-document"></i>
                            </i>
                            <span class="item-name">Kampanya Kodları</span>
                        </a>
                    </li>
                </ul>
            </div>

        </div>
    </aside>
