<?php
require_once "../connection/db.php";
header("Access-Control-Allow-Origin: *");

session_start();
//require_once "../verify_session.php";
if (isset($_SESSION["id_client"])  && isset($_GET["nom_complet"]) && isset($_GET["adresse"])  && isset($_GET["tel_adresse_client"])) {
    $query = 'INSERT INTO adresse( id_client, adresse, code_postal, nom_complet, tel_adresse_client) VALUES ( :id_client, :adresse, :code_postal, :nom_complet, :tel_adresse_client)';
    $sql = $conn->prepare($query);
    $sql->execute(array("id_client" => $_SESSION["id_client"], "adresse" => $_GET["adresse"], "code_postal" => $_GET["code_postal"], "tel_adresse_client" => $_GET["tel_adresse_client"], "nom_complet" => $_GET["nom_complet"] ));
    $msg["id_adresse"] = $conn->lastInsertId();
    $msg["code"] = 200;
    $msg["msg"] = "ok";
    $json = json_encode($msg, JSON_NUMERIC_CHECK);
    echo $json;
} else
    echo json_encode(array("code" => 400, "message" => "Error, parametres non sufficent"));
