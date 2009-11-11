<?	require_once(CLASS_PATH."activity.cls.php");
	require_once(CLASS_PATH."clsPager.php");
	require_once(CLASS_PATH.'chart.cls.php');
	$objGeneral->chekUserSessionExist();// check user session	
	$objActivity = new activity();
	$objChart = new chart('');
	$arrFilter = array();
	$sortType = "DESC";	
	$filter = $_GET['s'];
	if($_POST['ACT'] == "DELETE")
	{   unset($_SESSION['tmpFilter']);
		$objActivity->deleteActivity($_POST['editId']);
		$err_msg = "Your activity has been deleted successfully.";
	}
	
	//$ROW = $objActivity->getUsersActivityWithCount($_SESSION["tz_user"]["userid"]);
	//$ROW = $objActivity->convertForWithAmtSig($ROW);

/****************************************************/
//	Code for paging 
	$pageno			=	$_POST['txtPage'];
	$limit		=	_NO_OF_RECORDS_PER_PAGE_;

	if($pageno=="")
		$pageno	=	1;

	$p				=	new Pager();
	$start		=	$p->findStart($limit,$pageno);
	$pageLimit	= " LIMIT ".$start.", ".$limit;

	$ROW = $objActivity->getUsersActivityWithCount($_SESSION["tz_user"]["userid"],"",$filter);
	$TotalNumRow	=	$objActivity->db->num_rows;
	$startrecordno	=	$start + 1;
	$endrecordno	=	$start	+ $NumRow;

	$showingRrdHst	=	"<span class=\"pdL5\">".$lang_string['records']."<strong> $startrecordno - $endrecordno</strong> ".$lang_string['of']." <strong>$TotalNumRow</strong>";
	
	$p->getPageLimit($TotalNumRow,$limit,$pageno);	
	$pagelist	=	$p->varpageList;
	$totalPages = $p->toatalPages;

	$ROW = $objActivity->getUsersActivityWithCount($_SESSION["tz_user"]["userid"],$pageLimit,$filter);
	$ROW = $objActivity->convertForWithAmtSig($ROW);

//************************

	
	$actCount = "";
	if(is_array($ROW))
	{
		$actCount = count($ROW);
	}
	$msgId = $_GET["msg"];
	if($msgId == 1)
	{
		$err_msg = "Your activity has been added successfully.";
	}elseif($msgId == 2)
	{
		$err_msg = "Your activity has been updated successfully.";
	}
	if(!isset($_SESSION['tmpFilter'])){
			 $_SESSION['tmpFilter'] = $arrFilter;
	}
	if($_POST['txtSortType']!="")
	{
		$sortType = $_POST['txtSortType'];
	}
	$smarty->assign("err_msg",$err_msg);
	$smarty->assign("actCount",$actCount);
	$smarty->assign("ROW",$ROW);
	$smarty->assign("pagelist",$pagelist);
	$smarty->assign("FILER", $_SESSION['tmpFilter']);
	$smarty->assign("sortType",$sortType);
	$middle = "myActivity.tpl";
	
?>