<?php
require_once "../connection/db.php";
//require_once "../verify_session.php";
header("Access-Control-Allow-Origin: *");

if (isset($_GET["id_marque"])) {
    $query = "delete from marque where id_marque=?";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(1, $_GET['id_marque'], PDO::PARAM_INT);

    $stmt->execute();




    $msg["code"] = 200;
    $msg["msg"] = "ok";

    $json = json_encode($msg, JSON_NUMERIC_CHECK);
    echo $json;
} else {
    echo json_encode(array("code" => 400, "message" => "Error, parametres non sufficent"));
}
