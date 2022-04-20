<?php
require_once "../connection/db.php";
//require_once "../verify_session.php";
header("Access-Control-Allow-Origin: *");


$nom = $_GET["nom_marque"];
if (isset($nom)) {
    $sql = "INSERT into marque (nom_marque) values(?)";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(1, $nom, PDO::PARAM_STR);
    $stmt->execute();
    $id = $conn->lastInsertId();

    $msg["code"] = 200;
    $msg["id_marque"] = $id;
    $msg["msg"] = "ok";

    $json = json_encode($msg, JSON_NUMERIC_CHECK);
    echo $json;
} else {
    echo json_encode(array("code" => 400, "message" => "Error, parametres non sufficent"));
}
