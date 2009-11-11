<?php
include_once("settings.php");
include_once("scripts/gmail.php");
$include_Path	=	"../";


  $login = $_POST['username'];
  $password = $_POST['password'];

	$resultarray = get_contacts($login, $password);
	$display_array = $resultarray;
	include_once ($include_Path.'user/imported_address.php');

?>
