<?php
session_start();
header("Access-Control-Allow-Origin: *");
require_once "../connection/db.php";

//require_once "../verify_session.php";
if (isset($_SESSION["id_client"]) && isset($_GET["id_produit"])) {

    $query = 'INSERT INTO wishlist(id_client, id_produit) VALUES (:id_client, :id_produit)';
    $sql = $conn->prepare($query);
    $sql->execute(array("id_client" => $_SESSION["id_client"], "id_produit" => $_GET["id_produit"]));
    $id = $conn->lastInsertId();
    $msg["code"] = 200;
    $msg["msg"] = "ok";
    $json = json_encode($msg, JSON_NUMERIC_CHECK);
    echo $json;
} else
    echo json_encode(array("code" => 400, "message" => "Error, parametres non sufficent"));
