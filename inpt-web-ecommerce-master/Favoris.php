<?php
session_start();
require_once "./req/verify.php";
?>
<!DOCTYPE html>
<html lang="en">
<?php
require_once "./req/verify.php";

?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Favoris</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <link href="../css/navbar.css" rel="stylesheet">
    <script src="../js/jquery-3.5.1.slim.min.js"></script>

    <script src="../js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../css/bootstrap-icons.css">
    <link rel="stylesheet" href="../css/admin/sidebar.css">

    <style>


    </style>
</head>

<body>
    <?php
    require_once "req/navbar.php";

    ?>
    <div class="container-fluid mt-5 pt-5">



        <div class="jumbotron">
            <div class="card">
                <h1 class="text-warning text-center" style="font-family:  Comic Sans MS">My wishlist</h1>
                <div class="card-body" id="card-body">


                </div>
            </div>

        </div>
    </div>

    <div class="container-fluid">
        <?php
        require_once "req/footbar.php";

        ?>
    </div>
    <!-- Modal del -->
    <div class="modal fade" id="modal_del" tabindex="-1" aria-labelledby="modal_del" aria-hidden="true">
        <div class="modal-dialog modal-md ">
            <div class="modal-content" id="modal_content_del">

            </div>
        </div>
    </div>


    <script>
        function read() {
            fetch("../php/Favoris/read_wishlist").then(resp => resp.json()).then(json => {
                const data = json.data;
                console.log(data);
                data.forEach(element => {
                    $("#card-body").append(`
                    <div class="card mx-5">

                          <div class="card-body">
                          <div class="row">
                                <div class="col col-md-2">
                                    <img class="card-img-right" src="http://fakeimg.pl/150x150/" alt="Card image cap">
                                </div>
                                <div class="col col-md-6 pl-5">
                                    <div class="row">
                                        <div>
                                            <h3 style="font-family:  Comic Sans MS">${element.label}</h3>
                                            <ul class="list-inline pull-right">
                                                <li><i class="bi bi-star-fill" style="color: yellow;"></i><i class="bi bi-star-fill" style="color: yellow;"></i><i class="bi bi-star-fill" style="color: yellow;"></i><i class="bi bi-star-half" style="color: yellow;"></i><i class="bi bi-star" style="color: yellow;"></i></li>
                                            </ul>
                                            <h5 class="text-danger">${element.prix_produit}<br>
                                            <button type="button" class="btn btn-warning btn-sm mt-2"style="border-radius: 5px;">Acheter maintenant</button>
                                        </div>
                                    </div>

                                    </div>
                                    <div class="col col-md-4 ">
                                    <span><div class="d-flex justify-content-end px-3">
                                    <button type="button" style="border-radius: 5px;" class="h-50 w-25 btn-success"><a href="produit?id_produit=${element.id_produit}" class="text-white">view</a></button>
                                                <button type="button" style="border-radius: 5px;" class="h-50 w-25 ml-1 btn-danger" onclick="del(${element.id_produit},${element.id_client})">remove</button>
                                                
                                            </div></span>
                                    </div>

                                    </div>
                                    </div>
                                </div>
                                <br>
                                <hr>
                                <br>

                    `);
                });
            });
        }

        function del(id_produit, id_client) {
            fetch("../php/Favoris/delp?id_produit=" + id_produit + "&id_client=" + id_client).then(resp => resp.json()).then(json => {
                const data = json.data;


            }).catch(err => {
                console.log(err);
            });
        };

        read();
    </script>



</body>

</html>