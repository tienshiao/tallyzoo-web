{literal}
<script language="javascript">
$().ready(function() {

$("#frmRegister").validate(
{
		rules: {
			
			txtUName: {
				required: true,
				maxlength: 16
			},
			txtPass: {
				required: true,
				minlength: 8
			},
			txtCpass: {
				required: true,
				minlength: 8,
				equalTo: "#txtPass"
			},
			txtEmail: {
				required: true,
				email: true
			},
			cmbTimeZone:{
			required: true
			},
			terms:{
			required: true
			}
		},
		messages: {
			txtUName: {
			required: "Required.",
			maxlength: "Username will be 16 character maximum."
			},
			txtPass: {
				required: "Required.",
				minlength: "Your password must consist of at least 8 characters."
			},
			txtCpass: {
				required: "Required",
				equalTo: "Password and Confirm password must be same."
			},
			txtEmail: "Required",
			cmbTimeZone:"Required.",
			terms:"Required"
			
		}

	}
	);
	
	
	
	// check if confirm password is still valid after password changed
	$("#password").blur(function() {
		$("#txtCpass:").valid();
	});
	
	
});
 

function valideRegister()
{
	document.getElementById("lblTerms").style.display= "";
  
}

onload = calculate_time_zone;
</script>


{/literal}
<div id="container">
	  <p>&nbsp;</p>
		<div class="login_tabs">
       	<a href="{$SITEURL}login" id="ln_login">Login</a> <a href="javascript:;"  id="ln_signup" class="tabActive" >Sign Up</a></div>
        <div class="login_signup_box">
            
            
            <div id="sign_up" >
                
                    <h1>Create a  Account</h1>
                  <div class="tips">
                    <h2>Why TallyZoo.com</h2>
                    <ul>
                      <li>Easy - So track it</li>
                      <li>Change Your Life - Track habits you want to change</li>
                      <li>Dashboards - Spot trends &amp; Explore</li>
                      <li>Privacy Settings - Share it &amp; keep it private</li>
                      
                    </ul>
                  </div>
                  <form name="frmRegister" id="frmRegister" method="post" enctype="multipart/form-data" onSubmit="javascript:valideRegister();">
				   <input type="hidden" name="ACT" value="ADD">
				  <div id="mid_body" class="error" >{$error_msg}</div>
				<fieldset>
                        <p class="">
                          <label for="form-signup-username">Username</label>
                          <input type="text" value="{$ROW.username}" tabindex="1" size="25" name="txtUName" maxlength="255" id="txtUName" class="txt_fld" />
                        </p>
                        
                        <p class="">
                          <label for="form-signup-password">Password</label>
                          <input type="password" value="" tabindex="2" size="25" name="txtPass" maxlength="16" id="txtPass" class="txt_fld"/>
                        </p>
                        <p>
                          <label for="form-signup-password-confirm">Confirm Password</label>
                          <input type="password" value="" tabindex="3" size="25" name="txtCpass" maxlength="16" id="txtCpass" class="txt_fld"/>
                        </p>
						<p class="">
                          <label for="form-signup-email">Email</label>
                          <input type="text"  tabindex="4" size="25" name="txtEmail" maxlength="255" id="txtEmail" class="txt_fld" value="{$ROW.email}" />
                        </p>
						<!--
						<p>
                          <label for="form-signup-password-confirm">Image</label>
                          <input type="file"  tabindex="5" size="25" name="userPic"  id="userPic" class="txt_fld"/>
                        </p>
						<p>
                          <label for="form-signup-password-confirm">About me</label>
                          <textarea name="txtAboutMe" id="txtAboutMe" class="fld_txt wd_350" rows="6" tabIndex="7">{$ROW.about}</textarea>
                        </p>
						-->
						<p>
                          <label for="form-signup-password-confirm">Time Zone</label>
                          <select name="cmbTimeZone" id="cmbTimeZone" tabIndex="7" class="cmbTimeZone">
							<option value="">---------------Select-----------</option>
							{$cmbTimeZone}
						</select>
                        </p>
						
                        <p id="confirm-terms">
                          <input type="checkbox" tabindex="8" name="terms" id="terms" class="checkbox fl_lft"  />
                          <label for="terms">&nbsp; Yes, I agree to the TallyZoo.com <a href="{$SITEURL}content/16">Terms of Use</a></label>
						  <label style="display:none" id="lblTerms" class="error">Required.</label>
                          
                          
                        </p>
                        <p>
                          <input type="submit" value="Sign Up" tabindex="7" class="btn_sty" />
                        </p>
                    </fieldset>
                  </form>
                
            </div>
             <div class="cl_both"><img src="images/spacer.gif" width="1" height="1" alt="" /></div>
       </div>
       
	  <div class="cl_both"><img src="images/spacer.gif" width="1" height="1" alt="" /></div>
     </div>
    
    <div id="container_bot">&nbsp;</div>
	<!-- Container Ends -->