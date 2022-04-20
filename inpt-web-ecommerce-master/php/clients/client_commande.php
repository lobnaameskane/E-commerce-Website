<?php
require_once "../connection/db.php";header("Access-Control-Allow-Origin: *");

//require_once "../verify_session.php";
$query = 'SELECT id_commande, date_commande, etat_actuell, prix_commande from commande where id_client=:id_client order by date_commande DESC LIMIT 5';


$sql = $conn->prepare($query);
$sql->execute(array("id_client" => $_GET["id_client"]));
$commandes = $sql->fetchAll(PDO::FETCH_ASSOC);

$msg["data"] = $commandes;
$msg["query"] = $query;
$msg["code"] = 200;
$msg["msg"] = "ok";

$json = json_encode($msg, JSON_NUMERIC_CHECK);
echo $json;
