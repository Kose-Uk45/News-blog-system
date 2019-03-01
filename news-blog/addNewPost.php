
<?php require_once("include/databaseConnec.php");?>
<?php require_once("include/sessions.php");?>
<?php require_once("include/functions.php");?>
<?php require_once("include/commentsTotal.php");?>
<?php
#rignht section
   if(isset($_POST['postSubmit'])){
     $title=mysqli_real_escape_string($con, $_POST['postTitle']);
     $category=mysqli_real_escape_string($con,$_POST['postCategory']);
     $post=mysqli_real_escape_string($con,$_POST['postDetails']);

     date_default_timezone_set('Asia/Bombay');
     #date_default_timezone_set('Asia/Calcutta');
     $currentTime=time();//Get the current time
     $dateTime=strftime("%d-%B-%Y-[%H:%M:%S]",$currentTime);//date to be inserted into database
     $creator=$_SESSION['username'];//session with login user name
     $imageToUpload=$_FILES["postImage"]["name"]; /*defining a variable that holds submited image from the form.
     The first parameter "PostImage" =the name given to the image input field,and the second parameter "name" represents that the file
     should use the name specified by the user*/
     $target="uploads/".basename($_FILES["postImage"]["name"]);/*iploadedImages/ is the target directory,
      and the concatenated parameter is the target file to be uplodaed. Hence the $target variable holds
      the image moved by the move_uploaded_file() function.*/
     if(empty($title)){
       $_SESSION['ErrorMessage']= "Title cannot be blank";// utilizing the sessions error mesaage design rather than simple echoing
       redirect_to("addNewPost.php");
     }elseif(strlen($title)<3) {
      $_SESSION['ErrorMessage']="Title length Should not be shorter";
       redirect_to("addNewPost.php");
     }else {
       #GLOBAL $y;
       #Inserting the post details into database
       $sqlInsert="INSERT INTO admin_panel(date_and_time,title,Categories,author,image,post)
       values('$dateTime','$title','$category','$creator','$imageToUpload','$post')";
       $sqlExcute= mysqli_query($con,$sqlInsert);
       move_uploaded_file($_FILES["postImage"]["tmp_name"],$target);/*This function moves the uploaded
        file to a new location called $target.*/

           if($sqlExcute){
             $_SESSION['SuccessMessage']="Post Added Successfully";
             redirect_to("addNewPost.php");
           }else {
             $_SESSION['ErrorMessage']="Failed to add post! Please try again";
              redirect_to("addNewPost.php");
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

<title>New Post</title>
</head>

<body>
<div class="container">
   <div class="row">
     <div class="col-xs-2 well">
         <ul class="nav nav-pills nav-stacked">
          <li><a href="dashboard.php"><span class="glyphicon glyphicon-th"></span>&nbsp;Dashboard</a></li>
          <li class="active"><a href="addNewPost.php"><span class="glyphicon glyphicon-list-alt"></span>&nbsp;Add New Post</a></li>
          <li><a href="categories.php"><span class="glyphicon glyphicon-tags"></span>&nbsp;Categories</a></lil>
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
      <h2>Manage Posts</h2>
      <!--calling the error and succes messages from the functions.php file to display messages-->
          <?php
          echo  errorMessage();
          echo successMessage();
          ?>

      <form action="addNewPost.php" method="post" enctype="multipart/form-data" >
        <fieldset>
          <div class="form-group">
          <label for="postTitle">Title</label>
          <input type="text" name="postTitle" placeholder="enter Post Title" class="form-control">
          </div>

        <div class="form-group">
         <lable for="">Category</lable>
         <select class="form-control" name="postCategory">
          <option  Selected>Select from below Categories</option>
            <?php
              $sqlSelect="SELECT * FROM Categories ORDER BY date_and_time Desc ";
              $sqlExcute=mysqli_query($con,$sqlSelect);
              while($dataRows=mysqli_fetch_array($sqlExcute)){
                $displayId=$dataRows['id'];
                $displayDateTime=$dataRows['date_and_time'];
                $displayCategory=$dataRows['name'];

             ?>

             <option>
              <?php echo $displayCategory;?>
             </option>
          <?php }?>
         </select>
        </div>
        <div class="form-group">
         <label for="postImage">Image</label>
         <input type="file" name="postImage" class="form-control">
        </div>
        <div class="form-group">
          <label for="postDetails">Post</label>
          <textarea class="form-control" type="text" name="postDetails" placeholder="Enter the Commplete post here"></textarea>
        </div>
        <input type="submit" name="postSubmit" value="Add Post" class=" btn btn-success">
          </fieldset>
      </form>

    </div><!--End of the admin panel dashboard-->


   </div><!--End of first row-->
</div><!--End of the conatiner div with conatiner class-->
<div class="well text-center">
  <h1>Panel written and created by <a href="">Kose</a></h1>

</div>
</body>

</html>
