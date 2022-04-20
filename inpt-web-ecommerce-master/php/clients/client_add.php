<?php
require_once "../connection/db.php";header("Access-Control-Allow-Origin: *");

//require_once "../verify_session.php";
session_start();

if (isset($_GET["email"]) && isset($_GET["mdp_client"]) && ($_GET["nom_client"]) && isset($_GET["prenom_client"])  && isset($_GET["date_naissance"]) && isset($_GET["sexe"])  && isset($_GET["adresse"]) && isset($_GET["code_postal"]) && isset($_GET["tel_adresse_client"])) {
    foreach ($_GET as $key => $value) {
        $_GET[$key] = ($_GET[$key] == "") ? null : $_GET[$key];
    }
    $query =  'INSERT INTO client( nom_client, prenom_client, tel_client, date_naissance, sexe, email, mdp_client) VALUES (:nom_client, :prenom_client, :tel_client, :date_naissance, :sexe,:email, :mdp_client)';
    $sql = $conn->prepare($query);
    $sql->execute(array("email" => $_GET["email"], "nom_client" => $_GET["nom_client"], "prenom_client" => $_GET["prenom_client"], "tel_client" => $_GET["tel_adresse_client"], "date_naissance" => $_GET["date_naissance"], "sexe" => $_GET["sexe"], "mdp_client" => password_hash($_GET["mdp_client"], PASSWORD_BCRYPT)));
    $id =  $conn->lastInsertId();

    $query =  'INSERT INTO adresse( id_client, adresse, code_postal, nom_complet, tel_adresse_client) VALUES (:id_client, :adresse, :code_postal, :nom_complet, :tel_adresse_client)';
    $sql = $conn->prepare($query);
    $sql->execute(array("id_client" =>   $id, "adresse" => $_GET["adresse"], "code_postal" => $_GET["code_postal"], "nom_complet" => $_GET["nom_client"] . " " . $_GET["prenom_client"], "tel_adresse_client" => $_GET["tel_adresse_client"]));

    $msg["code"] = 200;
    $msg["msg"] = "ok";
    $_SESSION["email_client"] = $_GET["email"];
    $_SESSION["nom_client"] = $_GET["nom_client"];
    $_SESSION["prenom_client"] = $_GET["prenom_client"];
    $_SESSION["id_client"] = $id;
    $_SESSION["connection_status"] = "connected";

    $json = json_encode($msg, JSON_NUMERIC_CHECK);
    echo $json;
} else {
    echo json_encode(array("code" => 400, "message" => "Error, parametres non sufficent"));
}
