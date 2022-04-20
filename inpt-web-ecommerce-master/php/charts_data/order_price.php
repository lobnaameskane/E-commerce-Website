<?php
require_once "../connection/db.php";
header("Access-Control-Allow-Origin: *");
//require_once "../verify_session.php";
$query =  'SELECT date(date_commande) as `date` ,sum(prix_commande) as prix_commande from commande c where date_commande >= ( CURDATE() - INTERVAL 7 DAY ) group  by date(date_commande)';
$sql = $conn->prepare($query);
$sql->execute();

$msg["data"] = $sql->fetchAll(PDO::FETCH_ASSOC);
$msg["code"] = 200;
$msg["msg"] = "ok";

$json = json_encode($msg, JSON_NUMERIC_CHECK);
echo $json;
