<?php
require_once "../connection/db.php";header("Access-Control-Allow-Origin: *");

$_GET = array_filter($_GET);

//require_once "../verify_session.php";
$query =  'SELECT c.id_client, CONCAT(c.nom_client ," " , c.prenom_client) as nom_client ,c.email  FROM client c  where c.act=1 ';
$sql = $conn->prepare($query);
$sql->execute();
$clients = $sql->fetchAll(PDO::FETCH_ASSOC);
$msg["data"] = $clients;
$msg["code"] = 200;
$msg["msg"] = "ok";

$json = json_encode($msg, JSON_NUMERIC_CHECK);
echo $json;
