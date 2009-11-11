<?PHP
/*****************************************************
Page Name: static_search.php
Purpose: Static search page
Created By: Mahesh L
Created On: Tuesday, December 30, 2008 4:15 PM
*****************************************************/
require_once("sadm_login_chk.php");
require_once(CLASS_PATH."admin_StaticPage.cls.php");
require_once(CLASS_PATH."clsDataGrid.php");
require_once("FCKeditor/fckeditor.php") ;

$table=new clsDataGrid($dbObj);
$objStaticPage=new StaticPage($dbObj);

$pgtitle = "";
$onload = "setAdminMenuActive('c'); document.getElementById('txtTitle').focus();";
if($_SESSION['s_hdnFlag'])
{
	// ***************************************Menu
	$menu = $objGeneral->setAdminMenu($_SESSION['s_hdnFlag']);
	$submenu = $objGeneral->fnBuildSubMenu("bottom_line");
	//**************************************** Fck Editor
	$oFCKeditor = new FCKeditor('txaDesc');
	$oFCKeditor->BasePath = 'FCKeditor/';
	if($_POST['pgaction']=='editview')
	{
		$row=$objStaticPage->fnGetAll($_POST['staticid']);
		$oFCKeditor->Value = $objGeneral->decodequotes($row[0]['fldDescription']);
		if(empty($row['fldStaticPageId']))
		{
			$staticid=$_POST['staticid'];	
		}
		else
		{
			$staticid=$row['fldStaticPageId'];		
		}
		$staticPagesDropdown= $objGeneral->fnstaticPage($staticid);
	}
	elseif($_POST['pgaction']=='edit')
	{
		$objStaticPage->Populate();
		$objStaticPage->fnUpdatePages($_POST['staticid']);
		$staticPagesDropdown= $objGeneral->fnstaticPage($_POST['staticid']);

		$siteurl=_SITEURL_."admin.php?mod=static_search";
		header("Location: $siteurl&act_id=2");
		exit;
	}
	else
	{
		$staticPagesDropdown= $objGeneral->fnstaticPage($_POST['staticid']);
	}
	$textarea=$oFCKeditor->Create() ;
}

$smarty->assign(array("PAGETITLE"			=> $pgtitle,
					  "ONLOAD"				=> $onload,
					  "MENU"				=> $menu,
					  "SUBMENU"				=> $submenu,
					  "STATICPAGEDROPDOWN"	=> $staticPagesDropdown,
					  "TITLE"				=> htmlentities( $objGeneral->decodequotes($row[0]['fldTitle'])),
					  "STATUS"				=> $row[0]['fldStatus'],
					  "DESC_TEXTAREA"		=> $textarea,
					  "CHKACTIVE"			=> $chkActive,
					  "CHKINACTIVE"			=> $chkInactive,
					  "staticid"			=> $staticid,
					  "DATAGRID"			=> $datagrid
					   ));
$middle="static_page.tpl";
//$smarty->display("admin/static_page.tpl");
?>