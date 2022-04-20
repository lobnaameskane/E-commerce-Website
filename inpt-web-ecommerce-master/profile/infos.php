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
        <div class="jumbotron">
            <div class="row mt-4 ">
                <div class="col-md-3 ">
                    <div class="list-group ">
                        <a href="infos.php" class="list-group-item list-group-item-action active">Profile</a>
                        <a href="commandes.php" class="list-group-item list-group-item-action">Commandes</a>
                        <a href="wishlist.php" class="list-group-item list-group-item-action">Wishlist</a>
                        <a href="statistiques.php" class="list-group-item list-group-item-action">Statistiques</a>
                        <a href="adresse.php" class="list-group-item list-group-item-action ">Adresse</a>

                    </div>
                </div>
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-body m-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <!-- Modal password-->
                                    <div class="modal fade" id="mdp" tabindex="-1" role="changemdp" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog  modal-dialog-centered modal-md" role="document">
                                            <div class="modal-content" id="mdp_body">

                                            </div>
                                        </div>
                                    </div>
                                    <h4>Votre Profile</h4>
                                    <hr>
                                    <div id="alert">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12" id="client_form">

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

</body>
<script>
    function voir_mdp() {
        $('#mdp_body').html(`
            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">changer le mot de passe</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body container-fluid">
                                <div id="alertModalpwd">
                                </div>
                                <form action="" class="form row" id="form_pwd">
                                    <div class="form-label-group col-12">
                                        <label for="inputNom">Mot de passe actuel</label>
                                        <input type="password" name="mdp_actuel" id="inputNom" class="form-control" placeholder="Mot de passe actuel" required autofocus>
                                    </div>
                                    <div class="form-label-group col-12 pt-2">
                                        <label for="inputNom">Nouveau mot de passe </label>
                                        <input type="password" name="mdp" id="inputNom" class="form-control" placeholder="mot de passe" required autofocus>
                                    </div>
                                    <div class="form-label-group col-12 pt-2">
                                        <label for="inputEmail">Confirmer le mot de passe </label>
                                        <input type="password" name="mdp_conf" id="inputPrenom" class="form-control" placeholder="confirmer le mot de passe" required autofocus>
                                    </div><br>

                                </form>
                                <div class="modal-footer mt-2">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                    <button class="btn btn-success" type="button" name="submit" onclick="modify_password()">modifier</button>
                                </div>
                            </div>
                            `);
        $('#mdp').modal('show');
    }

    function modify_password(id_user) {
        var dataform = $("#form_pwd").serialize();
        var dataformarray = $("#form_pwd").serialize();
        fetch("../php/profile/client_pwd?" + dataform).then(resp => resp.json()).then(json => {

            if (json.code == 200) {
                $("#alert").text('');
                $("#alert").append(`
                    <div class="alert alert-success"  >
                    <i class="bi bi-check-all"></i></i> Mot de passe  modifié
                        </div>`)
                $('#mdp').modal('hide');
            } else if (json.code == 401) {
                $("#alertModalpwd").text('');
                $("#alertModalpwd").append(`
                    <div class="alert alert-danger"  >
                    <i class="bi  bi-x-octagon mr-2"></i></i> ${json.msg}
                        </div>`)
            } else if (json.code == 399) {
                $("#alertModalpwd").text('');
                $("#alertModalpwd").append(`
                    <div class="alert alert-danger"  >
                    <i class="bi  bi-x-octagon mr-2"></i></i> ${json.msg}
                        </div>`)
            } else if (json.code == 398) {
                $("#alertModalpwd").text('');
                $("#alertModalpwd").append(`
                    <div class="alert alert-danger"  >
                    <i class="bi  bi-x-octagon mr-2"></i></i> ${json.msg}
                        </div>`)
            } else if (json.code == 402) {
                $("#alertModalpwd").text('');
                $("#alertModalpwd").append(`
                    <div class="alert alert-danger"  >
                    <i class="bi  bi-x-octagon mr-2"></i></i> ${json.msg}
                        </div>`)
            } else if (json.code == 403) {
                $("#alertModalpwd").text('');
                $("#alertModalpwd").append(`
                    <div class="alert alert-danger"  >
                    <i class="bi  bi-x-octagon mr-2"></i></i> ${json.msg}
                        </div>`)
            }
        });
    }



    function update_client() {
        var dataform = $("#form_change").serialize();
        fetch("../php/profile/update_client?" + dataform).then(resp => resp.json()).then(json => {
            if (json.code == 200) {
                get_data();
                $("#alert").text('');
                $("#alert").append(`
                    <div class="alert alert-success"  >
                    <i class="bi bi-check-all"></i></i> Vos modification ont été enregistrées
                        </div>`)
            }
        });
    }
    $(document).ready(get_data(event));

    function get_data(event) {
        fetch("../php/profile/get_client.php").then(resp => resp.json()).then(json => {
            const data = json.data;
            const adresse = json.adresse;
            $("#client_form").text('');

            $('#client_form').append(`
                    <form id="form_change">
                                        <div class="infos_clients">
                                            <div class='mt-2 row'>
                                                <div class="form-row p-2 col">
                                                    <div class="pt-3 col-2">
                                                        <h6>Nom: </h6>
                                                    </div>
                                                    <div class="mt-2 col">
                                                        <input class="form-control mr-sm-2" type="text"  name="nom" value="${data.nom_client} ">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class='mt-2 row'>
                                                <div class="form-row p-2 col">
                                                    <div class="pt-3 col-2">
                                                        <h6>Prenom: </h6>
                                                    </div>
                                                    <div class="mt-2 col">
                                                        <input class="form-control mr-sm-2" type="text" aria-label="prenom" name="prenom" value="${data.prenom_client}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class='mt-2 row'>
                                                <div class="form-row p-2 col">
                                                    <div class="pt-3 col-2">
                                                        <h6>Email: </h6>
                                                    </div>
                                                    <div class="mt-2 col">
                                                        <input class="form-control mr-sm-2" type="text"  name="email" value="${data.email} ">
                                                    </div>
                                                    <div class="mt-2 col-3">
                                                        <button type="button" class="btn btn-outline-secondary btn-block" onclick="voir_mdp()">changer mdp</button>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class='mt-2 row'>
                                                <div class="form-row p-2 col">
                                                    <div class="pt-3 col">
                                                        <h6>Date de Naissance: </h6>
                                                    </div>
                                                    <div class="mt-2 col">
                                                        <input class="form-control mr-sm-2" type="date" aria-label="nom" name="date" value="${data.date_naissance}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class='mt-2 row'>
                                                <div class="form-row p-2 col">
                                                    <div class="pt-3 col-2">
                                                        <h6>Sexe: </h6>
                                                    </div>
                                                    <div class="mt-2 col">
                                                        <select class="form-control" name="sexe">
                                                            <option >Homme</option>
                                                            <option ${data.sexe==('f')?"selected":''}>Femme</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class='mt-2 row'>
                                                <div class="form-row p-2 col">
                                                    <div class="pt-3 col-3">
                                                        <h6>Telephone: </h6>
                                                    </div>
                                                    <div class="mt-2 col">
                                                        <input class="form-control mr-sm-2" type="tel" aria-label="telephone" name="tel" value="0${data.tel_client}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-2 row">
                                                <div class='col'></div>
                                                <div class="ml-3 pt-2 col-8">
                                                    <button type="button" class="btn btn-success btn-lg btn-block" onclick="update_client()" style="background-color:navy;color:gold">Enregistrer</button>
                                                </div>
                                                <div class='col'></div>
                                            </div>
                                        </div>
                                    </form>
                        `);

        }).catch(err => {
            console.log(err);
        });
    }
</script>

</html>