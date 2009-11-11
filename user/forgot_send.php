<?
	include_once '../system/configme/siteconfig.php'; // include configuration file here	
	$path = str_replace("user/","",CLASS_PATH);
	include_once $path .'dbclass.php'; // database class include here	
	include_once $path .'user.cls.php'; // this is general class  include here	
	include_once$path.'general.cls.php';
	
	$dbObj = new dbclass(); // db object
	$objGeneral = new general($dbObj);
	$objUser = new user();
	
		$result=$objUser->fnforgotPassword($_REQUEST['txtUName'],$_REQUEST['txtPass']);
		if($result)
		{
			echo $err_msg = "Password Sent Successfully.";
			exit;			
		}
		else
		{
			echo $err_msg = "Invalid email address.";			
		}
	
	
?>