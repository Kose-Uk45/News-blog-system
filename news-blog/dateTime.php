<?php
date_default_timezone_set('Asia/Bombay');
#date_default_timezone_set('Asia/Calcutta');
$currentTime=time();//Get the current time
$dateTime=strftime("%d-%B-%Y-%H:%M:%S",$currentTime);//%A= full day of the week, %d=full date, %B=month %Y=year

echo $dateTime;
 ?>
