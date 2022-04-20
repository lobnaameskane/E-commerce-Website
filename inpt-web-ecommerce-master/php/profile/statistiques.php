<?php
session_start();

require_once "../connection/db.php";header("Access-Control-Allow-Origin: *");

//require_once "../verify_session.php";
if (isset($_SESSION["id_client"])) {

    $query = 'SELECT min(date_commande) first_commande,max(date_commande) last_commande , max(prix_commande) maximum_spent ,min(prix_commande) minimum_spent , avg(prix_commande) avg_spent,count(id_commande) nbre_commande from commande where id_client=:id_client';

    $sql = $conn->prepare($query);
    $sql->execute(array("id_client" => $_SESSION["id_client"]));
    $results = $sql->fetchAll(PDO::FETCH_ASSOC);
    $msg["data"] = $results;
    $msg["code"] = 200;
    $msg["msg"] = "ok";


    $json = json_encode($msg, JSON_NUMERIC_CHECK);
    echo $json;
} else
    echo json_encode(array("code" => 400, "message" => "Error, parametres non sufficent"));
