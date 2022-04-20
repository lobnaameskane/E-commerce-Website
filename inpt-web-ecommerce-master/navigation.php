<?php session_start();?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Navigation</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/navbar.css" rel="stylesheet">
    <script src="js/jquery-3.5.1.slim.min.js"></script>

    <script src="js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap-icons.css">
    <link rel="stylesheet" href="css/index.css">
  
  <style>


  </style>
</head>

<body>
  <?php

  require_once "req/navbar.php";


  ?>
  <div class="container-fluid mt-5 pt-5">
    <div class="row ">

      <div class="col-lg-2 col-md-3 col-sm-4 col-xs-4 border-right">
        <form id="affinitions_form">
          <div class="h4" style="color: navy;">Categories</div>
          <hr>
          <div id="categories">




          </div>
          <hr>
          <div class="h4" style="color: navy;">Affiner par</div>



          <div class="Marques my-5">
            <div class="h5" style="color: gold;">Marques</div>
            <br>
            <div id="marques">
            </div>

            <br>

            <div class="prix">
              <div class="h5" style="color: gold;">Prix</div>
              <br>
              <div>
                entre:
                <input type="number" name="from_price" id="from_price" onblur="show_products(0)" style="width:40px;margin-right: 3px;margin-left: 2px;border-radius: 5px;border-width: 1px;">
                et
                <input type="number" name="to_price" id="to_price" onblur="show_products(0)" style="width:40px;margin-left: 3px;border-radius: 5px;border-width: 1px;">
              </div>
              <div id="prices">

                <input type="checkbox" min="0" max="49" style="margin-right: 15px;">0-49 DH
                <br>

                <input type="checkbox" min="50" max="199" style="margin-right: 15px;">50-199 DH
                <br>


                <input type="checkbox" min="200" max="499" style="margin-right: 15px;">200-499 DH
                <br>


                <input type="checkbox" min="500" max="1000" style="margin-right: 15px;">500-1000 DH
                <br>

                <input type="checkbox" min="1000" max="10000000000" style="margin-right: 15px;">1000-+ DH

              </div>
        </form>

      </div>
      <hr>
    </div>
  </div>


  <div class="col">
    <div class="jumbotron">
      <div class="row justify-content-around" id="products_div">

      </div>
      <br>
      <br><br>
      <div class=" col-12 d-flex justify-content-center">
        <nav>
          <ul class="pagination" id="pagination">
            <li class="page-item ">
              <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
            </li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item active" aria-current="page">
              <a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>
            </li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item">
              <a class="page-link" href="#">Next</a>
            </li>
          </ul>
        </nav>
      </div>
    </div>









  </div>

  </div>

  </div>
  <div class="container-fluid">
    <?php
    require_once "req/footbar.php";

    ?>
  </div>

  <script>
    const queryString = window.location.search;
    var marques = [];
    var categories = [];
    var products = [];
    var filters = {
      marques: [],
      categories: []
    }
    var pages = [];

    function show_products(val) {
      $("#products_div").text('');
      var from_price = parseFloat($("#from_price").val()) || -1;
      var to_price = parseFloat($("#to_price").val()) || -1;
      var p = [...products]
      p = p.filter(el => (from_price != -1 ? el.prix_produit >= from_price : true) && (to_price != -1 ? el.prix_produit <= to_price : true));
      p = p.filter(el => filterRange(el.prix_produit));
      if (filters.categories.length > 0)
        p = p.filter(el => filters.categories.includes(el.id_categorie))
      if (filters.marques.length > 0)
        p = p.filter(el => filters.marques.includes(el.id_marque));
      console.log(p);
      pages = paginate(p, 12);
      pages[val].forEach((element, index) => {
        $("#products_div").append(`
          <div class="card  card_item col-lg-3 col-md-4 col-sm-5  m-2 p-1">
              <a href="produit?id_produit=${element.id_produit}">

                <img src="img/products/${element.id_produit}.jpg" height="250px" width="250px" class="card-img-top w-100 " alt="...">
              </a>
              <div class="card-body">
                <a href="produit?id_produit=${element.id_produit}" style="color: black;">
                  <span class="card-title h4">${element.label}</span>
                </a>
                <img src="img/stars.jpg" alt="rating" class=" d-inline-flex align-self-r w-lg-50 w-sm-50 w-md-75">
                <p style="color:gray">${element.description_produit}</p>
                <a href="produit?id_produit=${element.id_produit}" class="btn btn-primary">Acheter</a>
                <span class="h6" style="margin-left: 30%;">${element.prix_produit.toFixed(2)} DH</span>
              </div>
            </div>
            `);
      });

      $("#pagination").html(`
            <li class="page-item ${val>0? "":"disabled"} ">
              <a class="page-link" href="#" tabindex="-1" onclick="show_products( ${val>0? val-1:0})" aria-disabled="true">precedant</a>
            </li>
            ${pages.map((el,index)=> `
              <li class="page-item ${val==index?"active":""}"><a class="page-link" onclick="show_products(${index})" href="#">${index+1}</a></li>  
              `)}         
            <li class="page-item ${val<pages.length-1? "":"disabled"}">
              <a class="page-link" href="#" onclick="show_products( ${val<pages.length-1? val+1:pages.length-1})">suivant</a>
            </li>

      `);
    }
    async function get_products() {
      await fetch("./php/products/read_products" + queryString).then(resp => resp.json()).then(json => {
        products = json.data;
        //FILL brands ARRAY
        marques = products.map(el => {
          return {
            "id_marque": el.id_marque,
            "nom_marque": el.nom_marque
          }
        }).filter((v, i, a) => a.findIndex(t => (t.id_marque === v.id_marque)) === i)
        //FILL CATS ARRAY
        categories = products.map(el => {
          return {
            "id_categorie": el.id_categorie,
            "nom_categorie": el.nom_categorie
          }
        }).filter((v, i, a) => a.findIndex(t => (t.id_categorie === v.id_categorie)) === i);
        //calculate pags


      }).catch(err => console.error(err));
      return 0;
    }
    get_products().then(val => {
      show_products(val);
      marques.forEach((element, index) => {
        $("#marques").append(`
            <input type="checkbox" name="marques" value="${element.id_marque}" style="margin-right:12px">${element.nom_marque}<br>
        `);
      });
      categories.forEach((element, index) => {
        $("#categories").append(`
            <input type="checkbox" name="categories" value="${element.id_categorie}" style="margin-right:12px">${element.nom_categorie}<br>
        `);
      });
    });




    $("#marques").on('change', 'input:checkbox', function() {
      filters.marques = $("#marques > input:checkbox:checked").map(function() {
        return parseInt($(this).val())
      }).get();
      console.log(filters.marques);
      show_products(0);
    });
    $("#categories").on('change', 'input:checkbox', function() {
      filters.categories = $("#categories > input:checkbox:checked").map(function() {
        return parseInt($(this).val())
      }).get();
      console.log(filters.categories);
      show_products(0);

    });

    $("#prices").on('change', 'input:checkbox', function() {

      show_products(0);
    });

    function paginate(arr, size) {
      return arr.reduce((acc, val, i) => {
        let idx = Math.floor(i / size)
        let page = acc[idx] || (acc[idx] = [])
        page.push(val)
        return acc
      }, [])
    }

    function filterRange(amount) {
      var checkedInputs = $("#prices").find("input:checked").length;
      var totalInputs = $("#prices").find("input").length;
      var returnValue = false;

      $("#prices").find("input:checked").each(function() {
        var min = $(this).attr('min');
        var max = $(this).attr('max');
        if (amount >= min && amount <= max) {
          returnValue = true;
          return true;
        }
      });

      return (checkedInputs == 0 || totalInputs == checkedInputs || returnValue);
    }
  </script>





</body>

</html>