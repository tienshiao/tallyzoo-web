<?	ob_start("ob_gzhandler");
	session_start();
	list($usec, $sec) = explode(" ", $_SERVER['REQUEST_TIME']);
	$time_start =((float)$usec + (float)$sec);	
	unset($_SESSION['SETTING']);
	if($_GET['mod'] !="myActivity")
	{
		unset($_SESSION['tmpFilter']);
	}
	///////////////////////////////////////////////////////////////////////////
	//	FILENAME 			:	index.php
	//	DESCRIPTION 		:	This is the main front index file of site. 
	//	CREATED				:	19-Aug-2009	
	//	CREATED BY 			:	Sanjay Gurav	
	//	COMPANY 			:	EcoTech IT Solution Pvt Ltd..
	///////////////////////////////////////////////////////////////////////////////
	/*if($_SERVER[REMOTE_ADDR]=='61.17.203.202')
		echo $sql_get_top_profile;*/
	
	include_once 'system/configme/siteconfig.php'; // include configuration file here	
	include_once SMARTY_PATH."Smarty.class.php"; // smarty class include here
	include_once CLASS_PATH.'dbclass.php'; // database class include here	
	include_once CLASS_PATH.'general.cls.php'; // this is general class  include here	
	include_once CLASS_PATH.'formatting.php'; //formating function
	//include_once "seteditor.php"; //file to include FCKEditor
	
	//	DECLARE CLASS OBJECT
	$smarty = new Smarty(); // smarty object
	$dbObj = new dbclass(); // db object
	$objGeneral = new general($dbObj);

	//	SET SMARTY OBJECT
	$smarty->compile_dir = SMARTY_PATH.'templates_c/'; // smarty template path set here
	$smarty->config_dir = SMARTY_PATH.'configs/'; // smarty config dir path
	$smarty->cache_dir = SMARTY_PATH.'cache/'; // smarty cache dir path
	$smarty->compile_check = true; // smarty compile check path
	$smarty->caching = false;
	$smarty->register_modifier("sanitize_title_with_dashes", "sanitize_title_with_dashes");
	//	Include selected script
	if(isset($_REQUEST['mod']) && $_REQUEST['mod'] != "")
	{
		$fileName = $_REQUEST['mod'].".php";
	}
	else
		$fileName = "home.php";

	//Include file to get global variables
	include_once 'global.php';
	if(file_exists(SCRIPT_PATH.$fileName))
		include_once SCRIPT_PATH.$fileName;
	else
	{
		$middle="bad_query.tpl";
		//die("Not_Found");
	}

	$pgtitle="Tallyzoo Admin &raquo; Login"; //&raquo; == 
	//Set The All tamplates Here
	if(!isset($top)) $top =  TEMPLATE_PATH."front/header.tpl";
	else $top =  TEMPLATE_PATH."front/".$top;
	if(!isset($middle)) $middle = TEMPLATE_PATH."front/dashboard.tpl";
	else $middle =  TEMPLATE_PATH."front/".$middle;
	if(!isset($bottom)) $bottom =  TEMPLATE_PATH."front/footer.tpl";
	else $bottom =  TEMPLATE_PATH."front/".$bottom;
	if(!isset($tpl)) $tpl = TEMPLATE_PATH."front_main.tpl";
	
	//echo "<prE>";
	//print_r($_SESSION['SETTING']);
	//Assign Left/top/right/bottom tamplates to smarty/
	$smarty->assign("prefix", $prefix);
	$smarty->assign("title", $_SESSION['SETTING']['siteTitle']);
	$smarty->assign("metaKeyWords", $_SESSION['SETTING']['metaKeyWords']);
	$smarty->assign("metaDescription", $_SESSION['SETTING']['metaDescription']);	
	$smarty->assign("SITEURL", _SITEURL_);	
	$smarty->register_modifier("sslash","stripslashes");
	$smarty->assign("header", $top);
	$smarty->assign("middle", $middle);
	$smarty->assign("footer", $bottom);
	$smarty->assign("jquery",1);
	// Display Tpl File here
	$smarty->display($tpl);

	list($usec, $sec) = explode(" ", microtime());
	$time_end =((float)$usec + (float)$sec);       		
	if($_SERVER[REMOTE_ADDR]=='61.17.203.202' || $_SERVER[REMOTE_ADDR]=='202.71.141.194')
		//echo "Exe Time: ".$time = (float)round($time_end - $time_start, 2);	
	ob_end_flush();
?>