<?php
require_once "../connection/db.php";header("Access-Control-Allow-Origin: *");

//require_once "../verify_session.php";

if (isset($_GET["id_categorie"])&&isset($_GET["nom_categorie"])) {


$query = "UPDATE categorie set nom_categorie=:nom_categorie where id_categorie=:id_categorie";
$stmt = $conn->prepare($query);

$stmt->bindValue('id_categorie', $_GET['id_categorie'], PDO::PARAM_INT);

$stmt->bindValue('nom_categorie', $_GET['nom_categorie'], PDO::PARAM_STR);

$stmt->execute();



$msg["code"] = 200;
$msg["msg"] = "ok";

$json = json_encode($msg, JSON_NUMERIC_CHECK);
echo $json;
} else
echo json_encode(array("code" => 400, "message" => "Error, parametres non sufficent"));
