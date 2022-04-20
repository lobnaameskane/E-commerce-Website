<?php session_start();?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <link href="css/navbar.css" rel="stylesheet">
    <script src="js/jquery-3.5.1.slim.min.js"></script>

    <script src="js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap-icons.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/payment.css">
    <style>


    </style>

</head>

<body>
    <div>
        <?php
        require_once "req/navbar.php";

        require_once "./req/verify.php";



        ?>
    </div>
    <div class="container-fluid  ">


        <div class="container-fluid ">
            <div class="jumbotron d-flex justify-content-center ">
                <div class="card">
                    <div class="card-top border-bottom text-center"> <a href="#" class="link"> Retour a la boutique</a> <span id="logo">Amoil.com</span> </div>
                    <div class="card-body">

                        <div class="row upper"> <span><i class="fa fa-check-circle-o"></i></span> </div>


                        <div class="row">
                            <div class="col-md-7">
                                <div class="left border">
                                    <div class="row"> <span class="header">Payment</span>
                                        <div class="icons"> <img src="https://img.icons8.com/color/48/000000/visa.png" /> <img src="https://img.icons8.com/color/48/000000/mastercard-logo.png" /> <img src="https://img.icons8.com/color/48/000000/maestro.png" /> </div>
                                    </div>
                                    <form>
                                        <div class="row">
                                            <input type="radio" class="control-form col-1" name="payment_methode" value="liv" checked>
                                            <label class="col" for="card_payment">payment a la livraison</label>
                                        </div>
                                        <div class="row">
                                            <input type="radio" class="control-form col-1" name="payment_methode" disabled value="card">
                                            <label class="col" for="card_payment">payment par carte <span class="text-danger">(Pas Encore Disponible)</span></label>
                                        </div>
                                        <hr>
                                        <span>nom du proprietaire:</span> <input class="mb-4" placeholder="Linda Williams" disabled> <span>Numero de la carte:</span> <input class="mb-4" disabled placeholder="0125 6780 4567 9909">
                                        <div class="row">
                                            <div class=" col-4 mb-4"><span>date d'expiration:</span> <input placeholder="YY/MM" disabled> </div>
                                            <div class="col-4 mb-2"><span>CVV:</span> <input id="cvv" disabled> </div>
                                        </div> <input type="checkbox" id="save_card" class="align-left" disabled> <label for="save_card">Enregistrer les details de la carte banquaire</label>

                                    </form>
                                </div>

                            </div>
                            <div class="col-md-5">
                                <div class="right border" id="order_details">
                                    <div class="header">revision de la commande</div>

                                    <div id="nbr_orders">
                                    </div>
                                    <div id="products_orders">
                                    </div>

                                    <hr>
                                    <div class="row lower">
                                        <div class="col text-left">Subtotal</div>
                                        <div class="col text-right" id="subtotal"></div>
                                    </div>
                                    <div class="row lower">
                                        <div class="col text-left">livraison</div>
                                        <div class="col text-right">0 DH</div>
                                    </div>
                                    <div class="row lower">
                                        <div class="col text-left"><b>Total a payer</b></div>
                                        <div class="col text-right" id="total"><b></b></div>
                                    </div>


                                </div>
                                <button class="btn" style="border-radius:5px ;" id="finish_order" onclick="submit_order()">Terminer la commande</button>
                                <a href="cart.php"><button class="btn btn-secondary mt-2 " style="border-radius: 5px;background-color: lightgray;color:black ;">retourner au panier</button></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>




    </div>






    </div>

    <?php
    require_once "req/footbar.php";

    ?>

    <script>
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        if (!urlParams.has("id_adresse"))
            location.replace("dilevery");

        var products = [];

        function search() {
            fetch("../php/cart/cart_read").then(resp => resp.json()).then(json => {
                var data = json.data;
                products = data.filter(element => element.qtt_panier > 0);
                $("#nbr_orders").html(`<p>${products.length} produits</p>`);

                products.forEach(element => {
                    $("#products_orders").append(`<div class="row item">
                                        <div class="col-4 align-self-center"><img class="img-fluid" src="img/products/${element.id_produit}.jpg"></div>
                                        <div class="col-8">
                                            <div class="row"><b>${element.prix_produit} DH</b></div>
                                            <div class="row text-muted">${element.label} : </div>
                                            <div class="row text-muted">${element.options_produit}</div>
                                            <div class="row">Qtt:${element.qtt_panier}</div>
                                        </div>
                                    </div>`);
                })
                const total = products.reduce((a, b) => a + b.qtt_panier * b.prix_produit, 0);
                $("#subtotal").text(total + " DH");
                $("#total").text(total + " DH");
                if (products.length <= 0)
                    $("#finish_order").attr("disabled", "true");

            }).catch(err => {
                console.log(err);
            });
        }

        function submit_order() {
            fetch("../php/commandes/commande_add?id_adresse=" + urlParams.get("id_adresse")).then(resp => resp.json()).then(json => {
                if (json.code == 200) {
                    location.replace("recap?id_commande="+json.id_commande);

                }


            }).catch(err => {
                console.log(err);
            });

        };

        search();
    </script>


</body>

</html>