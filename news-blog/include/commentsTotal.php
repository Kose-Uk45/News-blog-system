<?php /*this file is included here only for purpose of
acessing bootstrap*/
include("BuildingCMS/comments.php")?>
<?php
$GLOBALS['total'];
function commentsTotal(){
  #<!--coments total to be shown-->
  #<span class='label label-warning'>
  $conn=mysqli_connect('localhost','root','12345','buildingCMS');
  $commentsTotal="SELECT COUNT(*) FROM Comments WHERE status='OFF' ";
  $commentsTotalExcute=mysqli_query($conn,$commentsTotal);
  $commentsTotalExcuteArray=mysqli_fetch_array($commentsTotalExcute);
  $commentsTotalExcuteArrayShift=array_shift($commentsTotalExcuteArray);
  echo "<span class='label label-warning pull-right'>".$commentsTotalExcuteArrayShift."</span>";
}
?>
