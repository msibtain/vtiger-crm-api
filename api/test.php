<?php
error_reporting(E_ALL);
ini_set('display_errors', "1");

include('../config.inc.php');
define('DB_HOST', $dbconfig['db_hostname']);
define('DB_USERNAME', $dbconfig['db_username']);
define('DB_PASSWORD', $dbconfig['db_password']);
define('DB_DATABASE', $dbconfig['db_name']);
define('MYSQL_TIMEZONE', $default_timezone);

include('db/clsDB.php');

$clsDB = new clsDB(
    $dbconfig['db_hostname'],
    $dbconfig['db_username'],
    $dbconfig['db_password'],
    $dbconfig['db_name']
);

$query = "SELECT * FROM `com_vtiger_workflows`";
$rows = $clsDB->getRows( $query );

echo "<pre>";
print_r($rows);


echo "done...8889900";