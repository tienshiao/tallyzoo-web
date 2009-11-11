<?	require_once(CLASS_PATH."activity.cls.php");
	require_once(CLASS_PATH."clsPager.php");
	$objGeneral->chekUserSessionExist();// check user session	
	$objActivity = new activity();
	if($_POST['ACT'] == "DELETE")
	{
		$objActivity->deleteMydata($_POST['editId']);
		$err_msg = "Record has been deleted successfully.";

	}
	//	Code for paging 
	$pageno			=	$_POST['txtPage'];
	$limit		=	_NO_OF_RECORDS_PER_PAGE_;

	if($pageno=="")
		$pageno	=	1;

	$p				=	new Pager();
	$start		=	$p->findStart($limit,$pageno);
	$pageLimit	= " LIMIT ".$start.", ".$limit;

	$ROW = $objActivity->getUsersMyData($_SESSION["tz_user"]["userid"]);
	$TotalNumRow	=	$objActivity->db->num_rows;
	$startrecordno	=	$start + 1;
	$endrecordno	=	$start	+ $NumRow;

	$showingRrdHst	=	"<span class=\"pdL5\">".$lang_string['records']."<strong> $startrecordno - $endrecordno</strong> ".$lang_string['of']." <strong>$TotalNumRow</strong>";
	
	$p->getPageLimit($TotalNumRow,$limit,$pageno);	
	$pagelist	=	$p->varpageList;
	$totalPages = $p->toatalPages;

	$ROW = $objActivity->getUsersMyData($_SESSION["tz_user"]["userid"],$pageLimit);
	$ROW = $objActivity->convertForWithAmtSig($ROW);
	
	$actCount = "";
	if(is_array($ROW))
	{
		$actCount = count($ROW);
	}
	$smarty->assign("err_msg",$err_msg);
	$smarty->assign("actCount",$actCount);
	$smarty->assign("ROW",$ROW);
	$smarty->assign("pagelist",$pagelist);
	$middle = "myData.tpl";
	
?>