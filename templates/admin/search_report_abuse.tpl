<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>{$SITENAME}</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<link rel="stylesheet" href="{$SITEURL}style/admin/mpp.css" type="text/css" />
		<script type="text/javascript" language="javascript" src="{$SITEURL}scripts/common/declaration.js"></script>
		<script type="text/javascript" language="javascript" src="{$SITEURL}scripts/common/messages.js"></script>
		<script type="text/javascript" language="javascript" src="{$SITEURL}scripts/common/prototype.js"></script>
	</head>
	<body onLoad="setAdminMenuActive('c');{$ONLOAD} {$ACTLOAD}" ondblclick="return false;">
		<form id="frm" name="frm" method="post" ><!-- onSubmit="javascript:return fnShowResult();" -->
		{include file="../templates/admin/header.tpl"}
		{$SUBMENU}
		</form>
		<form id="frmPost" name="frmPost" method="post" onsubmit="return fnGoToPage('desc_grid','admin/ajx_search_desc_mang.php');">
		<p class="w890 mm h05">&nbsp;</p>
		<div class="mm dispN" id="err_msg_list"></div>
		<p class="hS2"><i></i></p>
		<div class="w890 mm">
			<span class="fR">[<label><a href="Desc">&nbsp;<strong>Add/Edit</strong>&nbsp;</a></label>]</span>
			<label class="font_brown fL">Search Options </label>
		</div>
		<p class="w890 mm h20">&nbsp;</p>
		<div class="w890 mm bAllGry">
			<fieldset class="mm w880">
				<div class="clFx">
					<div class="fL w170">
						<label id="lpage">Page</label>
					</div>
					<div>
					<input type="text" class="w270" value="{$TITLE}" name="txtPage" id="txtPage" maxlength="50"/>
					</div>
				</div>		 
				<p class="hS1"><i></i></p>
				<div class="clFx">
					<div class="fL w170">
						<label>Status</label>
					</div>
					<div>
						<span>
							<input type="checkbox" class="nBr" id="chkActive" name="chkActive" {$CHKACTIVE}/>&nbsp;&nbsp;Active
						</span>
						<span class="mgrleft15">
							<input type="checkbox" class="nBr" id="chkInactive" name="chkInactive" {$CHKINACTIVE}/>&nbsp;&nbsp;Inactive
						</span>
					</div>
				</div>
				<p class="hS1"><i></i></p>
				<div class="clFx">
					<div class="fL w170">&nbsp;</div>
					<div>
						<input type='hidden' name='pgaction' id="pgaction">
						<input type='hidden' name='staticid' id="staticid">
						<input class="btnSty" type="button" name="Search" value="Search" alt="Search" title="Search" onclick="return fnShowResult('admin/ajx_search_desc_mang.php','desc_grid','frmPost');"/><!-- onclick="return fnShowResult();" -->
						<input  class="btnSty" type="reset" name="Reset" value="Reset" alt="Reset" title="Reset"/>
					</div>
				</div>
				<br/>
			</fieldset>
		</div>
		<input type="hidden" id="hdnUType" name="hdnUType">
		<p class="hS4"><i></i></p>
		<div class="w890 mm">
			<label class="font_brown">Description List</label>
		</div>  
		<div class="w890 mm" id="desc_grid">
			<!-- Dategrid starts from here -->
			{$DATAGRID}
			<!-- Dategrid ends here -->
		</div>
		</form>
		{include file="../templates/admin/footer.tpl"}
	</body>
</html>
{literal}
<script language="javascript">
function fnedit(id,utype)
{
	 document.frmPost.staticid.value=id;
	 document.frmPost.pgaction.value='editview';
	 document.getElementById('hdnUType').value=utype;
	 document.frmPost.action='Desc';
	 document.frmPost.submit();
}
</script>
{/literal}