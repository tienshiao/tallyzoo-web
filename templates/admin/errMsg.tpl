<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>{$SITENAME}</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<LINK REL="icon" HREF="{$SITEURL}mpp.ico" TYPE="image/x-icon"> 
		<LINK REL="SHORTCUT ICON" HREF="{$SITEURL}mpp.ico" TYPE="image/x-icon">
		<link rel="stylesheet" href="{$SITEURL}style/admin/mpp.css" type="text/css" />
		<script type="text/javascript" language="javascript" src="{$SITEURL}scripts/common/declaration.js"></script>
		<script type="text/javascript" language="javascript" src="{$SITEURL}scripts/common/messages.js"></script>
		<script type="text/javascript" language="javascript" src="{$SITEURL}scripts/admin/adm_login.js"></script>
	</head>
	<body onLoad="{$ONLOAD}" ondblclick="return false;">
		<form name="frmPost" method="post" enctype="multipart/form-data" onsubmit="return fnLogin();">
		{include file="../templates/admin/login_header.tpl"}
		<p class="hS7"><i></i></p>
		<p class="h20">&nbsp;</p>
		<p class="hS2"><i></i></p>
		<div id="login_body" class="h200">
			<p class="h20">&nbsp;</p>
				<fieldset id="login_flds" class="mm w550 bAllGry">
					<div class="clFx">
						<table width="100%" cellpadding="1" cellspacing="1">
							<tr>
								<td width="8%" align="center">
									<img src="{$SITEURL}images/admin/err_alert.gif" border="0">
								</td>
								<td width="20%" align="left">
									<strong>Error</strong>
								</td>
								<td width="72%" align="left">
									Your session has expired.
								</td>
							</tr>
							<tr>
								<td align="center">
									<img src="{$SITEURL}images/user/help.gif" border="0">
								</td>
								<td align="left">
									<strong>Suggestion</strong>
								</td>
								<td align="left">
									<li>For security reasons, the session will expire automatically, if the browser window is idle for a long time.</li>
									<p class="h10">&nbsp;</p>
									<li>If the problem persists, please try again after clearing the Temporary Files from your web browser.</li>
									<p class="h10">&nbsp;</p>
									<li><a href="{$SITEURL}admin/" alt="Click here to go to Login Page." title="Click here to go to Login Page."><strong>Click here to go to Login Page.</strong></a></li>
								</td>
							</tr>
						</table>
					</div>					
				</fieldset>
		</div>
		{include file="../templates/admin/footer.tpl"}
		</form>
	</body>
</html>