<?php require_once("include/databaseConnec.php");?>
<?php require_once("include/sessions.php");?>
<?php require_once("include/functions.php");?>
<?php require_once("include/commentsTotal.php");?>
<?php session_start();?>
<?php
 if(isset($_POST['usersubmit'])){
   $fusername=mysqli_real_escape_string($con,$_POST['username']);
   $fpassword=mysqli_real_escape_string($con,$_POST['userpassword']);
   if(empty($fusername) || empty($fpassword)){
    # echo "hello".$fusername."login unsuccessful sorry";
   $_SESSION['ErrorMessage']="all fields required";
   redirect_to("adminLogin.php");
 }else{
   #extract the database infor for comaprison. operation at the funtion pages
   /* ommitted temporarily due to malfunctions
   $found_admin=confirmLogin($ffusername,$ffpassword);
   if($found_admin){
     $_SESSION['SuccessMessage']="login successful welcome to home page";
     echo "sucess";
     redirect_to("adminLogin.php");
   }else{
       $_SESSION['ErrorMessage']="failed to login please try agin";
   echo "failed";}*/

   $sql="SELECT *FROM admin_registration WHERE name='$fusername'";
   $excute=mysqli_query($con,$sql);
   $total=mysqli_fetch_assoc($excute);
   $_SESSION['userid']=$total['id'];
   $dbPassword=$total['password'];
   $_SESSION['username']=$total['name'];
   //dehashing to compared db hased password with user inpu
   $hasedDecrpt=password_verify($fpassword,$dbPassword);
   if($hasedDecrpt){
     $_SESSION['SuccessMessage']="Login successfuly =>".$fusername ;
     redirect_to("dashboard.php");
   }else{
     $_SESSION['ErrorMessage']="failed to login please try agin";
   }
 }

 }
?>

<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
  <script src="bootstrap/jquery-3.2.1.js"></script>
  <script src="bootstrap/js/bootstrap.min.js"></script>

<title>login</title>
</head>

<body style="background-color:#009977;">
<nav class="navbar navbar-inverse " role="navigation">
<div class="container">
  <div class="navbar-header">
    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
    data-target="#collapse"><!-- toggle and the id of data to be collapsed into the toggle when the toggle icon is clicked-->
    <span class="sr-only">Toggle Navigtion</span><!--for screen reader accessibility-->
    <span class="icon-bar"></span><!--icons inside the toggle-->
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
  </button>
   <a class="navbar-brand" href="blog.php"><img src="images/logo.jpg" style="margin-top:-30px;" width="70px" height="70px"></a>
  </div>
  <div class="collapse navbar-collapse" id="collapse"><!--toggled items starts here-->
  <ul class="nav navbar-nav lead">
    <li><a href="">Home</a></li>
    <li class="active"><a href="#blog.php">Blog</a></li>
    <li><a href="">About</a></li>
    <li><a href="">Services</a></li>
    <li><a href="">contact us</a></li>
    <li><a href="">Features</a></li>
  </ul>

  <form action="blog.php" class="navbar-form navbar-right lead">
    <div class="form-group ">
      <input type="text" name="searchText" placeholder="search" id="searchNew">
      <input type="submit" name="searchSubmit" value="search">
    </div>
  </div><!--toggled items end here-->
  </form>
</div>
</nav><!--naviagtion ends-->
    <!---<div class="col-xs-offsedt-4 lead"><h1 class="text-center" style="color:green;">Admin login portal</h1></div>-->

      <div class="col-xs-offset-4 col-xs-4">
        <img src="images/logo.jpg" class="col-xs-offset-4 img-responsive  img-circle">
          <?php
           echo errorMessage();
           echo successMessage();


           ?>
      <form action="adminLogin.php" method="POST" enctype="multipart/form-data" >
          <div class="form-group">
          <label for="userName">Username</label>
            <div class="input-group input-group-lg">
              <span class="input-group-addon">
                 <span class="glyphicon glyphicon-envelope"></span>
               </span>
                   <input type="text" name="username" placeholder="enter user name" class="form-control">
              </div>
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <div class="input-group input-group-lg">
              <span class="input-group-addon">
                 <span class="glyphicon glyphicon-lock"></span>
               </span>
            <input type="password" class="form-control" name="userpassword" placeholder="password">
          </div>
          </div>

          <input type="submit" name="usersubmit" value="login" class="col-xs-offset-5 btn btn-success">
      </form>
    </div>


</body>
</html>
