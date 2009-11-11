<?PHP
/*****************************************************
Page Name: static_search.php
Purpose: Static search page
Created By: Mahesh L
Created On: Tuesday, December 30, 2008 4:15 PM
*****************************************************/


require_once("FCKeditor/fckeditor.php") ;
$pgtitle = "";
$onload = "setAdminMenuActive('d'); document.getElementById('txtAdminEmailAddress').focus();";
if($_SESSION['s_hdnFlag'])
{
	// ***************************************Menu
	$menu = $objGeneral->setAdminMenu($_SESSION['s_hdnFlag']);
	$submenu = $objGeneral->fnBuildSubMenu("bottom_line");
	//**************************************** Fck Editor
	
	if($_POST['pgaction']=='edit')
	{
		foreach($_POST as $k=>$v)
		{
			$$k = $objGeneral->encodequotes($v);
		}
		$sql = "Update settings set adimEmailAddress=\"$txtAdminEmailAddress\",siteTitle=\"$txtSiteTitle\",freeVersion=\"$txtVersion\",noOfChartsForFree=\"$txtNoChartsForFree\",noOfChartsForPremium=\"$txtNoChartsForPremium\",  	noOfDashBoardForFree=\"$txtNoOfDashBoardForFree\",noOfDashBoardForPremium=\"$txtNoOfDashBoardForPremium\",noOfRecordPerPage=\"$txtNoOfRecordsPerPage\",noOfPagesPerList=\"$txtOfPagesList\",metaKeyWords=\"$txtMetaKeywords\",metaDescription=\"$txtMetaDesc\",noOfActiForCombo=\"$txtNoOfActiForCombo\" where id='1'";
		$dbObj->Query($sql);
		$msg = "Settings Edited Successfully.";
		//$err_msg = "Settings Edited Successfully.";			
		//$smarty->assign("err_msg", $err_msg);
	}

	$sql = "SELECT * FROM settings WHERE id='1'";
	$result = $dbObj->select($sql);
	

	
}
$smarty->assign(array("PAGETITLE"			=> $pgtitle,
					  "ONLOAD"				=> $onload,
					  "MENU"				=> $menu,
					  "SUBMENU"				=> $submenu,
					  "msg"                 =>$msg,
					  "ROW"                 =>$result
					  
					   ));
$middle="settings.tpl";
//$smarty->display("admin/settings.tpl");
?>