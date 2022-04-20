<?php
require_once "../connection/db.php";header("Access-Control-Allow-Origin: *");

if ($_GET["mdp"] == null) {
    $msg["code"] = 401;
    $msg["msg"] = "veuillez saisir un mot de passe";
} else
    if ($_GET["mdp_conf"] == null) {
    $msg["code"] = 402;
    $msg["msg"] = "Veuillez confirmer le mot de passe";
} else if ($_GET["mdp"] == $_GET["mdp_conf"]) {
    $query = "update utilisateurs set mdp_user = :mdp_user where id_user= :id_user;";
    $sql = $conn->prepare($query);
    $sql->execute(array(
        "id_user" => $_GET["id_user"],
        "mdp_user" => password_hash($_GET["mdp"], PASSWORD_BCRYPT),

    ));
    $msg["code"] = 200;
    $msg["msg"] = "ok";
} else {




    $msg["code"] = 403;
    $msg["msg"] = "Veuillez vous assurer que les mots de passe sont identiques";
}


$json = json_encode($msg, JSON_NUMERIC_CHECK);
echo $json;
