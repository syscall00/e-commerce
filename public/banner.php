<body class="d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-md navbar-light bg-light">
        <a href="/public" class="navbar-brand">Ecommerce</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar5">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-collapse collapse justify-content-stretch" id="navbar5">
            <form class="ml-3 my-auto d-inline w-75" method="post" action="search">
                <div class="input-group">
                    <input type="text" class="form-control border-right-0" placeholder="Cerca un prodotto..." name="search" autocomplete="off" required />
                    <div class="input-group-append">
                        <button class="btn btn-outline-primary border-left-0" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                    </div>
                </div>
            </form>
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Il mio profilo</a>
                    <div class="dropdown-menu" aria-labelledby="dropdown01">
                        <a class="dropdown-item" href="/public/my/order">I miei ordini</a>
                        <a class="dropdown-item" href="/public/my/wishlist">La mia wishlist</a>
                        <a class="dropdown-item" href="/public/logout">Logout</a>
                    </div>
                </li>

                <li class="nav-item">
                    <span class="badge badge-pill badge-primary" id="cart-prod">0</span>
                    <a class="nav-link" href="/public/cart">Carrello</a>
                </li>
            </ul>
        </div>
    </nav>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" />
    <script src="js/banner/autocomplete.js"></script>
</body>
