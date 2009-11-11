	<form name="frmPost" id="frmPost" method="post" enctype="multipart/form-data" onsubmit="return fnLogin(this);">
	<input type="hidden" name="mod" value="">
	<input type="hidden" name="act" value="login">
	<p class="hS7"><i></i></p>
	<p class="h20">&nbsp;</p>
	<input type="hidden" id="hdnFlag" name="hdnFlag">
	{ if $err_msg neq ''}
		<div class="err_list mm w355" id="err_msg_list">{$err_msg}</div>
		<p class="hS2"><i></i></p>
	{ /if }
	<div id="login_body" class="h300">
		<p class="h10">&nbsp;</p>
		<div class="h3 cBr mTx">{$PAGETITLE}</div>
		<p class="h20">&nbsp;</p>
			<fieldset id="login_flds" class="mm w350 bAllGry">
				<div class="clFx">
					<div class="fL w100"><label id="lblname">Email Id</label></div><div><input type="text" class="w200" value="" name="txtLoginNm" id="txtLoginNm" maxlength="200"/></div>
				</div>	
				<p class="hS1"><i></i></p>
				<div class="clFx">
					<div class="fL w100"><label id="lblPwd">Password</label></div><div><input type="password" class="w200" value="" name="txtPwd" id="txtPwd" maxlength="20"/></div>
				</div>
				<p class="hS1"><i></i></p>
				<p class="hS2"><i></i></p>
				<p class="hS2"><i></i></p>
				<div class="clFx">
					<div class="fL w120">&nbsp;</div>
					<input type="submit" name="Login" value="Login" class="btnSty" alt="Login" title="Login"/>
					<input type="reset" name="reset" value="Reset" class="btnSty" alt="Reset" title="Reset"/>
				</div>
				<p class="hS2"><i></i></p>
			</fieldset>
	</div>
	</form>