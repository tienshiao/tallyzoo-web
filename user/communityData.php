<?	require_once(CLASS_PATH."activity.cls.php");
	require_once(CLASS_PATH."clsPager.php");
	require_once(CLASS_PATH."timezone/Date.php");
	$found = 0;
	//$rdochk = "every";
   // print_r($_POST);

	

		$objActivity = new activity();
		$searchKey = $_POST["hidFilter"];
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

			$ROW = $objActivity->searchCommunityData($searchKey);
			$TotalNumRow	=	$objActivity->db->num_rows;
			$startrecordno	=	$start + 1;
			$endrecordno	=	$start	+ $NumRow;

			$showingRrdHst	=	"<span class=\"pdL5\">".$lang_string['records']."<strong> $startrecordno - $endrecordno</strong> ".$lang_string['of']." <strong>$TotalNumRow</strong>";
			
			$p->getPageLimit($TotalNumRow,$limit,$pageno);	
			$pagelist	=	$p->varpageList;
			$totalPages = $p->toatalPages;
			$ROW = $objActivity->searchCommunityData($searchKey,$pageLimit);
			$ROW = $objActivity->convertForWithAmtSig($ROW);
          //  echo "<pre>";
   //print_r($ROW);
		//************************

		if(is_array($ROW))
		{
			$found = count($ROW);
		}
		


	$smarty->assign("error_msg",$msg);
	$smarty->assign("actCount",$found);
	$smarty->assign("ROW",$ROW);
	$smarty->assign("pagelist",trim($pagelist));
//	$smarty->assign("rdochk",$rdochk);
	
	$middle="communityData.tpl";
	if(!isset($_SESSION["tz_user"]["userid"]))
		$top = "home_header.tpl";
?>