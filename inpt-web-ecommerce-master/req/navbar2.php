<nav class=" navbar navbar-expand-sm navbar-light fixed-top bg-light">
    <div class="navbar-brand  ">
        <a href="#" class="h4" style="color:navy"><img src="img/logo.png" height="40">AMOIL</a>
    </div>
    <div class="col-6 col-lg-8  col-md-5 col-sm-4 d-flex justify-content-center">
        <input class="form-control " type="text" placeholder="Search..." style="width: 80%;">

    </div>
    <button class="navbar-toggler " data-toggle="collapse" data-target="#navigation" type="button">
        <span class="navbar-toggler-icon "></span>
    </button>
    <div class="navbar-collapse collapse" id="navigation">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a href="#" class="nav-link d-flex flex-column ">
                    <i class="bi bi-cart4 mr-4" style="font-size: 2rem;"></i>
                </a>
            </li>
            <li class="nav-item ">
                <a href="#" class="nav-link d-flex flex-column ">
                    <i class="bi bi-heart-fill ml-4 mr-4" style="font-size: 2rem;"></i>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a href="#" id="navbarDropdownAccount" class="nav-link dropdown-toggle  pl-2 pr-1 mx-1 py-3 my-n2" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" aria-label="Compte">
                    <i class="bi bi-person-circle" style="font-size: 2rem;"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownAccount">
                    <?php
                    if (!isset($_SESSION["user_id"])) {
                    ?>

                        <form class="px-4 py-3">
                            <div class="form-group">
                                <label for="exampleDropdownFormEmail1">Email address</label>
                                <input type="email" class="form-control" id="exampleDropdownFormEmail1" placeholder="email@example.com">
                            </div>
                            <div class="form-group">
                                <label for="exampleDropdownFormPassword1">Password</label>
                                <input type="password" class="form-control" id="exampleDropdownFormPassword1" placeholder="Password">
                            </div>
                            <div class="form-group">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="dropdownCheck">
                                    <label class="form-check-label" for="dropdownCheck">
                                        Remember me
                                    </label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Sign in</button>
                        </form>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">New around here? Sign up</a>
                        <a class="dropdown-item" href="#">Forgot password?</a>
                    <?php
                    } else {
                    ?>
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Something else here</a>
                    <?php
                    }
                    ?>
                </div>
            </li>


        </ul>

    </div>

</nav>
