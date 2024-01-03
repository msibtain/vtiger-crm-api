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

$query = "SELECT a.*, b.description FROM 
`vtiger_projecttask` AS a, `vtiger_crmentity` AS b WHERE 
a.projecttaskid = '{$task_id}' AND a.projecttaskid = b.crmid AND b.setype = 'ProjectTask'";
$rows = $clsDB->getRows( $query );
ob_get_clean();

echo json_encode([
    'success' => 'true',
    'data' => $rows[0]
]);