<?php
require_once "./req/verify.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
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
                        <a href="commandes.php" class="list-group-item list-group-item-action">Commandes</a>
                        <a href="wishlist.php" class="list-group-item list-group-item-action ">Wishlist</a>
                        <a href="statistiques.php" class="list-group-item list-group-item-action">Statistiques</a>
                        <a href="adresse.php" class="list-group-item list-group-item-action active">Adresse</a>


                    </div>
                </div>

                <div class="col-md-9">
                    <div class="card">
                        <div class="card-body">

                            <div class="d-flex justify-content-between  ">
                                <div>
                                    <h4 style="display:inline">Vos adresses</h4>

                                </div>
                                <div><button type="button" class="btn btn-lg btn-success" data-toggle="modal" data-target="#exampleModal">Ajouter une adresse</button></div>

                            </div>
                            <hr>
                            <div id="alert">
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-info" id="div_nbr">
                                        Nombre des adresses: <span id="adresse_number"></span>
                                    </div>

                                    <table class="table table-hover" id="table_search">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th scope="col">adresse</th>
                                                <th scope="col">code postale</th>
                                                <th scope="col">nom</th>
                                                <th scope="col">telephone</th>
                                                <th scope="col">options</th>
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

    <!-- Modal adding-->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="addUser" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ajouter une adresse</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body container-fluid">
                    <div id="alertModal">
                    </div>
                    <form action="" class="form row" id="form_add">
                        <div class="form-label-group col-12">
                            <label for="inputadreses">adresse</label>
                            <input type="text" name="adresse" class="form-control" placeholder="adresse" required autofocus>
                        </div>
                        <div class="form-label-group col-12">
                            <label for="inputcode">code postale</label>
                            <input type="text" name="code_postal" class="form-control" placeholder="code postale" required autofocus>
                        </div><br>
                        <div class="form-label-group col-6">
                            <label for="inputcode">Nom</label>
                            <input type="text" name="nom" class="form-control" placeholder="nom" required autofocus>
                        </div><br>
                        <div class="form-label-group col-6">
                            <label for="inputcode">Prenom</label>
                            <input type="text" name="prenom" class="form-control" placeholder="prenom" required autofocus>
                        </div><br>
                        <div class="form-label-group col-12">
                            <label for="inputcode">Telephone</label>
                            <input type="text" name="telephone" class="form-control" placeholder="telephone" required autofocus>
                        </div><br>

                    </form>
                    <div class="modal-footer mt-2">
                        <button type="button" class="btn col-2 btn-secondary" data-dismiss="modal">Annuler</button>
                        <button class="btn btn-success col-2" type="button" onclick="add_adresse()">Ajouter</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal changing-->
    <div class="modal fade" id="change" tabindex="-1" role="changeUser" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" id="modal_content_changing">
            </div>
        </div>
    </div>

    <div>


</body>
<script>
    function update_adresse(id_adresse) {
        var dataform = $("#form_change").serialize();
        fetch("../php/profile/adresse/modify?id_adresse=" + id_adresse + '&' + dataform).then(resp => resp.json()).then(json => {
            if (json.code == 200) {
                get_data();
                $("#alert").text('');
                $("#alert").append(`
                    <div class="alert alert-success"  >
                    <i class="bi bi-check-all"></i></i> adresse modifié
                        </div>`)
            }
        });
    }

    //TODO ADD VALIDATIONS TO FORMS

    function see_adresse(id_adresse, adresse, code_postal, nom_complet, tel_adresse_client) {

        $('#modal_content_changing').html(`
                            <div class="modal-header">
                                <h4 class="modal-title" id="exampleModalLabel">modifier l'adresse : ${adresse}</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body container-fluid">
                                <form action="" id="form_change" class="form row" method="post">
                                
                                    <div class="form-label-group col-6">
                                        <label for="inputNom">Adresse</label>
                                        <input type="text" name="adresse" class="form-control" placeholder="adresse" value="${adresse}" required autofocus>
                                    </div>
                                    <div class="form-label-group col-6">
                                        <label for="inputEmail">Code_postal</label>
                                        <input type="text" name="code_postal"  class="form-control" placeholder="code_postale" value="${code_postal}" required autofocus>
                                    </div><br>
                                    <div class="form-label-group col-6">
                                        <label for="inputEmail">Nom_complet</label>
                                        <input type="text" name="nom_complet"  class="form-control" placeholder="nom_complet" value="${nom_complet}" required autofocus>
                                    </div><br>
                                    <div class="form-label-group col-6">
                                        <label for="inputEmail">Telephone</label>
                                        <input type="text" name="tel"  class="form-control" placeholder="telephone" value="0${tel_adresse_client}" required autofocus>
                                    </div><br>
                                    </form>
                                    <div class="modal-footer ">
                                        
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                        <button type="button" class="btn btn-success" data-dismiss="modal" onclick="update_adresse(${id_adresse})">modifier</button>
                                    </div>
                                
                            </div>`)
        $('#change').modal('show');


    }

    function see_adresse_d(id_adresse, adresse) {

        $('#modal_content_changing').html(`
                    <div class="modal-header">
                        <h4 class="modal-title" id="exampleModalLabel">Supprimer l'adresse </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body container-fluid">
                        est-ce que vous voullez supprimer cette adresse ?
                        ${adresse}
                            <div class="modal-footer ">
                                
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="delete_adresse(${id_adresse})">Supprimer</button>
                            </div>
                        
                    </div>`)
        $('#change').modal('show');


    }



    function delete_adresse(id_adresse) {
        fetch("../php/profile/adresse/delete?id_adresse=" + id_adresse).then(resp => resp.json()).then(json => {
            if (json.code == 200) {
                get_data();
                $("#alert").text('');
                $("#alert").append(`
                    <div class="alert alert-danger"  >
                    <i class="bi bi-check-all"></i></i>adresse supprimé
                        </div>`)
            }
        }).catch(err => console.log(err));
    }


    function add_adresse() {
        var dataform = $("#form_add").serialize();
        fetch("../php/profile/adresse/add?" + dataform).then(resp => resp.json()).then(json => {
            if (json.code == 200) {
                get_data();
                $("#alert").text('');
                $("#alert").append(`
                    <div class="alert alert-success"  >
                    <i class="bi bi-check-all"></i></i>adresse ajoutée !!
                        </div>`)
                $('#exampleModal').modal('hide');
                $("#form_add").reset();
            } else if (json.code == 403) {
                get_data();
                $("#alertModal").text('');
                $("#alertModal").append(`
                    <div class="alert alert-danger"  >
                    <i class="bi bi-x-octagon mr-2"></i>${json.msg}
                        </div>`)
            } else if (json.code == 404) {
                get_data();
                $("#alertModal").text('');
                $("#alertModal").append(`
                    <div class="alert alert-danger"  >
                    <i class="bi bi-x-octagon mr-2"></i>${json.msg}
                        </div>`)
            } else if (json.code == 405) {
                get_data();
                $("#alertModal").text('');
                $("#alertModal").append(`
                    <div class="alert alert-danger"  >
                    <i class="bi bi-x-octagon mr-2"></i>${json.msg}
                        </div>`)
            } else if (json.code == 406) {
                get_data();
                $("#alertModal").text('');
                $("#alertModal").append(`
                    <div class="alert alert-danger"  >
                    <i class="bi bi-x-octagon mr-2"></i>${json.msg}
                        </div>`)
            }
        })

    }


    $(document).ready(get_data(event));

    function get_data(event) {
        fetch("../php/profile/adresse/read").then(resp => resp.json()).then(json => {
            const data = json.data;
            $('#adresse_number').text('');
            $('#adresse_number').append(`${data.length}`);
            $("#table_body").text('');
            data.forEach((element, index) => {
                $('#table_body').append(`
                <tr>
                    <th scope="row">${element.adresse}</th>
                    <td>${element.code_postal}</td>
                    <td>${element.nom_complet}</td>
                    <td>0${element.tel_adresse_client}</td>
                    <td class=" d-flex justify-content-between">
                        
                        <button type="button"  onclick='see_adresse(${element.id_adresse},"${element.adresse}","${element.code_postal}","${element.nom_complet}","${element.tel_adresse_client}")' style="border: none; background: none;padding: 0;">
                            <span aria-hidden="true"><i class="bi bi-pencil text-muted"></i></span>
                        </button>
                        <button type="button" class="close" onclick='see_adresse_d(${element.id_adresse},"${element.adresse}")'>
                            <span aria-hidden="true"><i class="bi bi-trash text-muted"></i></span>
                        </button>
                    </td>
                </tr>
                `);
            });
        }).catch(err => {
            console.log(err);
        });
    }
</script>



<div>

    <?php
    require_once "../req/footbar.php";

    ?>
</div>

</html>