<iframe id="forget" name="forget" width='0' height='0' frameborder="0" border='0'>
</iframe>
<div class="popup_box">
	<div class="close_icon"><a href="javascript:;"><img src="images/close.gif" border="0" onclick="javascript:fnHdnPopup('');" style="padding-right:10px;" /></a></div>&nbsp;&nbsp;

<div class="popup_content">
<div id="mid_body" class="error" align="center"></div>
<form name='frmForgot' id="frmForgot" method='post' action="user/ajx_comman.php?case=2" target="forget">
<input type="hidden" name="ACT" value="">
<table width="100%"  border="0" cellspacing="0" cellpadding="0" class="tbl_grid" style="margin:0px auto;">
	<tr>
		<th colspan="2" align="left"><b>Forgot Password</b></th>
	</tr>
	{if $error_msg neq ""}
	<tr valign="middle" align="center" class="error-msg"  height="15">
		<td colspan="2">{$error_msg}</td>
	</tr>
	{/if}
	<tr>
		<td>Enter your Email</td>
		<td><input type="text" name="txtEmail"></td>
	</tr>	
	<tr>
		<td align="center" colspan="2">
			<input type="submit" value="Send" class="btn_sty">
			<input type="Reset" value="Reset" class="btn_sty">
		</td>
	</tr>
</table>
</form>
</div>
</div>

