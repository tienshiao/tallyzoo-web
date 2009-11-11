<?	require_once(CLASS_PATH."user.cls.php");
	require_once(CLASS_PATH."clsManageImages.php");
	require_once(CLASS_PATH."/timezone/Date.php");
	$objUser = new user();
	$objImage = new clsManageImages();
	$err_msg = "";
	$timeZone = "";
	if($_POST['ACT'] == "ADD")
	{
		if(!$objUser->fnCreateUser())
		{
			$err_msg = "Username already exists.";
			$ROW["username"] = $objGeneral->encodequotes($_POST["txtUName"]);
			$ROW["password"] = $objGeneral->encodequotes($_POST["txtPass"]);
			$ROW["email"] = $objGeneral->encodequotes($_POST["txtEmail"]);
			$ROW["about"] = $objGeneral->encodequotes($_POST["txtAboutMe"]);
			$timeZone = $objGeneral->encodequotes($_POST["cmbTimeZone"]);
		}else{
			$err_msg = "You have been registered successfully.";
		}
	
	}
	
	$cmbTimeZone = $objUser->timeZone($timeZone);
	$middle="register.tpl";
	$top = "home_header.tpl";
	$smarty->assign("error_msg",$err_msg);
	$smarty->assign("jquery",1);
	$smarty->assign("ROW",$ROW);
	$smarty->assign("cmbTimeZone",$cmbTimeZone);
	
?>