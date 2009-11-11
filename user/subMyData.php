<? require_once(CLASS_PATH."activity.cls.php");
require_once(CLASS_PATH."user.cls.php");
require_once(CLASS_PATH."clsPager.php");
$ownerFlag = 0;
$objActivity = new activity();
$objUser = new user();	
$actId = $_POST['actiId'];

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

$smarty->assign("actCount",$actCount);
$smarty->assign("ownerFlag",$ownerFlag);
$middle="subMyData.tpl";



?>