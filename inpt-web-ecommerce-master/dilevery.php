<?php 
session_start();
require_once "./req/verify.php";
?>
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

<body>
    <div>
        <?php
        require_once "req/navbar.php";
        require_once "./req/verify.php";



        ?>
    </div>


    <div class="container ">
        <div class="jumbotron d-flex justify-content-center mt-5">
            <div class="card col pt-3">
                <div class="card-top border-bottom text-center"> <a href="index.php" class="link"> Retour a la boutique</a> <span id="logo">Amoil.com</span> </div>
                <div class="card-body">
                    <div class="row upper h3"> <span class="panier"> Adresse</span> </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="left border">
                                <div class="row"><span><i class="bi bi-signpost-2 " style="font-size: 2rem ;" aria-hidden="true"></i></i></span> <span class="header" style="font-size: 2rem;"> Liste des Adresse</span></div>
                                <hr>
                                <div class="row col-12">
                                    <fieldset class="col-12">
                                        <select class="form-control col-12" onchange="charge_adresse()" id="adresse_selector">
                                        </select>
                                    </fieldset>

                                    <br>
                                    <div class="col-12 mt-2">
                                        <div class="infos_clients">
                                            <div class='mt-2 row'>
                                                <h2 class="display-6">Details du Client</h2>
                                            </div>
                                            <div class='mt-2 row'>
                                                <div class="form-row p-2 col">
                                                    <div class="pt-3 col-4">
                                                        <h6>Nom Complet: </h6>
                                                    </div>
                                                    <div class="mt-2 col">
                                                        <input class="form-control mr-sm-2" type="text" aria-label="nom" readonly name="nom_complet" id="nom_complet" required>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class='mt-2 row'>
                                                <div class="form-row p-2 col">
                                                    <div class="pt-3 col-4">
                                                        <h6>Adresse: </h6>
                                                    </div>
                                                    <div class="mt-2 col">
                                                        <textarea class="form-control" rows="3" name="adresse" id="adresse" readonly required></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class='mt-2 row'>
                                                <div class="form-row p-2 col">
                                                    <div class="pt-3 col-4">
                                                        <h6>Telephone: </h6>
                                                    </div>
                                                    <div class="mt-2 col">
                                                        <input class="form-control mr-sm-2" type="number" aria-label="telephone" readonly name="tel_adresse_client" id="tel_adresse_client" required>
                                                    </div>
                                                </div>
                                                <div class="form-row p-2 col">
                                                    <div class="pt-3 col-4">
                                                        <h6>Code Postal: </h6>
                                                    </div>
                                                    <div class="mt-2 col">
                                                        <input class="form-control mr-sm-2" type="text" aria-label="zipcode" readonly id="code_postal" name="code_postal" required>
                                                    </div>
                                                </div>


                                            </div>
                                            <div class="row p-2 d-flex justify-content-center    col-12">
                                                <button class="btn btn-success" data-toggle="modal" data-target="#modal_add_adresse"><i class="bi bi-plus-circle"></i> Ajouter Nouvelle adresse </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="p-3 d-flex justify-content-center">
                                <span class="payment col-4 btn btn-primary" onclick="goto_payment()">Confirmer Commande <i class="bi bi-arrow-right-square-fill"></i></span>

                            </div>


                        </div>


                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal_add_adresse" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ajout adresse</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-12 mt-2">
                        <form id="fomr_add_adresse">
                            <div class="infos_clients">
                                <div class='mt-2 row'>
                                    <h2 class="display-6">Details du Client</h2>
                                </div>
                                <div class='mt-2 row'>
                                    <div class="form-row p-2 col">
                                        <div class="pt-3 col-4">
                                            <h6>Nom Complet: </h6>
                                        </div>
                                        <div class="mt-2 col">
                                            <input class="form-control mr-sm-2" type="text" aria-label="nom" name="nom_complet" id="nom_complet" required>
                                        </div>
                                    </div>

                                </div>

                                <div class='mt-2 row'>
                                    <div class="form-row p-2 col">
                                        <div class="pt-3 col-4">
                                            <h6>Adresse: </h6>
                                        </div>
                                        <div class="mt-2 col">
                                            <textarea class="form-control" rows="3" name="adresse" id="adresse" required></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class='mt-2 row'>
                                    <div class="form-row p-2 col">
                                        <div class="pt-3 col-4">
                                            <h6>Telephone: </h6>
                                        </div>
                                        <div class="mt-2 col">
                                            <input class="form-control mr-sm-2" type="number" aria-label="telephone" name="tel_adresse_client" id="tel_adresse_client" required>
                                        </div>
                                    </div>
                                    <div class="form-row p-2 col">
                                        <div class="pt-3 col-4">
                                            <h6>Code Postal: </h6>
                                        </div>
                                        <div class="mt-2 col">
                                            <input class="form-control mr-sm-2" type="number" aria-label="zipcode" id="code_postal" name="code_postal" required>
                                        </div>
                                    </div>


                                </div>

                            </div>
                        </form>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="add_adresse()">Ajouter l'adresse</button>
                </div>
            </div>
        </div>
    </div>




    <div class="mt-2">


        <?php
        require_once "req/footbar.php";
        ?>
    </div>



    <script>
        var adresses = [];

        function get_adresses() {
            fetch("./php/adresses/adresses_get").then(resp => resp.json()).then(json => {
                const data = json.data;
                adresses = data;
                $("#adresse_selector").html('');
                data.forEach((element, index) => {
                    $("#adresse_selector").append(`<option value="${index}">${index+1}- ${element.nom_complet} ${element.adresse}</option>`);
                });
                charge_adresse();
            }).catch(err => console.error(err));
        }

        function charge_adresse() {
            var index = $("#adresse_selector").val();
            const adresse = adresses[index];
            $("#nom_complet").val(adresse.nom_complet);
            $("#adresse").val(adresse.adresse);
            $("#tel_adresse_client").val(adresse.tel_adresse_client);
            $("#code_postal").val(adresse.code_postal);

        }

        function add_adresse() {
            if (check) {
                var dataform = $('#fomr_add_adresse').serialize();
                fetch("./php/adresses/adresse_add?" + dataform).then(resp => resp.json()).then(json => {
                    json;
                    if (json.code == 200) {
                        $("#modal_add_adresse").modal("hide");
                        get_adresses();

                    }

                }).catch(err => console.error(err));
            }
        }

        function check() {
            let valid = true;
            $('#fomr_add_adresse [required]').each(function() {
                if ($(this).is(':invalid') || !$(this).val()) {
                    valid = false;
                    $("#fomr_add_adresse").addClass("was-validated");
                };
            })
            return valid;
        }
        get_adresses();


        function goto_payment() {
            var index = $("#adresse_selector").val();
            const adresse = adresses[index];
            location.replace("payment?id_adresse=" + adresse.id_adresse)

        }
    </script>

</body>

</html>