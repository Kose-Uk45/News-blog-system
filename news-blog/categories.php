<?php require_once("include/databaseConnec.php");?>
<?php require_once("include/sessions.php");?>
<?php require_once("include/functions.php");?>
<?php require_once("include/commentsTotal.php");?>
<?php echo confirm_login();?>
<?php
#rignht section
   if(isset($_POST['submit'])){
     $category=mysqli_real_escape_string($con, $_POST['categoryName']);
     date_default_timezone_set('Asia/Bombay');
     #date_default_timezone_set('Asia/Calcutta');
     $currentTime=time();//Get the current time
     $dateTime=strftime("%d-%B-%Y-[%H:%M:%S]",$currentTime);//date to be inserted into database
     echo $dateTime;
     $creator=$_SESSION['username'];
     if(empty($category)){
       $_SESSION['ErrorMessage']= "all filds must be filed";// utilizing the sessions error mesaage design rather than simple echoing
       redirect_to("categories.php");
     }elseif(strlen($category)>20) {
      $_SESSION['ErrorMessage']="length of category too long";
       redirect_to("categories.php");
     }else {
       $sqlInsert="INSERT INTO Categories(date_and_time,name,creator_name) values('$dateTime','$category','$creator')";
       $sqlExcute= mysqli_query($con,$sqlInsert);
           if($sqlExcute){
             $_SESSION['SuccessMessage']="Category ".$category." Added";
             redirect_to("categories.php");
           }else {
             $_SESSION['ErrorMessage']="Failed to Add category";
              redirect_to("categories.php");
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

<title>categories</title>
</head>

<body>
<div class="container">
   <div class="row">
     <div class="col-xs-2 well">
       <h1>Admin left side bar links</h1>

         <ul class="nav nav-pills nav-stacked">
          <li><a href="dashboard.php"><span class="glyphicon glyphicon-th"></span>&nbsp;Dashboard</a></li>
          <li><a href="addNewPost.php"><span class="glyphicon glyphicon-list-alt"></span>&nbsp;Add New Post</a></li>
          <li class="active"><a href="categories.php"><span class="glyphicon glyphicon-tags"></span>&nbsp;Categories</a></lil>
            <li><a href="admins.php"><span class="glyphicon glyphicon-user"></span>&nbsp;Manage Admins</a></li>
            <li><a href="comments.php"><span class="glyphicon glyphicon-comment"></span>&nbsp;Comments
              <!--total of comments shown here from the commentsTotal.php
              included file having the commentsTotal funtion -->
              <?php echo commentsTotal();?>
            </a></li>
            <li><a href=""><span class="glyphicon glyphicon-equalizer"></span>&nbsp;Live Blog</a></li>
            <li><a href=""><span class="glyphicon glyphicon-log-out"></span>&nbsp;LogOut</a></li>
         </ul>


     </div><!--End of side bar for admin-->
     <div class="col-xs-8 well">
      <h1 class="text-center">Admin content dashboard</h1>
      <h2>Manage Category</h2>
      <!--calling the error and succes messages from the functions.php file to display messages-->
          <div> <?php
            echo  errorMessage();

             ?></div>
<?php echo successMessage();  ?>

      <form action="categories.php" method="POST" enctype="multipart/form-data" >
        <fieldset>
          <div class="form-group">
          <label for="categoryName">Name</label>
          <input type="text" name="categoryName" placeholder="enter category name" class="form-control">
          </div>
          <input type="submit" name="submit" value="Add category" class="btn btn-success">
        </fieldset>
      </form>
      <!--A div element to retrieve catgories from the database-->
      <div class="table-responsive">
       <table class="table table-striped table-hover">
        <tr>
          <th>SerNO</th>
          <th>Date and Time</th>
          <th>Catgeory Name</th>
          <th>Author</th>
          <th>Action</th>
        </tr>

          <?php
          $sqlSelect="SELECT * FROM Categories ORDER BY date_and_time Desc ";# ASC for ascending and DESC for descending order
          $sqlExcute=mysqli_query($con,$sqlSelect);
          $loopID=0;
          while($dataRows=mysqli_fetch_array($sqlExcute)){
            $displayId=$dataRows['id'];
            $displayDateTime=$dataRows['date_and_time'];
            $displayCategory=$dataRows['name'];
            $displayAuthor=$dataRows['creator_name'];
            $loopID++; #This will increament the Id value and works dynamically everytime the loop is iterated
          ?>
          <tr>
            <!--Outputting the data into the table td data-->
          <td> <?php echo $loopID; ?></td> <!--The increamented value is displyed rather than the fixed ID serial number from the database.-->
          <td> <?php echo $displayDateTime;?></td>
          <td> <?php echo $displayCategory;?></td>
          <td> <?php echo $displayAuthor;?></td>
          <td>
            <a href="deleteCategory.php?id=<?php echo $displayId?>"><span class="btn btn-danger">Delete</span></a>
          </td>
          </tr>

      <?php }?>


       </table>
      </div>
    </div><!--End of the admin panel dashboard-->
     <div class="col-xs-2 well">
      <h1>Admin right side bar </h1>
     </div>

   </div><!--End of first row-->
</div><!--End of the conatiner div with conatiner class-->
<div class="well text-center">
  <h1>Panel written and created by <a href="">Kose</a></h1>

</div>
</body>

</html>
