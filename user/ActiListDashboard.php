<?	
    require_once(CLASS_PATH."activity.cls.php");
    require_once(CLASS_PATH."user.cls.php");
	require_once(CLASS_PATH."clsManageImages.php");
	require_once(CLASS_PATH."clsPager.php");
	require_once(CLASS_PATH."timezone/Date.php");
	require_once(CLASS_PATH.'chart.cls.php');
	$objGeneral->chekUserSessionExist();// check user session	
   
    $currentUserId=$_SESSION["tz_user"]["userid"];
	$objActivity = new activity();
	$objChart = new chart('');
   	$ROW = $objActivity->getActivityDashBoard($currentUserId,'');
	
	$sql_select=$objActivity->selectDashboardValues($currentUserId);
	$count=count($sql_select);
	$id_count=count($id);
	$activity_id=$objActivity->activityIdfetch($sql_select,$count);
	$actCount = "";
	if(is_array($ROW))
	{
		$actCount = count($ROW);
	}
    
    $smarty->assign("CHECKED",$count);
	$smarty->assign("err_msg",$err_msg);
	$smarty->assign("actCount",$actCount);
	$smarty->assign("ROW",$ROW);
    $smarty->assign("DETAILS",$DETAILS);
    $smarty->assign("ACTIVITY",$activity_id);
	$smarty->assign("pagelist",$pagelist);
	$smarty->assign("FILER", $_SESSION['tmpFilter']);
	$middle = "ActiListDashboard.tpl";
	
	
?>