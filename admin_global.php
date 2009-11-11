<?
	///////////////////////////////////////////
	// File Name        : admin_global.php 
	// Craeted By       : SANJAY GURAV
	// Created Date     : 17-Aug-2009
	// LAST MODIFIED 	: 17-Aug-2009
	// File Modified By : SANJAY GURAV
	// Description      : This file is used for GLOBAL variables.	
	///////////////////////////////////////////
	
	//	Set All Common Variable Of Admin Panel
	if (!isset($_SESSION['SETTING']))
	{
		$objGeneral->getSystemSettingGlobalValue("SITE_TITLE");	// site name set here	
	}
	//print_r($_SESSION);
	$smarty->assign("SITE_TITLE", $_SESSION['SETTING']['SITE_TITLE']);	
	$smarty->assign("CSS", $_SESSION['SETTING']['SITE_CSS']);	
	$smarty->assign("Account_CSS", $_SESSION['SETTING']['MY_ACCOUNT_CSS']);
	$smarty->assign("CAL_CSS", $_SESSION['SETTING']['CAL_CSS']);
	$smarty->assign("POPUP_CSS", $_SESSION['SETTING']['POPUP_CSS']);
	$smarty->assign("SITE_STYLE_PATH", SITE_STYLE_PATH);						// site title assign to smarty
	
	$smarty->assign("meta_name_key",stripslashes($_SESSION['SETTING']['META_NAME_KEYWORDS']));	
	$smarty->assign("admin_name", $_SESSION['SETTING']['ADMIN_NAME']);
	$smarty->assign("SITE_JAVASCRIPT_PATH", SITE_JAVASCRIPT_PATH); // javbascript path
	
	//ASSIGN PHP VARIABLE TO SMARTY
	$smarty->assign("fileName" , $fileName);
	$smarty->assign("txt_username", $_COOKIE["CK_USERNAME"]);
	$smarty->assign("txt_password", $_COOKIE["CK_PASSWORD"]);

	if(!empty($_REQUEST['Show']))
		$recs_per_page = $_REQUEST['Show'];
	else
		$recs_per_page = 10;

	if(!empty($_REQUEST['act_id']))
	{
		switch($_REQUEST['act_id'])
		{
			case 1 :
				$act_load="fnSetMsg('".$_REQUEST['act_id']."');";
			break;
			case 2 :
				$act_load="fnSetMsg('".$_REQUEST['act_id']."');";
			break;
			case 3 :
				$act_load="fnSetMsg('".$_REQUEST['act_id']."');";
			break;
			case 4 :
				$act_load="fnSetMsg('".$_REQUEST['act_id']."');";
			break;
			case 7 :
				$act_load="fnSetMsg('".$_REQUEST['act_id']."');";
			break;
		}
	}
?>