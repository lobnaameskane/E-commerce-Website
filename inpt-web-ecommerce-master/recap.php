<?php session_start();?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>recu</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/navbar.css" rel="stylesheet">
    <script src="js/jquery-3.5.1.slim.min.js"></script>

    <script src="js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap-icons.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/dilevery.css">

<body>
    <?php
    require_once "req/navbar.php";
    require_once "./req/verify.php";


    ?>
    <div class="container-fluid" style="background-color: rgb(0,0,40);">
        <div class="jumbotron mb-0 mt-5">
            <div class="card">
                <div class="title">Recu de la commande </div>
                <div class="info">
                    <div class="row">
                        <div class="col-7"> <span id="heading">Date</span><br> <span id="date_commande"></span> </div>
                        <div class="col-5 pull-right"> <span id="heading">commande numero</span><br> <span id="num_commande"></span> </div>
                    </div>
                </div>
                <div class="pricing" id="products">

                </div>
                <div class="total">
                    <div class="row">
                        <div class="col-9"></div>
                        <div class="col-3">
                            <bigger id="prix_commande"></bigger>
                        </div>
                    </div>
                </div>
                <div class="tracking">
                    <div class="title">Suivie de la commande</div>
                    <ul id="tracking">

                    </ul>
                </div>


            </div>
            <div class="d-flex justify-content-end  ">
                <button type="print" class="btn btn-primary" onclick="window.print()"> imprimer</button>
            </div>

        </div>
    </div>

    <div class="container-fluid">
        <?php
        require_once "req/footbar.php";

        ?>
    </div>

    <script>
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        if (!urlParams.has("id_commande"))
            location.replace("index");

        fetch("../php/commandes/commande_read?id_commande=" + urlParams.get("id_commande")).then(resp => resp.json()).then(json => {
            var data = json.data;
            var commande_info = data.commande_info;
            var commande_details = data.commande_details;

            commande_details.forEach(element => {
                $("#products").append(`
                    <div class="row">
                            <div class="col-8"> <span >${element.label}</span> <span class="text-muted"> : ${element.nom_marque} | ${element.options_produit.replace(/(<([^>]+)>)/gi, ",")}</span> </div>
                            <div class="col-1"> <span >X${element.qtt_commande}</span></div>
                            <div class="col-3"> <span id="price">${(element.prix_produit_commande*element.qtt_commande).toFixed(2)}</span> </div>
                            <div class="col-1"></div>
                            <div class="col"><span class="text-muted" > </span></div>
                    </div>
                    <hr>
                `);
            })
            $("#date_commande").text(commande_info.date_commande);
            $("#num_commande").text(urlParams.get("id_commande"));
            $("#prix_commande").text(commande_info.prix_commande.toFixed(2));
            commande_info.script_etat.split(/\n/g).filter(element=> element.length>0).forEach(element => {
                $("#tracking").append(`<li>${element}</li>`);

            })


        }).catch(err => {
            console.log(err);
        });
    </script>
</body>

</head>

</html>