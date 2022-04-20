<?php
require_once "./req/verify.php";

?>
<!DOCTYPE html>
<html lang="en">


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
        require_once "./req/verify.php";

        ?>
    </div>

    <div class="container">
        <div class="jumbotron ">
            <div class="row mt-4">
                <div class="col-md-3 ">
                    <div class="list-group ">
                        <a href="infos.php" class="list-group-item list-group-item-action ">Profile</a>
                        <a href="commandes.php" class="list-group-item list-group-item-action">Commandes</a>
                        <a href="wishlist.php" class="list-group-item list-group-item-action active">Wishlist</a>
                        <a href="statistiques.php" class="list-group-item list-group-item-action">Statistiques</a>
                        <a href="adresse.php" class="list-group-item list-group-item-action ">Adresse</a>


                    </div>
                </div>
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4>Votre Wishlist</h4>
                                    <hr>
                                    <div id="alert">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-info" id="div_nbr">
                                        Nombre des produits: <span id="nbr_produit"></span>
                                    </div>

                                    <table class="table table-hover" id="table_search">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col"></th>
                                                <th scope="col">Produit</th>
                                                <th scope="col">marque</th>
                                                <th scope="col">Prix</th>
                                                <th scope="col">option</th>
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

</body>
<script>
    function delete_product(id_produit) {
        fetch("../php/profile/wishlist/delete?id_produit=" + id_produit).then(resp => resp.json()).then(json => {
            if (json.code == 200) {
                get_data();
                $("#alert").text('');
                $("#alert").append(`
                    <div class="alert alert-danger"  >
                    <i class="bi bi-check-all"></i></i> Produit supprimé
                        </div>`)
            }
        }).catch(err => console.log(err));
    }

    $(document).ready(get_data(event));

    function get_data(event) {
        fetch("../php/profile/wishlist/read").then(resp => resp.json()).then(json => {
            var data = json.data;
            $("#table_body").text('');
            data.forEach((element, index) => {
                $('#table_body').append(`
                <tr class=" ${element.valide==1? "table-success":element.valide==-1?"table-danger":"" }">
                    <td>${index+1}</td>
                    <td><img src="../img/products/${element.id_produit}.jpg" height=50 width=50 /></td>
                    <td>${element.label}</td>
                    <td>${element.nom_marque}</td>
                    <td>${element.prix_produit}</td>
                    <td>
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Options</button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="../produit?id_produit=${element.id_produit}" >Voir produit</a>
                        <a class="dropdown-item" onclick="delete_product(${element.id_produit},1)">supprimer</a>
                    </div>
                    </td>
                </tr>
                `);
            });
            $("#nbr_produit").text(data.length);
        }).catch(err => {
            console.log(err);
        });
    }
</script>

</html>