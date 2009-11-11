<script language="javascript1.3" src="js/emailvalidation.js" ></script>
<script language="javascript1.3" src="js/ahah.js" ></script>

<div >
	<div class="popup_box" style=" border:6px solid #173E64; background-color:#FFFFFF;">
	<div class="header pos_section_title" style="padding-right:5px;">
	<img src="{$img_path}close.gif" alt="Close" class="popup_close" onclick="Javascript:fnHdnPopup('');" />
</div>

<div id="searchlist" style="display:block; padding-left:10px; padding-right:10px;">
	<p class="h05">&nbsp;</p><label class="main-heading">Invite Friends</label>
	<div id='target' style="display:none;">
		<table width="100%" cellspacing="6" cellpadding="0" border="0">
		<tr>
			<td align="center" bgcolor="#efefef">
				<table  border="0" width="100%" bgcolor="#FFFFFF">
					<tr>
						<td >
							<table width="100%" border="0" cellspacing="5" cellpadding="10" class="tbl_grid">
							<tr>
								<td align="center">
									<img src='{$img_path}indicatorbar.gif'><br><br>Loading.......
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			</td>
			</tr>
		</table>
	</div>
	<div id="ImportTbl">
		<form name="frmImport" id="frmImport" onsubmit="javascript:return InviteFriends();">
	<table width="100%" cellspacing="6" cellpadding="0" border="0">
		<tr>
			<td align="center" bgcolor="#efefef">
				<table  border="0" width="100%" bgcolor="#FFFFFF">
					<tr>
						<td >
							<table width="100%" border="0" cellspacing="5" cellpadding="10" class="tbl_grid">
								<tr>
									<td align="left" width="40%"><img src="{$img_path}{$myimg}.gif"/>
									<td align="right" width="60%"><font color="red"><u>No details are stored</u></font></td>
								</tr>
								<tr>
									<td colspan="2" align="center">
										<table  width="100%" border="0" cellspacing="5" cellpadding="10" align=-"center">
											<tr>
												<td align="left" width="40%"><strong>Email Address</strong><span class="error">*</span></td>
												<td align="left" ><input type="text" class="txt_fld wdt200" name="username"  id="username" /></td>
											</tr>
											<tr>
												<td align="left"> <strong>Password</strong><span class="error">*</span></td>
												<td align="left" > <input type="password" class="txt_fld wdt200" name="password"  id="password" /></td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td >&nbsp;</td>
									<td align="left"><input name="btnInvite"  id="btnInvite" type="submit" class="btn_sty" value="Invite My Friends" alt="Invite My Friends" title="Invite My Friends"/></td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	</form>
	</div>
</div>
<INPUT TYPE="hidden" NAME="script" ID="script"  VALUE="{$script}">