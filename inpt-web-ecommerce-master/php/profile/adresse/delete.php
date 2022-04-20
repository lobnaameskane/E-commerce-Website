<?php
session_start();
require_once "../../connection/db.php";
header("Access-Control-Allow-Origin: *");

if (isset($_SESSION["id_client"]) && isset($_GET["id_adresse"])) {
    $query = "DELETE from adresse where id_adresse= :id_adresse";
    $sql = $conn->prepare($query);
    $sql->execute(array(
        "id_adresse" => $_GET["id_adresse"]
    ));
    $msg["code"] = 200;
    $msg["msg"] = "ok";
    $json = json_encode($msg, JSON_NUMERIC_CHECK);
    echo $json;
} else
    echo json_encode(array("code" => 400, "message" => "Error, parametres non sufficent"));
