<?php require "req/verify.php";  ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration</title>

    <script src="../js/jquery-3.5.1.slim.min.js"></script>

    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="../js/bootstrap-select.min.js"></script>
    <script src="../js/i18n/defaults-fr_FR.js"></script>
    <link rel="stylesheet" href="../css/bootstrap-select.min.css">
    <link rel="stylesheet" href="../css/bootstrap-icons.css">
    <link rel="stylesheet" href="../css/admin/sidebar.css">
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <link href="../css/navbar.css" rel="stylesheet">
    <style>
        .imagePreview {
            width: 100%;
            height: 180px;
            background-position: center center;
            background: url(../img/no_img.jpg);
            background-color: #fff;
            background-size: cover;
            background-repeat: no-repeat;
            display: inline-block;
            box-shadow: 0px -3px 6px 2px rgba(0, 0, 0, 0.2);
        }

        .btn-primary {
            display: block;
            border-radius: 0px;
            box-shadow: 0px 4px 6px 2px rgba(0, 0, 0, 0.2);
            margin-top: -5px;
        }

        .imgUp {
            margin-bottom: 15px;
        }
    </style>

    <style>
        .imagePreview {
            width: 100%;
            height: 180px;
            background-position: center center;
            background: url(../img/no_img.jpg);
            background-color: #fff;
            background-size: cover;
            background-repeat: no-repeat;
            display: inline-block;
            box-shadow: 0px -3px 6px 2px rgba(0, 0, 0, 0.2);
        }

        .btn-primary {
            display: block;
            border-radius: 0px;
            box-shadow: 0px 4px 6px 2px rgba(0, 0, 0, 0.2);
            margin-top: -5px;
        }

        .imgUp {
            margin-bottom: 15px;
        }
    </style>

    <style>
        .imagePreview {
            width: 100%;
            height: 180px;
            background-position: center center;
            background: url(../img/no_img.jpg);
            background-color: #fff;
            background-size: cover;
            background-repeat: no-repeat;
            display: inline-block;
            box-shadow: 0px -3px 6px 2px rgba(0, 0, 0, 0.2);
        }

        .btn-primary {
            display: block;
            border-radius: 0px;
            box-shadow: 0px 4px 6px 2px rgba(0, 0, 0, 0.2);
            margin-top: -5px;
        }

        .imgUp {
            margin-bottom: 15px;
        }
    </style>

</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <?php require "req/sidebar.php" ?>
            <div class="col pt-4 h-100">
                <div class="container-fluid">
                    <h1><a href="" data-target="#sidebar" data-toggle="collapse" class="d-md-none"><i class="fa fa-bars"></i></a> Produits</h1>
                    <h6 class="hidden-sm-down">Page pour ajouter, modifier ou supprimer un produit</h6>
                    <hr>


                    <form id="form_search">

                        <h5 class="font-italic  text-secondary">Filtrer ?</h5>
                        <div class="row">
                            <div class="col-6">
                                <input class="form-control" type="search" id="search_admin" placeholder="entrer un mot clé">

                            </div>
                            <div class="col-3">
                                <button type="button" onclick="search(true)" class="btn btn-dark btn-block ">Rechercher</button>
                            </div>
                            <div class="col-3">
                                <button onclick="add_modal_show();" type="button" class="btn btn-success btn-block ">Ajouter un produit</button>
                            </div>
                        </div>
                    </form>

                </div>

                <div id="msg" class="mt-2">

                </div>
                <div class="mt-4 ">
                    <div class="d-flex justify-content-center">
                        <div class="alert alert-info col-9 " id='div_nbr' hidden>
                            Nombre de Produits Trouvés : <span id="nbr_prd"></span>
                        </div>

                    </div>
                    <br>


                    <table class="table table-hover" id="table_search">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Photo</th>
                                <th scope="col">Label</th>
                                <th scope="col">Marque</th>
                                <th scope="col">Categorie</th>
                                <th scope="col">Prix</th>
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
    <!--modal-->
    <div class="modal  fade" id="modal_details" tabindex="-1" aria-labelledby="modal_details" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" id="modal_content">

            </div>
        </div>
    </div>

    <script>
        var img_updated = false;
        var marques;
        var categories;
        fetch("../php/brands/brands_read").then(resp => resp.json()).then(json => {
            marques = json.data;

        }).catch(err => {
            console.log(err);
        });
        fetch("../php/categories/categories_read").then(resp => resp.json()).then(json => {
            categories = json.data;
        }).catch(err => {
            console.log(err);
        });



        function add_modal_show() {
            img_updated = false;
            $('#modal_content').html(`
                     <div class="modal-header">
                    <h5 class="modal-title" id="exampleModal">AJOUTER PRODUIT</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                <div class="modal-body">
                        <form  id='form_add_product'>                          
                            <div class="form-group">
                                <label for="label"> Label :</label>

                                <input type="text" id="label_add" name="label" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="prix_produit">Le prix :</label>
                                <input type="number"  id="prix_produit_add" name="prix_produit"  class="form-control" required>
                            </div>
                            <div class="form-group">
                            <label for="id_marque">La marque :</label>
                                <select class="form-control selectpicker" name="id_marque" id="id_marque_add" data-live-search="true" required>
                                <option data-tokens="" selected value disabled></option>
                                ${marques.map(element => `<option value="${element.id_marque}">${element.nom_marque}</option>`)}
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="id_categorie">La categorie :</label>
                                <select class="form-control selectpicker" name="id_categorie" id="id_categorie_add" data-live-search="true" required>       
                                <option data-tokens="" selected value disabled></option>
                                ${categories.map(element => `<option value="${element.id_categorie}" >${element.nom_categorie}</option>`)}</select>
                            </div>
                            <div class="form-group">
                                <label for="description_produit">Description :</label>
                                <textarea class="form-control" name="description_produit" id="description_produit"></textarea>                               
                            </div>      
                            <div class="form-group">
                                <label for="description_produit">Image de produit :</label>
                                <div class="d-flex justify-content-center">
                                    <div class="col-4 imgUp">
                                    <div class="imagePreview"></div>
                                    <label class="btn btn-primary">
                                    charger photo<input type="file" name="file" id="img_input_add" input class="uploadFile img" value="charger photo" style="width: 0px;height: 0px;overflow: hidden;">
                                    </label>
                                    </div>    
                                </div>
                                <div class="alert alert-danger alert-dismissible fade show" id="alert_add" hidden>
                                un ou plusieurs champs sont vides
                            </div>                                                       
                            </div>                                
                        </form>
                </div>
                    
                <div class="modal-footer">
                                <input type="button"  onclick="add_product()" class="btn btn-success"  form-control" value="Confirmer Ajout">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">FERMER</button>               
                </div>
                </div>`);
            $('.selectpicker').selectpicker();
            $('#modal_details').modal('show');
        };

        function add_product() {
            if ($("#label_add").val() != "" && $("#prix_produit_add").val() != "" && $("#id_categorie_add").val() != null && $("#id_marque_add").val() != null) {
                var dataform = $("#form_add_product").serialize();
                fetch("../php/products/insert_product?" + dataform).then(resp => resp.json()).then(json => {
                    const id_produit = json.id_produit;
                    if (img_updated) {
                        const form = document.getElementById("form_add_product")
                        var data = new FormData(form);
                        data.append('id_produit', id_produit);
                        fetch('../php/utility/upload_image', {
                                method: 'POST',
                                body: data,
                            } // This is your file object
                        ).then(
                            response => response.json() // if the response is a JSON object
                        ).then(
                            success => {
                                $('#modal_details').modal('hide');
                                search()
                            }
                            // Handle the success response object
                        ).catch(
                            error => console.log(error) // Handle the error response object
                        );
                    }

                }).catch(err => {
                    console.log(err);
                })

            } else {
                $("#alert_add").removeAttr("hidden");
            }

        };

        function update_product(id_produit) {
            if ($("#label_update").val() != "" && $("#prix_produit_update").val() != "" && $("#id_categorie_update").val() != null && $("#id_marque_update").val() != null) {
                var dataform = $("#form_update_product").serialize();
                fetch("../php/products/update_product?id_produit=" + id_produit + "&" + dataform).then(resp => resp.json()).then(json => {
                    if (img_updated) {
                        const form = document.getElementById("form_update_product")
                        var data = new FormData(form);
                        data.append('id_produit', id_produit);
                        fetch('../php/utility/upload_image', {
                                method: 'POST',
                                body: data,
                            } // This is your file object
                        ).then(
                            response => response.json() // if the response is a JSON object
                        ).then(
                            success => {

                            } // Handle the success response object
                        ).catch(
                            error => console.log(error) // Handle the error response object
                        );
                    }
                    return json

                }).then(json => {
                    $('#modal_details').modal('hide');
                    search()
                }).catch(err => {
                    console.log(err);
                });
            } else {
                $("#alert_add").removeAttr("hidden");
            }

        };

        function update_modal_show(id_produit, label, id_marque, id_categorie, prix_produit, description_produit) {
            img_updated = false;
            fetch("../php/products/read_desc_product?id_produit=" + id_produit).then(resp => resp.json()).then(json => {
                var data = json.data;
                $('#modal_content').html(`
            <div class="modal-header">
                    <h5 class="modal-title" id="exampleModal">Modifier Produit ${id_produit}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                <div class="modal-body">
                        <form  id='form_update_product'>                          
                            <div class="form-group">
                                <label for="label"> Label :</label>

                                <input type="text" id="label_update" name="label" value="${label}" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="prix_produit">Le prix :</label>
                                <input type="number"  id="prix_produit_update" value="${prix_produit}" name="prix_produit"  class="form-control" required>
                            </div>
                            <div class="form-group">
                            <label for="id_marque">La marque :</label>
                                <select class="form-control selectpicker" name="id_marque" id="id_marque_update" data-live-search="true" required>
                                ${marques.map(element => `<option value="${element.id_marque}" ${id_marque==element.id_marque?"selected":""}>${element.nom_marque}</option>`)}
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="id_categorie">La categorie :</label>
                                <select class="form-control selectpicker" name="id_categorie" id="id_categorie_update" data-live-search="true" required>       
                                <option data-tokens="" selected value disabled></option>
                                ${categories.map(element => `<option value="${element.id_categorie}" ${id_categorie==element.id_categorie?"selected":""} >${element.nom_categorie}</option>`)}</select>
                            </div>
                            <div class="form-group">
                                <label for="description_produit">Description :</label>
                                <textarea class="form-control" name="description_produit" id="description_produit">${data.description_produit}</textarea>
                                
                            </div>
                            <div class="form-group">
                                <label for="description_produit">Image de produit :</label>
                                <div class="d-flex justify-content-center">
                                    <div class="col-4 imgUp">
                                    <div class="imagePreview"></div>
                                    <label class="btn btn-primary">
                                    charger photo<input type="file" name="file" id="img_mod_up" input class="uploadFile img" value="charger photo" style="width: 0px;height: 0px;overflow: hidden;">
                                    </label>
                                    </div>    
                                </div>                                                   
                            </div>  
                            <div class="alert alert-danger alert-dismissible fade show" id="alert_update" hidden>
                                un ou plusieurs champs sont vides
                            </div>
                            
                        </form>
                </div>
                    
                <div class="modal-footer">
                                <input type="button" onclick="update_product(${id_produit})" class="btn btn-info"  form-control" value="Confirmer modification">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">FERMER</button>               
                </div>
                </div> `);
                $('.selectpicker').selectpicker();
                $('#modal_details').modal('show');
                $('#img_mod_up').closest(".imgUp").find('.imagePreview').css("background-image", "url(" + `../img/products/${id_produit}.jpg` + ")")
            });
        };

        function search() {

            fetch("../php/products/read_products?search_admin=" + $("#search_admin").val()).then(resp => resp.json()).then(json => {
                var data = json.data;
                $("#table_body").text('');

                data.forEach((element) => {
                    $('#table_body').append(`
                        <tr>
                            <td>${element.id_produit}</td>
                            <td><img src="../img/products/${element.id_produit}.jpg" height="50px" width="50px"  ></td>
                            <td>${element.label}</td>
                            <td>${element.nom_marque}</td>
                            <td>${element.nom_categorie}</td>
                            <td>${element.prix_produit.toFixed(2)}</td>
                            <td>
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">OPTIONS</button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                           
                                <a class="dropdown-item" href="#" onclick='update_modal_show(${element.id_produit},"${element.label}",${element.id_marque},${element.id_categorie},${element.prix_produit});'>MODIFIER</a>
                                <a class="dropdown-item" href="#" onclick='modal_delete_show(${element.id_produit},"${element.label}");'>SUPPRIMER </a>
                            </div>
                            </td>
                        </tr>
                        `);
                });
                $("#nbr_prd").text(data.length);
                $("#div_nbr").removeAttr("hidden");

            }).catch(err => {
                console.log(err);
            });
        }

        function modal_delete_show(id_produit, nom_produit) {
            $('#modal_content').html(`
            <div class="modal-header">                  
                    <h5 class="modal-title " >Suppression du produit N° ${id_produit}</h5>          
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Etes-vous sûr de vouloir supprimer le produit "<b>${nom_produit}"</b>?</p>
                </div>
                <div class="modal-footer d-flex justify-content-around">
                     <button type="button" class="btn btn-danger"  onclick="delete_categorie(${id_produit},'${nom_produit}')" >oui</button>
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">non</button>
                </div>    `);
            $('#modal_details').modal('show');
        };

        function delete_categorie(id_produit, nom_produit) {
            fetch("../php/products/delete_product?id_produit=" + id_produit).then(resp => resp.json()).then(json => {
                const data = json.data;
                $("#modal_details").modal("hide");

                $("#msg").html(`
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>supprimée!</strong> . le produit ${nom_produit} a ete supprimée 
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
        search();
        $(function() {
            $(document).on("change", ".uploadFile", function() {
                var uploadFile = $(this);
                var files = !!this.files ? this.files : [];
                if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support

                if (/^image/.test(files[0].type)) { // only image file
                    var reader = new FileReader(); // instance of the FileReader
                    reader.readAsDataURL(files[0]); // read the local file
                    img_updated = true;
                    reader.onloadend = function() { // set image data as background of div
                        //alert(uploadFile.closest(".upimage").find('.imagePreview').length);
                        uploadFile.closest(".imgUp").find('.imagePreview').css("background-image", "url(" + this.result + ")");
                    }
                }

            });
        });
    </script>
</body>

</html>