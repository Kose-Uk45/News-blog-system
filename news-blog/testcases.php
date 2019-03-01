<?php require_once("include/sessions.php"); ?>

<?php
$ffusername="kose";
$ffpassword="rootroot";
function confirmLogin($ffusername,$ffpassword){
  $sql="SELECT *FROM admin_registration WHERE name='$ffusername' && password='$ffpassword'";
  $excute=mysqli_query($con,$sql);
  if($total = mysqli_fetch_assoc($excute)){
   return $total;
  }else{
    return null;
  }

}
$found=confirmLogin($ffusername,$ffpassword);
if($found){echo "hello";}else{echo "faled";}

?>
<?php /*
function confirmLogin($fusername,$fpassword){
  $sql="SELECT *FROM admin_registration WHERE name='$fusername' && password='$fpassword'";
  $excute=mysqli_query($con,$sql);
  $total=mysqli_fetch_assoc($excute);
  $name=$total['name'];
  $password=$total['password'];
  if($name==$fusername && $password==$fpassword){
    $_SESSION['SuccessMessage']="login successful welcome to home page";
    redirect_to("adminLogin.php");
  }else{
    $_SESSION['ErrorMessage']="failed to login please try agin";
  }

}*/ ?>
