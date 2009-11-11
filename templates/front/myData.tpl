<script type="text/javascript" src="{$SITEURL}includes/javascript/jscolor/jscolor.js"></script>
<script src="{$SITEURL}includes/javascript/round.js" type="text/javascript"></script>

<div id="sub_menu_out">
    	<div id="sub_menu"><a href="{$SITEURL}myActivity"  title="My Activities"><span class="ln_lft">&nbsp;</span>My Activities<span class="ln_rgt">&nbsp;</span></a> <a href="javascript:;" id="subActive" title="My Data Feed"><span class="ln_lft">&nbsp;</span>My Data Feed<span class="ln_rgt">&nbsp;</span></a> </div>
    </div>
<div id="container">
<div align="center" class="error" id="mid_body">{$err_msg}&nbsp;</div>
<form name="frmmydata" method="post" >
<input type="hidden" name='editId' value="">
<input type="hidden" name='ACT' value="">
<input type="hidden" id="txtPage" name="txtPage">
<input type="hidden" id="perpage" name="perpage">
<div class="blue_block">
        	<div class="blue_block_in">
        	  
        	  <table border="0" cellspacing="0" cellpadding="0">
        	    <tr>
        	      <td><input name="txtQuickCnt" type="text" id="txtQuickCnt" value="Activity: Amount" class="fld_txt wd_250" onFocus="javascript:blankAmt();" /></td>
				   <td class="calendar" id="tdCal"><a href="javascript:;" onClick="javascript:showCal();"><img src="images/icons/cal.gif" width="16" height="20" alt="Calendar" /></a></td>
        	      <td><a href="javascript:;" onClick="javascript:quickAdd('myData');"><img src="images/btn_quick_add.gif" width="90" height="23" alt="Quick Add" /></a></td>
      	      </tr>
      	    </table>
       	  </div>
       </div>
		
		<div class="block_content">
		  
          <h2>My Data Feed</h2>
		 {if $actCount gt 0}

		  {if $pagelist neq ""}
			<table width="100%" border="0" cellspacing="0" class="pagingtable" >
			<tr>
				<td align="right">{$pagelist}</td>
			</tr>
		</table>
	{/if}
          <div class="tbl_block">


	 <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl_grid">	
		<tr>
			<th width="4%">&nbsp;</th>
			<th align="left" width="20%">Activity Name</th>
			<th align="left" width="20%">Note</th>
			<th align="left" width="17%">Date</th>
			<th align="left" width="5%" nowrap align="center">Count</th>
			<th align="center" width="18%"></th>
		</tr>
{section name=index loop=$ROW}
		<tr class="{cycle values='row2,row1'}">
			<td align="center"><div style="background-color: #{$ROW[index].color}; margin: 0pt auto; width: 20px; font-size: 2px; line-height: 10px; color: #ffffff;" class="rounded">&nbsp;</div>
			</td>
			<td class="activities"><span class="act_head"><a href="activities/{$ROW[index].actId}/{$ROW[index].name|sanitize_title_with_dashes}">{$ROW[index].name}</a></span></td>
			<td id="td_note_{$ROW[index].id}">
			<a class="tooltip" href="javascript:">{$ROW[index].note|truncate:40:"...":false}<b><em></em>{$ROW[index].note}</b></a>

			
			</td>
			<td id="td_date_{$ROW[index].id}">{$ROW[index].created_on}</td>
			<td id="td_amount_{$ROW[index].id}">{$ROW[index].amount}</td>
			<td align="right">
			<a href="javascript:;" title="Save"  id="a_save_{$ROW[index].id}" style="display:none;" onClick="javascript:saveRow('{$ROW[index].id}');">Save</a><span style="display:none;" id="span_{$ROW[index].id}">|</span><a href="javascript:;" title="Cancel"  id="a_cancel_{$ROW[index].id}" style="display:none;" onClick="javascript:cancel('{$ROW[index].id}');">Cancel</a>
			<a href="javascript:;"  title="Edit" id="a_edit_{$ROW[index].id}" onClick="editRow('{$ROW[index].id}');">Edit</a>&nbsp;<a title="Delete" href="javascript:deleAct('{$ROW[index].id}');" class="iconImg"><img src="images/icons/delete.gif" border="0"></a></td>
		</tr>
{/section}
	</table>
	</div>
          <div class="tbl_block_bot">&nbsp;</div>
		  {if $pagelist neq ""}
			<table width="100%" border="0" cellspacing="0" class="pagingtable" >
			<tr>
				<td align="right">{$pagelist}</td>
			</tr>
		</table>
	{/if}
		
		<script type="text/javascript">
			Rounded('rounded', 6, 6);
	</script>
{else}
	<div align="center" class="error" id="mid_body">No activity found.</div>

{/if}
</form>
</div>
</div>
<div id="container_bot">&nbsp;</div>
{literal}
<script language="javascript">
function showpagingresult(pageno,numrecordperrow)
{
	document.getElementById('txtPage').value = pageno;
	document.getElementById('perpage').value = numrecordperrow;
	document.frmmydata.submit();

}
function deleAct(id)
{
	if(confirm('                  !! WARNING !!\n------------------------------------------------------------\n                  Data Feed will be deleted.\n                  Are you sure?'))
	{
		document.frmmydata.editId.value = id;
		document.frmmydata.ACT.value = "DELETE";
		document.frmmydata.action = "{/literal}{$SITEURL}myData{literal}";
		document.frmmydata.submit();
		
		
	}
}


var responseText = "";
function editRow(id)
{
	notId = "td_note_" + id;
	tagsId = "td_tags_" + id;		
	amtId = "td_amount_" + id;		
	editId = "a_edit_" + id;
	saveId = "a_save_" + id;
	cancelId = "a_cancel_" + id;
	pipeId = "span_" + id;
	dateId = "td_date_"+ id;

	value = "id=" + id + "&ACT=edit";
	responseText = str = submitAjax(6,value);
	arr = str.split("@**#");
	noteTextBox = "<input type=\"text\" name=\"txtNote_" + id+ "\" id=\"txtNote_" + id + "\" class=\"fld_txt wd_180\" value=\"" + arr[0] + "\">";
	tagsTextBox = "<input type=\"text\" name=\"txtTag_" + id + "\" id=\"txtTag_" + id + "\" class=\"fld_txt wd_180\" value=\"" + arr[1] + "\">";
	amtTextBox = "<input type=\"text\" name=\"txtCount_" + id + "\" id=\"txtCount_" + id + "\" class=\"fld_txt wd_100\" value=\"" + arr[2] + "\">";

	dateTextBox = "<input type=\"text\" name=\"txtDate_" + id + "\" id=\"txtDate_" + id + "\" class=\"fld_txt wd_180\" value=\"" + arr[3] + "\">";
	
	document.getElementById(notId).innerHTML = noteTextBox;
	/*document.getElementById(tagsId).innerHTML = tagsTextBox;*/
	document.getElementById(dateId).innerHTML = dateTextBox;
	document.getElementById(amtId).innerHTML = amtTextBox;
	document.getElementById(editId).style.display = "none";
	document.getElementById(saveId).style.display = "";
	document.getElementById(cancelId).style.display = "";
	document.getElementById(pipeId).style.display = "";
	
}
function saveRow(id)
{
	notId = "td_note_" + id;
	tagsId = "td_tags_" + id;		
	amtId = "td_amount_" + id;		
	editId = "a_edit_" + id;
	saveId = "a_save_" + id;
	cancelId = "a_cancel_" + id;
	pipeId = "span_" + id;
	dateId = "td_date_"+ id;

	txtNoteId = "txtNote_" + id;
	txtTagsId = "txtTag_" + id;
	txtCountId = "txtCount_" + id;
	txtDate = "txtDate_"+ id;
	
	value = "id=" + id + "&ACT=save&txtNote=" + encodeURIComponent(document.getElementById(txtNoteId).value) +  "&txtCount=" +  encodeURIComponent(document.getElementById(txtCountId).value) + "&txtDate=" + encodeURIComponent(document.getElementById(txtDate).value);
	str = submitAjax(6,value);

	var note = document.getElementById(txtNoteId).value;
	if(note.length >40)
	{
		subnote = note.substring(0,40) + "...";
	}else{
		subnote = note;
	}
	if(Trim(note) != "")
	{
		note = "<a class=\"tooltip\" href=\"javascript:;\">" + subnote + "<b><em></em>" + note + "</b></a>"
	}
	document.getElementById(notId).innerHTML = note;

	/*document.getElementById(tagsId).innerHTML = document.getElementById(txtTagsId).value;
	*/
	document.getElementById(dateId).innerHTML = document.getElementById(txtDate).value;
	document.getElementById(amtId).innerHTML = document.getElementById(txtCountId).value;
	document.getElementById(editId).style.display = "";
	document.getElementById(saveId).style.display = "none";
	document.getElementById(cancelId).style.display = "none";
	document.getElementById(pipeId).style.display = "none";
	
}
function cancel(id)
{
	notId = "td_note_" + id;
	tagsId = "td_tags_" + id;		
	amtId = "td_amount_" + id;		
	editId = "a_edit_" + id;
	saveId = "a_save_" + id;
	cancelId = "a_cancel_" + id;
	pipeId = "span_" + id;
	dateId = "td_date_"+ id;

	arr = responseText.split("@**#");
	noteTextBox = arr[0];
	tagsTextBox = arr[1];
	amtTextBox = arr[2];
	dateTextBox = arr[3];

	var note = noteTextBox;
	if(note.length >40)
	{
		subnote = note.substring(0,40) + "...";
	}else{
		subnote = note;
	}
	if(Trim(note) != "")
	{
		note = "<a class=\"tooltip\" href=\"javascript:;\">" + subnote + "<b><em></em>" + note + "</b></a>"
	}
	document.getElementById(notId).innerHTML = note;
	/*document.getElementById(tagsId).innerHTML = tagsTextBox;*/
	document.getElementById(dateId).innerHTML = dateTextBox;
	document.getElementById(amtId).innerHTML = amtTextBox;
	document.getElementById(editId).style.display = "";
	document.getElementById(saveId).style.display = "none";
	document.getElementById(cancelId).style.display = "none";
	document.getElementById(pipeId).style.display = "none";

}

function addPicker()
{
	var myPicker = new jscolor.color(document.getElementById('txtColor'), {})
	myPicker.fromString('6BFAFF')
}
</script>
{/literal}