<?php session_start(); ?>
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
        .options_label {
            background-color: #dc3545;
            border-color: #dc3545;
            color: white;
        }

        .options_label:hover,
        .options_label:focus,
        .options_label:active,
        .options_label.active {
            background-color: #d32535;
            border-color: #bd2130;
            color: white;

        }
    </style>

</head>

<body>
    <?php require_once "req/navbar.php"; ?>



    <div class="container">
        <div class=" jumbotron ">
            <div class="">
                <div class="row " id="product_section">
                    <!--premiere section-->

                </div>
            </div>



            <div>
                <div>
                    <div>
                        <div class="card">
                            <nav class="nav nav-tabs">
                                <a class="nav-item nav-link active" href="#p1" data-toggle="tab">Description</a>
                                <a class="nav-item nav-link" href="#p2" data-toggle="tab">Commentaires</a>
                            </nav>
                            <div class="tab-content" id="tab-content">


                            </div>

                        </div>
                    </div>
                </div>
            </div>



            <div>
                <h2 class="my-5" style="color: rgb(2, 2, 58);text-decoration: underline;font-style: italic;">De la meme catégorie
                </h2>
                <div class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner w-100" id="same_categorie">
                    </div>

                </div>

                <h2 class="my-5" style="color: rgb(2, 2, 58);text-decoration: underline;font-style: italic;">Vous pouvez admirer
                    aussi</h2>
                <div id="carouselControls2" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner w-100" id="new_items">



                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="toast bg-success text-dark" role="alert" id="toast_cart" aria-live="assertive" style="position: absolute; top: 100px; right: 0;width:25%" aria-atomic="true">
        <div class="toast-header">
            <i class="bi bi-check2 text-success"></i>
            <strong class="mr-auto">Succes</strong>
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="toast-body">
            Ajouté au panier !!!
        </div>
    </div>

    </div>

    <div class="container-fluid">
        <?php
        require_once "req/footbar.php";

        ?>
    </div>

    <script>
        var product = {};
        var inside = null;
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        if (!urlParams.has("id_produit"))
            window.location.replace("..");
        else {
            fetch("./php/products/read_product?id_produit=" + urlParams.get("id_produit")).then(resp => resp.json()).then(json => {
                const data = json.data;
                inside = json.inside;
                product = data.product;
                options = data.options;
                $("#product_section").html(`
                <div class="col-12 col-md-6 mt-5">
                        <div class="row">
                            <div class="col">

                                <img src="img/products/${product.id_produit}.jpg" alt="" class="card-img" style="max-height: 400px;">

                            </div>
                        </div>
                        <!--d'autres photos (ajouter un carroussel apres)
                        <div class="row mx-3 my-2">
                            <div class="col-3">
                                <div class="card ">
                                    <a href=""><img src="img/pc2.jpeg" alt="" class="card-img"></a>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="card ">
                                    <a href=""><img src="img/pc2.jpeg" alt="" class="card-img"></a>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="card ">
                                    <a href=""><img src="img/pc2.jpeg" alt="" class="card-img"></a>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="card ">
                                    <a href=""><img src="img/pc2.jpeg" alt="" class="card-img"></a>
                                </div>
                            </div>
                        </div>-->
                    </div>
                    <!--deuxieme section-->
                    <div class="col-12 col-md-6 mt-5">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-9">
                                <h5 class="card-title text-secondary">${product.nom_marque}</h5>
                                <h3 class="card-title">${product.label}</h3>
                                </div>
                                <div class="col-3" id="divheart">
                                    <i class="bi ${inside?"bi-suit-heart-fill":"bi-suit-heart"}" id="hearti"  style="font-size: 22px; color:red;" onclick="add_to_wishlist(${product.id_produit})"></i>
                                </div>
                            </div>
                            <div>
                                <ul class="list-inline pull-right">
                                    <li>
                                        <i class="bi bi-star-fill" style="color: yellow;"></i>
                                        <i class="bi bi-star-fill" style="color: yellow;"></i>
                                        <i class="bi bi-star-fill" style="color: yellow;"></i>
                                        <i class="bi bi-star-half" style="color: yellow;"></i>
                                        <i class="bi bi-star" style="color: yellow;"></i>
                                    </li>
                                </ul>
                            </div>
                            <form action="" id="form_product">
                            <h4 style="color: red;">${product.prix_produit.toFixed(2) || 0} DH</h4>
                            ${options.map((element,index)=> `<h5 class="mt-2 mx-3 "><small>${element.type_options}:</small></h5>
                            <div class="btn-group btn-group-toggle d-flex justify-content-around" data-toggle="buttons">
                                ${element.options.split(";").map((option,index)=> `
                                    <label class="btn  btn-warning options_label ${index==0?'active':''}">
                                    <input type="radio" name="${element.type_options}" value="${option}"  autocomplete="off" ${index==0?'checked':''}> ${option}
                                    </label>`)}
                            </div>
                                `) }
                            
                                <div class="form-group">
                                    <span>
                                        <h5 class="card-text mt-2 mx-3 "><small class="text-muted">Quantité:</small></h5>
                                    </span><input type="number" value="1" name="qtt_panier"  min="0" class=" input my-3 mx-3" style="border-radius: 15px;height: 30px;width: 130px; color:darkblue;">
                                    <div class="form-group mt-2  ">
                                    <button type="button" class="btn btn-warning" onclick="add_to_cart()" <?php if (!isset($_SESSION["id_client"])) echo "disabled"  ?> style="border-radius: 20px;">Ajouter au panier</button>
                                </div>
                                    </div>
                               
                            </form>
                        </div>
                    </div>
                `);
                //FIX COMMENTS
                $("#tab-content").html(`
                                <div class="tab-pane active  p-3 " id="p1">${product.description_produit}</div>
                                <div class="tab-pane " id="p2">
                                    <div class="card  mx-3 my-3 ">
                                        <div class="card-body">
                                            <h6 class="card-title ">User x</h6>
                                            This is some text within a card body.
                                        </div>
                                    </div>
                                    <div class="card  mx-3 my-3 ">
                                        <div class="card-body">
                                            <h6 class="card-title ">User x</h6>
                                            This is some text within a card body.
                                        </div>
                                    </div>
                `);
            })

        }


        fetch("./php/products/get_most_products").then(resp => resp.json()).then(json => {
            const data = json.data;
            for (let index = 0; index < data.length / 2; index++) {
                const element = data[index];
                $("#same_categorie").append(`
                <div class="carousel-item ${index==0?'active':''}">
                    <div class="col-12 col-lg-4">
                        <div class="card">
                            <a href="?id_produit=${data[index].id_produit}"><img src="./img/products/${data[index].id_produit}.jpg" class="card-img-top" alt="...">
  </a>                           <div class="card-body">
                                <a class="stretched-link" href="?id_produit=${data[index].id_produit}" style="color: rgb(2, 2, 58);">
                                    <span class="card-title h4">${data[index].label}</span>
                                </a>
                                <p style="color:gray">description</p>
                                <a href="?id_produit=${data[index].id_produit}" class="btn btn-danger">Acheter</a>
                                <span class="h6" style="margin-left:20px;">${data[index].prix_produit.toFixed(2)} DH</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="card">
                            <a href="?id_produit=${data[index+1].id_produit}"><img src="./img/products/${data[index+1].id_produit}.jpg" class="card-img-top" alt="..."> </a>
                            <div class="card-body">
                                <a class="stretched-link" href="?id_produit=${data[index+1].id_produit}" style="color: rgb(2, 2, 58);">
                                    <span class="card-title h4">${data[index+1].label}</span>
                                </a>
                                <p style="color:gray">description</p>
                                <a href="?id_produit=${data[index+1].id_produit}" class="btn btn-danger">Acheter</a>
                                <span class="h6" style="margin-left:20px;">${data[index+1].prix_produit.toFixed(2)} DH</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="card">
                            <a href="?id_produit=${data[index+2].id_produit}"><img src="./img/products/${data[index+2].id_produit}.jpg" class="card-img-top" alt="..."> </a>
                            <div class="card-body">
                                <a class="stretched-link" href="?id_produit=${data[index+2].id_produit}" style="color: rgb(2, 2, 58);">
                                    <span class="card-title h4">${data[index+2].label}</span>
                                </a>
                                <p style="color:gray">description</p>
                                <a href="?id_produit=${data[index+2].id_produit}" class="btn btn-danger">Acheter</a>
                                <span class="h6" style="margin-left:20px;">${data[index+2].prix_produit.toFixed(2)} DH</span>
                            </div>
                        </div>
                    </div>
                </div>                     
            `);
            }
        });
        fetch("./php/products/get_newest_products").then(resp => resp.json()).then(json => {
            const data = json.data;
            for (let index = 0; index < data.length / 2; index++) {
                const element = data[index];
                $("#new_items").append(`
                <div class="carousel-item ${index==0?'active':''}">
                    <div class="col-12 col-lg-4">
                        <div class="card">
                            <a href="?id_produit=${data[index].id_produit}"><img src="./img/products/${data[index].id_produit}.jpg" class="card-img-top" alt="...">
  </a>                           <div class="card-body">
                                <a class="stretched-link" href="?id_produit=${data[index].id_produit}" style="color: rgb(2, 2, 58);">
                                    <span class="card-title h4">${data[index].label}</span>
                                </a>
                                <p style="color:gray">description</p>
                                <a href="?id_produit=${data[index].id_produit}" class="btn btn-danger">Acheter</a>
                                <span class="h6" style="margin-left:20px;">${data[index].prix_produit.toFixed(2)} DH</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="card">
                            <a href="?id_produit=${data[index+1].id_produit}"><img src="./img/products/${data[index+1].id_produit}.jpg" class="card-img-top" alt="..."> </a>
                            <div class="card-body">
                                <a class="stretched-link" href="?id_produit=${data[index+1].id_produit}" style="color: rgb(2, 2, 58);">
                                    <span class="card-title h4">${data[index+1].label}</span>
                                </a>
                                <p style="color:gray">description</p>
                                <a href="?id_produit=${data[index+1].id_produit}" class="btn btn-danger">Acheter</a>
                                <span class="h6" style="margin-left:20px;">${data[index+1].prix_produit.toFixed(2)} DH</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="card">
                            <a href="?id_produit=${data[index+2].id_produit}"><img src="./img/products/${data[index+2].id_produit}.jpg" class="card-img-top" alt="..."> </a>
                            <div class="card-body">
                                <a class="stretched-link" href="?id_produit=${data[index+2].id_produit}" style="color: rgb(2, 2, 58);">
                                    <span class="card-title h4">${data[index+2].label}</span>
                                </a>
                                <p style="color:gray">description</p>
                                <a href="?id_produit=${data[index+2].id_produit}" class="btn btn-danger">Acheter</a>
                                <span class="h6" style="margin-left:20px;">${data[index+2].prix_produit.toFixed(2)} DH</span>
                            </div>
                        </div>
                    </div>
                </div>                   
            `);

            }

        });

        function add_to_cart() {
            var data = $("#form_product").serialize();
            data += "&id_produit=" + product.id_produit;
            fetch("php/cart/add_to_cart.php?" + data).then(resp => resp.json()).then(json => {
                $('#toast_cart').toast({
                    delay: 3000
                })
                $('#toast_cart').toast('show')
            }).catch(err => console.log(err));
        }





        function add_to_wishlist(id_produit) {
            //TODO FIX THIS

            if (!inside)
                fetch("../php/Favoris/addw?id_produit=" + id_produit).then(resp => resp.json()).then(json => {
                    $("#hearti").removeClass("bi-suit-heart");
                    $("#hearti").addClass("bi-suit-heart-fill");

                }).catch(err => {
                    console.log(err);
                });
            else
                fetch("../php/Favoris/delp?id_produit=" + id_produit).then(resp => resp.json()).then(json => {
                    if (json.code == 200) {
                        $("#hearti").removeClass("bi-suit-heart-fill");
                        $("#hearti").addClass("bi-suit-heart");
                    }
                }).catch(err => {
                    console.log(err);
                });
            inside = !inside;
        };
    </script>


</body>

</html>