<?php
session_start();
require_once "./req/verify.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>panier</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/navbar.css" rel="stylesheet">
  <link href="css/cart.css" rel="stylesheet">
  <script src="js/bootstrap.bundle.min.js"></script>

  <link rel="stylesheet" href="css/bootstrap-icons.css">
  <style>


  </style>
</head>

<body>
  <div>
    <?php
    require_once "req/navbar.php";

    ?>
  </div>
  <div class="container-fluid  ">


    <div class="container-fluid ">
      <div class="jumbotron d-flex justify-content-center ">
        <div class="card">
          <div class="card-top border-bottom text-center"> <a href="#" class="link"> Retour a la boutique</a> <span id="logo">Amoil.com</span> </div>
          <div class="card-body">
            <div class="row upper"> <span class="panier"> Panier</span> <span class="payment">Payment</span> </div>

            <div class="row">
              <div class="col-lg-12">
                <div class="left border">
                  <div class="row"><span><i class="bi bi-basket3-fill " style="font-size: 2rem ;" aria-hidden="true"></i></i></span> <span class="header" style="font-size: 2rem;"> Panier</span></div>

                  <div id="cart_content">

                    <div class="card mb-3 p-0 h-25">
                      <div class="row no-gutters">
                        <div class="col-md-2">
                          <img src="img/products/pc.jpg" class="card-img w-75" alt="...">
                        </div>
                        <div class="col-md-10">
                          <div class="card-body p-3 col-12 " style="width: 100%;">
                            <span class="card-title p-0 h5 d-flex justify-content-between" style="color: black;"><span style="color: black;">product1</span>
                              <span>
                                <span class="border pt-2 pl-3 pr-3 pb-1" id="qty">1</span>
                                <button id="minus" onclick='minus("qty","price")' style="padding: 2px 5px; border-radius: 10px; background-color: rgb(230,230,230) ;border-color:(230,230,230); border-width: 1px;">-</button>
                                <button id="plus" onclick='plus("qty","price")' style="padding: 2px 3px; border-radius: 10px; background-color: rgb(230,230,230) ;border-color:(230,230,230); border-width: 1px;">+</button>
                              </span>
                              <span>
                                <span style="color: black;">$</span>
                                <span class="mr-1" id="price" style="color: black;">1000</span> </span>
                            </span>
                            <span>
                              <div class="d-flex justify-content-end px-3">
                                <button type="button" style="border-radius: 5px;" class="h-50 w-25 btn-success">view</button>
                                <button type="button" style="border-radius: 5px;" class="h-50 w-25 ml-1 btn-danger">remove</button>

                              </div>
                            </span>

                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="card mb-3 p-0 h-25">
                      <div class="row no-gutters">
                        <div class="col-md-2">
                          <img src="img/products/product2.jpg" class="card-img w-75" alt="...">
                        </div>
                        <div class="col-md-10">
                          <div class="card-body p-3 col-12 " style="width: 100%;">
                            <span class="card-title p-0 h5 d-flex justify-content-between" style="color: black;"><span style="color: black;">product1</span>
                              <span>
                                <span class="border pt-2 pl-3 pr-3 pb-1" id="qty2">1</span>
                                <button id="minus" onclick='minus("qty2","price2")' style="padding: 2px 5px; border-radius: 10px; background-color: rgb(230,230,230) ;border-color:(230,230,230); border-width: 1px;">-</button>
                                <button id="plus" onclick='plus("qty2","price2")' style="padding: 2px 3px; border-radius: 10px; background-color: rgb(230,230,230) ;border-color:(230,230,230); border-width: 1px;">+</button>
                              </span>
                              <span>
                                <span style="color: black;">$</span>
                                <span class="mr-1" id="price2" style="color: black;">1200</span> </span>
                            </span>
                            <span>
                              <div class="d-flex justify-content-end px-3">
                                <button type="button" style="border-radius: 5px;" class="h-50 w-25 btn-success">view</button>
                                <button type="button" style="border-radius: 5px;" class="h-50 w-25 ml-1 btn-danger">remove</button>

                              </div>
                            </span>

                          </div>
                        </div>
                      </div>
                    </div>


                  </div>

                  <div class="d-flex justify-content-end h3">

                    <span>Totale: $</span>
                    <span id="total"></span>
                  </div>
                </div>


              </div>


            </div>

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
    require_once "req/footbar.php";

    ?>
  </div>

</body>
<script>
  var px = document.getElementById("price").innerHTML;
  var px2 = document.getElementById("price2").innerHTML;

  function plus(qty, price) {

    var h = parseFloat(document.getElementById(qty).innerHTML);
    var px = parseFloat(document.getElementById(price).innerHTML);
    if (h > 0) {
      px = px + px / h;
      h++;
      document.getElementById(qty).innerHTML = h;
      document.getElementById(price).innerHTML = px;
      var pxa = parseFloat(document.getElementById("price").innerHTML);
      var pxa2 = parseFloat(document.getElementById("price2").innerHTML);
      document.getElementById("total").innerHTML = pxa + pxa2;
    }

  }

  function minus(qty, price) {
    var h = parseFloat(document.getElementById(qty).innerHTML);
    var px = parseFloat(document.getElementById(price).innerHTML);
    if (h > 1) {
      px = px - px / h;
      h--;

      document.getElementById(qty).innerHTML = h;
      document.getElementById(price).innerHTML = px;
      var pxa = parseFloat(document.getElementById("price").innerHTML);
      var pxa2 = parseFloat(document.getElementById("price2").innerHTML);
      document.getElementById("total").innerHTML = pxa + pxa2;

    }
  }
  var px = parseFloat(document.getElementById("price").innerHTML);
  var px2 = parseFloat(document.getElementById("price2").innerHTML);
  document.getElementById("total").innerHTML = px + px2;
</script>

</html>