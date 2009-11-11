<? require_once(CLASS_PATH."activity.cls.php");
require_once(CLASS_PATH."user.cls.php");
require_once(CLASS_PATH."clsPager.php");
require_once(CLASS_PATH."/timezone/Date.php");
require_once(CLASS_PATH.'chart.cls.php');
$ownerFlag = 0;
$objActivity = new activity();
$objUser = new user();	
$objChart = new chart('');
$actId = $_REQUEST['editId'];

if($actId == ""){
	header("location:index.html");
}
 $retunFrom = $_POST['ACT'];
if($retunFrom == "VIEWFDATA")
	$url = "index.php?mod=myData";
elseif($retunFrom == "VIEWFACTI")
	$url = "index.php?mod=myActivity";

if($_POST['ACT'] == "DELETE")
{
	$objActivity->deleteMydata($_POST['dataId']);
	$err_msg = "<div><span class=\"error_div\">Record has been deleted successfully.</span></div>";
}
$ROW = $objActivity->getActivity($actId);

//Get user's Details
$ROWUSER = $objUser->getUserDetails($ROW['user_id']);
//print_r($ROWUSER);
//for composite activity.
if($ROW['activity_type'] == 1)
{
	$ROWSUBACTI = $objActivity->getRealatedActivity($ROW['graph_id']);
	
}

//*********** My Data ****************

	$ROWDATA = $objActivity->getUsersMyDataALL($ROW['id'],$ROW['activity_type'],$ROW['graph_id']);
	$ROWDATA = $objActivity->convertForWithAmtSig($ROWDATA);
	$actCount = "";
	if(is_array($ROWDATA))
	{
		$actCount = count($ROWDATA);
	}
//************************************
//Check if user id owner of activity.
if($_SESSION["tz_user"]["userid"] == $ROW["user_id"])
{
	$ownerFlag = 1;
}

$smarty->assign("ROW",$ROW);
$smarty->assign("ROWSUBACTI",$ROWSUBACTI);
$smarty->assign("ROWUSER",$ROWUSER);
$smarty->assign("ROWDATA",$ROWDATA);
$smarty->assign("err_msg",$err_msg);
$smarty->assign("actCount",$actCount);
$smarty->assign("pagelist",$pagelist);
$smarty->assign("ownerFlag",$ownerFlag);
$middle="activityDetails2.tpl";

$onLoad= $objActivity->returnChartJsFn($actId,$ROW['graph_type'],$ROW['dataOption']);

//$smarty->assign("onLoad",$onLoad);
$smarty->assign("fnGraph",$onLoad);

switch($ROW['graph_type']) {
    case 1:
        $legendClick = 'selectGraph';
        break;
    case 2:
        $legendClick = 'clickSlice';
        break;
    case 3:
        break;
    case 4:
        break;
    case 5:
        $legendClick = 'compareDataSet';
        break;
    case 6:
        break;
    case 7:
        break;
    case 8:
        break;
}
$smarty->assign("fnLegendClick", $legendClick);
if(!isset($_SESSION["tz_user"]["userid"]))
		$top = "home_header.tpl";
?>
