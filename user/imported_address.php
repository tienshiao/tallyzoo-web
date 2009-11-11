<?php 
/*%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	Created By: Lalit wankhade
	Created Date: 5/8/2008
%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%*/
$include_Path	=	"../";

include_once $include_Path.'system/configme/siteconfig.php'; // include configuration file here	
include_once $include_Path."smarty/Smarty.class.php"; // smarty class include here
	
	//	DECLARE CLASS OBJECT
	$smarty = new Smarty(); // smarty object

	//	SET SMARTY OBJECT
	$smarty->compile_dir = $include_Path.'smarty/templates_c/'; // smarty template path set here
	$smarty->config_dir = $include_Path.'smarty/configs/'; // smarty config dir path
	$smarty->cache_dir = $include_Path.'smarty/cache/'; // smarty cache dir path
	$smarty->compile_check = true; // smarty compile check path
	$smarty->caching = false;
	
	$cntarr = count($display_array);

if($cntarr != 0 && $cntarr != "")
	$cnt = "show";
else
	$cnt = "notshow";

$smarty->assign('display_array', $display_array);
$smarty->assign('cnt', $cnt);
$smarty->display($include_Path.'templates/front/imported_address.tpl');
?>