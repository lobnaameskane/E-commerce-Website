<?php
require_once "../connection/db.php";
header("Access-Control-Allow-Origin: *");

//require_once "../verify_session.php";
$query =  'SELECT c.id_client, CONCAT(c.nom_client ," " , c.prenom_client) as nom_client, COUNT(co.id_commande) as nbr_commande, MAX(co.date_commande) as last_commande ,MIN(co.date_commande) as first_commande , c.email, c.tel_client,  c.date_naissance, c.sexe, MIN(co.prix_commande) as minimum_spent, MAX(co.prix_commande) as maximum_spent,AVG(co.prix_commande) as avg_spent FROM client c left join commande co on c.id_client=co.id_client where c.act=1 GROUP BY c.id_client';
//$query2 = 'SELECT id_client, id_commande, date_commande, etat_actuell, prix_commande from commande GROUP BY id_client';
$filters = array("search", "from_date", "to_date", "minimum_commande", "maximum_commande", "minimum_spent", "maximum_spent");
$filters_active = array();
$params = array();
foreach ($filters as $value) {
    if (!empty($_GET[$value])) {
        switch ($value) {
            case 'search':
                $filters_active[$value] = ' c.email LIKE :search';
                $params["search"] = "%" . $_GET["search"] . "%";
                break;
            case 'from_date':
                $filters_active[$value] = ' first_commande >= :from_date';
                $params["from_date"] = $_GET["from_date"];
                break;
            case 'to_date':
                $filters_active[$value] = ' :to_date >= last_commande';
                $params["to_date"] = $_GET["to_date"];
                break;
            case 'minimum_commande':
                $filters_active[$value] = ' nbr_commande >= :minimum_commande';
                $params["minimum_commande"] = $_GET["minimum_commande"];
                break;
            case 'maximum_commande':
                $filters_active[$value] = ' :maximum_commande >= nbr_commande';
                $params["maximum_commande"] = $_GET["maximum_commande"];
                break;
            case 'minimum_spent':
                $filters_active[$value] = ' minimum_spent >= :minimum_spent';
                $params["minimum_spent"] = $_GET["minimum_spent"];
                break;
            case 'maximum_spent':
                $filters_active[$value] = ' :maximum_spent >= maximum_spent';
                $params["maximum_spent"] = $_GET["maximum_spent"];
                break;
        }
    }
}
$where = 0;
foreach ($filters_active as $v) {
    if ($where == 0) {
        $query .= " HAVING" . $v;
        $where = 1;
    } else {
        $query .= " AND" . $v;
    }
}

$sql = $conn->prepare($query);
$sql->execute($params);
$clients = $sql->fetchAll(PDO::FETCH_ASSOC);

$msg["data"] = $clients;
//$msg["filters"] = $filters_active;
//$msg["params"] = $params;
//$msg["query"] = $query;
$msg["code"] = 200;
$msg["msg"] = "ok";

$json = json_encode($msg, JSON_NUMERIC_CHECK);
echo $json;
