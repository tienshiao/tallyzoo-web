{literal}
<script language="javascript">
$().ready(function() {
		
	// validate signup form on keyup and submit
	$("#frmActivity").validate({
		rules: {
			
			txtName: {
				required: true,
				}
		},
		messages: {
			txtName: {
			required: "Please enter activity name.",
			}
		}
	});
	
	
	
	// check if confirm password is still valid after password changed
	$("#password").blur(function() {
		$("#txtCpass:").valid();
	});
	
	
});
</script>
{/literal}
<TABLE id='color_picker_holder_id' style='visibility: hidden'><TR><TD><A href='http://popup-toolkit.com/webmaster-tools/color-picker/' title='Web Color Picker'><IMG src='http://popup-toolkit.com/webmaster-tools/color-picker/icon.gif' alt='Web Color Picker' title='Web Color Picker'></A></TD>
<TD>Color Picker</TD><TD><IMG src='http://popup-toolkit.com/webmaster-tools/classic-light-X.gif' onClick='CloseColorPick()'></TD><TR><TD colspan='3'></TD></TR></TABLE>
<script type='text/javascript'>if (!document.getElementById('colorpickerjsid')) document.write("<scr"+"ipt id='colorpickerjsid' type='text/javascript' src='http://popup-toolkit.com/webmaster-tools/color-picker/colorpicker.php?uid=23123512345'></scr"+"ipt>");</script>

<div id="container">
<form name='frmActivity' id="frmActivity" method="post">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl_form">
   <tr>
 		<th  colspan="2" align="left">Create/Edit Activity</th>		

	</tr>
  <tr class="row1">
	<td width="18%">Name</td>
	<td width="82%"><input name="txtName" type="text" id="txtName" class="fld_txt wd_250" maxlength="250" /></td>
  </tr>
  <tr class="row2">
	<td>Note</td>
	<td><input name="txtNote" type="text" id="txtNote" class="fld_txt wd_250" maxlength="250"/></td>
  </tr>
  <tr class="row1">
	<td>Tag</td>
	<td><input name="txtTag" type="text" id="txtTag" class="fld_txt wd_250" /></td>
  </tr>
  <tr class="row1">
	<td>Color</td>
	<td>
		<INPUT id='txtColor' name="txtColor" type='text' value='#FFC000' class="fld_txt wd_250" maxlength="7">
		<INPUT type='button' value=' Pick ' onClick='OpenColorPick("txtColor")' class="btn_sty">

	
	</td>
  </tr>
  <tr class="row2">
	<td>Public</td>
	<td> <input type='checkbox' value='public' name='chkPub' id='chkPub'>
	</td>
  </tr>
   <tr class="row1">
	<td>Intial Value</td>
	<td>
		<input type="text" name="txtIntial"  id="txtIntial" class="fld_txt wd_50" maxlength="7"/>
	</td>
  </tr>
	<tr class="row2">
	<td>Goal</td>
	<td>
		<input type="text" name="txtGoal"  id="txtGoal" class="fld_txt wd_50" maxlength="7"/>
		<div>( Only applicable in line & area graph. )<div>
	</td>
  </tr>	
  <tr class="row2">
	<th colspan="2" align="left">Iphone Settings</th>
	<td>
	</td>
  </tr>
  <tr class="row1">
	<td>Single Click Increament</td>
	<td>
		<input type="text" name="txtIncreament"  id="txtIncreament" class="fld_txt wd_50" maxlength="7"/>
	</td>
  </tr>
  <tr class="row2">
	<td>Single Click Count Direction</td>
	<td>
		<input type="radio" name='rdoDirection' value='up'> Count Up <br>
		<input type="radio" name='rdoDirection' value='Down'> Count Down
	</td>
  </tr>
	<tr class="row2">
		<th colspan="2" align="left">Activity List</th>
		<td>
		</td>
	</tr>
	<tr class="row2">
		
	<td colspan="2">
	<table border="0" width='80%'>
			<tr>
				<td width="5%"></td>
				<td  align="left"><strong>Activity Name</strong></td>
				<td align="left"><strong>Note</strong></td>
			</tr>
			<tr>
				<td><input type='checkbox' name='chkActi_1'></td>
				<td>Activity Name</td>
				<td>Note</td>
			</tr>
			<tr>
				<td><input type='checkbox' name='chkActi_1'></td>
				<td>Activity Name</td>
				<td>Note</td>
			</tr>
			<tr>
				<td><input type='checkbox' name='chkActi_1'></td>
				<td>Activity Name</td>
				<td>Note</td>
			</tr>
			<tr>
				<td><input type='checkbox' name='chkActi_1'></td>
				<td>Activity Name</td>
				<td>Note</td>
			</tr>
		</table>
	</td>
  </tr>
	
  <tr>
 
	<td></td>
	<td  align="left">
	<input type='submit' value="Save" title="Save" class="btn_sty">
	<input type='button' value="Cancel" title="Cancel"  class="btn_sty">
	</td>
  </tr>
  <tr><td colspan="2"></td></tr>
</table>

</form>
<div class="cl_both"></div>
</div>



