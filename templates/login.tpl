<script src="../scripts/common/common.js"></script>
<form name='frm' method='post' onSubmit="return fnLogin();">
<input type="hidden" name="ACT" value="">
{if $msg neq ""}
	<center><font color=red>{$msg}</font></center>
{/if}
<table align="center" border="0">
	<tr>
		<td colspan="2"><b>Login</b></td>
	</tr>
	<tr>
		<td>Username</td>
		<td><input type="text" name="txtUName"></td>
	</tr>
	<tr>
		<td>Password</td>
		<td><input type="password" name="txtPass"></td>
	</tr>
	<tr height='10'>
		<td colspan="2"></td>
	</tr>
	<tr>
		<td align="center" colspan="2">
			<input type="submit" value="Login">
			<input type="Reset" value="Reset">
		</td>
	</tr>
	
</table>
</form>
{literal}
<script language="javascript">
	document.frm.txtUName.focus();
	function fnLogin()
	{
		doc = document.frm;
		if(trim(doc.txtUName.value) == "")
		{
			alert("Please Enter Username.");
			doc.txtUName.focus();
			return false;
		}
		if(trim(doc.txtPass.value) == "")
		{
			alert("Please Enter Password.");
			doc.txtPass.focus();
			return false;
		}
		document.frm.ACT.value="Login";
	}
</script>
{/literal}