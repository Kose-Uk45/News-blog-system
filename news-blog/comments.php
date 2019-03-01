<?php require_once("include/sessions.php") ?>
<?php require_once("include/functions.php");?>
<?php require_once("include/databaseConnec.php");?>
<?php require_once("include/commentsTotal.php");?>
<?php echo confirm_login();?>
<?php session_start();?>
<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
  <script src="bootstrap/jquery-3.2.1.js"></script>
  <script src="bootstrap/js/bootstrap.min.js"></script>

<title>comments</title>
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
         <ul class="nav nav-pills nav-stacked">
          <li> <a href="dashboard.php"> <span class="glyphicon glyphicon-th"></span>&nbsp;Dashboard</a></li>
          <li><a href="addNewPost.php"><span class="glyphicon glyphicon-list-alt"></span>&nbsp;Add New Post</a></li>
          <li><a href="categories.php"><span class="glyphicon glyphicon-tags"></span>&nbsp;Categories</a></lil>
            <li><a href=""><span class="glyphicon glyphicon-user"></span>&nbsp;Manage Admins</a></li>
            <li class="active"><a href="comments.php"><span class="glyphicon glyphicon-comment"></span>&nbsp;Comments
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
      <h1>Manage Comments</h1>
      <h2>Pending Approval</h2>
      <?php
       echo successMessage();
       echo errorMessage();
      ?>
       <div class="table-responive">
         <table class="table table-striped table-hover table-condensed">
           <tr>
             <th>No</th>
             <th>Name</th>
             <th>Date </th>
             <th>Comment</th>
             <th>Approve</th>
             <th>Delete Comment</th>
             <th>Details</th>
           </tr>

           <?php
            #retireve comments details to this table
            $getComments="SELECT *FROM Comments WHERE status='OFF' ORDER BY date_and_time DESC";
            $getCommentsExcute=mysqli_query($con,$getComments);
            $idincremented=0;
            while($commentsData=mysqli_fetch_array($getCommentsExcute)){
              $id=$commentsData['id'];#id for approval of only a comments on a post
              $id_from_admin=$commentsData['id_from_admin_panel'];/* alternative id to be used for the a
              incase all comments for one post are to be approved*/
              $name=$commentsData['name'];
              $date=$commentsData['date_and_time'];
              $comments=$commentsData['comment'];
              $idincremented++;
            /*  if(strlen($comments)>50 || strlen($name)>10){
                $comments=substr($comments,0,50)."..";
                $name=substr($name,0,10)."..";
              }*/
           ?>
           <tr>
             <td><?php echo $idincremented;?></td>
             <td><?php echo $name; ?></td>
             <td><?php echo $date; ?></td>
             <td><?php echo $comments; ?></td>
             <td><a href="approveComments.php?id=<?php echo $id; ?>"><span class="btn btn-success">Approve</span></a></td>
             <td><a href="approveComments.php?delete=<?php echo $id; ?>"><span class="btn btn-danger">Delete</span></a></td>
             <td><a href="fullPost.php?id=<?php echo $id_from_admin; ?>"><span class="btn btn-info">Preview</span></a></td>

           </tr>
         <?php } ?>

         </table>
       </div>
       <!--The table to display approved comments-->
       <h2>Approved Comments</h2>
        <div class="table-responive">
          <table class="table table-striped table-hover table-condensed">
            <tr>
              <th>No</th>
              <th>Name</th>
              <th>Date </th>
              <th>Comment</th>
              <th>Approved By</th>
              <th>Disapprove</th>
              <th>Delete Comment</th>
              <th>Details</th>
            </tr>

            <?php
             #retireve comments details to this table
             $getComments="SELECT *FROM Comments WHERE status='ON' ORDER BY date_and_time DESC";
             $getCommentsExcute=mysqli_query($con,$getComments);
             $idincremented=0;
             while($commentsData=mysqli_fetch_array($getCommentsExcute)){
               $id=$commentsData['id'];
               $id_from_admin=$commentsData['id_from_admin_panel'];
               $name=$commentsData['name'];
               $date=$commentsData['date_and_time'];
               $comments=$commentsData['comment'];
               $approvedby=$commentsData['approvedby'];
               $idincremented++;
               /*if(strlen($comments)>50 || strlen($name)>10){
                 $comments=substr($comments,0,50)."..";
                 $name=substr($name,0,10)."..";
               }*/
            ?>
            <tr>
              <td><?php echo $idincremented;?></td>
              <td><?php echo $name; ?></td>
              <td><?php echo $date; ?></td>
              <td><?php echo $comments; ?></td>
              <td><?php echo $approvedby;?></td>
              <!--<td><?php echo "Admin";?></td>-->
              <td><a href="approveComments.php?disapprove=<?php echo $id; ?>"><span class="btn btn-success">Revert</span></a></td>
              <td><a href="approveComments.php?delete=<?php echo $id; ?>"><span class="btn btn-danger">Delete</span></a></td>
              <td><a href="fullPost.php?id=<?php echo $id_from_admin; ?>"><span class="btn btn-info">Preview</span></a></td>

            </tr>
          <?php } ?>

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
