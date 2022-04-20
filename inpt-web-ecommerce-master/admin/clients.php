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
                <!-- Modal -->
                <div class="modal  fade" id="modal_details_delete" tabindex="-1" aria-labelledby="modal_details" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-md">
                        <div class="modal-content" id="modal_content_delete">
                        </div>
                    </div>
                </div>
                <div class="container.fluid">
                    <h1><a href="" data-target="#sidebar" data-toggle="collapse" class="d-md-none"><i class="fa fa-bars"></i></a>Clients</h1>
                    <h6 class="hidden-sm-down">Page pour visualiser les détails des clients</h6>
                    <hr>
                    <div id="alert">
                    </div>

                    <p>
                        <button class="btn btn-secondary btn-block" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                            <h5>RECHERCHE</h5>
                        </button>
                    </p>
                    <div class="collapse" id="collapseExample">
                        <form class="col-12" id='form_search'>

                            <div class='filtres'>
                                <div class='mt-2 row'>
                                    <div class="form-row p-2 col-12">
                                        <div class="pt-3 col-2">
                                            <h6>Par E-Mail: </h6>
                                        </div>
                                        <div class="mt-2 col-10">
                                            <input class="form-control mr-sm-2" type="search" placeholder="E-Mail" aria-label="Search" name="search">
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-2 row ">
                                    <div class="form-row p-2 col-12">
                                        <div class="mt-4 pt-3 col-3">
                                            <h6>Période d'Activité du Client: </h6>
                                        </div>
                                        <div class="col-2">
                                            <label for="from_date">Date Début:</label>
                                            <input type="date" name="from_date" class="form-control" id="from_date">
                                        </div>
                                        <div class="ml-3 col-2">
                                            <label for="to_date">Date Fin:</label>
                                            <input type="date" name="to_date" class="form-control" id="to_date">
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-2 row">
                                    <div class="form-row p-2 col-12">
                                        <div class="mt-4 col-3">
                                            <h6>Nombres de Commandes: </h6>
                                        </div>
                                        <div class="col-3">
                                            <div class="mcol-3 mt-3">
                                                <div class="input-group">
                                                    <input type="number" aria-label="min" name='minimum_commande' class="form-control" placeholder="Minimum" min="0">
                                                    <input type="number" aria-label="max" name='maximum_commande' class="form-control" placeholder="Maximum" min="0">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-2 row">
                                    <div class="form-row p-2 col-12">
                                        <div class="mt-4 col-3">
                                            <h6>Montant Total Dépensé: </h6>
                                        </div>
                                        <div class="col-3">
                                            <div class="mcol-3 mt-3">
                                                <div class="input-group">
                                                    <input type="number" aria-label="min" name='minimum_spent' class="form-control" placeholder="Minimum" min="0">
                                                    <input type="number" aria-label="max" name='maximum_spent' class="form-control" placeholder="Maximum" min="0">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-2 row">
                                    <div class='col-4'></div>
                                    <div class="ml-3 pt-2 col-4">
                                        <input type="submit" id="submit_search" class="btn btn-success btn-block  form-control" value="Confirmer">
                                    </div>
                                </div>

                        </form>
                    </div>


                </div>



                <div class="mt-4">
                    <div class="alert alert-info" id='div_nbr' hidden>
                        Nombre de Clients Trouvés : <span id="nbr_clt"></span>
                    </div>

                    <table class="table table-hover" id="table_search">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nom et Prénom</th>
                                <th scope="col">Nombre de Commandes</th>
                                <th scope="col">Dernière Activité</th>
                                <th scope="col">Options</th>
                                <!-- details ou email-->
                            </tr>
                        </thead>
                        <tbody id="table_body">

                        </tbody>
                    </table>


                </div>
            </div>

        </div>
    </div>
    <!--modal-->
    <div class="modal  fade" id="modal_details" tabindex="-1" aria-labelledby="modal_details" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" id="modal_content">

            </div>
        </div>
    </div>

    <script>
        function show_details(id_client, nom_client, nbr_commande, email, tel_client, date_naissance, sexe, first_commande, last_commande, minimum_spent, maximum_spent, avg_spent) {
            fetch("../php/clients/client_commande?id_client=" + id_client).then(resp => resp.json()).then(json => {
                const data = json.data;
                $('#modal_content').html(`
                     <div class="modal-header">
                    <h5 class="modal-title" id="exampleModal">CLIENT N° ${id_client}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mt-2 col-12 row">
                        <div class="col-auto">
                            <h5>
                                Informations du Clients
                            </h5>
                        </div>
                        <div class="col">
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label>Nom et Prénom</label>
                            <input type="text" class="form-control" readonly value="${nom_client}">
                        </div>
                        <div class="col-6">
                            <label>N° de Téléphone</label>
                            <input type="text" class="form-control" readonly value="${tel_client}">
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-6">
                            <label>Date de Naissance</label>
                            <input type="text" class="form-control" readonly value="${date_naissance}">
                        </div>
                        <div class="col-6">
                            <label>E-mail</label>
                            <input type="text" class="form-control" readonly value="${email}">
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-6">
                            <label>Sexe</label>
                            <input type="text" class="form-control" readonly value="${sexe}">

                        </div>
                    </div><br>
                    <div class="mt-2 col-12 row">
                        <div class="col-auto">
                            <h5>
                                Statistiques
                            </h5>
                        </div>
                        <div class="col">
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label>Première Activté</label>
                            <input type="text" class="form-control" readonly value="${first_commande}">
                        </div>
                        <div class="col-6">
                            <label>Dernière Activité</label>
                            <input type="text" class="form-control" readonly value="${last_commande}">
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-6">
                            <label>Montant d'Achat Maximum</label>
                            <input type="text" class="form-control" readonly value="${maximum_spent}">
                        </div>
                        <div class="col-6">
                            <label>Montant d'Achat Minimum</label>
                            <input type="text" class="form-control" readonly value="${minimum_spent}">
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-6">
                            <label>Moyenne d'Achat</label>
                            <input type="text" class="form-control" readonly value="${avg_spent}">
                        </div>
                        <div class="col-6">
                            <label>Nombre Total de Commandes</label>
                            <input type="text" class="form-control" readonly value="${nbr_commande}">
                        </div>
                    </div><br>
                    <div class="mt-2 col-12 row">
                        <div class="col-auto">
                            <h5>
                                Dernières Commandes
                            </h5>
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
                                        <th scope="col">N° Commande</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">État</th>
                                        <th scope="col">Montant d'Achat</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody id="table_body">
                                    ${data.map((element) => `
                                        <tr>
                                            <td>${element.id_commande}</td>
                                            <td>${element.date_commande}</td>
                                            <td>${element.etat_actuell}</td>
                                            <td>${element.prix_commande}</td>
                                            <td><a href='commandes_hist?id_commande=${element.id_commande}&nom_client=${nom_client}&tel_client=0${tel_client}'><button type="button" class="btn btn-link">VOIR</button></a></td>
                                        </tr>`)}
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class='col-3'></div>
                        <div class='col-5 m-3'><a href='commandes_hist?id_client=${id_client}&nom_client=${nom_client}'><button type="button" class="btn btn-info">Toutes les Commandes de ce Client</button></a></div>  
                    </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">FERMER</button>
                </div>
                </div>`);
                $('#modal_details').modal('show');
            }).catch(err => {
                console.log(err);
            });
        };

        $("#submit_search").click(function(event) {
            event.preventDefault();
            search();
        });

        function delete_confirmation(id_user, nom_client) {
            $('#modal_content_delete').html(`
                     <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalsup">Suppression </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Etes-vous sures de supprimer le client ${nom_client} ?
                </div>
                <div class="modal-footer mt-2">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="delete_client(${id_user},'${nom_client}')">Supprimer</button>
                </div>
                     `);
            $('#modal_details_delete').modal('show')
        }



        function delete_client(id_client, nom_client) {
            fetch("../php/clients/client_delete?id_client=" + id_client).then(resp => resp.json()).then(json => {
                if (json.code == 200) {
                    search();
                    $("#alert").text('');
                    $("#alert").append(`
                    <div class="alert alert-danger"  >
                    <i class="bi bi-check-all"></i></i> client ${nom_client} supprimé
                        </div>`)
                }
            }).catch(err => console.log(err));
        }



        function search() {
            var dataform = $("#form_search :input[value!='']").serialize();
            fetch("../php/clients/clients_read?" + dataform).then(resp => resp.json()).then(json => {
                var data = json.data;
                $("#table_body").text('');
                data.forEach((element, index) => {
                    $('#table_body').append(`
                        <tr class=" ${element.valide==1? "table-success":element.valide==-1?"table-danger":"" }">
                            <td>${index+1}</td>
                            <td>${element.nom_client}</td>
                            <td>${element.nbr_commande}</td>
                            <td>${element.last_commande}</td>
                            <td>
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">OPTIONS</button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                           
                                <a class="dropdown-item" href="#" onclick='show_details(${element.id_client},"${element.nom_client}",${element.nbr_commande},"${element.email}","0${element.tel_client}","${element.date_naissance}","${element.sexe}","${element.first_commande}","${element.last_commande}",${element.minimum_spent},${element.maximum_spent},${element.avg_spent});'>DÉTAILS</a>
                            
                                <a class="dropdown-item" href="mailto:${element.email}">ENVOYER E-MAIL</a>
                                <a class="dropdown-item" href="tel:${element.tel_client}">APPELER</a>
                                <a class="dropdown-item" href="#" onclick="delete_confirmation(${element.id_client},'${element.nom_client}');">SUPPRIMER</a>
                            </div>
                            </td>
                        </tr>
                        `);
                });
                $("#nbr_clt").text(data.length);
                $("#div_nbr").removeAttr("hidden");

            }).catch(err => {
                console.log(err);
            });
        }
        search();
    </script>
</body>

</html>