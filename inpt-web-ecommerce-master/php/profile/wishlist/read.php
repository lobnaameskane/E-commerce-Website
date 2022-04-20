<?php
require_once "../../connection/db.php";
header("Access-Control-Allow-Origin: *");

session_start();
if (isset($_SESSION["id_client"])) {
    $query = 'SELECT produit.id_produit,label, nom_marque, description_produit , prix_produit from produit , wishlist ,marque mr  where   produit.id_produit = wishlist.id_produit  and produit.id_marque = mr.id_marque and id_client=:id_client ';
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
