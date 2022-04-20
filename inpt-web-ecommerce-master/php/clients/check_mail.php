<?php
require_once "../connection/db.php";header("Access-Control-Allow-Origin: *");

//require_once "../verify_session.php";
if (isset($_GET["email"])) {
    $query =  'SELECT  email FROM client c where email= :email  ';
    $sql = $conn->prepare($query);
    $sql->execute(array("email" => $_GET["email"]));
    $msg = array();
    if ($sql->fetch(PDO::FETCH_ASSOC))
        $msg["email_valide"] = FALSE;

    else
        $msg["email_valide"] = TRUE;

    $msg["code"] = 200;
    $msg["msg"] = "ok";

    $json = json_encode($msg, JSON_NUMERIC_CHECK);
    echo $json;
} else {
    echo json_encode(array("code" => 400, "message" => "Error, parametres non sufficent"));
}
