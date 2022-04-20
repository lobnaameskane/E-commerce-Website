<?php
require_once "./req/verify.php";

?>
<!DOCTYPE html>
<html lang="en">
<?php

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>panier</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/navbar.css" rel="stylesheet">
    <script src="../js/jquery-3.5.1.slim.min.js"></script>

    <script src="../js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../css/bootstrap-icons.css">
    <link rel="stylesheet" href="../css/index.css">
    <style>


    </style>
</head>

<body>
    <div>
        <?php
        require_once "../req/navbar.php";

        ?>
    </div>

    <div class="container">
        <div class="jumbotron ">
            <div class="row mt-4">
                <div class="col-md-3 ">
                    <div class="list-group ">
                        <a href="infos.php" class="list-group-item list-group-item-action ">Profile</a>
                        <a href="commandes.php" class="list-group-item list-group-item-action active">Commandes</a>
                        <a href="wishlist.php" class="list-group-item list-group-item-action">Wishlist</a>
                        <a href="statistiques.php" class="list-group-item list-group-item-action">Statistiques</a>
                        <a href="adresse.php" class="list-group-item list-group-item-action ">Adresse</a>

                    </div>
                </div>
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4>Vos Commandes</h4>
                                    <hr>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-info" id="div_nbr">
                                        Nombre des commandes : <span id="nbr_cmnd"></span>
                                    </div>

                                    <table class="table table-hover" id="table_search">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th scope="col">id de la commande</th>
                                                <th scope="col">Date</th>
                                                <th scope="col">Etat</th>
                                                <th scope="col">Montant</th>
                                                <th scope="col">Option</th>
                                            </tr>
                                        </thead>
                                        <tbody id="table_body">

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div>

        <?php
        require_once "../req/footbar.php";

        ?>
    </div>
    <!-- Modal -->
    <div class="modal  fade" id="modal_details" tabindex="-1" aria-labelledby="modal_details" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" id="modal_content">

            </div>
        </div>
    </div>

</body>

<script>
    function show_details(id_commande, nom_client, tel_client) {
        fetch("../php/commandes/commande_read?id_commande=" + id_commande).then(resp => resp.json()).then(json => {
            const data = json.data;
            const commande_details = data.commande_details;
            const commande_info = data.commande_info;
            $('#modal_content').html(`
                     <div class="modal-header">
                    <h5 class="modal-title" id="exampleModal">Commande N° ${id_commande}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mt-2 col-12 row">
                        <div class="col-auto">

                            <h6>
                                informations Clients
                            </h6>
                        </div>
                        <div class="col">
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label>Nom Client</label>
                            <input type="text" class="form-control" readonly value="${nom_client}">

                        </div>
                        <div class="col-6">
                            <label>telephone</label>
                            <input type="text" class="form-control" readonly value="${tel_client}">
                        </div>
                    </div>
                    <div class="mt-2 col-12 row">
                        <div class="col-auto">
                            <h6>
                                informations Commande
                            </h6>
                        </div>
                        <div class="col">
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label>valeur de la commande</label>
                            <input type="text" class="form-control" readonly value="${parseFloat(commande_info.prix_commande).toFixed(2)}">
                        </div>
                        <div class="col-6">
                            <label>date heure</label>
                            <input type="text" class="form-control" readonly value="${commande_info.date_commande}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label>statut de la commande</label>
                            <input type="text" class="form-control" readonly value="${commande_info.etat_actuell}">

                        </div>
                        <div class="col-6">
                            <label>date de statut</label>
                            <input type="text" class="form-control" readonly value="${commande_info.date_etat_actuel}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <label>Adresse de livraison</label>
                            <textarea  rows="4" type="text" class="form-control" read-only >${commande_info.adresse}</textarea>
                        </div>
                    </div>  
                    <div class="mt-2 col-12 row">
                        <div class="col-auto">
                            <h6>
                                contenu commandes
                            </h6>
                        </div>
                        <div class="col">
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 mt-1">
                            <table class="table table-hover" id="table_search">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Produit</th>
                                        <th scope="col">Marque</th>
                                        <th scope="col">p. Unit</th>
                                        <th scope="col">Qtt</th>
                                        <th scope="col">Total</th>
                                    </tr>
                                </thead>
                                <tbody id="table_body">
                                    ${commande_details.map((el,index) => `
                                        <tr>
                                            <td>${index+1}</td>
                                            <td>${el.label}</td>
                                            <td>${el.nom_marque}</td>
                                            <td>${el.prix_produit_commande}</td>
                                            <td>${el.qtt_commande}</td>
                                            <td>${(el.prix_produit_commande*el.qtt_commande).toFixed(2)}</td>
                                        </tr>`)}
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
                
                     `);

            $('#modal_details').modal('show')
        }).catch(err => {
            console.log(err);
        });
    };













    $(document).ready(get_data(event));

    function get_data(event) {
        fetch("../php/profile/client_commande").then(resp => resp.json()).then(json => {
            var data = json.data;
            $("#table_body").text('');
            data.forEach((element, index) => {
                $('#table_body').append(`
                <tr class=" ${element.valide==1? "table-success":element.valide==-1?"table-danger":"" }">
                    <td>${element.id_commande}</td>
                    <td>${element.date_commande}</td>
                    <td>${element.etat_actuell}</td>
                    <td>${element.prix_commande}</td>
                    <td>
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Options</button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="#" onclick='show_details (${element.id_commande},"${element.nom_complet}","0${element.tel_adresse_client}");'>Voir Details</a>
                                <a class="dropdown-item" href="../recap?id_commande=${element.id_commande}">afficher recu</a>
                            </div>
                    </td>
                </tr>
                `);
            });
            $("#nbr_cmnd").text(data.length);

        }).catch(err => {
            console.log(err);
        });
    }
</script>

</html>