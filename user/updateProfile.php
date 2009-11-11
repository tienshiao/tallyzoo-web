<?	require_once(CLASS_PATH."user.cls.php");
	require_once(CLASS_PATH."clsManageImages.php");
	require_once(CLASS_PATH."/timezone/Date.php");
	$objGeneral->chekUserSessionExist();// check user session	
	$objUser = new user();
	$objImage = new clsManageImages();
	$err_msg = "";
	$timeZone = "";
	
	if($_POST['ACT'] == "UPDATE")
	{	
			$objUser->fnUpdateUser($_SESSION["tz_user"]["userid"]);
			$err_msg = "Your profile has been updated successfully.";
	}
	$ROW = $objUser->getUserDetails($_SESSION["tz_user"]["userid"]);
	$cmbTimeZone = $objUser->timeZone($ROW["timezone"]);
	$middle="updateProfile.tpl";
	$smarty->assign("error_msg",$err_msg);
	$smarty->assign("ROW",$ROW);
	$smarty->assign("cmbTimeZone",$cmbTimeZone);
	
?>