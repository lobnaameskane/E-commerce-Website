<?php
require_once "../connection/db.php";
header("Access-Control-Allow-Origin: *");

session_start();
//require_once "../verify_session.php";
if (isset($_SESSION["id_client"])) {
    $query = 'SELECT id_adresse,  adresse, code_postal, nom_complet, tel_adresse_client FROM adresse WHERE  act=1 AND id_client=:id_client';
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
