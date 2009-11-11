<?PHP
/*****************************************************
Page Name: static_search.php
Purpose: Static search page
Created By: Mahesh L
Created On: Tuesday, December 30, 2008 4:15 PM
*****************************************************/
require_once(CLASS_PATH."clsDataGrid.php");
$table=new clsDataGrid($dbObj);

$pgtitle = "";//&raquo; == 

if ($_REQUEST['act']=='view')
{
	$sql_sel="Select * from report_abuse where id='".$_REQUEST['aid']."'";		
	$row = $dbObj->select($sql_sel);	
	$smarty->assign("ROW", $row);
	$middle="view_abuse_details.tpl";	
}
else if ($_REQUEST['act']=='delete')
{
	$m_ids=$_POST['hidIds'];
	$id_arr=split("," ,$m_ids);
	for($i=0; $i<count($id_arr) ; $i++) 
	{
		$ids=$id_arr[$i];
		$SQL="DELETE FROM report_abuse WHERE id='".$ids."'";
		// AND fldStatus='inactive'
		//$dbObj->Query($SQL);
		$err_msg = "Record(s) deleted successfully!";
		$smarty->assign("err_msg", $err_msg);
	}
}
if ($_REQUEST['act']!='view')
{
	/*****************************Datagrid code starts from here ***************************/
	$pagevariable='admin'; //set page variable here ex: products
	$cname	 = array("URL","Reason","Details","Email","Actions");
	$fldnames = array("url","reason","details","email_id","status");
	$cdbname = "r.id";
	$unique_field = "id";
	$cwidth  = array("35%","20%","40%","5%");							
	if(!empty($_REQUEST['hidOrder']))
		$order=$_REQUEST['hidOrder'];
	else
		$order='DESC';//asc or desc
	if(!empty($_REQUEST['hidOrderBy']))
		$orderby=$_REQUEST['hidOrderBy'];//value
	else
		$orderby='r.id';//value
	$checkbox='1'; //if yes enter 1 or else enter 0.
	$tabindex='';//set tab index here	
	$div_id='rabuse_grid';
	$ajx_file = "admin_ajax.php?mod=ajx_report_abuse";
	/****************************Action Icon code starts from here **********************/
	//$view_icon ="<a href=\"#".$div_id."\" onClick=\"fnedit(', r.id ,');\">"._VIEWICON_."</a>";
	$view_icon ="<a href=\"javascript: ;\" onClick=\"javascript: fnPopupDiv(\'400\', \'100%\', \'ajx_report_abuse&act=view\', \'\',',r.id,');\">"._VIEWICON_."</a>";

	$buttons = "<input class=\"btnSty\" type=\"button\" name=\"Delete\" value=\"Delete\" alt=\"Delete\" title=\"Delete\" border=\"0\" onClick=\"javascript:fnDelete('".$div_id."','".$ajx_file."')\"/>";
	/***************************** Building search criteria condition ***************************/
	$condition ="" ;
	/*******************************SQL Query starts here ************************************/

	$sql = "SELECT r.url, r.reason, r.details, r.email_id, CONCAT('$view_icon') as actions, r.id FROM report_abuse r $condition";
	/*********************************SQL Query ends here*************************************/
	$datagrid=$table->DataGrid($sql,$pagevariable,$recs_per_page,$order,$orderby,$cname,$cdbname,$cwidth,$unique_field,$checkbox,$buttons,$tabindex,$div_id,$fldnames,$ajx_file);
	/*****************************Datagrid code ends here **********************************/
	$smarty->assign("DATAGRID", $datagrid);
	$middle="search_ajax_result.tpl";
}
?>