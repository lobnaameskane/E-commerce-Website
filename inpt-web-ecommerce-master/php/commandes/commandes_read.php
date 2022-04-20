<?php
require_once "../connection/db.php";header("Access-Control-Allow-Origin: *");

//require_once "../verify_session.php";
$_GET = array_filter($_GET);

if (isset($_GET["from_date"]) and isset($_GET["to_date"])) {
    $query = 'SELECT   co.id_commande, CONCAT(c.nom_client ," " , c.prenom_client) as nom_client,c.email, c.tel_client, DATE_FORMAT(co.date_commande, "%d/%m/%Y %h:%i %p") as date_commande , co.valide, co.prix_commande ,co.etat_actuell   FROM commande co left join client c on co.id_client = c.id_client    where 1=1  AND date(co.date_commande) between :from_date and :to_date';
    $params = array("from_date" => $_GET["from_date"], "to_date" => $_GET["to_date"]);
    if (isset($_GET["id_client"])) {
        $query .= " AND co.id_client= :id_client";
        $params["id_client"] = $_GET["id_client"];
    }
    $sql = $conn->prepare($query);
    $sql->execute($params);
    $results = $sql->fetchAll(PDO::FETCH_ASSOC);
    $msg["data"] = $results;
    $msg["code"] = 200;
    $msg["msg"] = "ok";

    $json = json_encode($msg, JSON_NUMERIC_CHECK);
    echo $json;
} else if (isset($_GET["id_client"])) {
    $query = 'SELECT   co.id_commande, CONCAT(c.nom_client ," " , c.prenom_client) as nom_client,c.email, c.tel_client, DATE_FORMAT(co.date_commande, "%d/%m/%Y %h:%i %p") as date_commande , co.valide, co.prix_commande ,co.etat_actuell   FROM commande co left join client c on co.id_client = c.id_client    where 1=1   AND co.id_client= :id_client';
    $params = array("id_client" => $_GET["id_client"]);
    $sql = $conn->prepare($query);
    $sql->execute($params);
    $results = $sql->fetchAll(PDO::FETCH_ASSOC);
    $msg["data"] = $results;
    $msg["code"] = 200;
    $msg["msg"] = "ok";

    $json = json_encode($msg, JSON_NUMERIC_CHECK);
    echo $json;
} else if (isset($_GET["get_nonvalidate"])) {
    $query = 'SELECT   co.id_commande, CONCAT(c.nom_client ," " , c.prenom_client) as nom_client,c.email, c.tel_client, DATE_FORMAT(co.date_commande, "%d/%m/%Y %h:%i %p") as date_commande , co.valide, co.prix_commande ,co.etat_actuell   FROM commande co left join client c on co.id_client = c.id_client   where  co.valide=0';
    $sql = $conn->prepare($query);
    $sql->execute();
    $results = $sql->fetchAll(PDO::FETCH_ASSOC);
    $msg["data"] = $results;
    $msg["code"] = 200;
    $msg["msg"] = "ok";
    $json = json_encode($msg, JSON_NUMERIC_CHECK);
    echo $json;
} else {
    echo json_encode(array("code" => 400, "message" => "Error, parametres non sufficent"));
}
