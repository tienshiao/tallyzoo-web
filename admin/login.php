<?PHP
/*****************************************************
Page Name: index.php
Purpose: Admin login
Created By: Sanjay G.
Created On: 17/08/2009
*****************************************************/
//Page title

//To set focus on email id field.
if($_REQUEST['t']!='$$')
	$onload="document.frmPost.txtLoginNm.focus();";
else
	$onload="";
$smarty->assign(array("PAGETITLE"	=> $pgtitle,
					  "ONLOAD"		=> $onload
					   ));
$top = "login_header.tpl";
$bottom = "footer.tpl";
if($_REQUEST['t']!='$$')
	$middle = "login.tpl";
else
	$middle = "errMsg.tpl";
?>