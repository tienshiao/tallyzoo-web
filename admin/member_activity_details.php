<?PHP
/*****************************************************
Page Name: static_search.php
Purpose: Static search page
Created By: Mahesh L
Created On: Tuesday, December 30, 2008 4:15 PM
*****************************************************/
require_once("sadm_login_chk.php");
require_once(CLASS_PATH."clsDataGrid.php");

if ($_REQUEST['act']!="")
	$action = $_REQUEST['act'];
else
	$action = "md";
$onload = "setAdminMenuActive('b');";

switch($action)
{
	case "md":
		$pgtitle = "Member Details";//&raquo; == 
		$menu = $objGeneral->setAdminMenu($_SESSION['s_hdnFlag']);
		$submenu= $objGeneral->fnBuildSubMenu("member_details");
		$row = $objGeneral->getMemberDetails($_REQUEST['mid']);
		$smarty->assign(array("PAGETITLE"			=> $pgtitle,
					  "ONLOAD"				=> $onload,
					  "MENU"				=> $menu,
					  "SUBMENU"				=> $submenu,
					  "msg"                 =>$msg,
					  "ROW"                 =>$row					  
					   ));
		$middle="member_details.tpl";
		//$smarty->display("admin/member_details.tpl");
		break;
	
	case "mad":
	default:
		$pgtitle = "Member Activity Details";//&raquo; == 
		$menu = $objGeneral->setAdminMenu($_SESSION['s_hdnFlag']);
		$submenu= $objGeneral->fnBuildSubMenu("member_activity_details");
		$table=new clsDataGrid($dbObj);
		/*****************************Datagrid code starts from here ***************************/
		$pagevariable='admin'; //set page variable here ex: products
		$cname	 = array("Activity Name","Note","Tags","Counts","Status","Actions");
		$fldnames = array("name","default_note","tags","totDf","status");
		$cdbname = "a.id";
		$unique_field = "id";
		$cwidth  = array("25%","35%","25%","5%","5%");
		if(!empty($_REQUEST['hidOrder']))
			$order=$_REQUEST['hidOrder'];
		else
			$order='DESC';//asc or desc
		if(!empty($_REQUEST['hidOrderBy']))
			$orderby=$_REQUEST['hidOrderBy'];//value
		else
			$orderby='a.id';//value
		$checkbox='1'; //if yes enter 1 or else enter 0.
		$tabindex='';//set tab index here	
		$div_id='activity_grid';
		$ajx_file = "admin_ajax.php?mod=ajx_member_activity_details";
		//ajx_member_activity_details.php?mid=".$_REQUEST['mid'];
		/****************************Action Icon code starts from here **********************/
		$edit_icon ="<a href=\"javascript: ;\" onClick=\"javascript: fnPopupDiv(\'400\', \'100%\', \'view_member_activity_details\', \'\',',a.id,');\">"._VIEWICON_."</a>";
		
		$buttons = "<input class=\"btnSty\" type=\"button\" name=\"Delete\" value=\"Delete\" alt=\"Delete\" title=\"Delete\" border=\"0\" onClick=\"javascript:fnDelete('".$div_id."','".$ajx_file."')\"/>&nbsp;<input class=\"btnSty\" type=\"button\" name=\"Active/Inactive\" value=\"Active/Inactive\" alt=\"Active/Inactive\" title=\"Active/Inactive\" border=\"0\" onClick=\"javascript:fnStatus('".$div_id."','".$ajx_file."')\"/>";
		$blocked_icon ="<img src=\""._SITEURL_."images/admin/block.gif\" border=\"0\" alt=\"Blocked\">";
		$unblocked_icon ="<img src=\""._SITEURL_."images/admin/unblock.gif\" border=\"0\" alt=\"UnBlocked\">";
		/***************************** Building search criteria condition ***************************/
		$condition =" WHERE m.id=".$_REQUEST['mid']." and m.id=a.user_id and a.id=d.item_id group by a.id" ;
		/*******************************SQL Query starts here ************************************/

		$sql = "SELECT a.name, a.default_note, a.tags, sum(d.amount) as totDf, if (a.status='blocked', CONCAT('$blocked_icon'), CONCAT('$unblocked_icon')) as status, CONCAT('$edit_icon') as actions, a.id as id FROM users m, activities a, counts d $condition";

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
							  "ActID"			=> $_REQUEST['mid'],
							  "DATAGRID"			=> $datagrid
							   ));
		$middle="member_acitivity_details.tpl";
		//$smarty->display("admin/member_acitivity_details.tpl");
}
?>