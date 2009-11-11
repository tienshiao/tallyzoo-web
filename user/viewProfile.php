<?	require_once(CLASS_PATH."activity.cls.php");
    require_once(CLASS_PATH."user.cls.php");
	require_once(CLASS_PATH."clsManageImages.php");
	require_once(CLASS_PATH."clsPager.php");
	require_once(CLASS_PATH."timezone/Date.php");
	//$objGeneral->chekUserSessionExist();// check user session	
    
	$objActivity = new activity();
	$arrFilter = array();
    $objUser = new user();
	$objImage = new clsManageImages();
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
    
	$ROW = $objActivity->getUsersActivityProfile($_GET['userId'],"",$filter);
	$TotalNumRow	=	$objActivity->db->num_rows;
	$startrecordno	=	$start + 1;
	$endrecordno	=	$start	+ $NumRow;

	$showingRrdHst	=	"<span class=\"pdL5\">".$lang_string['records']."<strong> $startrecordno - $endrecordno</strong> ".$lang_string['of']." <strong>$TotalNumRow</strong>";
	
 	$p->getPageLimit($TotalNumRow,$limit,$pageno);	
	$pagelist	=	$p->varpageList;
	$totalPages = $p->toatalPages;

	$ROW = $objActivity->getUsersActivityProfile($_GET['userId'],$pageLimit,$filter);
	$ROW = $objActivity->convertForWithAmtSig($ROW);
    //$ROW = $objActivity->seachUserActivity($searchKey,$pageLimit);
    //$ROW = $objActivity->convertForWithAmtSig($ROW);
    $DETAILS = $objUser->getUserDetails($_GET['userId']);
    //print ($DETAILS[imagename]);
   
 
   

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
	$smarty->assign("err_msg",$err_msg);
	$smarty->assign("actCount",$actCount);
	$smarty->assign("ROW",$ROW);
    $smarty->assign("DETAILS",$DETAILS);
    
	$smarty->assign("pagelist",$pagelist);
	$smarty->assign("FILER", $_SESSION['tmpFilter']);
	$middle = "viewProfile.tpl";
	if(!isset($_SESSION["tz_user"]["userid"]))
		$top = "home_header.tpl";
	
?>