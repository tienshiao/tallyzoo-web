<?	require_once(CLASS_PATH."activity.cls.php");
	require_once(CLASS_PATH.'chart.cls.php');
	$objActivity = new activity();
	$objChart = new chart('');

	$currentUserId = $_SESSION["tz_user"]["userid"];
	$searchkey = $_POST['txtSearchKey'];
	
	$ROW = $objActivity->getActivityDashBoard($currentUserId,$searchkey);
	$sql_select=$objActivity->selectDashboardValues($currentUserId);
	$count=count($sql_select);
	$id_count=count($id);
	$activity_id=$objActivity->activityIdfetch($sql_select,$count);
	$actCount = "";
	if(is_array($ROW))
	{
		$actCount = count($ROW);
	}
	$middle="actListAjaxDashboard.tpl";
	$smarty->assign("CHECKED",$count);
	$smarty->assign("err_msg",$err_msg);
	$smarty->assign("actCount",$actCount);
	$smarty->assign("ROW",$ROW);
    $smarty->assign("DETAILS",$DETAILS);
    $smarty->assign("ACTIVITY",$activity_id);

?>