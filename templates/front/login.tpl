{literal}
<script language="javascript">
$().ready(function() {
$("#frmLogin").validate({
		rules: {
			
			txtUName: {
				required: true
			},
			txtPass: {
				required: true
			}
		},
		messages: {
			txtUName: "Required.",
			txtPass: "Required."
			}
	});

	document.frmLogin.txtUName.value = readCookie('tzu');
});

</script>
{/literal}
<div id="container">
	  <p>&nbsp;</p>
		<div class="login_tabs">
       	<a href="javascript:;"  class="tabActive" id="ln_login">Login</a> <a href="{$SITEURL}register" id="ln_signup">Sign Up</a></div>
        <div class="login_signup_box">
            <div class="login_box" id="login_box">
                <h1>Login</h1>
              <div class="tips">
                <h4>Don’t have an account?</h4>
                <a href="{$SITEURL}register" >Sign up now!</a>
                <h4 style="margin-top: 20px;">Did you forget your password?</h4>
                <a href="javascript:;"  onClick="javascript: fnPopupDiv('320', '100', '200', '300', 'forgotpass', '','');fnForgotValidate();">Recover it here.</a>
             </div>
              
              <form name='frmLogin' id='frmLogin' method='post' onSubmit="createCookie();">
			  <input type="hidden" name="ACT" value="Login">
			  <div id="mid_body" class="error" >{$error_msg}</div>
                <fieldset>
                    <p class="">
                      <label for="form-login-username">Username</label>
                      <input type="text" value="" tabindex="8" size="25" name="txtUName" maxlength="255" id="txtUName" class="txt_fld" />
                    </p>
                    <p>
                      <label for="form-login-password">Password</label>
                      <input type="password" value="" tabindex="9" size="25" name="txtPass" maxlength="16" id="txtPass" class="txt_fld"/>
                    </p>
                    <p id="remember_me">
                      <input type="checkbox" value="T" tabindex="10" name="remember" id="login-remember" class="checkbox"/>
                      <label for="login-remember"> Remember me on this computer.</label>
                    </p>
                    <p id="log_in">
                      <input type="submit" value="Log In" tabindex="11" class="btn_sty" />
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
