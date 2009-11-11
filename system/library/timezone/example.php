<?php
// include class
include ("Date.php");
//echo date('Y-m-d : h:i:s A')."<br>";
// initialize object

//"2009-01-31 11:00:00 PM"
$str = $_POST['sdate'];
if($_GET["id"] == 1)
{ 
	$str = date('Y-m-d H:i:s',strtotime($_POST['sdate']));
}
$d = new Date($str);

// set local time zone
$d->setTZByID("GMT+13");

// convert to foreign time zone
$d->convertTZByID("Asia/Calcutta");

//echo date('Y-m-d : h:i:s A')."<br>";
//echo date("e");

// retrieve converted date/time

if($_GET["id"] == 1)
{
	echo $d->format("%Y-%m-%d %I:%M:%S %P");
}else{
	echo $d->format("%Y-%m-%d @ %I:%M:%S @ %P");
}
//echo $d->format("%Y-%m-%d %h:%i:%s %P");
?>