<?php
require_once "../connection/db.php";
//require_once "../verify_session.php";
header("Access-Control-Allow-Origin: *");

$results;
if (!isset($_GET["search"])) {
    $query = 'SELECT  mr.id_marque, mr.nom_marque, sum(case when pr.act = 1 then 1 else 0 end) as prod_count from marque mr left join produit pr on mr.id_marque = pr.id_marque  group by mr.id_marque';
    $sql = $conn->prepare($query);
    $sql->execute();
    $results = $sql->fetchAll(PDO::FETCH_ASSOC);
} else {
    $query = 'SELECT  mr.id_marque, mr.nom_marque, sum(case when pr.act = 1 then 1 else 0 end) as prod_count from marque mr left join produit pr on mr.id_marque = pr.id_marque where  mr.nom_marque like :search   group by mr.id_marque';
    $sql = $conn->prepare($query);
    $sql->execute(array("search" => "%" . $_GET["search"] . "%"));
    $results = $sql->fetchAll(PDO::FETCH_ASSOC);
}
$msg["data"] = $results;
$msg["code"] = 200;
$msg["msg"] = "ok";

$json = json_encode($msg, JSON_NUMERIC_CHECK);
echo $json;
