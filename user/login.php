<?
	require(CLASS_PATH ."user.cls.php");

	$objUser = new user();
	$msg = "";
	if($_POST['ACT'] == "Login")
	{
		if(!$objUser->fnUserLogin($_REQUEST['txtUName'],$_REQUEST['txtPass']))
		{
			$msg = "Invalid Username/Password.";
		}else{
			header("Location: "._SITEURL_."dashboard");
		}
	}
	$smarty->assign("error_msg",$msg);
	$prefix="Home Page";
	$middle="login.tpl";
	$top = "home_header.tpl";
?>