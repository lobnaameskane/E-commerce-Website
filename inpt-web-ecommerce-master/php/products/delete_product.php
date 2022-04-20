<?php
require_once "../connection/db.php";header("Access-Control-Allow-Origin: *");

//require_once "../verify_session.php";
if (isset($_GET["id_produit"])) {
    $query = "UPDATE produit set act=:act where id_produit=:id_produit";
    $stmt = $conn->prepare($query);

    $stmt->bindValue('id_produit', $_GET['id_produit'], PDO::PARAM_INT);

    $stmt->bindValue('act', 0, PDO::PARAM_INT);

    $stmt->execute();



    $msg["code"] = 200;
    $msg["msg"] = "ok";

    $json = json_encode($msg, JSON_NUMERIC_CHECK);
    echo $json;
} else
    echo json_encode(array("code" => 400, "message" => "Error, parametres non sufficent"));
