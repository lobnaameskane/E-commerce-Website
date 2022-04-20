<?php require "req/verify.php";  ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <link href="../css/navbar.css" rel="stylesheet">
    <script src="../js/jquery-3.5.1.slim.min.js"></script>

    <script src="../js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../css/bootstrap-icons.css">
    <link rel="stylesheet" href="../css/admin/sidebar.css">


</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <?php require "req/sidebar.php" ?>
            <div class="col pt-4 ">
                <div class="container.fluid">

                    <h2>
                        <a href="" data-target="#sidebar" data-toggle="collapse" class="d-md-none"><i class="fa fa-bars"></i></a>Historique des commandes
                    </h2>
                    <h6 class="hidden-sm-down">page pour valider les commandes</h6>
                    <hr>

                    <div class="mt-5">
                        <div class="alert alert-info" id="div_nbr" hidden>
                            Nombre des commandes trouvées : <span id="nbr_cmnd"></span>
                        </div>

                        <table class="table table-hover" id="table_search">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Client</th>
                                    <th scope="col">Date Heure</th>
                                    <th scope="col">Etat</th>
                                    <th scope="col">Montant</th>
                                    <th scope="col">Options</th>
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
    <!-- Modal -->
    <div class="modal  fade" id="modal_details" tabindex="-1" aria-labelledby="modal_details" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" id="modal_content">

            </div>
        </div>
    </div>

    <script>
        <?php echo 'var id_user = ' . $_SESSION["id_user"] . ";"; ?>

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
                            <textarea  rows="4" type="text" class="form-control" >${commande_info.adresse}</textarea>
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="update_commande(${id_commande},1)" data-dismiss="modal">Confirmer</button>
                    <button type="button" class="btn btn-danger" onclick="update_commande(${id_commande},-1)" data-dismiss="modal">Annuler</button>
                </div>
                     `);

                $('#modal_details').modal('show')
            }).catch(err => {
                console.log(err);
            });
        };

        function update_commande(id_commande, msg) {
            fetch(`../php/commandes/commande_update?id_commande=${id_commande}&msg=${msg}&id_user=${id_user}`).then(resp => resp.json()).then(json => {
                if (json.code == 200) {
                    get_data();
                }
            }).catch(err => console.log(err));

        }


        $(document).ready(get_data(event));

        function get_data(event) {
            fetch("../php/commandes/commandes_read?get_nonvalidate=true").then(resp => resp.json()).then(json => {
                var data = json.data;
                $("#table_body").text('');
                data.forEach((element, index) => {
                    $('#table_body').append(`
                        <tr class=" ${element.valide==1? "table-success":element.valide==-1?"table-danger":"" }">
                            <td>${index+1}</td>
                            <td>${element.nom_client}</td>
                            <td>${element.date_commande}</td>
                            <td>${element.etat_actuell}</td>
                            <td>${element.prix_commande.toFixed(2)}</td>
                            <td>
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Options</button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="#" onclick='show_details (${element.id_commande},"${element.nom_client}","0${element.tel_client}");'>Voir Details</a>
                                <a class="dropdown-item" onclick="update_commande(${element.id_commande},1)">Confirmer</a>
                                <a class="dropdown-item" onclick="update_commande(${element.id_commande},-1)">annuler</a>
                                <a class="dropdown-item" href="mailto:${element.email}">emailer client</a>
                                <a class="dropdown-item" href="tel:${element.tel_client}">telephoner client</a>
                            </div>
                            </td>
                        </tr>
                        `);
                });
                $("#nbr_cmnd").text(data.length);
                $("#div_nbr").removeAttr("hidden");

            }).catch(err => {
                console.log(err);
            });
        }
    </script>


</body>

</html>