{literal}
<script language="javascript">
function fnedit(id)
{
 document.frmPost.action="admin.php";
 document.frmPost.mid.value=id;
 document.frmPost.act.value='md';
 document.frmPost.mod.value='member_activity_details';
 document.frmPost.submit();
}

var cal1 = new ctlSpiffyCalendarBox("cal1", "frmPost", "txtDFrom","btnDate1","");
var cal2 = new ctlSpiffyCalendarBox("cal2", "frmPost", "txtDTo","btnDate2","");
</script>
{/literal}

<form id="frm" name="frm" method="post">
{$SUBMENU}
</form>
<form id="frmPost" name="frmPost" method="post" action="admin_ajax.php">
<input type="hidden" name="mod" value="">
<input type="hidden" name="act" value="">
<input type='hidden' name='mid' id="mid">
<p class="w890 mm h05">&nbsp;</p>
<div class="mm dispN" id="err_msg_list"></div>
<p class="hS2"><i></i></p>
<div class="w890 mm"><label class="font_brown">Search Options</label></div>  
<p class="w890 mm h05">&nbsp;</p>
<div class="w890 mm bAllGry">
	<fieldset class="mm w880">	
		<div class="clFx">
			<div class="fL w170">
				<label id="lpage">Username</label>
			</div>
			<div>
				<input type="text" class="w270" value="{$username}" name="txtUsername" id="txtUsername" maxlength="50"/>
			</div>
		</div>		 
		<p class="hS1"><i></i></p>	
		<div class="clFx">
			<div class="fL w170">
				<label>E-mail</label>
			</div>
			<div>
				<input type="text" class="w270" value="{$email}" name="txtEmail" id="txtEmail" maxlength="50"/>
			</div>
		</div>	
		<p class="hS1"><i></i></p>	
		<div class="clFx">
			<div class="fL w170">
				<label>Registered From &nbsp; </label>
			</div>
			<div><script language="JavaScript">cal1.writeControl();</script>&nbsp;(MM-dd-yyyy)
			</div>
			<div class="fL w170">
				<label> To </label>
			</div>
			<div><script language="JavaScript">cal2.writeControl();</script>&nbsp;(MM-dd-yyyy)
			</div>
		</div>		 
		<p class="hS1"><i></i></p>
		<div class="clFx">
			<div class="fL w170">
				<label>Status</label>
			</div>
			<div>
				<span>
					<input type="checkbox" class="nBr" id="chkActive" name="chkActive" {$CHKACTIVE}/>&nbsp;&nbsp;UnBlocked
				</span>
				<span class="mgrleft15">
					<input type="checkbox" class="nBr" id="chkInactive" name="chkInactive" {$CHKINACTIVE}/>&nbsp;&nbsp;Blocked
				</span>
			</div>
		</div>
		<p class="hS1"><i></i></p>
		<div class="clFx">
			<div class="fL w170">&nbsp;</div>
			<div>
				<input class="btnSty" type="button" name="Search" value="Search" alt="Search" title="Search" onClick="return fnShowResult('admin_ajax.php?mod=ajx_member_search','member_grid','frmPost');"/>
				<input  class="btnSty" type="Reset" name="Reset" value="Reset" alt="Reset" title="Reset"/>
			</div>
		</div>
		<br/>
	</fieldset>
</div>
<p class="hS4"><i></i></p>
<div class="w890 mm">
	<label class="font_brown">User List</label>
</div>
<div class="w890 mm" id="member_grid">
	{ if $err_msg neq ''}
		<div class="err_list mm w355" id="err_msg_list">{$err_msg}</div>
		<p class="hS2"><i></i></p>
	{ /if }
	<!-- Dategrid starts from here -->
	{$DATAGRID}
	<!-- Dategrid ends here -->
</div>		
</form>
<div id="spiffycalendar" class="text"></div>