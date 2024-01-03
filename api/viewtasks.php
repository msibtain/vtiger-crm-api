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

//$query = "SELECT * FROM `vtiger_projecttask`";
$query = "SELECT a.*, b.description, b.smcreatorid FROM 
`vtiger_projecttask` AS a, `vtiger_crmentity` AS b WHERE 
b.smcreatorid = '{$user_id}' AND a.projecttaskid = b.crmid AND b.setype = 'ProjectTask'";
$rows = $clsDB->getRows( $query );
ob_get_clean();

echo json_encode([
    'success' => 'true',
    'tasks' => $rows
]);