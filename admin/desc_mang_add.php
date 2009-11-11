<?PHP
/*****************************************************
Page Name: static_search.php
Purpose: Static search page
Created By: Mahesh L
Created On: Tuesday, December 30, 2008 4:15 PM
*****************************************************/
session_cache_limiter('private, must-revalidate');
session_start();
require "../includes/common/common.php";
require "../includes/common/common_functions.php";
require_once("../includes/common/sadm_login_chk.php");
require_once("../classes/admin/clsStaticPage.php");
require_once("../FCKeditor/fckeditor.php") ;
$pgtitle = "";
$onload = "document.getElementById('selpage').focus();";
$objStaticPage=new StaticPage();
if($_SESSION['s_hdnFlag'])
{
	// ***************************************Menu
	$menu = setAdminMenu($_SESSION['s_hdnFlag']);
	$submenu=fnBuildSubMenu("search_desc");
	//**************************************** Fck Editor
	$oFCKeditor = new FCKeditor('txaDesc');
	$oFCKeditor->BasePath = 'FCKeditor/';

	if($_REQUEST['pgaction']=='editview')
	{
		$userType=$_REQUEST['hdnUType'];
		if(empty($userType))
					$userType=$_REQUEST['rd1'];
		$row=$objStaticPage->fnGetAlldesc($_REQUEST['staticid'],$userType);
		
		$oFCKeditor->Value = decodequotes($row['fldDescription']);
		if(empty($row['fldStaticPageId']))
			$staticid=$_REQUEST['staticid'];
		else
			$staticid=$row['fldStaticPageId'];	
		$staticPagesDropdown=fnsearchdesccombo($userType,$staticid);

	}
	elseif($_REQUEST['pgaction']=='change_view')
	{
		$row=$objStaticPage->fnGetAlldesc($_REQUEST['staticttid'],$_REQUEST['rd1']);
		$userType=$_REQUEST['hdnUType1'];
		if(empty($userType))
					$userType=$_REQUEST['rd1'];
		if(empty($row['fldStaticPageId']))
			$staticid=$_REQUEST['staticttid'];
		else
			$staticid=$row['fldStaticPageId'];	
		$oFCKeditor->Value = decodequotes($row['fldDescription']);
	//	$showdesc=fnsearchdescLL($userType,$staticid);		
	$staticPagesDropdown=fnsearchdesccombo($_REQUEST['rd1'],$staticid);

	}
	elseif($_POST['pgaction']=='edit')
	{
		$objStaticPage->Populate();
		$objStaticPage->fnUpdatePages($_REQUEST['staticid']);
		$siteurl=_SITEURL_."SearchDesc";
		header("Location: $siteurl?act_id=2");
		exit;
	}
	else
	{
		$staticPagesDropdown=fnsearchdesccombo(3);
		$userType=3;
	}
	$textarea=$oFCKeditor->Create() ;
}
$smarty->assign(array("PAGETITLE"			=> $pgtitle,
									  "ONLOAD"				=> $onload,
									  "MENU"				=> $menu,
									  "SUBMENU"				=> $submenu,
									  "STATICPAGEDROPDOWN"	=> $staticPagesDropdown,
									  "TITLE"				=> htmlentities(decodequotes($row['fldTitle'])),
									  "USERTYPE"		    => $userType,
									  "STATUS"				=> $row['fldStatus'],
									  "DESC_TEXTAREA"		=> $textarea,
									  "CHKACTIVE"			=> $chkActive,
									  "CHKINACTIVE"			=> $chkInactive,
									  "DATAGRID"			=> $datagrid
						   ));

$smarty->display("admin/desc_mang_add.tpl");
?>