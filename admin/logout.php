<?PHP
	session_destroy();
	unset($_SESSION);
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
	$middle = "login.tpl";
?>