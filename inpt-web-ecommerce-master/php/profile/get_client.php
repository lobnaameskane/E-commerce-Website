<?php
session_start();
require_once "../connection/db.php";
header("Access-Control-Allow-Origin: *");

if (isset($_SESSION["id_client"])) {
    $query = "SELECT  nom_client , prenom_client , email , sexe , tel_client , date_naissance from client where id_client = :id_client";
    $sql = $conn->prepare($query);
    $sql->execute(array(
        "id_client" => $_SESSION["id_client"]
    ));
    $data = $sql->fetch(PDO::FETCH_ASSOC);

    $msg["data"] = $data;
    $msg["code"] = 200;
    $msg["msg"] = "ok";

    $json = json_encode($msg, JSON_NUMERIC_CHECK);
    echo $json;
} else
    echo json_encode(array("code" => 400, "message" => "Error, parametres non sufficent"));
