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

$query = "UPDATE `vtiger_projecttask` SET 
`projecttaskname` = '{$title}',
`projecttasknumber` = '{$task_no}',
`projecttasktype` = '{$type}',
`projecttaskpriority` = '{$priority}',
`projecttaskprogress` = '{$progress}',
`projecttaskhours` = '{$worked_hours}',
`startdate` = '{$start_date}',
`enddate` = '{$end_date}',
`projectid` = '{$projectid}',
`projecttaskstatus` = '{$status}' 
WHERE `projecttaskid` = '{$task_id}'
";
$result = $clsDB->query( $query );
if ($result)
{
    //$clsDB->query( "INSERT into `vtiger_projecttaskcf` SET projecttaskid = '{$task_id}'" );
    $clsDB->query( "UPDATE `vtiger_crmentity` SET 
        `smcreatorid` = '{$created_by}', 
        `smownerid` = '{$assigned_to}', 
        `modifiedby` = '{$created_by}', 
        `setype` = 'ProjectTask', 
        `description` = '{$description}', 
        `modifiedtime` = '".date("Y-m-d H:i:s")."', 
        `label` = '{$title}'
        WHERE 
        `crmid` = '{$task_id}'
        " 
    );
    
}

ob_get_clean();

echo json_encode([
    'success' => 'true',
    'result' => $result,
    'message' => "Task has been updated with ID: {$task_id}",
]);