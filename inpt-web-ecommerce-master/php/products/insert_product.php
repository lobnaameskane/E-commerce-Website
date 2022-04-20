<?php
require_once "../connection/db.php";header("Access-Control-Allow-Origin: *");

//require_once "../verify_session.php";

if (isset($_GET["label"]) && isset($_GET["prix_produit"]) && isset($_GET["id_marque"]) && isset($_GET["id_categorie"])) {
    $sql = "INSERT INTO produit(id_marque, id_categorie, label, prix_produit, description_produit) VALUES (:id_marque, :id_categorie, :label, :prix_produit, :description_produit)";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array("id_marque" => $_GET["id_marque"], "id_categorie" => $_GET["id_categorie"], "prix_produit" => $_GET["prix_produit"], "label" => $_GET["label"], "description_produit" => $_GET["description_produit"]));
    $id = $conn->lastInsertId();

    $msg["code"] = 200;
    $msg["id_produit"] = $id;
    $msg["msg"] = "ok";

    $json = json_encode($msg, JSON_NUMERIC_CHECK);
    echo $json;
} else {
    echo json_encode(array("code" => 400, "message" => "Error, parametres non sufficent"));
}
