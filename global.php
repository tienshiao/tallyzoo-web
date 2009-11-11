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
		$objGeneral->getSystemSettingGlobalValue();	// site name set here	
	}
	//print_r($_SESSION);
	$smarty->assign("meta_name_key",stripslashes($_SESSION['SETTING']['META_NAME_KEYWORDS']));	
	$smarty->assign("admin_name", $_SESSION['SETTING']['ADMIN_NAME']);
	$smarty->assign("SITE_JAVASCRIPT_PATH", SITE_JAVASCRIPT_PATH); // javbascript path
	
	//ASSIGN PHP VARIABLE TO SMARTY
	$smarty->assign("fileName" , $fileName);
	$smarty->assign("txt_username", $_COOKIE["CK_USERNAME"]);
	$smarty->assign("txt_password", $_COOKIE["CK_PASSWORD"]);
	
?>