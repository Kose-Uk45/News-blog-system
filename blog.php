<?php require_once("include/databaseConnec.php");?>
<?php require_once("include/sessions.php");?>
<?php require_once("include/functions.php");?>
<?php session_start(); ?>
<!DOCTYPE html>
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
               date_and_time  LIKE '%$searchbox%'OR
               title LIKE '%$searchbox%' OR
               Categories LIKE '%$searchbox%' OR
               post LIKE '%$searchbox%'";
               //ativiating the pagination tabs
             }elseif(isset($_GET['pages'])){
               $pages=$_GET['pages'];
               $pagesShown=($pages*5)-5;
               //calculating the total posts below
               $swql="SELECT COUNT(*) FROM admin_panel ";
               $run=mysqli_query($con,$swql);
               $array=mysqli_fetch_assoc($run);
               $shift=array_shift($array);
               echo $shift."<br>";
               //calculating the total posts above
               /*conditions to check if number of pages are 0, less than 0 , or
               greater than the number of post present in the database*/
               if($pages<0 ||$pages==0 || $pagesShown>$shift){
                 $pagesShown=0;
               }#else{$pagesShown=($pages*5)-5;}
               echo $pagesShown;
               $selectToBlog="SELECT * FROM admin_panel ORDER BY date_and_time DESC LIMIT $pagesShown,5";

             }
             //post to display accordingly when the category in the side area is clicked/curl_multi_set
             elseif(isset($_GET['category'])){
                 $category=$_GET['category'];
                 $selectToBlog="SELECT *FROM admin_panel WHERE Categories='$category' ORDER BY date_and_time DESC";

             }
             //activating the default pages to be retrieved
             else{
               $selectToBlog="SELECT * FROM admin_panel ORDER BY date_and_time DESC LIMIT 0,5";}/*ending else incase the
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
                 $postImage=$rows[image];
                 $postPost=$rows[post];

               ?>

               <div class="thumbnail " id="blog">
                 <img id="blogImage" class="img-responsie img-rounded" src="uploads/<?php echo $postImage; ?>">
                 <div class="caption">
                   <h2 id="heading"><?php echo htmlentities($postTitle); ?></h2>
                   <p> category:<?php echo htmlentities($postCategories)."</br>";?> published on:
                   <?php echo htmlentities($postDateTime); ?></p>
                   <p> <?php
                      #limiting the amount of post displayed to users
                      if(strlen($postPost)>500){
                        $postPost=substr($postPost,0,500)."....";
                      }
                      echo nl2br($postPost);
                    ?><a style="float:right;" href="fullPost.php?id=<?php echo htmlentities($postId); ?>">
                      <span class="btn btn-info">continue reading &rsaquo;&rsaquo;&rsaquo;</span></a></p>

                 </div>

               </div>

             <?php
           }#end of while loop
          ?>
        <!--pagination links -->
        <nav>
          <ul class="pagination pull-left">
        <?php
        $swql="SELECT COUNT(*) FROM admin_panel ";
        $run=mysqli_query($con,$swql);
        $array=mysqli_fetch_assoc($run);
        $shift=array_shift($array);
        $divide=$shift/5;
        $ceil_rounding=ceil($divide);
        echo $shift."<br>";
        echo $divide."<br>";
        echo $ceil_rounding."<br>";?>
        <!--adding the back/previous button on the pagination links below-->
        <?php
        if(isset($_GET['pages'])){
        $pages=$_GET['pages'];
        if($pages>1){?>
          <li><a href="blog.php?pages=<?php echo $pages-1; ?>">Back</a></li>
      <?php  }}
        ?>
        <!--adding the back/previous button on the pagination links above--><?php
        for($i=1;$i<=$ceil_rounding; $i++){
          if(isset($_GET['pages'])){//checking to ensure nav is only displayed when pages search query is set
          if($i==$_GET['pages']){?>
            <li class="active">  <a href="blog.php?pages=<?php echo $i;?>"> <?php echo $i;?></a></li>
        <?php  }else{
          ?>

        <li>  <a href="blog.php?pages=<?php echo $i;?>"> <?php echo $i;?></a></li>

      <?php  }}}
        ?>

        <!--adding the forward/next button on the pagination links below-->
        <?php
        if(isset($_GET['pages'])){
        $pages=$_GET['pages'];
        if($pages+1<=$ceil_rounding){?>
          <li><a href="blog.php?pages=<?php echo $pages+1; ?>">Next</a></li>
      <?php  }}
        ?>
        <!--adding the forward/next button on the pagination links above-->

      </ul>
    </nav><!--end of pagination links-->

          <?php
                if(isset($_GET['searchSubmit'])){
                 if(stripos($postTitle,$searchbox)!==false || stripos($postCategories,$searchbox)!==false ||
                      stripos($postDateTime,$searchbox)!==false || stripos($postPost,$searchbox)!==false )
                    {//matching search box with data retrived
                     }
                  else{
                   echo "</br>". "Your search for "."<span style='color:red;''>".$searchbox."</span>"." was not found".
                    '<a href="#searchNew"> use another word</a>' ;}}
       }# Ends checking wehther data exist in db
         else{ echo "errror occured";}?>

         </div><!--post area ends-->


         <div class="col-sm-offset-1 col-sm-3" style="background:green;"><!--side area start-->
           <h4>side area for the Categories and recent blog post</h4>
           <div class="panel-group">
           <!--div panel for categories-->
            <div class="panel"><!--start of category panel-->
              <div class="panel-heading">category heading</div>
              <div class="panel-body">
                <p class="panel-title">category body content</p>
                <?php

                $category=$_GET['category'];
                $categoriesToSideArea="SELECT * FROM Categories ORDER BY date_and_time DESC";
                $categoriesToSideAreaExcute=mysqli_query($con,$categoriesToSideArea);
                while($rows=mysqli_fetch_assoc($categoriesToSideAreaExcute)){
                $GLOBALS['x']=$rows['name'];
                  ?>
                  <a href="blog.php?category=<?php echo $x;?>"><?php echo $x."</br>";?></a>
                <?php }
                #echo $x;
                ?>
              </div>
              <div class="panel-footer"><p>category footer</p></div>
           </div><!--end of category panel-->
           <!--div panel for the recent blog post-->
           <div class="panel"><!--start of recent blog post -->
             <div class="panel-heading">recent blog post heading</div>
             <div class="panel-body">
               <p>recent blog post body content</p>
               <?php
               $sideArea="SELECT * FROM admin_panel ORDER BY date_and_time DESC LIMIT 0,1";
               $excuteSideArea=mysqli_query($con,$sideArea);
               $arrayFetch=mysqli_fetch_assoc($excuteSideArea);
               $shift=array_shift($arrayFetch);
               echo $shift;
               echo $title=$arrayFetch['title']."<br>";
               echo $post=$arrayFetch['post'];
               ?>
             </div>
             <div class="panel-footer"><p>recent blog post footer</p></div>
           </div><!--end of recent blog post-->
         </div>
         </div><!--side area ends--->
       </div><!--row ends-->
     </div> <!--conatiner body ends-->
     <div class="well text-center"><!--footer starts-->
       <h1>Panel written and created by <a href="">Kose</a></h1>

     </div><!--footer ends -->

  </body>

</html>
