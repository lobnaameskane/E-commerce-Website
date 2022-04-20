<?php
require_once "../connection/db.php";
header("Access-Control-Allow-Origin: *");

//require_once "../verify_session.php";
session_start();
if (isset($_SESSION["id_client"])) {

    $query = 'SELECT p.id_produit, p.options_produit, p.qtt_panier, pr.prix_produit, pr.label FROM panier p LEFT JOIN produit pr ON p.id_produit=pr.id_produit WHERE id_client=:id_client';


    $sql = $conn->prepare($query);
    $sql->execute(array("id_client" => $_SESSION["id_client"]));
    $cart = $sql->fetchAll(PDO::FETCH_ASSOC);
    $_SESSION["cart"] = $cart;
    
    $msg["data"] = $cart;
    $msg["code"] = 200;
    $msg["msg"] = "ok";

    $json = json_encode($msg, JSON_NUMERIC_CHECK);
    echo $json;
} else
    echo json_encode(array("code" => 400, "message" => "Error, parametres non sufficent"));
