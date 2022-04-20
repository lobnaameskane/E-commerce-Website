<?php
require_once "../connection/db.php";
header("Access-Control-Allow-Origin: *");

//require_once "../verify_session.php";
if (isset($_GET["id_marque"]) && isset($_GET["nom_marque"])) {
    $query = "UPDATE marque set nom_marque=:nom_marque where id_marque=:id_marque";
    $stmt = $conn->prepare($query);

    $stmt->bindValue('id_marque', $_GET['id_marque'], PDO::PARAM_INT);

    $stmt->bindValue('nom_marque', $_GET['nom_marque'], PDO::PARAM_STR);

    $stmt->execute();



    $msg["code"] = 200;
    $msg["msg"] = "ok";

    $json = json_encode($msg, JSON_NUMERIC_CHECK);
    echo $json;
} else {
    echo json_encode(array("code" => 400, "message" => "Error, parametres non sufficent"));
}
