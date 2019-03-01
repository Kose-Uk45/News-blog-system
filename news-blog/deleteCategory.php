<?php require_once("include/databaseConnec.php");?>
<?php require_once("include/functions.php");?>
<?php
#deleting the catgeories
$urlId=$_GET['id'];
$delete="DELETE FROM Categories WHERE id=$urlId";
$deleteExcute=mysqli_query($con,$delete);
redirect_to("categories.php");



?>
