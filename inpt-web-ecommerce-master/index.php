<?php session_start();?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AMOIL</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/navbar.css" rel="stylesheet">
    <script src="js/jquery-3.5.1.slim.min.js"></script>

    <script src="js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap-icons.css">
    <link rel="stylesheet" href="css/index.css">
    <style>

    </style>
</head>

<body>
    <?php
    require_once "req/navbar.php";
    ?>
    <div class="container ">
        <div class="jumbotron ">
            <div class="m-5">
                <form action="navigation" method="get">
                    <label for="search_input" class="form-label">Vous recherchez quelque chose ?</label>
                    <input class="form-control" type="search" name="search" id="search_input">
                </form>
            </div>

            <div class="row bg-secondary">

                <div class="col-md-3 col-sm-12  border border-warning bg-light  ml-3 ">
                    <div>
                        <h3 class="text-center  p-2 ">categories</h3>
                        <hr>
                        <ul id="categories_aside">


                        </ul>


                    </div>

                </div>
                <div class="col">
                    <div id="caroussel_banners" class="carousel slide" data-ride="carousel">

                        <ol class="carousel-indicators">
                            <?php
                            $files = array_diff(scandir("./img/banners"), array('..', '.'));
                            foreach ($files as $key => $value) {
                            ?>
                                <li data-target="#caroussel_banners" data-slide-to="<?php echo $key - 2 ?>" <?php if ($key == 2) echo 'class="active"' ?>></li>
                            <?php }
                            ?>
                        </ol>
                        <div class="carousel-inner">
                            <?php
                            foreach ($files as $key => $value) {
                            ?>
                                <div class="carousel-item <?php if ($key == 2) echo 'active' ?>">
                                    <img src="./img/banners/<?php echo $value ?>" class="d-block w-100" alt="...">
                                </div>
                            <?php }
                            ?>


                        </div>
                        <a class="carousel-control-prev" href="#caroussel_banners" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#caroussel_banners" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="row p-4 my-3">
                <h4>Mieux Notés</h4>
                <hr>
                <div id="caroussel_bestof" class="carousel slide mt-2 w-100" data-ride="carousel">
                    <div class="carousel-inner w-100" role="listbox" id="caroussel_bestof_items">



                    </div>
                    <a class="carousel-control-prev w-auto" href="#caroussel_bestof" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon bg-dark border border-dark rounded-circle" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next w-auto" href="#caroussel_bestof" role="button" data-slide="next">
                        <span class="carousel-control-next-icon bg-dark border border-dark rounded-circle" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
            <div class="row p-4 my-3">
                <h4>Nouvautés</h4>
                <hr>
                <div id="caroussel_newitems" class="carousel slide mt-2 w-100" data-ride="carousel">
                    <div class="carousel-inner w-100" role="listbox" id="caroussel_newitems_items">



                    </div>
                    <a class="carousel-control-prev w-auto" href="#caroussel_newitems" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon bg-dark border border-dark rounded-circle" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next w-auto" href="#caroussel_newitems" role="button" data-slide="next">
                        <span class="carousel-control-next-icon bg-dark border border-dark rounded-circle" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>

        </div>

    </div>
    <footer>
        <div class="container-fluid">
            <?php
            require_once "req/footbar.php";

            ?>
        </div>
    </footer>


</body>
<script>
    $('#caroussel_bestof').carousel({
        interval: 2500
    })
    $('#caroussel_newitems').carousel({
        interval: 10000
    })
    $('#caroussel_newitems').carousel({
        interval: 10000
    })




    $('.carousel .carousel-item').each(function() {
        var minPerSlide = 4;
        var next = $(this).next();
        if (!next.length) {
            next = $(this).siblings(':first');
        }
        next.children(':first-child').clone().appendTo($(this));

        for (var i = 0; i < minPerSlide; i++) {
            next = next.next();
            if (!next.length) {
                next = $(this).siblings(':first');
            }

            next.children(':first-child').clone().appendTo($(this));
        }
    });


    fetch("./php/categories/categories_read").then(resp => resp.json()).then(json => {
        const data = json.data;
        data.forEach(element => {
            $("#categories_aside").append(`
                <li><a href="navigation?categorie=${element.id_categorie}" title="${element.prod_count} produits dans cette categorie">${element.nom_categorie}</a></li>
            `)
        });
    });
    fetch("./php/products/get_most_products").then(resp => resp.json()).then(json => {
        const data = json.data;
        for (let index = 0; index < data.length / 3; index++) {
            $("#caroussel_bestof_items").append(`
                <div class="carousel-item ${index==0?'active':''}">
                    <div class="col-md-6 col-lg-4">
                        <div class="card  card_item  m-2 p-1">
                            <a href="produit?id_produit=${data[index].id_produit}">
                                <img src="img/products/${data[index].id_produit}.jpg" class="card-img-top w-100" >
                            </a>
                        <div class="card-body">
                            <a href="#" style="color: black;">
                                <span class="card-title h4">${data[index].label}</span>
                            </a>
                            <a href="#" class="btn btn-primary">BUY</a>
                            <span class="h6" style="margin-left: 30%;">${data[index].prix_produit.toFixed(2)} DH</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                        <div class="card  card_item  m-2 p-1">
                            <a href="produit?id_produit=${data[index+1].id_produit}">
                                <img src="img/products/${data[index+1].id_produit}.jpg" class="card-img-top w-100" >
                            </a>
                        <div class="card-body">
                            <a href="#" style="color: black;">
                                <span class="card-title h4">${data[index+1].label}</span>
                            </a>
                            <a href="#" class="btn btn-primary">BUY</a>
                            <span class="h6" style="margin-left: 30%;">${data[index+1].prix_produit.toFixed(2)} DH</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                        <div class="card  card_item  m-2 p-1">
                            <a href="produit?id_produit=${data[index+2].id_produit}">
                                <img src="img/products/${data[index+2].id_produit}.jpg" class="card-img-top w-100" >
                            </a>
                        <div class="card-body">
                            <a href="#" style="color: black;">
                                <span class="card-title h4">${data[index+2].label}</span>
                            </a>
                            <a href="#" class="btn btn-primary">BUY</a>
                            <span class="h6" style="margin-left: 30%;">${data[index+2].prix_produit.toFixed(2)} DH</span>
                        </div>
                    </div>
                </div>
                
            </div>
            `);
        }

    });
    fetch("./php/products/get_newest_products").then(resp => resp.json()).then(json => {
        const data = json.data;

        for (let index = 0; index < data.length / 3; index++) {
            $("#caroussel_newitems_items").append(`
                <div class="carousel-item ${index==0?'active':''}">
                    <div class="col-md-6 col-lg-4">
                        <div class="card  card_item  m-2 p-1">
                            <a href="produit?id_produit=${data[index].id_produit}">
                                <img src="img/products/${data[index].id_produit}.jpg" class="card-img-top w-100" >
                            </a>
                        <div class="card-body">
                            <a href="#" style="color: black;">
                                <span class="card-title h4">${data[index].label}</span>
                            </a>
                            <a href="#" class="btn btn-primary">BUY</a>
                            <span class="h6" style="margin-left: 30%;">${data[index].prix_produit.toFixed(2)} DH</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                        <div class="card  card_item  m-2 p-1">
                            <a href="produit?id_produit=${data[index+1].id_produit}">
                                <img src="img/products/${data[index+1].id_produit}.jpg" class="card-img-top w-100" >
                            </a>
                        <div class="card-body">
                            <a href="#" style="color: black;">
                                <span class="card-title h4">${data[index+1].label}</span>
                            </a>
                            <a href="#" class="btn btn-primary">BUY</a>
                            <span class="h6" style="margin-left: 30%;">${data[index+1].prix_produit.toFixed(2)} DH</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                        <div class="card  card_item  m-2 p-1">
                            <a href="produit?id_produit=${data[index+2].id_produit}">
                                <img src="img/products/${data[index+2].id_produit}.jpg" class="card-img-top w-100" >
                            </a>
                        <div class="card-body">
                            <a href="#" style="color: black;">
                                <span class="card-title h4">${data[index+2].label}</span>
                            </a>
                            <a href="#" class="btn btn-primary">BUY</a>
                            <span class="h6" style="margin-left: 30%;">${data[index+2].prix_produit.toFixed(2)} DH</span>
                        </div>
                    </div>
                </div>
                
            </div>
            `);
        }

    });
</script>

</html>