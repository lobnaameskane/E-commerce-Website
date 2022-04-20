<?php
session_start();
header("Access-Control-Allow-Origin: *");

require_once "../../connection/db.php";
if (isset($_SESSION["id_client"])) {
    $query = "select id_adresse,adresse, code_postal,nom_complet,tel_adresse_client  from adresse where id_client = :id_client";
    $sql = $conn->prepare($query);
    $sql->execute(array('id_client' => $_SESSION["id_client"]));
    $data = $sql->fetchAll(PDO::FETCH_ASSOC);

    $msg["data"] = $data;
    $msg["code"] = 200;
    $msg["msg"] = "ok";

    $json = json_encode($msg, JSON_NUMERIC_CHECK);
    echo $json;
} else
    echo json_encode(array("code" => 400, "message" => "Error, parametres non sufficent"));
