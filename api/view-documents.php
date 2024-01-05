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
`vtiger_notes` AS a, `vtiger_crmentity` AS b WHERE 
b.smcreatorid = '{$user_id}' AND a.notesid = b.crmid AND b.setype = 'Documents'";
$rows = $clsDB->getRows( $query );
$documents = [];
foreach ($rows as $doc)
{
    $query = "SELECT a.* FROM 
    `vtiger_attachments` AS a, `vtiger_seattachmentsrel` AS b WHERE 
    b.crmid = '".$doc->notesid."' AND a.attachmentsid = b.attachmentsid";

    $row = $clsDB->getRows( $query );

    $documents[] = [
        'notesid' => $doc->notesid,
        'title' => $doc->title,
        'filename' => $doc->filename,
        'filetype' => $doc->filetype,
        'filesize' => $doc->filesize,
        'filestatus' => $doc->filestatus,
        'path' => $row[0]->path,
        'attachment_id' => $row[0]->attachmentsid

    ];
}
ob_get_clean();

echo json_encode([
    'success' => 'true',
    'documents' => $documents
]);