<?php
require_once "../connection/db.php";header("Access-Control-Allow-Origin: *");

//require_once "../verify_session.php";


$nom = $_GET["nom_categorie"];
if (isset($nom)) {
    $sql = "INSERT into categorie (nom_categorie) values(?)";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(1, $nom, PDO::PARAM_STR);
    $stmt->execute();
    $id = $conn->lastInsertId();

    $msg["code"] = 200;
    $msg["id_categorie"] = $id;
    $msg["msg"] = "ok";

    $json = json_encode($msg, JSON_NUMERIC_CHECK);
    echo $json;
} else {
    echo json_encode(array("code" => 400, "message" => "Error, parametres non sufficent"));
}
