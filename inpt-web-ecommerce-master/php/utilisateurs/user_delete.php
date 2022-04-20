<?php
require_once "../connection/db.php";header("Access-Control-Allow-Origin: *");

$query = "delete from utilisateurs where id_user= :id_user";
$sql = $conn->prepare($query);
$sql->execute(array(
    "id_user"=>$_GET["id_user"]
));

$msg["code"] = 200;
$msg["msg"] = "ok";

$json = json_encode($msg, JSON_NUMERIC_CHECK);
echo $json;
