<?
    include_once '../system/configme/siteconfig.php';
	$path = str_replace("user/","",CLASS_PATH);
	require_once($path."activity.cls.php");
	require_once($path."dbclass.php");
	require($path."chart.cls.php");
	$objGeneral->chekUserSessionExist();// check user session	
	$dbObj = new dbclass(); // db object
	$objChart = new chart("../");
	$objActivity = new activity();
	$currentUserId=$_SESSION["tz_user"]["userid"];
	$columnArr1 = array();
	$columnArr2 = array();
	
	if($currentUserId > 0){
		$ROW = $objActivity->getDashboardActivityGraph($currentUserId);
        $selectedActi = $objActivity->selectDashboardValues($currentUserId);
     	$strIds = $objActivity->selectGraphPosition(1);
		
		if($strIds != '0')
		{  
			$arrIds = explode("###",$strIds);		
			if(count($arrIds) >0){ 
				if(trim($arrIds[0]) !=""){
					$ROW1 = $objActivity->getDashboardActivityGraph($currentUserId,$arrIds[0]);
				}
			
			}
			if(count($arrIds) >1){
				if(trim($arrIds[1]) !=""){
					$ROW2 = $objActivity->getDashboardActivityGraph($currentUserId,$arrIds[1]);
				}
			
			}
		}else{ 
			$cnt = 0;
			foreach($ROW as $key=>$val)
			{
				if($cnt <2){
					$ROW1[] = $val;
				}
				else{
					$ROW2[] = $val;
				}
				$cnt++;
			}
		}

        $i=0;
		
        foreach($ROW1 as $key=>$value)
		{
				 $i++;
				$ROWS =$value;   
				$RESULT1[]=$value; 
				$opt = $ROWS['dataOption'];
				$graphType = $ROWS['graph_type'];
				$activityId= $ROWS['id'];
				$goal=$ROWS['goal'];
				$divId = dashboardGraph_.$activityId;
				if($opt > 0){ 

				$fnJs= $objActivity->returnChartJsFn($activityId,$graphType,$opt);

				if(strlen($fnJs) > 1){
				$fnJs = substr($fnJs,0,-1);
				//	$arrGraphFun[] =  "dashboard_" ."$fnJs" .",'$divId');";
				$arrGraphFun[] =  "dashboard_" ."$fnJs" .",'$goal','$divId');";

				}

				}
          
          
        }
		foreach($ROW2 as $key=>$value)
		{
				 $i++;
				$ROWS =$value;   
				$RESULT2[]=$value; 
				$opt = $ROWS['dataOption'];
				$graphType = $ROWS['graph_type'];
				$activityId= $ROWS['id'];
				$goal=$ROWS['goal'];
				$divId = dashboardGraph_.$activityId;
				if($opt > 0){ 

				$fnJs= $objActivity->returnChartJsFn($activityId,$graphType,$opt);

				if(strlen($fnJs) > 1){
				$fnJs = substr($fnJs,0,-1);
				//	$arrGraphFun[] =  "dashboard_" ."$fnJs" .",'$divId');";
				$arrGraphFun[] =  "dashboard_" ."$fnJs" .",'$goal','$divId');";

				}

				}
          
          
        }
 
	}

   $onLoad = implode($arrGraphFun,""); 
  if($i == 0)
	{ 
		$onLoad="fnPopupDiv('550', '200', '30', '40', 'dashboardNoGraph', 'Dashboard','');";
	}	
//for show blank block
$totalGraphCnt = count($RESULT1) + count($RESULT2);
$chkFlag = 0;
for($i=count($RESULT1);$i<=4-$totalGraphCnt;$i++)
{
	if(count($RESULT1) <2){
		$RESULT1[] = array();
		$chkFlag++;
		$totalGraphCnt = count($RESULT1) + count($RESULT2);
	}
}

$totalGraphCnt = count($RESULT1) + count($RESULT2);
$chkFlag=0;
for($i=count($RESULT2);$i<=4-$totalGraphCnt;$i++)
{
	if(count($RESULT2) <2){
	$RESULT2[] = array();
	$chkFlag++;
	$totalGraphCnt = count($RESULT1) + count($RESULT2);
	}
}

/*if(count($RESULT1) ==0)
{
	$RESULT1[] = array();
	$RESULT1[] = array();
}elseif(count($RESULT1) ==1)
{
	$RESULT1[] = array();
}

if(count($RESULT2) ==0)
{
	$RESULT2[] = array();
	$RESULT2[] = array();
}elseif(count($RESULT2) ==1)
{
	$RESULT2[] = array();
}*/
//end of blank block
$smarty->assign("err_msg",$err_msg);
$smarty->assign("onLoad",$onLoad);
$smarty->assign("RESULT1",$RESULT1);
$smarty->assign("RESULT2",$RESULT2);
$smarty->assign("SELECTED",$selectedActi);
$middle="dashboard.tpl";
?>
