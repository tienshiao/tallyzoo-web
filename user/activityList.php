<?	require_once(CLASS_PATH."activity.cls.php");
	$objActivity = new activity();
	

	
		$actId = $_POST['id'];
		if($actId != "")
		{
			$ROWEIDT = $objActivity->getActivity($actId);
			$ROWINPUT["rdoActivityType"] = $objGeneral->decodequotes($ROWEIDT["activity_type"]);
			$ROWINPUT["graphId"] = $ROWEIDT["graph_id"];
			
			if($ROWEIDT["activity_type"] == 1)
			{
				$ROWINPUT["activityIds"] = $objActivity->getRealatedActIds($ROWEIDT["graph_id"]);
				$actiIdArr = explode(",",$ROWINPUT["activityIds"]);
			}
		}
	
	$searchkey = $_POST['txtSearchKey'];
	
	$ROW = $objActivity->getUsersActivity($_SESSION["tz_user"]["userid"],$actId,$searchkey);
	
	if(is_array($ROW)){
		$noOfact = count($ROW);
	}
	$middle="activityList.tpl";
	$smarty->assign("error_msg",$err_msg);
	$smarty->assign("noOfact",$noOfact);
	$smarty->assign("ROW",$ROW);
	$smarty->assign("ROWINPUT",$ROWINPUT);

?>