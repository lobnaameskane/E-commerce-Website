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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.bundle.min.js" integrity="sha512-SuxO9djzjML6b9w9/I07IWnLnQhgyYVSpHZx0JV97kGBfTIsUYlWflyuW4ypnvhBrslz1yJ3R+S14fdCWmSmSA==" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/bootstrap-icons.css">
    <link rel="stylesheet" href="../css/admin/sidebar.css">



</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <?php require "req/sidebar.php" ?>
            <div class="col pt-4">
                <h2>
                    <a href="" data-target="#sidebar" data-toggle="collapse" class="d-md-none"><i class="fa fa-bars"></i></a> Principale
                </h2>
                <hr>
                <div class="row">
                    <div class="col-6">
                        <canvas id="nbr_orders"></canvas>

                    </div>
                    <div class="col-6">
                        <canvas id="prix_orders"></canvas>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        fetch("../php/charts_data/order_nbr").then(resp => resp.json()).then(json => {


            var nbr_orders = $("#nbr_orders");
            var chart_nbr_orders_chart = new Chart(nbr_orders, {
                type: 'line',
                data: {
                    labels: json.data.map(element => element.date),
                    datasets: [{
                        data: json.data.map(element => element.nbr_commande),
                        borderWidth: 1,
                        borderColor: '#00c0ef',
                        label: 'Nombre des commandes',
                    }]
                },
                options: {
                    responsive: true,
                    title: {
                        display: true,
                        text: "Nombre des commandes effectuées ",
                    },
                    legend: {
                        display: false
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                            }
                        }]
                    }
                }
            });
        }).catch(err => {
            console.log(err);
        });
        fetch("../php/charts_data/order_price").then(resp => resp.json()).then(json => {


            var nbr_orders = $("#prix_orders");
            var chart_nbr_orders_chart = new Chart(nbr_orders, {
                type: 'line',
                data: {
                    labels: json.data.map(element => element.date),
                    datasets: [{
                        data: json.data.map(element => element.prix_commande),
                        borderWidth: 1,
                        borderColor: '#DC3545',
                        label: 'prix total des commandes',
                    }]
                },
                options: {
                    responsive: true,
                    title: {
                        display: true,
                        text: "prix total des commandes effectuées ",
                    },
                    legend: {
                        display: false
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                            }
                        }]
                    }
                }
            });
        }).catch(err => {
            console.log(err);
        });
    </script>
</body>


</html>