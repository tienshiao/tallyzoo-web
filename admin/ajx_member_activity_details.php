<?PHP
/*****************************************************
Page Name: static_search.php
Purpose: Static search page
Created By: Mahesh L
Created On: Tuesday, December 30, 2008 4:15 PM
*****************************************************/
require_once(CLASS_PATH."clsDataGrid.php");
$table=new clsDataGrid($dbObj);

if ($_REQUEST['act']=='delete')
{
	$m_ids=$_POST['hidIds'];
	$id_arr=split("," ,$m_ids);
	for($i=0; $i<count($id_arr) ; $i++) 
	{
		$ids=$id_arr[$i];
		$SQL="DELETE FROM activities WHERE id='".$ids."'";
		// AND fldStatus='inactive'
		//$dbObj->Query($SQL);
		$err_msg = "Record(s) deleted successfully!";			
		$smarty->assign("err_msg", $err_msg);
	}
}
else if ($_REQUEST['act']=='status')
{
	$m_ids=$_POST['hidIds'];
	$id_arr=split("," ,$m_ids);
	for($i=0; $i<count($id_arr) ; $i++) 
	{
		$ids=$id_arr[$i];
		$sql_sel="Select status from activities where id='".$ids."'";		
		$row = $dbObj->select($sql_sel);
		if ($row[0]['status']=='unblocked')
			$status="blocked";
		else if ($row[0]['status']=='blocked')
			$status="unblocked";
		$SQL="update activities set status='$status' WHERE id='".$ids."'";
		// AND fldStatus='inactive'
		$dbObj->Query($SQL);
		$err_msg = "Record(s) status changed successfully!";			
		$smarty->assign("err_msg", $err_msg);		
	}
}

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
$smarty->assign("DATAGRID", $datagrid);
$middle="search_ajax_result.tpl";
?>