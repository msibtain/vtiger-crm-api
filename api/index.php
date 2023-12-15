<?php
$request_uri = $_SERVER['REQUEST_URI'];
$arrTemp = explode("/", $request_uri);
$strFileName = $arrTemp[count($arrTemp)-1];
if (file_exists($strFileName.".php"))
{
    include($strFileName.".php");
}
else
{
    die("Invalid API url");
}