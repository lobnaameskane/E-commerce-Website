
<?php
require_once "../connection/db.php";header("Access-Control-Allow-Origin: *");

//require_once "../verify_session.php";
session_start();
if (isset($_SESSION["id_client"])) {
    $query = "SELECT  w.id_client , w.id_produit , label , prix_produit from wishlist w  left join produit p on p.id_produit = w.id_produit   WHERE id_client=:id_client";
    $sql = $conn->prepare($query);
    $sql->execute(array("id_client" => $_SESSION["id_client"]));
    $results = $sql->fetchAll(PDO::FETCH_ASSOC);
    $msg["data"] = $results;
    $msg["code"] = 200;
    $msg["msg"] = "ok";

    $json = json_encode($msg, JSON_NUMERIC_CHECK);
    echo $json;
}
else
    echo json_encode(array("code" => 400, "message" => "Error, parametres non sufficent"));