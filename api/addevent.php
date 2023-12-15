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

$query = "SELECT MAX(activityid) AS maxid FROM `vtiger_activity`";
$rows = $clsDB->getRows( $query );
$activity_id = $rows[0]->maxid + 1;

$query = "INSERT into `vtiger_activity` SET 
`activityid` = '{$activity_id}',
`subject` = '{$subject}',
`activitytype` = '{$activitytype}',
`date_start` = '{$date_start}',
`due_date` = '{$due_date}',
`time_start` = '{$time_start}',
`time_end` = '{$time_end}',
`eventstatus` = '{$eventstatus}',
`visibility` = '{$visibility}'
";
$result = $clsDB->query( $query );
if ($result)
{
    $clsDB->query( "INSERT into `vtiger_activitycf` SET activityid = '{$activity_id}'" );
    $clsDB->query( "INSERT into `vtiger_activity_reminder_popup` SET 
    `semodule` = 'Calendar', 
    `recordid` = '{$activity_id}', 
    `date_start` = '{$date_start}', 
    `time_start` = '{$time_start}', 
    `status` = '0'" );

}

ob_get_clean();

echo json_encode([
    'success' => 'true',
    'result' => $result,
    'activityid' => $activity_id,
]);