<?php
header('Content-Type: application/json; charset=utf-8');

ob_start();

extract($_POST);

include('../config.inc.php');
include('db/clsDB.php');

$clsDB = new clsDB(
    $dbconfig['db_hostname'],
    $dbconfig['db_username'],
    $dbconfig['db_password'],
    $dbconfig['db_name']
);

$query = "SELECT * FROM `vtiger_activity`";
$rows = $clsDB->getRows( $query );
ob_get_clean();

echo json_encode([
    'success' => 'true',
    'events' => $rows
]);