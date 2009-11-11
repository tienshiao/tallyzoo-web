<?	require_once(CLASS_PATH."activity.cls.php");
	require_once(CLASS_PATH."clsPager.php");
	require_once(CLASS_PATH."timezone/Date.php");
	$found = 0;
	$rdochk = "every";
	if(isset($_SESSION["tz_user"]["userid"]))
	{
		$rdochk = "only";
	}

	if($_POST["ACT"] == "search" || $_GET['searchKeyVal'] !="")
	{ 
		$objActivity = new activity();
		if($_POST["txtSearchKey"] != ""){
			$searchKey = $_POST["txtSearchKey"];
		}elseif($_GET['searchKeyVal'] !="")
		{
			$searchKey = $_GET['searchKeyVal'];
		}
		//$ROW = $objActivity->seachUserActivty($searchKey);
		$rdochk = $_POST['rdoOnlyEvery'] ;
			
	
		/****************************************************/
		//	Code for paging 
			$pageno			=	$_POST['txtPage'];
			$limit		=	_NO_OF_RECORDS_PER_PAGE_;

			if($pageno=="")
				$pageno	=	1;

			$p				=	new Pager();
			$start		=	$p->findStart($limit,$pageno);
			$pageLimit	= " LIMIT ".$start.", ".$limit;

			$ROW = $objActivity->seachUserActivty($searchKey);
			$TotalNumRow	=	$objActivity->db->num_rows;
			$startrecordno	=	$start + 1;
			$endrecordno	=	$start	+ $NumRow;

			$showingRrdHst	=	"<span class=\"pdL5\">".$lang_string['records']."<strong> $startrecordno - $endrecordno</strong> ".$lang_string['of']." <strong>$TotalNumRow</strong>";
			
			$p->getPageLimit($TotalNumRow,$limit,$pageno);	
			$pagelist	=	$p->varpageList;
			$totalPages = $p->toatalPages;
			$ROW = $objActivity->seachUserActivty($searchKey,$pageLimit);
			$ROW = $objActivity->convertForWithAmtSig($ROW);

		//************************

		if(is_array($ROW))
		{
			$found = count($ROW);
		}
		
	}

	$smarty->assign("error_msg",$msg);
	$smarty->assign("actCount",$found);
	$smarty->assign("ROW",$ROW);
	$smarty->assign("pagelist",trim($pagelist));
	$smarty->assign("rdochk",$rdochk);
	$smarty->assign("searchKey",$searchKey);
	$prefix="Search Activity | User Page";	
	$middle="search.tpl";
	if(!isset($_SESSION["tz_user"]["userid"]))
		$top = "home_header.tpl";
?>