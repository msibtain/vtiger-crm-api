<?php
if (isset($_COOKIE['vtiger_user'])) {
    unset($_COOKIE['vtiger_user']); 
    setcookie('vtiger_user', '', -1, '/'); 
    header("Location: login.php");
} else {
    header("Location: login.php");
}

?>
