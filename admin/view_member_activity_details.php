<?PHP
/*****************************************************
Page Name: static_search.php
Purpose: Static search page
Created By: Mahesh L
Created On: Tuesday, December 30, 2008 4:15 PM
*****************************************************/
require_once("sadm_login_chk.php");
require_once(CLASS_PATH."clsDataGrid.php");

$pgtitle = "Member Details";//&raquo; == 
$menu = $objGeneral->setAdminMenu($_SESSION['s_hdnFlag']);
$submenu= $objGeneral->fnBuildSubMenu("member_details");
$row = $objGeneral->getMemberActivityDetails($_REQUEST['aid']);
$smarty->assign(array("PAGETITLE"			=> $pgtitle,
			  "ONLOAD"				=> $onload,
			  "MENU"				=> $menu,
			  "SUBMENU"				=> $submenu,
			  "msg"                 =>$msg,
			  "ROW"                 =>$row					  
			   ));
$middle="activity_details.tpl";
//$smarty->display("admin/activity_details.tpl");	
?>