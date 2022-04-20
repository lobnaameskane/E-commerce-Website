<?php
require_once "../connection/db.php";header("Access-Control-Allow-Origin: *");

//require_once "../verify_session.php";

if (isset($_GET["search"]) || isset($_GET["categorie"]) || isset($_GET["marque"])) {
    $query = 'SELECT  pr.id_produit,label,prix_produit,pr.id_marque,pr.id_categorie,m.nom_marque,nom_categorie, count(qtt.id_produit) as qtt_sold,SUBSTRING(description_produit, 1,30) as description_produit  from produit pr left join qt_commande qtt  on pr.id_produit=qtt.id_produit left join marque m on pr.id_marque=m.id_marque left join categorie cat on pr.id_categorie=cat.id_categorie  WHERE act=1 AND 1=1 ';
    $params = array();
    if (!empty($_GET["search"])) {
        $query .= " and label like :search or description_produit like :search ";
        $params["search"] = "%" . $_GET["search"] . "%";
    }
    if (!empty($_GET["categorie"])) {
        $query .= " and pr.id_categorie = :categorie";
        $params["categorie"] = $_GET["categorie"];
    }
    if (!empty($_GET["marque"])) {
        $query .= " and id_marque = :marque";
        $params["marque"] = $_GET["marque"];
    }

    $query .= ' GROUP by pr.id_produit   order by qtt_sold  desc ';

    $sql = $conn->prepare($query);
    $sql->execute($params);
    $results = $sql->fetchAll(PDO::FETCH_ASSOC);


    $msg["data"] = $results;
    $msg["code"] = 200;
    $msg["msg"] = "ok";

    $json = json_encode($msg, JSON_NUMERIC_CHECK);
    echo $json;
} else if (isset($_GET["search_admin"])) {
    $query = 'SELECT  pr.id_produit,label,prix_produit,pr.id_marque,pr.id_categorie,m.nom_marque,nom_categorie from produit pr left join marque m on pr.id_marque=m.id_marque left join categorie cat on pr.id_categorie=cat.id_categorie WHERE act=1 and (label LIKE :search  OR nom_marque LIKE :search  OR nom_categorie LIKE :search  OR description_produit LIKE :search)    ';

    $sql = $conn->prepare($query);
    $sql->execute(array("search" => "%" . $_GET["search_admin"] . "%"));
    $results = $sql->fetchAll(PDO::FETCH_ASSOC);


    $msg["data"] = $results;
    $msg["code"] = 200;
    $msg["msg"] = "ok";

    $json = json_encode($msg, JSON_NUMERIC_CHECK);
    echo $json;
} else {
    echo json_encode(array("code" => 400, "message" => "Error, parametres non sufficent"));
}
