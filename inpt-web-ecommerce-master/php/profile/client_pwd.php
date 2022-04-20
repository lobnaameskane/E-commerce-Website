<?php
session_start();header("Access-Control-Allow-Origin: *");

require_once "../connection/db.php";
if (isset($_SESSION["id_client"])) {

    if ($_GET["mdp"] == null) {
        $msg["code"] = 399;
        $msg["msg"] = "veuillez saisir le mot de passe actuel";
    } else
if ($_GET["mdp"] == null) {
        $msg["code"] = 401;
        $msg["msg"] = "veuillez saisir le mot de passe";
    } else
    if ($_GET["mdp_conf"] == null) {
        $msg["code"] = 402;
        $msg["msg"] = "Veuillez confirmer le mot de passe";
    } else if ($_GET["mdp"] == $_GET["mdp_conf"]) {
        $pass = $_GET["mdp_actuel"];
        $query = "select mdp_client from client where id_client=:id_client";
        $sql = $conn->prepare($query);
        $sql->execute(array(
            "id_client" => $_SESSION["id_client"]
        ));
        $row = $sql->fetch();

        if (password_verify($pass, $row["mdp_client"])) {
            $query = "update client set mdp_client = :mdp_client where id_client= :id_client;";
            $sql = $conn->prepare($query);
            $sql->execute(array(
                "id_client" => $_SESSION["id_client"],
                "mdp_client" => password_hash($_GET["mdp"], PASSWORD_BCRYPT),

            ));
            $msg["code"] = 200;
            $msg["msg"] = "ok";
        } else {
            $msg["code"] = 398;
            $msg["msg"] = "Veuillez que le mot de passe actuel est correct";
        }
    } else {




        $msg["code"] = 403;
        $msg["msg"] = "Veuillez vous assurer que les mots de passe sont identiques";
    }


    $json = json_encode($msg, JSON_NUMERIC_CHECK);
    echo $json;
} else
    echo json_encode(array("code" => 400, "message" => "Error, parametres non sufficent"));
