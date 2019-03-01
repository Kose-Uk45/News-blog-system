<?php require_once("include/functions.php")?>
<?php
$_SESSION['userid']=null;
session_destroy();
redirect_to("adminLogin.php");

?>
