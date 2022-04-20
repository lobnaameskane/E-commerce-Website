<?php
require_once "../connection/db.php";header("Access-Control-Allow-Origin: *");

if ($_GET["nom"] == null) {
    $msg["code"] = 404;
    $msg["msg"] = "La case nom ne peut pas etre vide";
} else
    if ($_GET["prenom"] == null) {
    $msg["code"] = 403;
    $msg["msg"] = "La case prenom ne peut pas etre vide";
} else

        if ($_GET["mail"] == null) {
    $msg["code"] = 402;
    $msg["msg"] = "La case email ne peut pas etre vide";
} else

            if ($_GET["mdp"] == null) {
    $msg["code"] = 405;
    $msg["msg"] = "La case mot de passe ne peut pas etre vide";
}  else
    if ($_GET["mdp_conf"] == null) {
    $msg["code"] = 406;
    $msg["msg"] = "Merci de confirmer le mot de passe";
} else if ($_GET["mdp"] == $_GET["mdp_conf"]) {
    $query = "INSERT into utilisateurs (nom_user,prenom_user,email_user,mdp_user,is_admin,tel_user) values(:nom_user,:prenom_user,:email_user,:mdp_user,:is_admin,:tel_user  );";
    $sql = $conn->prepare($query);
    $sql->execute(array(
        "nom_user" => $_GET["nom"],
        "prenom_user" => $_GET["prenom"],
        "email_user" => $_GET["mail"],
        "mdp_user" => password_hash($_GET["mdp"], PASSWORD_BCRYPT),
        "is_admin" => $_GET["admin"],
        "tel_user" => $_GET["tel"],
    ));
    $msg["code"] = 200;
    $msg["msg"] = "ok";
}else{
    $msg["code"] = 407;
    $msg["msg"] = "Veuillez vous assurer que les mots de passe sont identiques";
}

$json = json_encode($msg, JSON_NUMERIC_CHECK);
echo $json;
