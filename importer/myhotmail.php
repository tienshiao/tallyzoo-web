<?
	require("baseclass/baseclass.php");
	require("hotmail/msn_contact_grab.class.php");
	$obj = new hotmail();
	$username	=	$_POST['username'];
	$password	=	$_POST['password'];

	$contacts	=	$obj->getAddressbook($username, $password);
	$display_array = $contacts;

	$fp = fopen("cookie.txt","w+");
		fwrite($fp,"");				
		fclose($fp);
		@unlink($fp);
	$include_Path	=	"../";
	include_once ($include_Path.'user/imported_address.php');
	
?>
