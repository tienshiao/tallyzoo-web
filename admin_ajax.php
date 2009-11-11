<?
	///////////////////////////////////////////
	// File Name        : index_ajax.php 
	// Craeted By       : SANJAY GURAV
	// Created Date     : 03-AUGAST-2007
	// File Modified By : SANJAY GURAV
	// Modify  Date     : 25-JULY-2007 (Removed global.cls.php)
	// Description      : This class file is used for GLOBAL variables.

	///////////////////////////////////////////
	ob_start("ob_gzhandler");
	session_start();
	list($usec, $sec) = explode(" ", $_SERVER['REQUEST_TIME']);
	$time_start =((float)$usec + (float)$sec);

	//	INCLUDE COMMON FILE
	include_once 'system/configme/siteconfig.php'; // include configuration file here	
	include_once SMARTY_PATH."Smarty.class.php"; // smarty class include here
	include_once CLASS_PATH.'dbclass.php'; // database class include here
	include_once CLASS_PATH.'admin_general.cls.php'; // this is general class include here	
	//include_once "seteditor.php";

	//DECLARE CLASS OBJECT
	$smarty = new Smarty(); // smarty object
	$dbObj = new dbclass(); // db object
	$objGeneral = new general($dbObj);

	//	SET SMARTY OBJECT
	$smarty->compile_dir = SMARTY_PATH.'templates_c/';			// smarty template path set here
	$smarty->config_dir = SMARTY_PATH.'configs/';				// smarty config dir path
	$smarty->cache_dir = SMARTY_PATH.'cache/';					// smarty cache dir path
	$smarty->compile_check = true;								// smarty compile check path
	$smarty->caching = false;		
	
	if(!empty($_REQUEST['Show']))
		$recs_per_page = $_REQUEST['Show'];
	else
		$recs_per_page = 10;

	//	Set All Common Variable Of Admin Panel
	if (!isset($_SESSION['SETTING']))
	{
		$objGeneral->getSystemSettingGlobalValue("SITE_TITLE");	//site name set here	
	}

	//	SCRIPT FILE SET
	if(isset($_REQUEST['mod']) && $_REQUEST['mod'] != "")
	{	
		$fileName = $_REQUEST['mod'].".php";
	}
	else
		$fileName = "loginnot.php";

	if(file_exists(ADMIN_SCRIPT_PATH.$fileName))
		include_once ADMIN_SCRIPT_PATH.$fileName;
	else
		die("File not found ".$fileName);
	
	if(!isset($middle)) $middle = TEMPLATE_PATH."admin/login.tpl";
	else $middle =  TEMPLATE_PATH."admin/".$middle;
	if(!isset($tpl)) $tpl = TEMPLATE_PATH."admin_ajax.tpl";

	//Assign Left/top/right/bottom file to smarty/
	/*if ($_SESSION['SETTING']['ADMIN_NAME']=='')
		$_SESSION['SETTING']['ADMIN_NAME'] = $objGeneral->getSystemSettingValue("ADMIN_NAME");*/			
		
	// GET ADMIN NAME FOR PRIVATE MESSGAE
	$smarty->assign("admin_name", $_SESSION['SETTING']['ADMIN_NAME']);
	$smarty->register_modifier("sslash","stripslashes");
	$smarty->assign("txt_username", $_COOKIE["CK_USERNAME"]);
	$smarty->assign("txt_password", $_COOKIE["CK_PASSWORD"]);
	$smarty->assign("middle", $middle);

	// Display Tpl File here
	$data=$smarty->display($tpl);

	list($usec, $sec) = explode(" ", microtime());
	$time_end =((float)$usec + (float)$sec);       		
	//if($_SERVER[REMOTE_ADDR]=='61.17.203.202' || $_SERVER[REMOTE_ADDR]=='202.71.141.194')
	//echo "Exe Time: ".$time = (float)round($time_end - $time_start, 2);
	ob_end_flush();
?>