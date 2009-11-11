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
$onload = "setAdminMenuActive('e'); document.getElementById('txtPage').focus();";
if($_SESSION['s_hdnFlag'])
	$menu = $objGeneral->setAdminMenu($_SESSION['s_hdnFlag']);

/*****************************Datagrid code starts from here ***************************/
$pagevariable='admin'; //set page variable here ex: products
$cname	 = array("Page","UserType","Status","Actions");
$fldnames = array("fldStaticPageName","fldUserTypeId","fldStatus");
$cdbname = "spd.fldStaticPageId";
$unique_field = "fldDescriptionId";
$cwidth  = array("40%","20%","20%","10%");							
if(!empty($_REQUEST['hidOrder']))
	$order=$_REQUEST['hidOrder'];
else
	$order='DESC';//asc or desc
if(!empty($_REQUEST['hidOrderBy']))
	$orderby=$_REQUEST['hidOrderBy'];//value
else
	$orderby='spd.fldDescriptionId';//value
$checkbox='1'; //if yes enter 1 or else enter 0.
$tabindex='';//set tab index here	
$div_id='desc_grid';
$ajx_file = "admin/ajx_search_desc_mang.php";
/****************************Action Icon code starts from here **********************/
$edit_icon ="<a href=\"#".$div_id."\" onClick=\"fnedit(', spd.fldStaticPageId ,',',spd.fldUserTypeId,');\">"._EDITICON_."</a>";

$buttons = "<input class=\"btnSty\" type=\"button\" name=\"Delete\" value=\"Delete\" alt=\"Delete\" title=\"Delete\" border=\"0\" onClick=\"javascript:fnDelete('".$div_id."','".$ajx_file."')\"/>&nbsp;<input class=\"btnSty\" type=\"button\" name=\"Active/Inactive\" value=\"Active/Inactive\" alt=\"Active/Inactive\" title=\"Active/Inactive\" border=\"0\" onClick=\"javascript:fnStatus('".$div_id."','".$ajx_file."')\"/>";
/***************************** Building search criteria condition **********************/
 $condition= $objGeneral->fnBuildCondition('search_desc');
/***************************** Building search criteria condition **********************/
/*******************************SQL Query starts here **********************************/
 $sql = "SELECT sp.fldStaticPageName,(IF(spd.fldUserTypeId=3,'Landlord',(IF(spd.fldUserTypeId=4,'Tenant',''))))AS fldUserTypeId,CONCAT(UCASE(MID(spd.fldStatus,1,1)),MID(spd.fldStatus,2)) AS fldStatus,CONCAT('$edit_icon') as actions,spd.fldDescriptionId as fldDescriptionId FROM descriptions spd, staticpages sp $condition";
/*********************************SQL Query ends here***********************************/
 $datagrid=$table->DataGrid($sql,$pagevariable,$recs_per_page,$order,$orderby,$cname,$cdbname,$cwidth,$unique_field,$checkbox,$buttons,$tabindex,$div_id,$fldnames,$ajx_file);
/*****************************Datagrid code ends here **********************************/
$staticPagesDropdown= $objGeneral->fnsearchdesccombo($_REQUEST['cmbStaticPage']);
$Title=$_REQUEST['txtTitle'];


if($_REQUEST['chkActive']=='on')
	$chkActive="checked";
if($_REQUEST['chkInactive']=='on')
	$chkInactive="checked";
$submenu= $objGeneral->fnBuildSubMenu("search_desc");

$smarty->assign(array("PAGETITLE"			=> $pgtitle,
					  "ONLOAD"				=> $onload,
					  "MENU"				=> $menu,
					  "SUBMENU"				=> $submenu,
					  "STATICPAGEDROPDOWN"	=> $staticPagesDropdown,
					  "TITLE"				=> htmlentities($Title),
					  "CHKACTIVE"			=> $chkActive,
					  "CHKINACTIVE"			=> $chkInactive,
					  "DATAGRID"			=> $datagrid
					   ));
$middle="search_desc_mang.tpl";
//$smarty->display("admin/search_desc_mang.tpl");
?>