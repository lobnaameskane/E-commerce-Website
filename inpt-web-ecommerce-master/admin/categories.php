<?php require "req/verify.php"; //proteger la page 
?>
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


    <style>

    </style>


</head>

<body>

    <div class="container-fluid">
        <div class="row">
            <?php require "req/sidebar.php" ?>
            <div class="col pt-4">
                <h1>Catégories</h1>
                <br>

                <form id="form_search">

                    <h5 class="font-italic  text-secondary">Filtrer ?</h5>
                    <div class="row">
                        <div class="col-6">
                            <input class="form-control" type="search" id="search_categories" placeholder="Type to search...">

                        </div>
                        <div class="col-2">
                            <button type="button" onclick="search(true)" class="btn btn-dark ">Rechercher</button>
                        </div>
                        <div class="col-4">
                            <button data-toggle="modal" data-target="#modal_add" type="button" class="btn btn-success " style="width: 100%;">Ajouter une nouvelle catégorie</button>
                        </div>
                    </div>
                </form>
                <br>
                <div id="msg">

                </div>


                <hr>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="table_add">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Nom</th>
                                <th>Nombre des produits</th>
                                <th>Options</th>
                            </tr>
                        </thead>
                        <tbody id="table_body">

                        </tbody>
                    </table>
                </div>



            </div>
        </div>
    </div>
    <!-- Modal del -->
    <div class="modal fade" id="modal_del" tabindex="-1" aria-labelledby="modal_del" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered ">
            <div class="modal-content" id="modal_content_del">

            </div>
        </div>
    </div>
    <!-- Modal modify-->
    <div class="modal fade" id="modal_modify" tabindex="-1" aria-labelledby="modal_modify" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content" id="modal_content_modify">

            </div>
        </div>
    </div>
    <!-- Modal add-->
    <div class="modal fade" id="modal_add" tabindex="-1" aria-labelledby="modal_add" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content" id="modal_content_add">
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter une nouvelle catégorie</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form_add">
                        <label for="nom" class="form-control-label">Tapez le nom de la catégorie :</label>
                        <input type="text" id="nom_categorie_add" name="nom_categorie" class="form-control" placeholder="Nom" required>
                    </form>
                    <div class="alert alert-danger mt-3" id="alert_add" hidden>il faut remplire le champ du nom</div>
                    <div class="alert alert-danger mt-3" id="alert_add2" hidden>ce nom de categorie existe deja</div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="add_categorie();">Ajouter</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        search();
        var categories = [];

        function search() {
            fetch("../php/categories/categories_read?search=" + $("#search_categories").val()).then(resp => resp.json()).then(json => {
                const data = json.data;
                categories = data.map(element => element.nom_categorie);
                $("#table_body").html('');
                data.forEach(element => {
                    $("#table_body").append(`
                    <tr>
                       <td>${element.id_categorie}</td>
                       <td>${element.nom_categorie}</td>
                       <td>${element.prod_count}</td>                 
                       <td>
                         <button class="btn btn-warning btn-block dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Options</button>
                         <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                         <a class="dropdown-item" href="#"  onclick='modify_modal_show(${element.id_categorie},"${element.nom_categorie}");'>Modifier</a>
                         <a class="dropdown-item" href="#" onclick='delete_modal_show(${element.id_categorie},"${element.nom_categorie}",${element.prod_count});'>Supprimer</a>                                        
                         </div>
                       </td>            
                    </tr>`)
                });
            });
        }

        function add_categorie() {
            var nom_categorie = $("#nom_categorie_add").val();
            if (nom_categorie.length > 0) {
                if (!categories.includes(nom_categorie))
                    fetch("../php/categories/add?nom_categorie=" + nom_categorie).then(resp => resp.json()).then(json => {
                        const id_categorie = json.id_categorie;
                        $('#table_body').append(`
                        <tr>
                            <td>${id_categorie}</td>
                            <td>${nom_categorie}</td>
                            <td>0</td>
                            
                            <td>
                            <button class="btn btn-warning btn-block dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Options</button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="#" onclick='modify_modal_show(${id_categorie},"${nom_categorie}");'>Modifier</a>
                            <a class="dropdown-item" href="#" onclick='delete_modal_show(${id_categorie},"${nom_categorie}",0);'>Supprimer</a>
                            </div>
                            </td>
                        </tr>
                        `);
                        $('#form_add').trigger("reset");
                        $("#modal_add").modal("hide");
                        categories.push(nom_categorie);
                    }).catch(err => {
                        console.error(err);
                    });
                else
                    $('#alert_add2').removeAttr("hidden");
            } else
                $('#alert_add').removeAttr("hidden");
        }


        function delete_modal_show(id_categorie, nom_categorie, prod_count) {
            $('#modal_content_del').html(`
               <div class="modal-header">                  
                    <h5 class="modal-title " >Suppression de la catégorie N° ${id_categorie}</h5>          
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Etes-vous sûr de vouloir supprimer la catégorie "<b>${nom_categorie}"</b>?</p>
                    <div class="alert alert-danger">Impossible de supprimer. la categorie contient des produits. merci de la vider avant</div>
                </div>
                <div class="modal-footer d-flex justify-content-around">
                     <button type="button" class="btn btn-danger" ${prod_count>0? "disabled":""} onclick="delete_categorie(${id_categorie},'${nom_categorie}')" >oui</button>
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">non</button>
                </div>      
                     `);
            $("#modal_del").modal("show");
        };

        function delete_categorie(id_categorie, nom_categorie) {
            fetch("../php/categories/del?id_categorie=" + id_categorie).then(resp => resp.json()).then(json => {
                const data = json.data;
                $("#modal_del").modal("hide");

                $("#msg").html(`
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>supprimée!</strong> . la categorie ${nom_categorie} a ete supprimée 
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>    
                `)
                search();

            }).catch(err => {
                console.log(err);
            });
        }

        function modify_modal_show(id_categorie, nom_categorie) {
            $('#modal_content_modify').html(`
            <div class="modal-header">
                    
                    <h5 class="modal-title" >Modifier la catégorie N° ${id_categorie}</h5>
                    
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form_update">
                        <label for="nom" class="form-control-label  ">Ancien nom de la categorie</label>
                        <input type="text"  class="form-control" value="${nom_categorie}" disabled>
                        <label for="nom_categorie" class="form-control-label mt-2   ">Nouveau nom de la categorie</label>
                        <input type="text" name="nom_categorie" id="nom_categorie_u" class="form-control" placeholder="Nouveau nom" required>
                        <div class="alert alert-danger mt-3" id="alert_modify" hidden>il faut remplire le champ de nouveau nom</div>
                        <div class="alert alert-danger mt-3" id="alert_modify2" hidden>ce nom de categorie existe deja</div>
                    </form>
                    </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="update_categorie(${id_categorie});" id="submit-modify">Enregistrer</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                </div>
                
                     `);
            $('#modal_modify').modal('show');
        };

        function update_categorie(id_categorie) {
            var nom_categorie = $("#nom_categorie_u").val();
            if (nom_categorie.length > 0)
                if (!categories.includes(nom_categorie)) {
                    fetch("../php/categories/modify?id_categorie=" + id_categorie + "&nom_categorie=" + nom_categorie).then(resp => resp.json()).then(json => {
                        if (json.code == 200) {
                            $('#modal_modify').modal('hide');
                            search();
                        }
                    }).catch(err => {
                        console.log(err);
                    });
                } else
                    $("#alert_modify2").removeAttr("hidden");
            else
                $("#alert_modify").removeAttr("hidden");

        }
    </script>
</body>

</html>