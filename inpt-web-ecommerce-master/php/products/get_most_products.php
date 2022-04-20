<?php
require_once "../connection/db.php";header("Access-Control-Allow-Origin: *");

//require_once "../verify_session.php";
$query = "";
if (!isset($_GET["id_categorie"])) {
    $query = 'SELECT  pr.id_produit,label,prix_produit,count(qtt.id_produit) as qtt_sold from produit pr left join qt_commande qtt on pr.id_produit=qtt.id_produit   where act=1 group by pr.id_produit    order by qtt_sold  desc limit 6 ';
    $sql = $conn->prepare($query);
    $sql->execute();
    $results = $sql->fetchAll(PDO::FETCH_ASSOC);
    $msg["data"] = $results;
    $msg["code"] = 200;
    $msg["msg"] = "ok";

    $json = json_encode($msg, JSON_NUMERIC_CHECK);
    echo $json;
} else {
    $query = 'SELECT  pr.id_produit,label,prix_produit,count(qtt.id_produit) as qtt_sold from produit pr left join qt_commande qtt on pr.id_produit=qtt.id_produit where act=1 group by pr.id_produit    order by qtt_sold  desc limit 6 ';
    $sql = $conn->prepare($query);
    $sql->execute(array("id_categorie" => $_GET["id_categorie"]));
    $results = $sql->fetchAll(PDO::FETCH_ASSOC);
    $msg["data"] = $results;
    $msg["code"] = 200;
    $msg["msg"] = "ok";


    $json = json_encode($msg, JSON_NUMERIC_CHECK);
    echo $json;
}
