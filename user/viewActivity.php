<? 
require_once(CLASS_PATH."activity.cls.php");
$objGeneral->chekUserSessionExist();// check user session
$objActivity = new activity();
	
$actId = $_POST['editId'];
 $retunFrom = $_POST['ACT'];
if($retunFrom == "VIEWFDATA")
	$url = "index.php?mod=myData";
elseif($retunFrom == "VIEWFACTI")
	$url = "index.php?mod=myActivity";

$ROW = $objActivity->getActivity($actId);

if($ROW['activity_type'] == 1)
{
	$ROWSUBACTI = $objActivity->getRealatedActivity($ROW['graph_id']);
	
}
$smarty->assign("ROW",$ROW);
$smarty->assign("ROWSUBACTI",$ROWSUBACTI);
$smarty->assign("BACKURL",$url);
$middle="viewActivity.tpl";

?>