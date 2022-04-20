<?php
require_once "../connection/db.php";header("Access-Control-Allow-Origin: *");

if (isset($_GET["nom"])) {
    $query = "update utilisateurs set nom_user = :nom_user , prenom_user = :prenom_user , email_user = :email_user , is_admin = :is_admin , tel_user = :tel_user  where id_user= :id_user;";
    $sql = $conn->prepare($query);
    $sql->execute(array(
        "id_user" => $_GET["id_user"],
        "nom_user" => $_GET["nom"],
        "prenom_user" => $_GET["prenom"],
        "email_user" => $_GET["mail"],
        "is_admin" => $_GET["admin"],
        "tel_user" => $_GET["tel"],


    ));
    $msg["code"] = 200;
    $msg["msg"] = "ok";
}


$json = json_encode($msg, JSON_NUMERIC_CHECK);
echo $json;
