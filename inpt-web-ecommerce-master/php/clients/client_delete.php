<?php
require_once "../connection/db.php";header("Access-Control-Allow-Origin: *");

$query = "update client set act=0 where id_client=:id_client";
$sql = $conn->prepare($query);
$sql->execute(array(
    "id_client"=>$_GET["id_client"]
));

$msg["code"] = 200;
$msg["msg"] = "ok";

$json = json_encode($msg, JSON_NUMERIC_CHECK);
echo $json;
