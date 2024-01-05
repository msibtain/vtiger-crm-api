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



$query = "SELECT id FROM `vtiger_crmentity_seq`";
$rows = $clsDB->getRows( $query );
$task_id = $rows[0]->id + 1;

$query = "INSERT into `vtiger_projecttask` SET 
`projecttaskid` = '{$task_id}',
`projecttaskname` = '{$title}',
`projecttask_no` = '{$task_no}',
`projecttasktype` = '{$type}',
`projecttaskpriority` = '{$priority}',
`projecttaskprogress` = '{$progress}',
`projecttaskhours` = '{$worked_hours}',
`startdate` = '{$start_date}',
`enddate` = '{$end_date}',
`projectid` = '{$projectid}',
`projecttaskstatus` = '{$status}'
";
$result = $clsDB->query( $query );
if ($result)
{
    $clsDB->query( "INSERT into `vtiger_projecttaskcf` SET projecttaskid = '{$task_id}'" );
    $clsDB->query( "INSERT into `vtiger_crmentity` SET 
        `crmid` = '{$task_id}', 
        `smcreatorid` = '{$created_by}', 
        `smownerid` = '{$assigned_to}', 
        `modifiedby` = '{$created_by}', 
        `setype` = 'ProjectTask', 
        `description` = '{$description}', 
        `createdtime` = '".date("Y-m-d H:i:s")."', 
        `modifiedtime` = '".date("Y-m-d H:i:s")."', 
        `label` = '{$title}'
        " 
    );

    $clsDB->query( "UPDATE `vtiger_crmentity_seq` SET `id` = '{$task_id}'" );
    
    
}

ob_get_clean();

echo json_encode([
    'success' => 'true',
    'result' => $result,
    'taskid' => $task_id,
]);