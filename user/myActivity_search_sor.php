<?	require_once(CLASS_PATH."activity.cls.php");
	require_once(CLASS_PATH."clsPager.php");
	require_once(CLASS_PATH.'chart.cls.php');
include_once CLASS_PATH.'formatting.php'; //formating function
	$objGeneral->chekUserSessionExist();// check user session	
	$objActivity = new activity();
	$objChart = new chart('');
	$arrFilter = array();
	$sortType = "DESC";	
	$filter = $_POST['txtSearch'];
	if($_POST['txtSortType']!="")
	{
		$sortType = $_POST['txtSortType'];
	}
/****************************************************/
//	Code for paging 

	$pageno			=	$_POST['txtPage'];
	$limit		=	_NO_OF_RECORDS_PER_PAGE_;

	if($pageno=="")
		$pageno	=	1;

	$p				=	new Pager();
	$start		=	$p->findStart($limit,$pageno);
	$pageLimit	= " LIMIT ".$start.", ".$limit;

	$ROW = $objActivity->getUsersActivityWithCount($_SESSION["tz_user"]["userid"],"",$filter,$sortType);
	$TotalNumRow	=	$objActivity->db->num_rows;
	$startrecordno	=	$start + 1;
	$endrecordno	=	$start	+ $NumRow;

	$showingRrdHst	=	"<span class=\"pdL5\">".$lang_string['records']."<strong> $startrecordno - $endrecordno</strong> ".$lang_string['of']." <strong>$TotalNumRow</strong>";
	
	$p->getPageLimit($TotalNumRow,$limit,$pageno);	
	$pagelist	=	$p->varpageList;
	$totalPages = $p->toatalPages;

	$ROW = $objActivity->getUsersActivityWithCount($_SESSION["tz_user"]["userid"],$pageLimit,$filter,$sortType);
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
	$smarty->register_modifier("sanitize_title_with_dashes", "sanitize_title_with_dashes");
	$smarty->assign("err_msg",$err_msg);
	$smarty->assign("actCount",$actCount);
	$smarty->assign("ROW",$ROW);
	$smarty->assign("pagelist",$pagelist);
	$smarty->assign("FILER", $_SESSION['tmpFilter']);
	$smarty->assign("sortType",$sortType);
	$middle = "myActivity_search_sort.tpl";
	
?>