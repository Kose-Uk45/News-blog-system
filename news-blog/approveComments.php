<?php require_once("include/sessions.php") ?>
<?php require_once("include/functions.php");?>
<?php require_once("include/databaseConnec.php");?>
<?php require_once("include/commentsTotal.php");?>
<?php session_start();?>
<?php
$urlIdOfPost=$_GET['id'];
 if(isset($_GET['id'])){
   $urlIdOfPost=$_GET['id'];
   $careator=$_SESSION['username'];
   $sqlUpdate="UPDATE Comments SET status='ON', approvedby='$careator' WHERE id='$urlIdOfPost'";
   if(!$sqlUpdateExcute=mysqli_query($con,$sqlUpdate)){
     $_SESSION['ErrorMessage']="failed to approve Comments";
     redirect_to('comments.php');
     #print_r(mysqli_error_list($con));

   }else{
     $_SESSION['successMessage']="Comment Approved Successfully";
     echo "comment sucessfully approved";
      redirect_to('comments.php');
   }
#disapproving approved comments
 }elseif(isset($_GET['disapprove'])){
   $urlIdOfPost=$_GET['disapprove'];
   $sqlUpdate="UPDATE Comments SET status='OFF' WHERE id='$urlIdOfPost'";
   if(!$sqlUpdateExcute=mysqli_query($con,$sqlUpdate)){
     $_SESSION['ErrorMessage']="failed to disapprove Comments";
     redirect_to('comments.php');
     #print_r(mysqli_error_list($con));

   }else{
     $_SESSION['successMessage']="Comment disapproved Successfully";
     echo "comment sucessfully approved";
      redirect_to('comments.php');
   }

 }elseif(isset($_GET['delete'])){
   $urlIdOfPost=$_GET['delete'];
   $sqlUpdate="DELETE FROM Comments WHERE id='$urlIdOfPost'";
   if(!$sqlUpdateExcute=mysqli_query($con,$sqlUpdate)){
     $_SESSION['ErrorMessage']="failed to delete Comments";
     redirect_to('comments.php');
     #print_r(mysqli_error_list($con));

   }else{
     $_SESSION['successMessage']="Comment disapproved Successfully";
     echo "comment sucessfully deleted";
      redirect_to('comments.php');
   }
 }

?>
