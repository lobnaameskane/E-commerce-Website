<?php
require_once "../connection/db.php";header("Access-Control-Allow-Origin: *");

//require_once "../verify_session.php";
if (isset($_GET["id_produit"])) {
    $query = 'SELECT description_produit from produit where id_produit=:id_produit ';
    $params = array("id_produit"=> $_GET["id_produit"]);

    $sql = $conn->prepare($query);
    $sql->execute($params);
    $results = $sql->fetch(PDO::FETCH_ASSOC);


    $msg["data"] = $results;
    $msg["code"] = 200;
    $msg["msg"] = "ok";

    $json = json_encode($msg, JSON_NUMERIC_CHECK);
    echo $json;
}  else {
    echo json_encode(array("code" => 400, "message" => "Error, parametres non sufficent"));
}
