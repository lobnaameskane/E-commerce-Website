<?php
require_once "../connection/db.php";header("Access-Control-Allow-Origin: *");

//require_once "../verify_session.php";
$query = "";
if (!isset($_GET["id_categorie"])) {
    $query = 'SELECT  id_produit,label,prix_produit from produit where act=1 order by id_produit desc limit 6  ';

    $sql = $conn->prepare($query);
    $sql->execute();
    $results = $sql->fetchAll(PDO::FETCH_ASSOC);
    $msg["data"] = $results;
    $msg["code"] = 200;
    $msg["msg"] = "ok";
    $json = json_encode($msg, JSON_NUMERIC_CHECK);
    echo $json;
} else {
    $query = 'SELECT  id_produit,label,prix_produit from produit WHERE id_categorie=:id_categorie and act=1 order by id_produit desc limit 6   ';
    $sql = $conn->prepare($query);
    $sql->execute(array("id_categorie" => $_GET["id_categorie"]));
    $results = $sql->fetchAll(PDO::FETCH_ASSOC);
    $msg["data"] = $results;
    $msg["code"] = 200;
    $msg["msg"] = "ok";


    $json = json_encode($msg, JSON_NUMERIC_CHECK);
    echo $json;
}
