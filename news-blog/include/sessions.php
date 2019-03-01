<?php require_once("include/databaseConnec.php");?>
<?php
session_start();
#functions to be resued for the error and sucess messages in the dashboard and categoryboard
function errorMessage(){
  if(isset($_SESSION['ErrorMessage'])){
    $output="<div class=\"alert alert-danger\">";
    $output.=htmlentities($_SESSION['ErrorMessage']);
    $output.="</div>";
    $_SESSION['ErrorMessage']=null;
    return $output;
  }
}


function successMessage(){
  if(isset($_SESSION['SuccessMessage'])){
    $output="<div class=\"alert alert-success\">";
    $output.=htmlentities($_SESSION['SuccessMessage']);
    $output.="</div>";
    $_SESSION['SuccessMessage']=null;
    return $output;
  }
}



 ?>
