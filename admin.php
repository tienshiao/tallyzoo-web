<?	ob_start("ob_gzhandler");
	session_start();
	list($usec, $sec) = explode(" ", $_SERVER['REQUEST_TIME']);
	$time_start =((float)$usec + (float)$sec);	
	unset($_SESSION['SETTING']);
	///////////////////////////////////////////////////////////////////////////
	//	FILENAME 			:	admin.php
	//	DESCRIPTION 		:	This is the main admin index file of site. 
	//	CREATED				:	14-Aug-2009
	//	LAST MODIFIED 		:	14-Aug-2009
	//	CREATED BY 			:	Sanjay Gurav
	//	LAST MODIFIED BY 	:	Sanjay Gurav
	//	COMPANY 			:	EcoTech IT Solution Pvt Ltd..
	///////////////////////////////////////////////////////////////////////////////
	/*if($_SERVER[REMOTE_ADDR]=='61.17.203.202')
		echo $sql_get_top_profile;*/
	
	include_once 'system/configme/siteconfig.php'; // include configuration file here	
	include_once SMARTY_PATH."Smarty.class.php"; // smarty class include here
	include_once CLASS_PATH.'dbclass.php'; // database class include here	
	include_once CLASS_PATH.'admin_general.cls.php'; // this is general class  include here	
	//include_once "seteditor.php"; //file to include FCKEditor
	
	//	DECLARE CLASS OBJECT
	$smarty = new Smarty(); // smarty object
	$dbObj = new dbclass(); // db object
	$objGeneral = new general($dbObj);
	//print_r($_REQUEST);
	//	SET SMARTY OBJECT
	$smarty->compile_dir = SMARTY_PATH.'templates_c/'; // smarty template path set here
	$smarty->config_dir = SMARTY_PATH.'configs/'; // smarty config dir path
	$smarty->cache_dir = SMARTY_PATH.'cache/'; // smarty cache dir path
	$smarty->compile_check = true; // smarty compile check path
	$smarty->caching = false;
	
	//	Include selected script
	if(isset($_REQUEST['mod']) && $_REQUEST['mod'] != "")
	{
		$fileName = $_REQUEST['mod'].".php";
	}
	else
		$fileName = "login.php";

	//Include file to get global variables
	include_once 'admin_global.php';
	if(file_exists(ADMIN_SCRIPT_PATH.$fileName))
		include_once ADMIN_SCRIPT_PATH.$fileName;
	else
		die("File not found ".$fileName);	

	$pgtitle="Tallyzoo Admin &raquo; Login"; //&raquo; == 
	//Set The All tamplates Here
	if(!isset($top)) $top =  TEMPLATE_PATH."admin/header.tpl";
	else $top =  TEMPLATE_PATH."admin/".$top;
	if(!isset($middle)) $middle = TEMPLATE_PATH."admin/login.tpl";
	else $middle =  TEMPLATE_PATH."admin/".$middle;
	if(!isset($bottom)) $bottom =  TEMPLATE_PATH."admin/footer.tpl";
	else $bottom =  TEMPLATE_PATH."admin/".$bottom;
	if(!isset($tpl)) $tpl = TEMPLATE_PATH."admin_main.tpl";
	
	$smarty->assign(array("SITENAME"	=> _SITENAME_,
					  "SITEURL"		=> _SITEURL_,
					  "ACTLOAD"		=> $act_load,
					  "MANDATORY"	=> _MANDATORY_MSG_
				  ));

	//Assign Left/top/right/bottom tamplates to smarty/
	$smarty->assign("server_path", SERVER_PATH);
	$smarty->register_modifier("sslash","stripslashes");
	$smarty->assign("header", $top);
	$smarty->assign("middle", $middle);
	$smarty->assign("footer", $bottom);

	// Display Tpl File here
	$smarty->display($tpl);

	list($usec, $sec) = explode(" ", microtime());
	$time_end =((float)$usec + (float)$sec);       		
	if($_SERVER[REMOTE_ADDR]=='61.17.203.202' || $_SERVER[REMOTE_ADDR]=='202.71.141.194')
		//echo "Exe Time: ".$time = (float)round($time_end - $time_start, 2);	
	ob_end_flush();
?>