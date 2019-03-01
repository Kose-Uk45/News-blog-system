<?php require_once("include/databaseConnec.php");?>
<?php require_once("include/sessions.php"); ?>

<?php
#function to be reused for the header redirection if constraints are violated
function redirect_to($newLocation){
  header("location:".$newLocation);
  exit;
}
/*
function confirmLogin($ffusername,$ffpassword){
  $sql="SELECT *FROM admin_registration WHERE name='$ffusername' && password='$ffpassword'";
  $excute=mysqli_query($con,$sql);
  if($total = mysqli_fetch_assoc($con,$excute)){
   return $total;
  }else{
    return null;
  }

}*/
#below two functions are for session tracking for login purpose.
function login(){
if(isset($_SESSION['userid'])){
  return $_SESSION['userid'];
  return true;
}}
function confirm_login(){
  if(!login()){
   $_SESSION['ErrorMessage']="login is required please";
  redirect_to("adminLogin.php");
}}

 ?>
