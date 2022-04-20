<?php
require_once "../connection/db.php";header("Access-Control-Allow-Origin: *");

//require_once "../verify_session.php";
if (isset($_GET["id_produit"])) {
    $query = 'SELECT p.id_produit, p.id_marque, p.id_categorie, label, prix_produit, description_produit  ,nom_marque,nom_categorie FROM produit p  left join marque m on p.id_marque=m.id_marque left join categorie cat on p.id_categorie=cat.id_categorie WHERE p.id_produit=:id_produit AND act=1 ';
    $params = array("id_produit" => $_GET["id_produit"]);
    $sql = $conn->prepare($query);
    $sql->execute($params);
    $product = $sql->fetch(PDO::FETCH_ASSOC);
    $query = 'SELECT options , type_options  FROM  options o    WHERE id_produit=:id_produit ';
    $sql = $conn->prepare($query);
    $sql->execute($params);
    $options = $sql->fetchAll(PDO::FETCH_ASSOC);
    $results = array("product" => $product, "options" => $options);
    //check wishlist
    $inside = false;
    if (isset($_SESSION["id_client"])) {
        $query = 'SELECT * from wishlist where id_client=:id_client and  id_produit=:id_produit)';
        $sql = $conn->prepare($query);
        $sql->execute(array("id_client" => $_SESSION["id_client"], "id_produit" => $_GET["id_produit"]));
        if ($sql->fetch())
            $inside = true;
        else
            $inside = false;
    }

    $msg["inside"] = $inside;
    $msg["data"] = $results;
    $msg["code"] = 200;
    $msg["msg"] = "ok";

    $json = json_encode($msg, JSON_NUMERIC_CHECK);
    echo $json;
} else {
    echo json_encode(array("code" => 400, "message" => "Error, parametres non sufficent"));
}
