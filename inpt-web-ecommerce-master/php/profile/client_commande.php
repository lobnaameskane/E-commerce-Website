<?php
session_start();
require_once "../connection/db.php";header("Access-Control-Allow-Origin: *");

//require_once "../verify_session.php";
if (isset($_SESSION["id_client"])) {
    $query2 = 'SELECT   id_commande,date_commande,etat_actuell,prix_commande,tel_adresse_client, nom_complet  FROM commande c,adresse where  c.id_client=:id_client and adresse.id_adresse=c.id_adresse';
    $sql = $conn->prepare($query2);
    $sql->execute(array("id_client" => $_SESSION["id_client"]));
    $commande = $sql->fetchAll(PDO::FETCH_ASSOC);
    $msg["data"] = $commande;
    $msg["code"] = 200;
    $msg["msg"] = "ok";


    $json = json_encode($msg, JSON_NUMERIC_CHECK);
    echo $json;
} else
    echo json_encode(array("code" => 400, "message" => "Error, parametres non sufficent"));
