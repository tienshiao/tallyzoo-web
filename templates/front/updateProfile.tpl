
{literal}
<script language="javascript">

flag = 0;
function changePassword()
{ 
	if(flag == 0){
		flag = 1;
		document.getElementById("newpass").style.display = "";
		document.getElementById("cnewpass").style.display = "";
		
	}else{
		flag = 0;
		document.getElementById("newpass").style.display = "none";
		document.getElementById("cnewpass").style.display = "none";
		
	}
}
function submitFormUpdate()
{
	var doc = document.frmUpdate;
	
	document.getElementById('lblemail').style.display = "none";
	document.getElementById('lbltimeszone').style.display = "none";
	if(flag == 1){ 
	document.getElementById('lblcpass').style.display = "none";
	document.getElementById('lblpass').style.display = "none";
	}
	if(flag == 1){
		if(Trim(doc.txtPass.value) == "")
		{
			document.getElementById('lblpass').style.display ="";
			document.getElementById('lblpass').innerHTML='Required.';
			doc.txtPass.focus();
			return false;
		}
		if(doc.txtPass.value.length <8)
		{
			document.getElementById('lblpass').style.display ="";
			document.getElementById('lblpass').innerHTML='Your password must consist of at least 8 characters.';
			doc.txtPass.focus();
			return false;
		}
		if(Trim(doc.txtCpass.value) == "")
		{
			document.getElementById('lblcpass').style.display ="";
			document.getElementById('lblcpass').innerHTML='Required.';
			doc.txtCpass.focus();
			return false;
		}
		if(doc.txtCpass.value !=doc.txtPass.value)
		{
			document.getElementById('lblcpass').style.display ="";
			document.getElementById('lblcpass').innerHTML='Password and Confirm password must be same.';
			doc.txtCpass.focus();
			return false;
		}
	}

	if(Trim(doc.txtEmail.value) == "")
	{
		document.getElementById('lblemail').style.display ="";
		document.getElementById('lblemail').innerHTML='Required.';
		doc.txtEmail.focus();
		return false;
	}else{
		if(!IsEmail(doc.txtEmail.value))
		{
			document.getElementById('lblemail').style.display ="";
			document.getElementById('lblemail').innerHTML='Invalid Email Address.';
			doc.txtEmail.focus();
			return false;
		}
	}
	if(Trim(doc.cmbTimeZone.value) == "")
	{
		document.getElementById('lbltimeszone').style.display ="";
		document.getElementById('lbltimeszone').innerHTML='Required.';
		doc.cmbTimeZone.focus();
		return false;
	}
	
}


</script>


{/literal}
<div id="sub_menu_out">
    <div id="sub_menu">
    <a id="subActive" href="#">
    <span class="ln_lft"> </span>
    Profile
    <span class="ln_rgt"> </span>
    </a>
    </div>
</div>
<!-- Container Starts -->
	<div id="container">
    <div align="center" class="error" id="mid_body">{$error_msg}&nbsp;</div>
		<div class="block_content" id="my_profile">
       	  <h2>{$ROW.username}</h2>
            <form name="frmUpdate" id="frmUpdate" method="post" enctype="multipart/form-data" onSubmit="javascript:return submitFormUpdate();" >
<input type="hidden" value="UPDATE" name="ACT">
       	  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl_profile">
		  
        	  <tr>
        	    
        	    <td width="44%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<th colspan="2" align="left" class="tbl_hrdN">Profile</th>
					</tr>
        	      <!-- <tr>
        	        <th colspan="2">One word that would describe you best: <br />
       	            <input name="textfield4" type="text" class="fld_txt wd_300" id="textfield4" value="Ari" /></th>
       	          </tr> -->
        	      <tr>
        	        <th width="22%" valign="top">Image:</th>
        	        <td width="78%" class="img_link">
                    
                    <input type="file" name="userPic" id="userPic" class="file_field" /><!-- <br />
                    <img src="images/pics/pic_02.jpg" width="50" height="48" alt="" style="margin-top: 10px;" /> -->
                    </td>
      	        </tr>
                </tr>
                  {if $ROW.exImage neq ""}
                  <tr>
                	<td></td>
                	<td class="img_link">
                		{$ROW.imagename}
                
                	</td>
                 </tr>
                  {/if}
        	      <tr>
        	        <th valign="top">About me:</th>
        	        <td><textarea name="txtAboutMe" rows="5" class="fld_txt wd_250" id="txtAboutMe">{$ROW.about}</textarea></td>
      	        </tr>
       	        </table></td>
				<td width="5%"></td>
				<td width="56%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<th colspan="2" align="left" class="tbl_hrdN">Account Info</th>
					</tr>
        	      <!-- <tr>
        	        <th width="27%">Username:</th>
        	        <td width="73%"><input name="textfield2" type="text" class="fld_txt wd_250" id="textfield2" value="Ari4" /></td>
       	          </tr> -->
        	      <tr>
        	        <th>Email:</th>
                    <td><input name="txtEmail" type="text" id="txtEmail" class="fld_txt wd_250" id="textfield" value="{$ROW.email}" /><label id="lblemail" class="error"></label><span class="error">*</span></td>
       	          </tr>
                                 
           
        	      <tr>
        	        <th>Password:</th>
        	        <td><a href="javascript:;" onclick="changePassword();">change password</a></td>
       	          </tr>                
                                    
        	      <tr >
        	        <th colspan="2" nowrap="nowrap">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" >
        	          <tr id="newpass" style="display:none;">
        	        <th width="27%" nowrap="nowrap" >New Password:</th>
        	        <td width="73%"><input name="txtPass" type="password" id="txtPass" class="fld_txt wd_250" maxlength="250" /><label id="lblpass" class="error" style="display:none;"></label><span class="error">*</span></td>
       	          </tr>
                  <tr id="cnewpass" style="display:none;">
        	        <th width="27%" nowrap="nowrap">Confirm Password:</th>
        	        <td width="73%"><input name="txtCpass" type="password"  id="txtCpass" class="fld_txt wd_250" maxlength="250" /><label id="lblcpass" class="error" style="display:none;"></label><span class="error">*</span></td>
       	          </tr>
      	          </table></th>
      	        </tr>
        	     <tr>
        	        <th nowrap="nowrap">Time Zone:</th>
					<td><!-- <input type="checkbox" name="chkTimeZone" id="chkTimeZone" >&nbsp;&nbsp;Set Automatically --></td>
       	          </tr>
				  <tr>
				  <th colspan="2">
                 
					<select name="cmbTimeZone" id="cmbTimeZone" class="fld_sel">
       	              	<option value="">------------------------------------------Select------------------------------------------</option>
			{$cmbTimeZone}
   	                </select><label id="lbltimeszone" class="error"></label><span class="error">*</span>
				  </th>
				  </tr>
       	        </table></td>
       	    </tr>
       	  </table>
          <br />
       	  <table width="100%" border="0" cellspacing="0" cellpadding="0">
       	    <tr>
       	      <td align="right">
                 
                 <input value="Cancel" title="Cancel" class="btn_sty2 btn_cancel" type="button" onclick="javascript:fnredirect('index.php?mod=viewProfile');" /> &nbsp; &nbsp; 
                 <input type='submit' value="Save" title="Save"  class="btn_sty2 btn_save" /> </td>
   	        </tr>
   	      </table>
          </form>
        </div>

</div>
    
    <div id="container_bot">&nbsp;</div>
	<!-- Container Ends -->


