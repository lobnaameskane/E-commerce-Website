<?php
require_once "../connection/db.php";header("Access-Control-Allow-Origin: *");

session_start();
//require_once "../verify_session.php";
if (isset($_SESSION["id_client"])  && isset($_GET["id_adresse"]) && isset($_SESSION["cart"])) {
    $ttl = 0;
    foreach ($_SESSION["cart"] as $key => $value) {
        # code...
        $ttl += $value["qtt_panier"] * $value["prix_produit"];
    }


    $query = 'INSERT INTO commande( id_client,  id_adresse,   prix_commande   ) VALUES (:id_client,  :id_adresse,   :prix_commande)';
    $sql = $conn->prepare($query);
    $sql->execute(array("id_client" => $_SESSION["id_client"], "id_adresse" => $_GET["id_adresse"], "prix_commande" => $ttl));
    $id_commande = $conn->lastInsertId();
    foreach ($_SESSION["cart"] as $key => $value) {
        # code...
        if ($value["qtt_panier"] > 0) {
            $query = 'INSERT INTO qt_commande( id_commande,id_produit, prix_produit_commande, qtt_commande, options_produit) VALUES ( :id_commande,:id_produit, :prix_produit_commande, :qtt_commande, :options_produit)';
            $sql = $conn->prepare($query);
            $x =  $sql->execute(array("id_commande" => $id_commande, "id_produit" => $value["id_produit"], "prix_produit_commande" => $value["prix_produit"], "qtt_commande" => $value["qtt_panier"], "options_produit" => $value["options_produit"]));
            if ($x) {
                $query = 'DELETE FROM panier WHERE id_produit=:id_produit and id_client=:id_client and options_produit=:options_produit';
                $sql = $conn->prepare($query);
                $sql->execute(array("id_produit" => $value["id_produit"], "id_client" => $_SESSION["id_client"], "options_produit" => $value["options_produit"]));
            }
        } else continue;
    }


    $msg["id_commande"] = $id_commande;
    $msg["code"] = 200;
    $msg["msg"] = "ok";
    $json = json_encode($msg, JSON_NUMERIC_CHECK);
    echo $json;
} else
    echo json_encode(array("code" => 400, "message" => "Error, parametres non sufficent"));
