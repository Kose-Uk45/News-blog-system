<?php require_once("include/sessions.php") ?>
<?php require_once("include/functions.php");?>
<?php require_once("include/databaseConnec.php");?>
<?php require_once("include/commentsTotal.php");?>
<?php echo confirm_login();?>
<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
  <script src="bootstrap/jquery-3.2.1.js"></script>
  <script src="bootstrap/js/bootstrap.min.js"></script>

<title>Dashboard</title>
</head>

<body>
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
      <li class="active"><a href="blog.php">Blog</a></li>
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
<div class="container">
   <div class="row">
     <div class="col-xs-2 well">
       <?php echo "Your Session Id is=>".login();#session called from login function in functions files?>
         <ul class="nav nav-pills nav-stacked">
          <li class="active"> <a href="dashboard.php"> <span class="glyphicon glyphicon-th"></span>&nbsp;Dashboard</a></li>
          <li><a href="addNewPost.php"><span class="glyphicon glyphicon-list-alt"></span>&nbsp;Add New Post</a></li>
          <li><a href="categories.php"><span class="glyphicon glyphicon-tags"></span>&nbsp;Categories</a></lil>
            <li><a href="admins.php"><span class="glyphicon glyphicon-user"></span>&nbsp;Manage Admins</a></li>
            <li><a href="comments.php"><span class="glyphicon glyphicon-comment"></span>&nbsp;Comments
              <!--total of comments shown here from the commentsTotal.php
              included file having the commentsTotal funtion -->
              <?php echo commentsTotal();?>
            </a></li>
            <li><a href=""><span class="glyphicon glyphicon-equalizer"></span>&nbsp;Live Blog</a></li>
            <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span>&nbsp;LogOut</a></li>
         </ul>


     </div><!--End of side bar for admin-->
     <div class="col-xs-10 well">
         <!--calling the error and succes messages from the functions.php file to display messages-->
       <?php
        echo  errorMessage();
        echo successMessage();
        ?>
      <h1>Admin content area</h1>
       <div class="table-responive">
         <table class="table table-striped table-hover table-condensed">
           <tr>
             <th>No</th>
             <th>Post Title</th>
             <th>Date and time</th>
             <th>Author</th>
             <th>Category</th>
             <th>Banner</th>
             <th>Comments</th>
             <th>Actions</th>
             <tr>Details</th>
           </tr>

           <?php
            $selectToDashboard="SELECT * FROM admin_panel ORDER BY date_and_time DESC";
            $selectToDashboardExcute=mysqli_query($con, $selectToDashboard);
            $IdDynamic=0;
            while($dataRows=mysqli_fetch_array($selectToDashboardExcute)){
              $outputToDashBoardId=$dataRows['id'];
              $outputToDashBoardTitle=$dataRows['title'];
              $outputToDashBoardDate=$dataRows['date_and_time'];
              $outputToDashBoardAuthor=$dataRows['author'];
              $outputToDashBoardCategory=$dataRows['Categories'];
              $outputToDashBoardBanner=$dataRows['image'];
              #$Post=$dataRows['post'];
              $IdDynamic++;

              ?>
              <tr>
                <td><?php echo   $IdDynamic;?></td>
                <td>
                  <?php
                  if(strlen($outputToDashBoardTitle)>15){
                    $outputToDashBoardTitle=substr($outputToDashBoardTitle,0,15)."...";}
                    echo $outputToDashBoardTitle;
                   ?>
                </td>
                <td>
                  <?php
                  if(strlen($outputToDashBoardDate)>11){
                  $outputToDashBoardDate=substr($outputToDashBoardDate,0,11)."...";}
                  echo $outputToDashBoardDate;
                   ?>
                </td>
                <td><?php echo $outputToDashBoardAuthor;?></td>
                <td>
                  <?php
                  if(strlen($outputToDashBoardCategory)>10){
                  $outputToDashBoardCategory=substr($outputToDashBoardCategory,0,10)."...";}
                  echo $outputToDashBoardCategory;?>
                </td>
                <td><img src="uploads/<?php echo $outputToDashBoardBanner;?>" width="70" height="50"></td>
                <td>
                  <!--counts of unapproved comments-->
                  <span class="pull-left">
                  <?php
                  //processing comments from comments and admin table using both foreign and primary keys respectively
                  $commentsApproved="SELECT COUNT(*) FROM Comments WHERE id_from_admin_panel='$outputToDashBoardId'AND status='OFF'";
                  $commentsApprovedExcute=mysqli_query($con,$commentsApproved);
                  $commentsApprovedArray=mysqli_fetch_array($commentsApprovedExcute);
                  $commentsApprovedArrayShift=array_shift($commentsApprovedArray);
                  #echo "<span class='label label-danger'>".$commentsApprovedArrayShift."</span>";
                  #print_r(mysqli_error_list($con));
                  if($commentsApprovedArrayShift>0){
                    echo "<span class='label label-danger'>".$commentsApprovedArrayShift."</span>";
                  }
                  ?>
                </span>

                <!--counts of approved comments-->
                <span class="pull-right">
                <?php
                //processing comments from comments and admin table using both foreign and primary keys respectively
                $commentsApproved="SELECT COUNT(*) FROM Comments WHERE id_from_admin_panel='$outputToDashBoardId'AND status='ON'";
                $commentsApprovedExcute=mysqli_query($con,$commentsApproved);
                $commentsApprovedArray=mysqli_fetch_array($commentsApprovedExcute);
                $commentsApprovedArrayShift=array_shift($commentsApprovedArray);
                #echo "<span class='label label-danger'>".$commentsApprovedArrayShift."</span>";
                #print_r(mysqli_error_list($con));
                if($commentsApprovedArrayShift>0){
                  echo "<span class='label label-success'>".$commentsApprovedArrayShift."</span>";
                }
                ?>
              </span>
                </td>
                <td>
                  <a href="editPost.php?edit=<?php echo $outputToDashBoardId;?>">
                    <span class="btn btn-warning">edit</span>
                  </a>
                  <a href="deletePost.php?delete=<?php echo $outputToDashBoardId;?>">
                    <span class="btn btn-danger">delete</span>
                  </a>

                </td>
                <td><a href="fullPost.php?id=<?php echo $outputToDashBoardId;?>"><span class="btn btn-info">preview</span></a></td>
              </tr>

            <?php
            }
            ?>
         </table>
       </div>
    </div><!--End of the admin panel dashboard-->
   </div><!--End of first row-->
</div><!--End of the conatiner div with conatiner class-->
<div class="well text-center">
  <h1>Panel written and created by <a href="">Kose</a></h1>

</div>
</body>

</html>
