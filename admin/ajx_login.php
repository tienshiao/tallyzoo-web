<?
	if($_REQUEST['act']=='login')
	{
		$Login=$objGeneral->checkLogin($_REQUEST['txtLoginNm'],$_REQUEST['txtPwd']);
		if($Login['0']['fldAdminType']!="")
		{
			echo "<p class='h5'>&nbsp;</p><div width='100%' style='padding: 2px; background: rgb(204, 68, 68) none repeat scroll 0%; visibility: visible; font-size: 100%; position: absolute; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial; color: white; font-family: arial,sans-serif;' id='loadingDiv'>  Loading...  </div><p class='h200'>&nbsp;</p><script>window.document.location.href='admin.php?mod=home';</script> ";
							exit;
			//header("Location: admin.php?mod=home");
		}
		else
		{
			$err_msg = "Invalid e-mail id or Password.";
			$middle = "login.tpl";
			$smarty->assign("err_msg", $err_msg);
		}
	}
	elseif($_REQUEST['act']=='logout')
	{
		session_destroy();
		unset($_SESSION);
		echo "logout";	
		exit;
	}
?>