<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>panier</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/navbar.css" rel="stylesheet">
    <script src="js/jquery-3.5.1.slim.min.js"></script>

    <script src="js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap-icons.css">
    <link href="css/navbar.css" rel="stylesheet">
    <link href="css/cart.css" rel="stylesheet">
    <script src="js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="css/bootstrap-icons.css">
    <style>


    </style>
</head>

<body>
    <div>
        <?php
        require_once "req/navbar.php";

        ?>
    </div>
    <div class="container-fluid  ">


        <div class="container-fluid ">
            <div class="jumbotron d-flex justify-content-center ">
                <div class="card col-12">
                    <div class="card-top border-bottom text-center"> <a href="index.php" class="link"> Retour a la boutique</a> <span id="logo">Amoil.com</span> </div>
                    <div class="card-body">
                        <div class="row upper"> <span class="panier"> Panier</span> <button type="button" onclick="go_to_dilevery()" class="btn btn-success payment">Payment <i class="bi bi-arrow-right-square"></i></button> </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="left border">
                                    <div class="row"><span><i class="bi bi-basket3-fill " style="font-size: 2rem ;" aria-hidden="true"></i></i></span> <span class="header" style="font-size: 2rem;"> Panier</span></div>

                                    <div id="cart_content">

                                    </div>

                                    <div class="d-flex justify-content-end h3">

                                        <span id="total"></span>

                                    </div>
                                </div>


                            </div>


                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
    </div>
    <div class="toast bg-danger text-light" role="alert" id="toast_delete" aria-live="assertive" style="position: absolute; top: 100px; right: 0;" aria-atomic="true">
        <div class="toast-header">
            <i class="bi bi-trash text-danger"></i>
            <strong class="mr-auto">Supprimée</strong>
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="toast-body">
            Supprimé avec succée
        </div>
    </div>



    <!--modal-->
    <div class="modal  fade" id="modal_details" tabindex="-1" aria-labelledby="modal_details" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" id="modal_content">

            </div>
        </div>
    </div>
    <!--toast-->
    <div class="toast bg-danger text-light" role="alert" id="toast_products" aria-live="assertive" style="position: absolute; top: 100px; right: 0;" aria-atomic="true">
        <div class="toast-header">
            <i class="bi bi-x-octagon-fill text-danger"></i>
            <strong class="mr-auto">Erreur</strong>
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="toast-body">
            Impossible de passer une commande sans produits.
        </div>
    </div>


    <div>

        <?php
        require_once "req/footbar.php";
        ?>
        <script>
            <?php
            if (!isset($_SESSION["id_client"]))
                header("location: index.php");
            else
                echo "const id_client=" . $_SESSION["id_client"] . ";";
            ?>
            var products = [];
            //TODO ADD DETAILS 

            $(document).ready(function() {
                $('#toast_products').toast({
                    delay: 3000
                })
            });

            function fill_cart_div() {
                $("#cart_content").text('');
                products.forEach((element, index) => {
                    $('#cart_content').append(`
                        <div class="card mb-3 p-0 h-25">
                            <div class="row no-gutters">
                                <div class="col-md-2">
                                    <img src="img/products/${element.id_produit}.jpg" class="card-img w-75" alt="image_produit">
                                </div>
                                <div class="col-md-10">
                                    <div class="card-body p-3 col-12   " style="width: 100%;">
                                        <span class="card-title mr-5 h5 " style="color: black;"><span style="color: black;">${element.label}</span>
                                        <span class="card-title mr-5 h6 " style="color: black;"><span style="color: black;">${element.options_produit}</span>   
                                        <span>
                                                <span class="border pt-2 pl-3 pr-3 pb-1" id="qty">${element.qtt_panier}</span>
                                                <button id="minus" onclick="change_qtt(${index},'-')" style="padding: 2px 5px; border-radius: 10px; background-color: rgb(230,230,230) ;border-color:(230,230,230); border-width: 1px;">-</button>
                                                <button id="plus" onclick="change_qtt(${index},'+')" style="padding: 2px 3px; border-radius: 10px; background-color: rgb(230,230,230) ;border-color:(230,230,230); border-width: 1px;">+</button>
                                            </span>
                                            <span >
                                                <span class="mr-1" id="price" style="color: black;">${(element.prix_produit*element.qtt_panier).toFixed(2)}</span>
                                                <span style="color: black;">DH</span>
                                            </span>
                                            
                                        </span>
                                        <div class="mt-1">
                                            <div class="d-flex justify-content-end px-3">
                                                <a href="produit?id_produit=${element.id_produit}" style="border-radius: 5px;" class="h-50 w-25 btn btn-info">VOIR</a>
                                                <button style="border-radius: 5px;" class="h-50 w-25 ml-1 p-1 btn-danger" onclick="retirer_du_panier(${index})"><i class="bi bi-trash"></i> RETIRER</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        `);
                });
                $("#total").text(products.reduce((a, b) => a + b.qtt_panier * b.prix_produit, 0).toFixed(2) + " DH");


            }


            function search() {
                fetch("../php/cart/cart_read").then(resp => resp.json()).then(json => {
                    var data = json.data;
                    products = data;
                    fill_cart_div()



                }).catch(err => {
                    console.log(err);
                });
            }

            function retirer_du_panier(index) {
                var element = products[index];
                console.log(element);
                $('#modal_content').html(`
                    <div class="modal-header">
                        <h5 class="modal-title" >RETIRER DU PANIER</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Etes-vous sûr de vouloir retirer ce produit du panier?</p>
                        <div class="col-12">
                                    <div class="card-body p-3 col-12  row" style="width: 100%;">
                                        <div class="col-2">
                                            <img src="img/products/${element.id_produit}.jpg" class="card-img w-75" alt="image_produit">
                                        </div>
                                        <div class="col-9">
                                        <span>
                                            <span class="card-title p-0 h5 d-flex justify-content-between" style="color: black;"><span style="color: black;">${element.label}</span>
                                                <span>
                                                    <span class="border pt-2 pl-3 pr-3 pb-1" id="qty">${element.qtt_panier}</span>
                                                </span>
                                                <span>
                                                    <span class="mr-1" id="price" style="color: black;">${element.prix_produit}</span>
                                                    <span style="color: black;">DH</span>
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Anuller</button>
                        <button type="button" onclick="delete_produit(${index})" class="btn btn-danger"><i class="bi bi-trash"></i>  Suprrimer</button>
                    </div>`);
                $('#modal_details').modal('show');
            }

            function delete_produit(index) {
                var element = products[index];

                fetch("../php/cart/delete_from_cart?id_produit=" + element.id_produit + "&options_produit=" + element.options_produit).then(resp => resp.json()).then(json => {
                    $("#modal_details").modal("hide");
                    $('#toast_delete').toast({
                        delay: 1500
                    })
                    $('#toast_delete').toast('show')

                    search();

                }).catch(err => {
                    console.log(err);
                });
            }

            function change_qtt(index, char) {
                var element = products[index];
                var qtt_panier = (char == '+') ? element.qtt_panier + 1 : (element.qtt_panier > 0) ? element.qtt_panier - 1 : 0;
                if (qtt_panier != element.qtt_panier) {
                    console.log("updating");
                    element.qtt_panier = qtt_panier;
                    fetch("php/cart/update_cart.php?id_produit=" + element.id_produit + "&qtt_panier=" + element.qtt_panier + "&options_produit=" + element.options_produit).then(resp => resp.json()).then(json => {
                        console.log(json);
                        fill_cart_div();
                    }).catch(err => console.log(err));
                }

            }

            function go_to_dilevery() {
                var valide = false;
                products.forEach(element => {
                    if (element.qtt_panier > 0) {
                        valide = true;
                        return;
                    }
                });
                if (valide) {
                    location.replace("dilevery");
                } else {
                    $('#toast_products').toast('show')

                }

            }


            //id_client de la session
            search();
        </script>

</body>

</html>