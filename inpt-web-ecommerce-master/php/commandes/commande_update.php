<?php
require_once "../connection/db.php";header("Access-Control-Allow-Origin: *");

//require_once "../verify_session.php";
if (isset($_GET["id_commande"]) && isset($_GET["msg"]) && isset($_GET["id_user"])) {
    $query = 'UPDATE commande SET id_user = :id_user ,valide=:msg where id_commande=:id_commande';
    $sql = $conn->prepare($query);
    $sql->execute(array("id_commande" => $_GET["id_commande"],"id_user" => $_GET["id_user"],"msg" => $_GET["msg"]));


    $msg["code"] = 200;
    $msg["msg"] = "ok";

    $json = json_encode($msg, JSON_NUMERIC_CHECK);
    echo $json;
} else {
    echo json_encode(array("code" => 400, "message" => "Error, parametres non sufficent"));
}
