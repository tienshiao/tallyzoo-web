{if $cnt neq notshow}
	<div align="center" style="display:">
	<table width="100%" border="0" cellspacing="3" cellpadding="0" class="tbl_content_0padding">
			<tr bgcolor="#0176B3">
				<th width="48%" valign="bottom" class="eve" align="left"><span class="more_link4"><a href="javascript:checkall(true)">
			Check All</a> | <a href="javascript:checkall(false)">Uncheck All</a></span></th>
				<th valign="bottom" class="eve" align="left"><strong>MY CONTACTS</strong></th>
		</tr>

		<tr>
			<td height="25" colspan="2">
			<div align="center">

				<table cellpadding="0" cellspacing="0" width="100%" id="table4" style="border-top: 1px solid #D8D8D8; ">
				
				 {foreach from=$display_array key=myId item=contacts}
					<tr>
						<td width="34" bgcolor="#FFFFFF" >
						
						<input type="checkbox" name="chkIds" id="chkIds" value="{$contacts.contacts_email}" checked></td>

						<td height="25" bgcolor="#FFFFFF" width="312" align="left">{$contacts.contacts_email}</td>
						<td height="25" bgcolor="#FFFFFF" align="left">{$contacts.contacts_name}</td>
						<INPUT TYPE="hidden" NAME="txtImportname" value="{$contacts.contacts_name}">
					</tr>
				 {/foreach}
				</table>
			</div>

		</td>
		</tr>
		<tr>
			<td colspan="3" align="left" class="gray_separator">&nbsp;</td>
		</tr>
	</table>
	{else}
 &nbsp;&nbsp;
	<table border="0" cellpadding="0" cellspacing="0" width="100%" id="table5" style="border: 1px solid #D8D8D8">
		<tr>
			<td bgcolor="#FFFFFF" height="50">
			<p align="center"><b><font face="Arial" size="2" color="#3366CC">!Error 
			- No contacts were found, please check your logins.</font></b></td>
		</tr>
	</table>
	{/if}
