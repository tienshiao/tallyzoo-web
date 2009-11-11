<?php

	/*%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
		Created By: Lalilt Wankhade
		Created Date: Tuesday, Jun 24, 2008
	%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%*/
include_once (IMPORT_PATH.'includes/config.php');
include_once (IMPORT_PATH.'includes/tbs_class.php');

if ($service != "") {//get service from processor e.g mygmail.php  $service = 'mygmail';

    $get = $service;

}
else {
	$get = $_GET["ACT"];
}
if ($get =="") {
    $script = "myhotmail";
    $img = "myhotmail.gif";
}
else {
    $script = $get;
    $img = $get;
}
//select template inner table [var.which] in TBS (email or cvs upload)
if ($table != "") {
    $which = $table;
}
else {
    $which = $_GET['tbl'];
	$poweredby_top = $footer; //powered by
}

//if loading index.php for first time
if ($which == "") {
    $which = 1;
	$poweredby_top = $footer; //powered by
}

$TBS = new clsTinyButStrong;
$TBS->NoErr = true;
$cntarr = count($display_array);

if($cntarr == 0 && $cntarr != "")
	$cnt = "show";
else
	$cnt = "notshow";

	$page = "importer";

	$middle="importer.tpl";
	$smarty->assign("error_msg",$err_msg);
	$smarty->assign("noOfact",$noOfact);
	$smarty->assign("ROW",$ROW);
	$smarty->assign("ACTIDARR",$actiIdArr);
	$smarty->assign("ROWINPUT",$ROWINPUT);

	$smarty->assign('myimg',$img);
	
	$smarty->assign('script', $script);
	$smarty->assign('display_array', $display_array);
	$smarty->assign('cnt', $cnt);
	$smarty->assign('leftmenu' , $leftmenu);

	$smarty->assign('img_path',IMAGES_PATH);


?>
