<?PHP
/*****************************************************
Page Name: static_search.php
Purpose: Static search page
Created By: Mahesh L
Created On: Tuesday, December 30, 2008 4:15 PM
*****************************************************/
require_once("sadm_login_chk.php");
require_once(CLASS_PATH."clsDataGrid.php");
$table=new clsDataGrid($dbObj);

$pgtitle = "";//&raquo; == 
$onload = "setAdminMenuActive('c');";
$menu = $objGeneral->setAdminMenu($_SESSION['s_hdnFlag']);
if($_GET['act_id']==2)
{
	$err_msg = "Record updated successfully!";			
	$smarty->assign("err_msg", $err_msg);
}

/*****************************Datagrid code starts from here ***************************/
$pagevariable='admin'; //set page variable here ex: products
$cname	 = array("Page","Title","Status","Actions");
$fldnames = array("fldStaticPageName","fldTitle","fldStatus");
$cdbname = "spd.fldStaticPageId";
$unique_field = "fldDescriptionId";
$cwidth  = array("35%","20%","40%","5%");							
if(!empty($_REQUEST['hidOrder']))
	$order=$_REQUEST['hidOrder'];
else
	$order='DESC';//asc or desc
if(!empty($_REQUEST['hidOrderBy']))
	$orderby=$_REQUEST['hidOrderBy'];//value
else
	$orderby='spd.fldDescriptionId';//value
$checkbox='0'; //if yes enter 1 or else enter 0.
$tabindex='';//set tab index here	
$div_id='static_grid';
$ajx_file = "admin_ajax.php?mod=ajx_static_search";
/****************************Action Icon code starts from here **********************/
$edit_icon ="<a href=\"#".$div_id."\" onClick=\"fnedit(', spd.fldStaticPageId ,');\">"._EDITICON_."</a>";
//$buttons = "<input class=\"btnSty\" type=\"button\" name=\"Delete\" value=\"Delete\" alt=\"Delete\" title=\"Delete\" border=\"0\" onClick=\"javascript:fnDelete('".$div_id."','".$ajx_file."')\"/>&nbsp;<input class=\"btnSty\" type=\"button\" name=\"Active/Inactive\" value=\"Active/Inactive\" alt=\"Active/Inactive\" title=\"Active/Inactive\" border=\"0\" onClick=\"javascript:fnStatus('".$div_id."','".$ajx_file."')\"/>";
/***************************** Building search criteria condition ***************************/
 $condition= $objGeneral->fnBuildCondition('static_search');
/*******************************SQL Query starts here ************************************/
 $sql = "SELECT sp.fldStaticPageName,spd.fldTitle,CONCAT(UCASE(MID(spd.fldStatus,1,1)),MID(spd.fldStatus,2)) AS fldStatus,CONCAT('$edit_icon') as actions,spd.fldDescriptionId as fldDescriptionId FROM descriptions spd, staticpages sp $condition";
/*********************************SQL Query ends here*************************************/
 $datagrid=$table->DataGrid($sql,$pagevariable,$recs_per_page,$order,$orderby,$cname,$cdbname,$cwidth,$unique_field,$checkbox,$buttons,$tabindex,$div_id,$fldnames,$ajx_file, 0);
/*****************************Datagrid code ends here **********************************/

//$staticPagesDropdown= $objGeneral->fnstaticPage($_REQUEST['cmbStaticPage']);
$Title=$_REQUEST['txtTitle'];
if($_REQUEST['chkActive']=='on')
	$chkActive="checked";
if($_REQUEST['chkInactive']=='on')
	$chkInactive="checked";
$submenu= $objGeneral->fnBuildSubMenu("bottom_line");
$smarty->assign(array("PAGETITLE"			=> $pgtitle,
					  "ONLOAD"				=> $onload,
					  "MENU"				=> $menu,
					  "SUBMENU"				=> $submenu,
					  "STATICPAGEDROPDOWN"	=> $staticPagesDropdown,
					  "TITLE"				=> htmlentities($Title),
					  "CHKACTIVE"			=> $chkActive,
					  "CHKINACTIVE"			=> $chkInactive,
					   "cmbStaticPage"			=> $_REQUEST['cmbStaticPage'],
					  "DATAGRID"			=> $datagrid
					   ));
$middle="static_search.tpl";
?>