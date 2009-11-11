<?	require_once(CLASS_PATH."activity.cls.php");
	require_once(CLASS_PATH."/timezone/Date.php");
	require_once(CLASS_PATH."chart.cls.php");
	$objGeneral->chekUserSessionExist();// check user session
	$objActivity = new activity();
	$objChart = new chart('');
	$haveData = 0;
	$actiLimit = $objActivity->returnActiLimit();
	if($_GET['ACT'] == "EDIT")
	{
		$actId = $_GET['id'];
		$ROWEIDT = $objActivity->getActivity($actId);
		$ROWINPUT["rdoActivityType"] = $objGeneral->decodequotes($ROWEIDT["activity_type"]);
		$ROWINPUT["txtName"] = $objGeneral->decodequotes($ROWEIDT["name"]);
		$ROWINPUT["txtNote"] = $objGeneral->decodequotes($ROWEIDT["default_note"]);
		$ROWINPUT["txtTag"] = $objGeneral->decodequotes($ROWEIDT["tags"]);
		$ROWINPUT["txtColor"] = $objGeneral->decodequotes($ROWEIDT["color"]);
		$ROWINPUT["rdoAccess"] = $objGeneral->decodequotes($ROWEIDT["hidden"]);
		$ROWINPUT["txtIntial"] = $objGeneral->decodequotes($ROWEIDT["initial_value"]);
		$ROWINPUT["txtGoal"] = $objGeneral->decodequotes($ROWEIDT["goal"]);
		$ROWINPUT["graphId"] = $ROWEIDT["graph_id"];
		$graphType = $ROWEIDT["graph_type"]; 
		$dataOpt = $ROWEIDT["dataOption"]; 
		$graphId = $ROWEIDT["graph_id"]; 
		
		//$ROWINPUT["activityIds"] = explode(",",$_POST["activityIds"]);
		if($ROWEIDT["activity_type"] == 1)
		{
			$ROWINPUT["activityIds"] = $objActivity->getRealatedActIds($ROWEIDT["graph_id"]);
			$actiIdArr = explode(",",$ROWINPUT["activityIds"]);
		}else{
			$arrData = $objActivity->getUsersMyDataALL($actId,0,$ROWEIDT["graph_id"]);
			if(is_array($arrData))
			{
				$haveData = count($arrData);
			}
		}
	}
	
	$ROW = $objActivity->getUsersActivity($_SESSION["tz_user"]["userid"],$actId);
	$tblColor = $objGeneral->returnColorPlate($ROW['color']);
	if(is_array($ROW)){
		$noOfact = count($ROW);
	}
	if($graphType <=0)
	{
		$graphType = 1;
	}
	$imgChart = $objChart->returnPevieImg($graphType);
	$cmbDataOpt = $objChart->returnCombo($graphType,$dataOpt);
	$middle="addActivity.tpl";
	$smarty->assign("error_msg",$err_msg);
	$smarty->assign("noOfact",$noOfact);
	$smarty->assign("ROW",$ROW);
	$smarty->assign("ACTIDARR",$actiIdArr);
	$smarty->assign("tblColor",$tblColor);
	$smarty->assign("ROWINPUT",$ROWINPUT);
	$smarty->assign("dataOpt",$dataOpt);
	$smarty->assign("graphType",$graphType);
	$smarty->assign("cmbDataOpt",$cmbDataOpt);
	$smarty->assign("imgChart",$imgChart);
	$smarty->assign("graphId",$graphId);
	$smarty->assign('haveData',$haveData);
	$smarty->assign("actiLimit",$actiLimit);
	$smarty->assign("graphLoad",$graphLoad);
	

?>