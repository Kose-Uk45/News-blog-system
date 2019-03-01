
<?php require_once("include/databaseConnec.php");?>
<?php require_once("include/sessions.php");?>
<?php require_once("include/functions.php");?>
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
     $creator="Admin";
     $imageToUpload=$_FILES["postImage"]["name"]; /*defining a variable that holds submited image from the form.
     The first parameter "PostImage" =the name given to the image input field,and the second parameter "name" represents that the file
     should use the name specified by the user*/
     $target="uploads/".basename($_FILES["postImage"]["name"]);/*iploadedImages/ is the target directory,
      and the concatenated parameter is the target file to be uplodaed. Hence the $target variable holds
      the image moved by the move_uploaded_file() function.*/

       #deleting post details from database
       $urlSearchparameterOfDelete=$_GET['delete'];
       $postToDelete="DELETE FROM admin_panel WHERE id='$urlSearchparameterOfDelete'";
       $postToDeleteExcute=mysqli_query($con,$postToDelete);
       move_uploaded_file($_FILES["postImage"]["tmp_name"],$target);/*This function moves the uploaded
        file to a new location called $target.*/

           if($postToDeleteExcute){
             $_SESSION['SuccessMessage']="Post deleted Successfully";
             redirect_to("dashboard.php");
           }else {
             $_SESSION['ErrorMessage']="Failed to delete post! Please try again";
              redirect_to("dashboard.php");
               }


  }

  ?>
<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
  <script src="bootstrap/jquery-3.2.1.js"></script>
  <script src="bootstrap/js/bootstrap.min.js"></script>

<title>delete Post</title>
</head>

<body>
<div class="container">
   <div class="row">
     <div class="col-xs-2 well">
         <ul class="nav nav-pills nav-stacked">
          <li><a href="dashboard.php"><span class="glyphicon glyphicon-th"></span>&nbsp;Dashboard</a></li>
          <li class="active"><a href="addNewPost.php"><span class="glyphicon glyphicon-list-alt"></span>&nbsp;Add New Post</a></li>
          <li><a href="categories.php"><span class="glyphicon glyphicon-tags"></span>&nbsp;Categories</a></lil>
            <li><a href=""><span class="glyphicon glyphicon-user"></span>&nbsp;Manage Admins</a></li>
            <li><a href=""><span class="glyphicon glyphicon-comment"></span>&nbsp;Comments</a></li>
            <li><a href=""><span class="glyphicon glyphicon-equalizer"></span>&nbsp;Live Blog</a></li>
            <li><a href=""><span class="glyphicon glyphicon-log-out"></span>&nbsp;LogOut</a></li>
         </ul>


     </div><!--End of side bar for admin-->
     <div class="col-xs-8 well">
      <h2>Delete Posts</h2>
      <!--calling the error and succes messages from the functions.php file to display messages-->
          <?php
          echo  errorMessage();
          echo successMessage();
          ?>
          <?php
        #retriev data and show them to the input fields to be edit
        $urlSearchparameterOfDelete=$_GET['delete'];
         $selectToInputFields="SELECT * FROM admin_panel WHERE id='$urlSearchparameterOfDelete'";
         $selectToInputFieldsExcute=mysqli_query($con,$selectToInputFields);
         while($dataRows=mysqli_fetch_array($selectToInputFieldsExcute)){
           $titleToUpdate=$dataRows['title'];
           $categoryToUpdate=$dataRows['Categories'];
           $imageToUpdate=$dataRows['image'];
           $postToUpdate=$dataRows['post'];
      }  ?>

      <form action="deletePost.php?delete=<?php echo $urlSearchparameterOfDelete; ?>" method="post" enctype="multipart/form-data" >
        <fieldset>
          <div class="form-group">
          <label for="postTitle">Title</label>
          <input disabled type="text" name="postTitle" class="form-control" value="<?php echo $titleToUpdate; ?>">
          </div>
        <div class="form-group">
          <span>Previous Category</span>
          <?php echo $categoryToUpdate;?>
         <lable for="category"></br>Category</lable>
         <select disabled class="form-control" name="postCategory">
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
          <!--retrieving the existing image-->
          <span>Previous Image </span>
        <img src="uploads/<?php echo $imageToUpdate; ?>" width="100px"; height="50px>
         <label for="postImage"></br>Select Image</label>
         <input disabled  type="file" name="postImage" class="form-control">
        </div>
        <div class="form-group">
          <label for="postDetails">Post</label>
          <textarea disabled class="form-control" type="text" name="postDetails"><?php echo $postToUpdate; ?></textarea>
        </div>
        <input type="submit" name="postSubmit" value="Delete Post" class=" btn btn-danger">
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
