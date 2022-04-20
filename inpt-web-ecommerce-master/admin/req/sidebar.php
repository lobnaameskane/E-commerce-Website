<div class="col-2 collapse  show d-md-flex bg-secondary  text-light   pt-2 pl-0 min-vh-100" id="sidebar">
    <div>

        <h1 class="col-12  text-center mt-5">AMOIL</h1>
        <h6 class="col-12  text-center mt-4">Interface d'administration de site AMOIl</h6>

        <div class="col-12 mt-5">
            <hr>
            <ul class="nav flex-column flex-nowrap overflow-hidden">
                <li class="nav-item">
                    <a class="nav-link text-truncate" href="index"><i class="bi bi-house-fill"></i> <span class="d-none d-sm-inline">principale</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link collapsed text-truncate" href="#submenu1" data-toggle="collapse" data-target="#submenu1"><i class="bi bi-bag"></i> <span class="d-none d-sm-inline">Commandes</span></a>
                    <div class="collapse" id="submenu1" aria-expanded="false">
                        <ul class="flex-column pl-2 nav">
                            <li class="nav-item"><a class="nav-link py-0" href="./commandes.php"> <i class="bi bi-bag-check"></i><span> Validation</span></a></li>
                            <li class="nav-item"><a class="nav-link py-0" href="./commandes_hist.php"> <i class="bi bi-clock-history"></i><span> Historique</span></a></li>

                        </ul>
                    </div>
                </li>
                <?php
                if (isset($_SESSION["is_admin"])) {
                    if ($_SESSION["is_admin"] == 1) {
                ?>
                        <li class="nav-item">
                            <a class="nav-link text-truncate" href="./produits.php"><i class="bi bi-cart-check"></i> <span class="d-none d-sm-inline">Produits</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-truncate" href="./categories.php"><i class="bi bi-tags-fill"></i> <span class="d-none d-sm-inline">Categories</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-truncate" href="./brands.php"><i class="bi bi-upc-scan"></i> <span class="d-none d-sm-inline">Marques</span></a>
                        </li>
                        <li class="nav-item"><a class="nav-link text-truncate" href="./clients.php"><i class="bi bi-person-circle"></i> <span class="d-none d-sm-inline">Clients</span></a></li>

                        <li class="nav-item"><a class="nav-link text-truncate" href="./utilisateurs.php"><i class="bi bi-emoji-smile"></i> <span class="d-none d-sm-inline">Utilisateurs</span></a></li>
                <?php
                    }
                }
                ?>
            </ul>
        </div>


        <div class="col-12 text-center mt-5">
            <form method="get">
                <button class="btn btn-danger" name="disconnect"> se decconecter</button>


            </form>

        </div>

    </div>




</div>