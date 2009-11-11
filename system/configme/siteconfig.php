<?php
//////////////////////////////////////////////////////////////////////////
//	FILENAME 			:	config.php
//	DESCRIPTION 		:	This is the main admin index file of site. 
//	CREATED				:	14-Aug-2009
//	LAST MODIFIED 		:	14-Aug-2009
//	CREATED BY 			:	Sanjay Gurav
//	LAST MODIFIED BY 	:	Sanjay Gurav
//	COMPANY 			:	EcoTech IT Solution Pvt Ltd..
//////////////////////////////////////////////////////////////////////////

error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);  	// display all errors except notices
@ini_set('display_errors', '1'); 		// display all errors
@ini_set('register_globals', 'On');	// make globals off runtime

//	OLDER VERSION MAPPING
if(empty($_SERVER)){
	$_GET = &$HTTP_GET_VARS;
	$_POST = &$HTTP_POST_VARS;
	$_SERVER = &$HTTP_SERVER_VARS;
}
extract($_GET);
extract($_POST);

//	SITE CONFIGURATION
define(_SITENAME_,"::Tallyzoo::");//Site name
$path_http = pathinfo('http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']);
$arrDirPath = explode("/", $path_http["dirname"]);
if($arrDirPath[count($arrDirPath)-1] == "admin" || $arrDirPath[count($arrDirPath)-1] == "cron" || $arrDirPath[count($arrDirPath)-1] == "merchantcp" || $arrDirPath[count($arrDirPath)-1] == "affiliatecp"){
	define("SERVER_ROOT_PATH", substr(getcwd(), 0, (strlen(getcwd())-strlen($arrDirPath[count($arrDirPath)-1])))); // server root path is deined here
	$serverPath = $arrDirPath;
	array_pop($serverPath);
	$serverUrl = implode("/",$serverPath);
	define("SERVER_PATH", $serverUrl."/"); 								// server path is deined here
}else{
	define("SERVER_ROOT_PATH", getcwd()."/"); 		  					// server root path is deined here
	$serverUrl = implode("/",$arrDirPath);
	define("SERVER_PATH", $serverUrl."/"); 								// server path is deined here
	$path_https = pathinfo('http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']);
}
$path_https = pathinfo('http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']);
define("SERVER_SSL_PATH", $path_https["dirname"]."/");					// server https path is deined here

// DATABASE CONFIGURATION/

define(_DBTYPE_,"mysql");//Database type
define(_DBUSER_,"432082_tz_test");//DB User
define(_DBPASS_,"Tally456$");//DB Password
define(_DBHOST_,"mysql50-06.wc2.dfw1.stabletransit.com");//DB Host Name
define(_DBNAME_,"432082_tz_test");//Database Name

// ALL SITE VARIABLE DEFINE
define(_SITEURL_, SERVER_PATH);//Site URL
define("TEMPLATE_PATH", SERVER_ROOT_PATH.'templates/'); // template path set here
define("CLASS_PATH", SERVER_ROOT_PATH.'system/library/'); // class path set here
define("SITE_INCLUDE_PATH", SERVER_PATH.'includes/'); // site java script path set here
define("SMARTY_PATH", SERVER_ROOT_PATH.'smarty/'); // smarty path set here
define("SCRIPT_PATH", SERVER_ROOT_PATH.'user/'); // script path set here
define("IMAGES_PATH", SERVER_PATH.'images/'); // images server path
define("USER_IMAGES_PATH", 'images/user/'); // member image path
define("IMGWIDTH",120); //Thumb width
define("IMGHEIGHT",120); //Thumb height

define("IMPORT_PATH", SERVER_ROOT_PATH.'importer/'); // images server path

define("ADMIN_SCRIPT_PATH", SERVER_ROOT_PATH.'admin/'); // script path set here

ini_set("session.gc_maxlifetime", (60*60)*2);
$currentTimeoutInSecs = ini_get("session.gc_maxlifetime");
setlocale(LC_MONETARY, 'en_US');

define(_INVALIDLOGIN_,"Invalid Email Id or Password!");//Invalid email id or password.
define(_NO_RECORDS_MSG_,"<p style=\"color:red;\">Sorry! No Records found.</p>");//Invalid email id or password.
define(_EDITICON_,"<image src=\""._SITEURL_."images/admin/edit1.gif\" class=\"nBr\" alt=\"Edit\" title=\"Edit\">");//Edit icon.
define(_VIEWICON_,"<image src=\""._SITEURL_."images/admin/view.gif\" class=\"nBr\" alt=\"View Details\" title=\"View Details\">");//View icon.
define(_DELETEICON_,"<image src=\""._SITEURL_."images/admin/delete.gif\" class=\"nBr\" alt=\"View Details\" title=\"View Details\">");//Delete icon.

define(_LOGIN_DET_MSG_,"<div class=\"txtInfo mgrleft5 mgrtop5\"><strong>Note:&nbsp;</strong>Login details will be mailed to registered email id.</div>");//Login details send as mail message.
define(_MANDATORY_MSG_,"<div class=\"rTx txtInfo fR\">Fields marked with * are mandatory</div>");//Mandatory Fields message
define("_ENCRYPT_KEY_","z1Mc6KRxA7Nw90dGjY5qLXhtrPgJOfeCaUmHvQT3yW8nDsI2VkEpiS4blFoBuZ");//encryption key
define(SUC_MSG_CLS,"mm w880 p5 success_list dispB");//Success message class
define(_NO_OF_RECORDS_PER_PAGE_,5);
define("_JS_KIT_PREFIX_","test_");