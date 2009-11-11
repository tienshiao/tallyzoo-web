<?PHP
/*****************************************************
Page Name: home.php
Purpose: Admin home page
Created By: Ramamohan
Created On: 11/7/2008 11:00 AM
*****************************************************/
//Include files
require_once("sadm_login_chk.php");
//require "includes/common/common_functions.php";
//Page title
$pgtitle = "Welcome to Tallyzoo &raquo; Administration";//&raquo; == »
$onload = "";
$tot_Members = $objGeneral->getMemberCountByStatus('All');
$tot_New_Members = $objGeneral->getMemberCountByStatus('New');
$tot_Blocked_Members = $objGeneral->getMemberCountByStatus('blocked');

if(!empty($_SESSION['s_hdnFlag']))
{
	$menu = $objGeneral->setAdminMenu($_SESSION['s_hdnFlag']);
	$submenu = $objGeneral->fnBuildSubMenu("bottom_line");
}
$smarty->assign(array("PAGETITLE"	=> $pgtitle,
					  "ONLOAD"		=> $onload,
					  "MENU"		=> $menu,
					  "SUBMENU"		=> $submenu,
					  "tot_Members"		=> $tot_Members,
					  "tot_New_Members"		=> $tot_New_Members,
					  "tot_Blocked_Members"		=> $tot_Blocked_Members
					   ));
$middle = "home.tpl";
//$smarty->display("admin/home.tpl");
?>