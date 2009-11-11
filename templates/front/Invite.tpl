<script src="{$SITEURL}includes/javascript/callAjax.js" type="text/javascript"></script>
{literal}
<script language="javascript">

function SendInvitation()
{
	var obj	=	document.frmUpdate;
	obj.txtEmailIds.value	 =	"";
	obj.txtNames.value	 =	"";
	
	// For Text Box
	var len	=	obj.txtEmail.length;
	if(len!=undefined){
		for(var i=0;i<len;i++){

			if(obj.txtEmail[i].value!=""){

				if(!isValidEmail(obj.txtEmail[i])){
						obj.txtEmail[i].focus();
						return false;
				}
				if(obj.txtEmailIds.value!=""){
					obj.txtEmailIds.value += "," + obj.txtEmail[i].value;
					obj.txtNames.value += "," + obj.txtName[i].value;
				}
				else{
					obj.txtEmailIds.value = obj.txtEmail[i].value;
					obj.txtNames.value   =   obj.txtName[i].value;
				}
			}
		}
	}

	if(obj.chkIds !=undefined)
	{
		len	=	obj.chkIds.length;
		if(len!=undefined){
			for(var i=0;i<len;i++){
				if(obj.chkIds[i].checked==true){
					if(obj.txtEmailIds.value!="") {
						obj.txtEmailIds.value += "," + obj.chkIds[i].value;
						obj.txtNames.value += "," + obj.txtImportname[i].value;
					}
					else {
						obj.txtEmailIds.value = obj.chkIds[i].value;
						obj.txtNames.value  = obj.txtImportname[i].value;
					}
				}
			}
		}else{

			if(obj.chkIds.checked==true){
					obj.txtEmailIds.value = obj.chkIds.value;
					obj.txtNames.value  = obj.txtImportname.value;
			}

		}
	}

	if(obj.txtEmailIds.value == "")
	{
		alert("Please enter at least one email id");
		return false;
	}
}

</script>

{/literal}
<div id="container">
<form name="frmUpdate" id="frmUpdate" method="post" enctype="multipart/form-data" onSubmit="javascript: return SendInvitation();">
<input type="hidden" value="INVITE" name="ACT">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl_grid">
   <tr>
 		<th  colspan="2" align="left">Invite Friend</th>

	</tr>
	{if $error_msg neq ""}
	<tr valign="middle" align="center" class="error-msg"  height="15">
		<td>{$error_msg}</td>
	</tr>
	{/if}

	<tr>
		<td align="center">
			<table width="80%">
			<tr>
			<td>
				<table width="100%" border="0" cellspacing="5" cellpadding="10" class="tbl_content">
				<tr>
					<td align="left" colspan="2">
						<strong>Email Address</strong><br />
						&nbsp;<input type="text" class="fld_txt wd_250" name="txtEmail"  id="txtEmail" />
					</td>
					<td align="left" colspan="2">
						<strong>Name</strong>(optional)<br />
						&nbsp;<input type="text" class="fld_txt wd_200" name="txtName" id="txtName"/>
					</td>
				</tr>
				<tr>
					<td align="left" colspan="2">
						&nbsp;<input type="text" class="fld_txt wd_250"  name="txtEmail"  id="txtEmail" />
					</td>
					<td align="left" colspan="2">
						&nbsp;<input type="text" class="fld_txt wd_200" name="txtName" id="txtName"/>
					</td>
				</tr>
				<tr>
					<td align="left" colspan="2">
						&nbsp;<input type="text" class="fld_txt wd_250"  name="txtEmail" id="txtEmail" />
					</td>
					<td align="left" colspan="2">
						&nbsp;<input type="text" class="fld_txt wd_200"  name="txtName" id="txtName" />
					</td>
				</tr>
				<tr>
					<td align="left" colspan="2">
						&nbsp;<input type="text" class="fld_txt wd_250"  name="txtEmail" id="txtEmail" />
					</td>
					<td align="left" colspan="2">
						&nbsp;<input type="text" class="fld_txt wd_200" name="txtName" id="txtName"/>
					</td>
				</tr>
				<tr>
					<td align="left" colspan="2">&nbsp;<input type="text" class="fld_txt wd_250"  name="txtEmail" id="txtEmail" /></td>
					<td align="left" colspan="2">
					&nbsp;<input type="text" class="fld_txt wd_200" name="txtName" id="txtName"/></td>
				</tr>
				</table>

				<div id="dvshowfield">
				<table class="tbl_content" cellspacing="2" cellpadding="10" border="0" width="100%">
				<tr><td align="right" colspan="2" ><input name="button" type="button" class="btn_sty" value="Add More" onclick="Javascript:fnaddfields();" alt="Add More" title="Add More"/></td></tr></table>
				</div>


				<table class="tbl_content" cellspacing="5" cellpadding="10" border="0" width="100%">
				<tr>
					<td class="gray_separator" colspan="4"> </td>
				</tr>
				<tr> 
					<td colspan="4">
					You can also invite friends using your Gmail, Hotmail, Yahoo or AOL address book.&nbsp;<u>Invite mail contacts>></u></td>
				</tr>
				<tr><td>&nbsp;</td>
				</tr>
				<tr>
					<td>
						<a  title="Hotmail" href="Javascript: Mydomain('myhotmail')" class="iconImg"><img src="{$img_path}myhotmail.gif" alt="Hotmail" border="0" /></a>
					</td>
					<td width="28%">
						<a title="Yahoo" href="Javascript: Mydomain('myyahoo')" class="iconImg"><img src="{$img_path}yahoo.gif" alt="Yahoo" border="0" /></a>
					</td>
					<td width="22%">
						<a  href="Javascript: Mydomain('myaol')" title="AOL" class="iconImg"><img src="{$img_path}AOL.gif" alt="AOL" border="0" /></a>
					</td>
					<td width="27%">
						<a   title="Gmail" href="Javascript: Mydomain('mygmail')" class="iconImg"><img src="{$img_path}gmail.gif" alt="Gmail" border="0" /></a>
					</td>
				</tr>

				<tr><td>&nbsp;</td></tr>
				</table></td>
			 </tr>
			
		<tr><td>
			<div id="EmailAddress" align="center" style="display:none"></div>
			<div id="notfound"  style="display:none"></div> 
			</td></tr>

			   <tr><td>
			   
			   <table width="100%" border="0" class="tbl_content" cellspacing="5" cellpadding="10">
                 <tr> <td colspan="2"><strong>You may personalize the invite to your friends by adding an additional message below.</strong></td> </tr>
                 <tr>
                   <td colspan="2"><span>Hi [name],</span><br />
                       <br />
                       <textarea name="textarea"  id="textarea" class="fld_txt wd_565" rows="5"></textarea></td>
                 </tr>
                 
                 <tr>
                   <td width="480">&nbsp;</td>
                   <td><input name="button" type="submit" class="btn_sty" value="Send Invite" alt="Send Invite" title="Send Invite"/></td>
                 </tr>
               </table></td>
			</tr>
		</table> 
		</td>
	</tr>

 <input type="hidden" name="cnttextbox" id = "cnttextbox" value="">
 <INPUT type="hidden" name="txtEmailIds" id="txtEmailIds" value="">
 <input type="hidden" name="txtNames" id="txtNames" value="">
 <input type="hidden" name="domain" id="domain" value="">

</table>

</form>
<div class="cl_both"></div>

</div>
<div id="container_bot">&nbsp;</div>
{literal}
<script language="javascript">
	function AddMore()
	{
		document.getElementById("addmore").style.display="";
		document.getElementById("traddmore").style.display="none";
	}

	function Mydomain(domainname)
	{
		document.frmUpdate.domain.value=domainname;
		fnPopupDiv('500', '100', '30', '40', 'importer',domainname,'');
	//	addPicker();
		//fnOpenPopupUserforImport('popup_importer',600);
	}

function fnaddfields() 
{

	if(document.frmUpdate.cnttextbox.value == 50)
	{
		alert("You can add Maximum 50 email addresses.");
		return false;
	}

	var browserName	= navigator.appName;

	document.getElementById("cnttextbox").value = parseInt(document.getElementById("cnttextbox").value) + 1;
	
	var str = document.getElementById("dvshowfield").innerHTML;
	var browserName	= navigator.appName;
	if(browserName == "Netscape") {
		var strReplace =  "<td colspan=\"2\" align=\"right\"><input name=\"button\" class=\"btn_sty\" value=\"Add More\" onclick=\"Javascript:fnaddfields();\" alt=\"Add More\" title=\"Add More\" type=\"button\"></td></tr></tbody></table>";
	}else {
		var strReplace =  "<TD align=right colSpan=2><INPUT class=btn_sty title=\"Add More\" onclick=Javascript:fnaddfields(); type=button alt=\"Add More\" value=\"Add More\" name=button></TD></TR></TBODY></TABLE>";
	}

	str = str.replace(strReplace, "");
	str += "<tr><td align=\"left\"  style=\"padding-left:5px\">&nbsp;<input type=\"text\" class=\"fld_txt wd_250\"  name=\"txtEmail\"  id=\"txtEmail\" /></td>";
	str +="<td align=\"left\">&nbsp;<input type=\"text\" class=\"fld_txt wd_200\" name=\"txtName\" id=\"txtName\"/></td></tr><tr>" + strReplace;
	document.getElementById("dvshowfield").innerHTML	=	str;
}

function InviteFriends()
{
	if(document.frmImport.username.value == "")
	{
		alert('Email address is required');
		document.frmImport.username.focus();
		return false;
	}
	if(!isValidEmail(document.frmImport.username)){
		document.frmImport.username.focus();
		return false;
	}

	if(document.frmImport.password.value == "")
	{
		alert('Password is required');
		document.frmImport.password.focus();
				return false;
	}
	
	var script = document.getElementById("script").value;
	document.frmImport.btnInvite.disabled = true;
	document.getElementById("ImportTbl").style.display = "none";
	document.getElementById("target").style.display = "block";
	ImportAddresses(script);
	return false;

}

function ImportAddresses(script)
{
	if(script == "mygmail")
		var url="./import/import.php";
	else
		var url="./importer/"+script+".php";

	xmlHttp	=GetXmlHttpObject(stateImportAddr)
	var uname = document.getElementById("username").value
	var password =document.getElementById("password").value;
	var domain =	script;
	var parameters= "username="+uname+"&password="+password+"&domain="+domain;
	xmlHttp.open("POST", url, false);
	xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	xmlHttp.send(parameters)
}

function stateImportAddr(){
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete") {
		fnHdnPopup('');
		document.getElementById("EmailAddress").style.display="";
		document.getElementById("EmailAddress").innerHTML	=	xmlHttp.responseText;
	}
}

function checkall(thestate){
var el_collection = document.frmUpdate.chkIds;
for (var c=0;c<el_collection.length;c++)
	el_collection[c].checked=thestate
}
</script>
{/literal}
