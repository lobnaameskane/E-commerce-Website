<?php
header("Access-Control-Allow-Origin: *");
session_start();
require_once "../connection/db.php";
if (isset($_SESSION["id_client"]) && isset($_GET["id_produit"])) {
    $query = "DELETE from wishlist where id_produit=:id_produit and id_client=:id_client";
    $sql = $conn->prepare($query);
    $sql->execute(array(
        "id_produit" => $_GET["id_produit"],
        "id_client" => $_SESSION["id_client"]
    ));

    $msg["code"] = 200;
    $msg["msg"] = "ok";

    $json = json_encode($msg, JSON_NUMERIC_CHECK);
    echo $json;
} else
    echo json_encode(array("code" => 400, "message" => "Error, parametres non sufficent"));
