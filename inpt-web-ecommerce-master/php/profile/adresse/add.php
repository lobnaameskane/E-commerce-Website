<?php
session_start();header("Access-Control-Allow-Origin: *");

require_once "../../connection/db.php";
if (isset($_SESSION["id_client"])) {

    if ($_GET["adresse"] == null) {
        $msg["code"] = 404;
        $msg["msg"] = "La case adresse ne peut pas etre vide";
    } else if ($_GET["code_postal"] == null) {
        $msg["code"] = 403;
        $msg["msg"] = "La case code postal ne peut pas etre vide";
    } else if ($_GET["nom"] == null) {
        $msg["code"] = 405;
        $msg["msg"] = "La case nom ne peut pas etre vide";
    } else if ($_GET["telephone"] == null) {
        $msg["code"] = 406;
        $msg["msg"] = "La case telephone ne peut pas etre vide";
    } else {
        $query = "INSERT into adresse (id_client,adresse,code_postal,nom_complet,tel_adresse_client) values(:id_client,:adresse,:code_postal,:nom_complet,:tel_adresse_client);";
        $sql = $conn->prepare($query);
        $sql->execute(array(
            "id_client" => $_SESSION["id_client"],
            "adresse" => $_GET["adresse"],
            "code_postal" => $_GET["code_postal"],
            "nom_complet" => ($_GET["nom"] . ' ' . $_GET["prenom"]),
            "tel_adresse_client" => $_GET["telephone"]
        ));
        $msg["code"] = 200;
        $msg["msg"] = "ok";
    }

    $json = json_encode($msg, JSON_NUMERIC_CHECK);
    echo $json;
} else
    echo json_encode(array("code" => 400, "message" => "Error, parametres non sufficent"));
