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

$query = "SELECT `crypt_type` FROM `vtiger_users` WHERE `user_name` = '{$user_name}'";
$rows = $clsDB->getRows( $query );
if (!count($rows))
{
    echo json_encode([
        'success' => 'false',
        'message' => 'Invalid login details'
    ]);
    die();
}

$user_password = encrypt_password($user_name, $user_password, $rows[0]->crypt_type);

$query = "SELECT * FROM `vtiger_users` WHERE 
`user_name` = '{$user_name}' AND `user_password` = '{$user_password}'";
$rows = $clsDB->getRows( $query );
ob_get_clean();

if (count($rows))
{
    echo json_encode([
        'success' => 'true',
        'message' => 'Login successfull',
        'id' => $rows[0]->id
    ]);
    die();
}
else
{
    echo json_encode([
        'success' => 'false',
        'message' => 'Invalid login details.'
    ]);
    die();
}

function encrypt_password($user_name, $user_password, $crypt_type='') 
{
    // encrypt the password.
    $salt = substr($user_name, 0, 2);

    // For more details on salt format look at: http://in.php.net/crypt
    if($crypt_type == 'MD5') {
        $salt = '$1$' . $salt . '$';
    } elseif($crypt_type == 'BLOWFISH') {
        $salt = '$2$' . $salt . '$';
    } elseif($crypt_type == 'PHP5.3MD5') {
        //only change salt for php 5.3 or higher version for backward
        //compactibility.
        //crypt API is lot stricter in taking the value for salt.
        $salt = '$1$' . str_pad($salt, 9, '0');
    }

    $encrypted_password = crypt($user_password, $salt);
    return $encrypted_password;
}