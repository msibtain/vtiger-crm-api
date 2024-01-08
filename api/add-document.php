<?php
header('Content-Type: application/json; charset=utf-8');

function initStorageFileDirectory() {
    $filepath = '../storage/';

    $year  = date('Y');
    $month = date('F');
    $day   = date('j');
    $week  = '';

    if (!is_dir($filepath . $year)) {
        //create new folder
        mkdir($filepath . $year);
    }

    if (!is_dir($filepath . $year . "/" . $month)) {
        //create new folder
        mkdir($filepath . "$year/$month");
    }

    if ($day > 0 && $day <= 7)
        $week = 'week1';
    elseif ($day > 7 && $day <= 14)
        $week = 'week2';
    elseif ($day > 14 && $day <= 21)
        $week = 'week3';
    elseif ($day > 21 && $day <= 28)
        $week = 'week4';
    else
        $week = 'week5';

    if (!is_dir($filepath . $year . "/" . $month . "/" . $week)) {
        //create new folder
        mkdir($filepath . "$year/$month/$week");
    }

    $filepath = $filepath . $year . "/" . $month . "/" . $week . "/";

    return $filepath;
}

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
$document_id = $rows[0]->id + 1;
$document_attachment_id = $document_id + 1;

$result = $clsDB->query( "INSERT into `vtiger_crmentity` SET 
        `crmid` = '{$document_id}', 
        `smcreatorid` = '{$uploaded_by}', 
        `smownerid` = '{$assigned_to}', 
        `modifiedby` = '{$uploaded_by}', 
        `setype` = 'Documents', 
        `description` = '', 
        `createdtime` = '".date("Y-m-d H:i:s")."', 
        `modifiedtime` = '".date("Y-m-d H:i:s")."', 
        `label` = '{$title}'
        " 
);

$result_attachment = $clsDB->query( "INSERT into `vtiger_crmentity` SET 
        `crmid` = '{$document_attachment_id}', 
        `smcreatorid` = '{$uploaded_by}', 
        `smownerid` = '{$assigned_to}', 
        `modifiedby` = '0', 
        `setype` = 'Documents Attachment', 
        `description` = '', 
        `createdtime` = '".date("Y-m-d H:i:s")."', 
        `modifiedtime` = '".date("Y-m-d H:i:s")."', 
        `label` = ''
        " 
);

if ($result && $result_attachment)
{
    # update crmentity seq;
    $clsDB->query( "UPDATE `vtiger_crmentity_seq` SET `id` = '{$document_attachment_id}'" );
    $directory = initStorageFileDirectory();
    $destination = $directory . $document_attachment_id . "_" . $_FILES['file']['name'];
    move_uploaded_file($_FILES['file']['tmp_name'], $destination);
    $path_to_db = str_replace("../", "", $directory);
}

$clsDB->query( "INSERT into `vtiger_attachments` SET 
        `attachmentsid` = '{$document_attachment_id}', 
        `name` = '".$_FILES['file']['name']."', 
        `description` = '', 
        `type` = '".$_FILES['file']['type']."', 
        `path` = '{$path_to_db}'
        " 
);

$query = "SELECT COUNT(notesid) AS cc FROM `vtiger_notes`";
$rows_notes = $clsDB->getRows( $query );
if ($rows_notes)
{
    $next_note = $rows_notes[0]->cc + 1;
}
else
{
    $next_note = 1;
}


$result_notes = $clsDB->query( "INSERT into `vtiger_notes` SET 
        `notesid` = '{$document_id}', 
        `note_no` = 'DOC".$next_note."', 
        `title` = '{$title}', 
        `filename` = '".$_FILES['file']['name']."', 
        `notecontent` = '',
        `folderid` = '1',
        `filetype` = '".$_FILES['file']['type']."',
        `filelocationtype` = 'I',
        `filedownloadcount` = '',
        `filestatus` = '1',
        `filesize` = '".$_FILES['file']['size']."',
        `fileversion` = ''
        " 
);

$clsDB->query( "INSERT into `vtiger_notescf` SET 
        `notesid` = '{$document_id}'
        " 
);

$clsDB->query( "INSERT into `vtiger_seattachmentsrel` SET 
        `crmid` = '{$document_id}',
        `attachmentsid` = '{$document_attachment_id}'
        " 
);

$clsDB->query( "INSERT into `vtiger_modtracker_basic` SET 
        `id` = '{$document_id}',
        `crmid` = '{$document_id}',
        `module` = 'Documents',
        `whodid` = '{$uploaded_by}',
        `changedon` = '".date("Y-m-d H:i:s")."',
        `status` = '2'
        " 
);

$clsDB->query( "INSERT into `vtiger_modtracker_basic` SET 
        `id` = '{$document_attachment_id}',
        `crmid` = '{$task_id}',
        `module` = 'ProjectTask',
        `whodid` = '{$uploaded_by}',
        `changedon` = '".date("Y-m-d H:i:s")."',
        `status` = '4'
        " 
);

$clsDB->query( "UPDATE `vtiger_modtracker_basic_seq` SET 
        `id` = '{$document_attachment_id}'
        " 
);

$clsDB->query( "INSERT into `vtiger_modtracker_relations` SET 
        `id` = '{$document_attachment_id}',
        `targetid` = '{$document_id}',
        `targetmodule` = 'Documents',
        `changedon` = '".date("Y-m-d H:i:s")."'
        " 
);

$clsDB->query( "INSERT into `vtiger_senotesrel` SET 
        `crmid` = '{$task_id}',
        `notesid` = '{$document_id}'
        " 
);


ob_get_clean();

echo json_encode([
    'success' => 'true',
    'result' => $result,
    'result_attachment' => $result_attachment,
    'document_id' => $document_id,
    'document_attachment_id' => $document_attachment_id,
    'destination' => $destination
]);