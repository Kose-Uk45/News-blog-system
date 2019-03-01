<?php require_once("include/databaseConnec.php");?>
<?php require_once("include/sessions.php");?>
<?php require_once("include/functions.php");?>
<?php
if(isset($_POST['userSubmit'])){
  $NameFromComment=mysqli_real_escape_string($con,$_POST['userName']);
  $EmailFromComment=mysqli_real_escape_string($con,$_POST['userEmail']);
  $actualComment=mysqli_real_escape_string($con,$_POST['userComment']);
  date_default_timezone_set('Asia/Bombay');
  #date_default_timezone_set('Asia/Calcutta');
  $currentTime=time();//Get the current time
  $dateTime=strftime("%d-%B-%Y-[%H:%M:%S]",$currentTime);//date to be inserted into database
  $status="OFF";
  if(empty($NameFromComment)|| empty($EmailFromComment)|| empty($actualComment)){
    echo "name required name required and others required"."<br>";
  }elseif(strlen($actualComment)>500){
    echo "comment should't be more than 500 characters";
  }else{
    $urlid=$_GET['id'];
    $creator=$_SESSION['username'];
    $sql="INSERT INTO Comments(date_and_time,name,email,comment,approvedby,status,id_from_admin_panel)
    values('$dateTime','$NameFromComment','$EmailFromComment','$actualComment','Pending','$status','$urlid')";
    $runSql=mysqli_query($con,$sql) ;
    #echo "affected rows".mysqli_affected_rows($con);
    if(!$runSql){
      echo "failed to insert".mysqli_error_list($con)."<br>"."<pre>";
      print_r(mysqli_error_list($con));//returns the list of errors
      print_r(mysqli_dump_debug_info($con));//dumps debugging info to the log files returns 1 on sucess

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
    <link rel="stylesheet" href="customStyles/public.css">
    <meta charset="utf-8">
    <title>public blog</title>
  </head>
  <body>
  <!--  <div style="height=10px; background: #27aae1;">hello line test</div>-->
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
    <!--<div style="height=10px; background:red; color:green;">hello line test</div>-->
     <div class="container"><!--blog body-->
       <div classs="page-header">
         <h1>Welcome to the NetYourself research news and updates</h1>
         <h2>You gonna find the best of us in technology here</h2>
       </div>
       <div class="row">
         <div class="col-sm-8"><!--post area starts-->

             <?php
             #activating the search box
             if(isset($_GET['searchSubmit'])){
               $searchbox=$_GET['searchText'];
               $selectToBlog="SELECT * FROM admin_panel WHERE
               date_and_time LIKE '%$searchbox%'OR
               title LIKE '%$searchbox%' OR
               Categories LIKE '%$searchbox%' OR
               post LIKE '%$searchbox%'";
             }else{
               $urlPostId=$_GET['id'];#an id from the url when the continue reading button in blog.php is clicked
               $selectToBlog="SELECT * FROM admin_panel WHERE id=$urlPostId ORDER BY date_and_time DESC";}/*ending else incase the
                searchSubmit button is not set.
                The complete content is displayed as usual*/

               $selectToBlogExcute=mysqli_query($con,$selectToBlog);/*Excuting all the conditions
                that's both if and else above*/
                if($selectToBlogExcute>0){# begin checking wehther data exist in db
               while($rows=mysqli_fetch_array($selectToBlogExcute)){
                 $postId=$rows['id'];
                 $postDateTime=$rows['date_and_time'];
                 $postTitle=$rows['title'];
                 $postCategories=$rows['Categories'];
                 $postAuthor=$rows['author'];
                 $postImage=$rows['image'];
                 $postPost=$rows['post'];

               ?>

               <div class="thumbnail " id="blog">
                 <img id="blogImage" class="img-responsie img-rounded" src="uploads/<?php echo $postImage; ?>">
                 <div class="caption">
                   <h2 id="heading"><?php echo htmlentities($postTitle); ?></h2>
                   <p> category:<?php echo htmlentities($postCategories)."</br>";?> published on:
                   <?php echo htmlentities($postDateTime); ?></p>
                   <p> <?php echo nl2br($postPost);?></p>
                 </div>
                   <div>
                     <h1 style="color:#0000FF">Comments</h1>
                     <!--retrieving the comments to the public page-->
                    <span>
                      <?php
                      $posturl=$_GET["id"];
                     $selectComment="SELECT * FROM Comments WHERE id_from_admin_panel='$posturl' AND status='ON' ORDER BY date_and_time DESC";
                     $selectCommentsExcute=mysqli_query($con,$selectComment);
                     while($commentsRows=mysqli_fetch_array($selectCommentsExcute)){
                       $name=$commentsRows['name'];
                       $date=$commentsRows['date_and_time'];
                       $comments=$commentsRows['comment'];
                       ?>
                       <p>
                         <!--A php scope to print out the comments-->
                         <img src="images/logo.jpg" width="30px" height="30px">
                         <?php
                          echo "<span style='margin-left:10px;'>".$name."</span>"."<br>";
                          echo "<span style='margin-left:44px;'>".$date."</span>"."</br>";
                          echo "<span style='margin-left:44px;'>".$comments."</span>"."</br>"; ?>
                       </p>
                       <?php
                     }
                    ?></span>
                   </div>
                 <form action="fullPost.php?id=<?php echo $_GET['id'];?>" method="POST">

              <span class="btn-info">Share you view about this post</span>
              <div class="form-group">
              <label for="Name">Name</label><br>
                <input type="text" name="userName" placeholder="enter your name">
              </div>
              <div class="form-group">
              <label for="Name">Email</label><br>
                <input type="Email" name="userEmail" placeholder="enter your Email">
              </div>
              <div class="form-group">
              <label for="Comment">Comment</label><br>
                <textarea name="userComment" placeholder="Write comment here" rows="5"></textarea>
              </div>
              <input type="submit" name="userSubmit" value="submit" class="btn btn-info">
               </div>


             <?php
           }#end of while loop
                   if(stripos($postTitle,$searchbox)!==false || stripos($postCategories,$searchbox)!==false ||
                      stripos($postDateTime,$searchbox)!==false || stripos($postPost,$searchbox)!==false )
                    {//matching search box with data retrived
                     }
                  else{
                   echo "Your search for "."<span style='color:red;'>".$searchbox."</span>"." was not found".
                    '<a href="#searchNew"> use another word</a>' ;}
       }# Ends checking wehther data exist in db
         else{ echo "errror occured";}?>

         </div><!--post area ends-->
         <div class="col-sm-offset-1 col-sm-3" style="background:green;"><!--side area start-->
           <h1>this is the side area</h1>
         </div><!--side area ends--->
       </div><!--row ends-->
     </div> <!--conatiner body ends-->
     <div class="well text-center"><!--footer starts-->
       <h1>Panel written and created by <a href="">Kose</a></h1>

     </div><!--footer ends -->

  </body>

</html>
