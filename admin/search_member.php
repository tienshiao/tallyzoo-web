<?PHP
/*****************************************************
Page Name: static_search.php
Purpose: Static search page
Created By: Mahesh L
Created On: Tuesday, December 30, 2008 4:15 PM
*****************************************************/
//require "../includes/common/common_functions.php";
require_once("sadm_login_chk.php");
require_once(CLASS_PATH."clsDataGrid.php");
$pgtitle = "";//&raquo; == 
$onload = "setAdminMenuActive('b'); document.getElementById('txtUsername').focus();";
$menu = $objGeneral->setAdminMenu($_SESSION['s_hdnFlag']);
$submenu= $objGeneral->fnBuildSubMenu("bottom_line");
$table = new clsDataGrid($dbObj);

/*****************************Datagrid code starts from here ***************************/
$pagevariable='admin'; //set page variable here ex: products
$cname	 = array("Username","email","Total Activity","Status","Actions");
$fldnames = array("username","email","totAct","status");
$cdbname = "m.id";
$unique_field = "id";
$cwidth  = array("35%","40%","20%","5%");							
if(!empty($_REQUEST['hidOrder']))
	$order=$_REQUEST['hidOrder'];
else
	$order='DESC';//asc or desc
if(!empty($_REQUEST['hidOrderBy']))
	$orderby=$_REQUEST['hidOrderBy'];//value
else
	$orderby='m.id';//value
$checkbox='1'; //if yes enter 1 or else enter 0.
$tabindex='';//set tab index here	
$div_id='member_grid';
$ajx_file = "admin_ajax.php?mod=ajx_member_search";
/****************************Action Icon code starts from here **********************/
$edit_icon ="<a href=\"#".$div_id."\" onClick=\"fnedit(', m.id ,');\">"._VIEWICON_."</a>";
$buttons = "<input class=\"btnSty\" type=\"button\" name=\"Delete\" value=\"Delete\" alt=\"Delete\" title=\"Delete\" border=\"0\" onClick=\"javascript:fnDelete('".$div_id."','".$ajx_file."')\"/>&nbsp;<input class=\"btnSty\" type=\"button\" name=\"Active/Inactive\" value=\"Active/Inactive\" alt=\"Active/Inactive\" title=\"Active/Inactive\" border=\"0\" onClick=\"javascript:fnStatus('".$div_id."','".$ajx_file."')\"/>";
$blocked_icon ="<img src=\""._SITEURL_."images/admin/block.gif\" border=\"0\" alt=\"Blocked\">";
$unblocked_icon ="<img src=\""._SITEURL_."images/admin/unblock.gif\" border=\"0\" alt=\"UnBlocked\">";
//echo "<pre>";
//print_R($_POST);
/***************************** Building search criteria condition ***************************/
 $condition = $objGeneral->fnBuildCondition('member_search');
/*******************************SQL Query starts here ************************************/

$sql = "SELECT m.username, m.email,  (select count(a.id) from activities a where a.user_id=m.id) as totAct, if (m.status='blocked', CONCAT('$blocked_icon'), CONCAT('$unblocked_icon')) as status, CONCAT('$edit_icon') as actions, m.id as id FROM users m where 1 $condition";

/*********************************SQL Query ends here*************************************/
$datagrid=$table->DataGrid($sql,$pagevariable,$recs_per_page,$order,$orderby,$cname,$cdbname,$cwidth,$unique_field,$checkbox,$buttons,$tabindex,$div_id,$fldnames,$ajx_file);
/*****************************Datagrid code ends here **********************************/

$Title=$_REQUEST['txtTitle'];
if($_REQUEST['chkActive']=='on')
	$chkActive="checked";
if($_REQUEST['chkInactive']=='on')
	$chkInactive="checked";
//$submenu=fnBuildSubMenu("static_search");
$smarty->assign(array("PAGETITLE"			=> $pgtitle,
					  "ONLOAD"				=> $onload,
					  "MENU"				=> $menu,
					  "SUBMENU"				=> $submenu,					  
					  "TITLE"				=> htmlentities($Title),
					  "CHKACTIVE"			=> $chkActive,
					  "CHKINACTIVE"			=> $chkInactive,
					  "DATAGRID"			=> $datagrid
					   ));
$middle="search_member.tpl";
//$smarty->display("admin/search_member.tpl");
?>