<?php
require_once "../connection/db.php";
header("Access-Control-Allow-Origin: *");

//require_once "../verify_session.php";
session_start();
if (isset($_SESSION["id_client"]) && isset($_GET["id_produit"]) && isset($_GET["options_produit"])) {
    $query = 'DELETE FROM panier WHERE id_client=:id_client AND id_produit=:id_produit AND options_produit=:options_produit';
    $sql = $conn->prepare($query);
    $sql->execute(array("id_client" => $_SESSION["id_client"], "id_produit" => $_GET["id_produit"], "options_produit" => $_GET["options_produit"]));
    $msg["code"] = 200;
    $msg["msg"] = "ok";
    $json = json_encode($msg, JSON_NUMERIC_CHECK);
    echo $json;
} else
    echo json_encode(array("code" => 400, "message" => "Error, parametres non sufficent"));
