<?php
require_once "../connection/db.php";header("Access-Control-Allow-Origin: *");

//require_once "../verify_session.php";

$query = "delete from categorie where id_categorie=?";
$stmt = $conn->prepare($query);
$stmt->bindValue(1, $_GET['id_categorie'], PDO::PARAM_INT);

$stmt->execute();




$msg["code"] = 200;
$msg["msg"] = "ok";

$json = json_encode($msg, JSON_NUMERIC_CHECK);
echo $json;
