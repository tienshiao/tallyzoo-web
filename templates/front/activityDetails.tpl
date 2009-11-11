{literal}
<script language="javascript">
var cal1 = new ctlSpiffyCalendarBox("cal1", "frmView", "txtDateQuick","btnDate1","");
function showpagingresult(pageno,numrecordperrow)
{	document.frmView.target = "";
	document.getElementById('txtPage').value = pageno;
	document.getElementById('perpage').value = numrecordperrow;
	document.frmView.submit();

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
	noteTextBox = "<input type=\"text\" name=\"txtNote_" + id+ "\" id=\"txtNote_" + id + "\" class=\"fld_txt wd_150\" value=\"" + arr[0] + "\">";
	tagsTextBox = "<input type=\"text\" name=\"txtTag_" + id + "\" id=\"txtTag_" + id + "\" class=\"fld_txt wd_180\" value=\"" + arr[1] + "\">";
	amtTextBox = "<input type=\"text\" name=\"txtCount_" + id + "\" id=\"txtCount_" + id + "\" class=\"fld_txt wd_50\" value=\"" + arr[2] + "\">";

	dateTextBox = "<input type=\"text\" name=\"txtDate_" + id + "\" id=\"txtDate_" + id + "\" class=\"fld_txt wd_150\" value=\"" + arr[3] + "\" >";
	
	document.getElementById(notId).innerHTML = noteTextBox;
	/*document.getElementById(tagsId).innerHTML = tagsTextBox;*/
	document.getElementById(dateId).innerHTML = dateTextBox;
	document.getElementById(amtId).innerHTML = amtTextBox;
	document.getElementById(editId).style.display = "none";
	document.getElementById(saveId).style.display = "";
	document.getElementById(cancelId).style.display = "";
	document.getElementById(pipeId).style.display = "";
	
}
function saveRow(id,filterActiId)
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
	actiId = document.getElementById('editId').value;
	value = "id=" + id + "&ACT=save&txtNote=" + encodeURIComponent(document.getElementById(txtNoteId).value) +  "&txtCount=" +  encodeURIComponent(document.getElementById(txtCountId).value) + "&txtDate=" + encodeURIComponent(document.getElementById(txtDate).value) + "&actiId=" + actiId;
	str = submitAjax(6,value);
	if(Trim(str) != "")
	{
		eval(str);
	}
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
	if(filterActiId >0){
	subActiMyData(filterActiId);
	}
	
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

function showTabs(cnt)
{
	if(cnt == 1)
	{
		document.getElementById("echoDiv").style.display="";
		document.getElementById("dataDiv").style.display="none";
		document.getElementById("a_ehco").className="active";
		document.getElementById("a_data").className="";
		document.getElementById("tabactive").value="echo";
		
	}else{ 
		document.getElementById("echoDiv").style.display="none";
		document.getElementById("dataDiv").style.display="";
		document.getElementById("a_ehco").className="";
		document.getElementById("a_data").className="active";
		document.getElementById("tabactive").value="data";
	}
}
function viewActivity(id)
{
		document.frmView.editId.value = id;
		document.frmView.ACT.value = "VIEWFACTI";
		document.frmView.target = "";
		document.frmView.action = "index.php?mod=activityDetails";
		document.frmView.submit();
}
function deleAct(id)
{
	if(confirm('Are you sure, you want to delete this record?.'))
	{
		document.frmView.dataId.value = id;
		document.frmView.ACT.value = "DELETE";
		document.frmView.action = location.href;
		document.frmView.submit();
	}
}
function showProfile(uid)
{
	document.frmView.userId.value = uid;
	document.frmView.action = "{/literal}{$SITEURL}{literal}viewProfile";
	document.frmView.submit();
}
/*****************************************************
Written By: Deepak Kamle
Written On: 08-Sep-2009
*****************************************************/

function fnCountValidate()
{ 
	
	var doc = document.frmView;
	{/literal}
	{if $ROW.activity_type eq 1}
	{literal}
	if(doc.cmbActivity)
	{
		if(Trim(doc.cmbActivity.value) == "" )
		{
			alert("Please select activity.");
			doc.cmbActivity.focus();
			return false;
		}
	}
	{/literal}
	{/if}
	{literal}
	if(Trim(doc.txtCount.value) == "" || Trim(doc.txtCount.value) =="#")
	{
		alert("Please enter count.");
		doc.txtCount.focus();
		return false;
	}else{
		if(isNaN(doc.txtCount.value))
		{
			alert("Only numeric/float value is allowed.");
			doc.txtCount.focus();
			return false;		
		}
	}
	if(document.getElementById('txtDateQuick')){
	 date = document.getElementById('txtDateQuick').value;
	  if(!check_date('txtDateQuick'))
	  {
			document.getElementById('txtDateQuick').focus();
			return false;
	  }
	
	}
	if(Trim(doc.txtNote.value) == "Notes")
	{
		doc.txtNote.value = "";
	}
	doc.target = "activityframe";
	doc.action = "{/literal}{$SITEURL}user/ajx_comman.php?case=5{literal}";
	
	

}

function fnshowNote(flag) {
		if(flag) {
			document.getElementById('note_text').style.display = 'block';
			//document.getElementById('hide_note').style.display = 'block';
			document.getElementById('show_note').innerHTML = "<a href=\"javascript:;\" onclick=\"javascript:fnshowNote(0);\">Hide Note</a>";
		} else {
			document.getElementById('note_text').style.display = 'none';
			//document.getElementById('hide_note').style.display = 'none';
			document.getElementById('show_note').innerHTML = "<a href=\"javascript:;\" onclick=\"javascript:fnshowNote(1);\">Show Note</a>";
		}
	}

function subActiMyData(id)
{ 
	var responseText = $.ajax({
	type: "POST",
	url: "{/literal}{$SITEURL}index_ajax.php?mod=subMyData{literal}",
	data: "actiId=" + id,
	async: false
	}).responseText;
	document.getElementById("tblMyData").innerHTML = responseText;
	Rounded('rounded', 6, 6);
	if(document.getElementById('filterDiv')){
		obj = document.getElementById('filterDiv').getElementsByTagName('a');
		len = obj.length;

		for(i=0;i<len;i++)
		{
			aid = obj[i].id;
			if(aid==id){
			 document.getElementById(aid).className="filter_act_cls";
			}else{
				document.getElementById(aid).className="";
			  }
		}
	}
}
function subActiMyDataForIframe(id)
{ 
	var responseText = $.ajax({
	type: "POST",
	url: "{/literal}{$SITEURL}index_ajax.php?mod=subMyData{literal}",
	data: "actiId=" + id,
	async: false
	}).responseText;
	parent.document.getElementById("tblMyData").innerHTML = responseText;
	Rounded('rounded', 6, 6);
	setTimeout(function () {setErrorNull();}, 5000);
	if(document.getElementById('filterDiv')){
		obj = document.getElementById('filterDiv').getElementsByTagName('a');
		len = obj.length;

		for(i=0;i<len;i++)
		{
			aid = obj[i].id;
			if(aid==id){
			 document.getElementById(aid).className="filter_act_cls";
			}else{
				document.getElementById(aid).className="";
			  }
		}
	}	
}
function backToSearch()
{
	document.frmsearch.submit();
}
function setErrorNull(timeMiliSec)
{  
	document.getElementById("mid_body").innerHTML = "";
}
{/literal}
{if $smarty.post.ACT eq 'DELETE'}
{literal}
setTimeout(function () {setErrorNull();}, 10000);
{/literal}
{/if}
{literal}
</script>
{/literal}
<script src="{$SITEURL}includes/javascript/round.js" type="text/javascript"></script>
<script type="text/javascript" src="{$SITEURL}includes/javascript/jscolor/jscolor.js"></script>

<iframe id="activityframe" name="activityframe" width='0' height='0' frameborder="0"  border='0'></iframe>
<!-- Header Ends -->
	
    <div id="sub_menu_out">
    	<div id="sub_menu">
		{if $ownerFlag eq 1}
		<a href="index.php?mod=myActivity" 
		id="subActive"><span class="ln_lft">&nbsp;</span>My Activities<span class="ln_rgt">&nbsp;</span></a>
		<a href="index.php?mod=myData"><span class="ln_lft">&nbsp;</span>My Data Feed<span class="ln_rgt">&nbsp;</span></a>
		{else}
		<a href="viewProfile/{$ROW.user_id}" id="subActive" ><span class="ln_lft">&nbsp;</span><b>{$ROWUSER.username}</b><span class="ln_rgt">&nbsp;</span></a>
		
		{/if}
		 </div>
    </div>
    
	<!-- Container Starts -->
	<div id="container">

    <form name="frmView" method="post"  onSubmit="javascript:return fnCountValidate();">
	<input type="hidden" id="txtPage" name="txtPage">
	<input type="hidden" id="perpage" name="perpage">
	<input type="hidden" id="editId" name="editId" value="{$ROW.id}">
	<input type="hidden" id="tabactive" name="tabactive" value="{$smarty.post.tabactive}">
	<input type="hidden" name='ACT' value="">
	<input type="hidden" name='dataId' value="">
	<input type="hidden" name="userId">
	<input type="hidden" name='idOwnFlag' id='idOwnFlag' value="{$ownerFlag}">
	<input type='hidden' name='txtGoal' id='txtGoal' value="{$ROW.goal}">
	<div class="gray2_block_content">
		<div class="block_top"><div>&nbsp;</div></div>
		<div class="block_mid">
				
		  <div class="view_top_section2">
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
				  <tr>
					<td width="79%"><table border="0" cellspacing="0" cellpadding="0">
					  <tr>
						<td width="70" class="img_link"><a 
						{if $ownerFlag eq 1}
						href="javascript:;"
						{else}
						href="{$SITEURL}viewProfile/{$ROW.user_id}')"
						{/if}
							>{$ROWUSER.imagename}</a></td>
						<td colspan="2" nowrap="nowrap"><h2>{$ROW.name|truncate:35:"...":true}</h2></td>
						 </tr>
					  </table>
					  <p class="note_text" id="note_text" style="display: none;">{$ROW.default_note}</p>
					</td>
					<td width="21%" align="right" valign="bottom">{if $ROW.hidden eq 1}
						<img src="images/icons/public3_new.gif" width="55" height="21" alt="Public" />
						{/if}
					  <table border="0" cellspacing="0" cellpadding="0">
						<tr>
						  <td>{if $ROW.default_note neq ''}<p id="show_note">
						    <a href="javascript:;" onclick="javascript:fnshowNote(1);" >View Note</a>						  
						  </p>
						  {/if}
						  </td>
						  <td><p> &nbsp; 
						  {if $ownerFlag eq 1}
						  <a id="edit_link" href="javascript:fnPopupDiv('900','250','40','40','addActivity','EDIT','{$smarty.get.editId}');prev_{$fnGraph}">Edit</a>
						  {/if}
						  </p></td>
						</tr>
					  </table>
					  
					</td>
				</tr>
		  </table>
		  </div>
		  			  
		 <div class="view_content_section">
		 <div align="center"  id="mid_body">{$err_msg}</div>
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
			  <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl_insides2">
				<tr class="row1">
				  <th>Chart</th>
				</tr>
				
				<tr class="row_gray">
				 <td>
					<table width="100%" border="0" cellspacing="8" cellpadding="0" >
						<tr class="row2">
				{if $ownerFlag eq 1}
				  <td width="28%" valign="top"><div class="fld_set">
				   
					<p><strong>Add Count</strong></p>
					<p>
						{if $ROW.activity_type eq 1}
						  <select name="cmbActivity" class="fld_sel wd_150">
							<option value="">--Activity--</option>
							{section name=index loop=$ROWSUBACTI}	
								<option value="{$ROWSUBACTI[index].activity_id}">{$ROWSUBACTI[index].name}</option>
							{/section}
						</select>
   					  {/if}
					</p>
					<p>
					  <input name="txtCount" type="text" class="fld_txt wd_75" id="txtCount" value="#"  onFocus="javascript:fnblank('txtCount');"/>
					  </p>
					  <p>
					  <span id="tdCal">
					  <!--
					  <a href="javascript:;" onClick="javascript:showCalSmall();"><img src="images/icons/cal.gif" alt="Calendar" width="16" height="20" align="absmiddle" /></a>
					  -->
					  <script language="javascript">
					   var calControl = cal1.writeControl();
					   document.write(calControl);
					  </script>
					  </span>
					  </p>

					
					<p>
					  <textarea name="txtNote"  id="txtNote" 
					  {if $ROW.activity_type eq 1}
					  rows="9"
					  {else}
					  rows="10"
					  {/if}
					  class="fld_txt wd_175" onFocus="javascript:fnblank('txtNote');"
					  >Notes</textarea>
					</p>
					<p>
					  <input type="submit" name="button" id="button" value="Save" class="btn_sty2 btn_save" />
					</p>
				  </div></td>
				  {/if}
				  <td  align="right" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="noPad">
					<tr class="row2">
					  <td align="left" valign="bottom" class="activities">
					  <div id='chartContainer' align='center'>
						
						<img src="images/indicatorbar.gif" style="padding-top:80px;">
						</div>
                        <div id="showHide" style="display:none"><div style="display:none" id="a_showhide"></div></div>
                        {if $ROW.activity_type eq 1}
						<p style="text-align:right; font-size:.9em;"><a href="javascript:;" onClick="$('#legendContainer').slideToggle(.5);" title='Show/Hide Legend'>Show/Hide Legend</a> &nbsp; &nbsp;</p>
                        <div id='legendContainer' align='center' style="display:none">
                            {if $fnLegendClick eq 'compareDataSet'}
                            Select base activity:
                            <select onchange="$('#chartContainer embed').get(0).selectDataSet(this.value)">
                                {section name=index loop=$ROWSUBACTI}
                                <option value="{$smarty.section.index.index}">{$ROWSUBACTI[index].name}</option>
                                {/section}
                            </select>
                            <table width="100%">
                                <tr>
                                    <td valign="top">
                                    <table width="100%">
                                        {math equation="ceil(count/2)" count=$ROWSUBACTI|@count assign="actCount2"}
                                        {section name=index loop=$ROWSUBACTI max=$actCount2}
                                        <tr height="30px">
                                            <td valign="top" width="30px">
                                                <div style="background-color: #{$ROWSUBACTI[index].color}; margin: 0; width: 20px; font-size: 2px; line-height: 10px; color: #ffffff;" class="lrounded">&nbsp;</div>
                                            </td>
                                            <td valign="top">
                                                <input type="checkbox" onChange="if (this.checked) $('#chartContainer embed').get(0).compareDataSet({$smarty.section.index.index}); else $('#chartContainer embed').get(0).uncompareDataSet({$smarty.section.index.index});" /> {$ROWSUBACTI[index].name}<br />
                                            </td>
                                        </tr>
                                        {/section}
                                    </table>
                                    </td>
                                    <td valign="top">
                                    <table width="100%">
                                        {section name=index loop=$ROWSUBACTI start=$actCount2}
                                        <tr height="30px">
                                            <td valign="top" width="30px">
                                                <div style="background-color: #{$ROWSUBACTI[index].color}; margin: 0; width: 20px; font-size: 2px; line-height: 10px; color: #ffffff;" class="lrounded">&nbsp;</div>
                                            </td>
                                            <td valign="top">
                                                <input type="checkbox" onChange="if (this.checked) $('#chartContainer embed').get(0).compareDataSet({$smarty.section.index.index}); else $('#chartContainer embed').get(0).uncompareDataSet({$smarty.section.index.index});" /> {$ROWSUBACTI[index].name}<br />
                                            </td>
                                        </tr>
                                        {/section}
                                    </table>
                                    </td>
                                </tr>
                            </table>
                            {elseif $fnLegendClick eq 'showGraph'}
                            <table width="100%">
                                <tr>
                                    <td valign="top">
                                    <table width="100%">
                                        {math equation="ceil(count/2)" count=$ROWSUBACTI|@count assign="actCount2"}
                                        {section name=index loop=$ROWSUBACTI max=$actCount2}
                                        <tr height="30px">
                                            <td valign="top" width="30px">
                                                <div style="background-color: #{$ROWSUBACTI[index].color}; margin: 0; width: 20px; font-size: 2px; line-height: 10px; color: #ffffff;" class="lrounded">&nbsp;</div>
                                            </td>
                                            <td valign="top">
                                                <input type="checkbox" onChange="if (this.checked) $('#chartContainer embed').get(0).showGraph({$smarty.section.index.index}); else $('#chartContainer embed').get(0).hideGraph({$smarty.section.index.index});" checked /> {$ROWSUBACTI[index].name}<br />
                                            </td>
                                        </tr>
                                        {/section}
                                    </table>
                                    </td>
                                    <td valign="top">
                                    <table width="100%">
                                        {section name=index loop=$ROWSUBACTI start=$actCount2}
                                        <tr height="30px">
                                            <td valign="top" width="30px">
                                                <div style="background-color: #{$ROWSUBACTI[index].color}; margin: 0; width: 20px; font-size: 2px; line-height: 10px; color: #ffffff;" class="lrounded">&nbsp;</div>
                                            </td>
                                            <td valign="top">
                                                <input type="checkbox" onChange="if (this.checked) $('#chartContainer embed').get(0).showGraph({$smarty.section.index.index}); else $('#chartContainer embed').get(0).hideGraph({$smarty.section.index.index});" checked /> {$ROWSUBACTI[index].name}<br />
                                            </td>
                                        </tr>
                                        {/section}
                                    </table>
                                    </td>
                                </tr>
                            </table>
                            {else}
                            {math equation="ceil(count/2)" count=$ROWSUBACTI|@count assign="actCount2"}
                            <table width="100%">
                                <tr>
                                    <td valign="top" width="50%">
                                    <table width="100%">
                                        {section name=index loop=$ROWSUBACTI max=$actCount2}
                                        <tr height="30px">
                                            <td valign="top" width="30px">
                                                <div style="background-color: #{$ROWSUBACTI[index].color}; margin: 0; width: 20px; font-size: 2px; line-height: 10px; color: #ffffff;" class="lrounded">&nbsp;</div>
                                            </td>
                                            <td valign="top">
                                                <a href="javascript:;" onClick="{if $fnLegendClick} $('#chartContainer embed').get(0).{$fnLegendClick}({$smarty.section.index.index}){/if};"> {$ROWSUBACTI[index].name}</a><br/>
                                            </td>
                                        </tr>
                                        {/section}
                                    </table>
                                    </td>
                                    <td valign="top">
                                    <table width="100%" width="50%">
                                        {section name=index loop=$ROWSUBACTI start=$actCount2}
                                        <tr height="30px">
                                            <td valign="top" width="30px">
                                                <div style="background-color: #{$ROWSUBACTI[index].color}; margin: 0; width: 20px; font-size: 2px; line-height: 10px; color: #ffffff;" class="lrounded">&nbsp;</div>
                                            </td>
                                            <td valign="top">
                                                <a href="javascript:;" onClick="{if $fnLegendClick} $('#chartContainer embed').get(0).{$fnLegendClick}({$smarty.section.index.index}){/if};"> {$ROWSUBACTI[index].name}</a><br/>
                                            </td>
                                        </tr>
                                        {/section}
                                    </table>
                                    </td>
                                </tr>
                            </table>
                            {/if}
                            <script language="javascript">
                                Rounded("lrounded", 6, 6);
                            </script>
                        </div>
                        {/if}
						</td>
					</tr>
				  </table></td>
					</tr>
			  </table>
			  <script language="javascript">	
						{$fnGraph}
				</script>
			</td>
				</tr>
			  </table>
			  <p>&nbsp;</p>
				
			  {if $ownerFlag eq '0'}
				{assign var="showecho" value=""}
				{assign var="showdata" value="none"}
			  {else}
				{assign var="showecho" value="none"}
				{assign var="showdata" value=""}
			  {/if}
			  
				  <table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
						  <td class="tabs_sub3"><div><a href="javascript:;" onClick="javascript:showTabs(1);" {if $smarty.post.tabactive eq 'echo' or $ownerFlag eq 0}
					class="active" {/if} title="Comments" id="a_ehco">Comments</a> <a href="javascript:;" {if $smarty.post.tabactive eq 'data' or $ownerFlag eq 1}
					class="active" {/if} onClick="javascript:showTabs(2);" title="Data"  id="a_data">Data</a></div></td>
					</tr>
						<tr>
						  <td class="tabs_sub_container">

						  <div id="echoDiv" style="display:{$showecho};">
								
						<div class="js-kit-comments" permalink="" unique="{$smarty.const._JS_KIT_PREFIX_}{$smarty.get.editId}" ></div><script src="http://js-kit.com/for/tallyzoo.com/comments.js"></script>
						</div>
						
						<div id="dataDiv" style="display:{$showdata};">
						{if $actCount gt 0}
							<div class="block_content">
						   {if $ROW.activity_type eq 1}
								<div class="filters" id="filterDiv"><a href="javascript:;" onClick="javascript:subActiMyData('{$ROW.id}');;" class="filter_act_cls" id="{$ROW.id}">All</a>
								{section name=index loop=$ROWSUBACTI}
								<a href="javascript:;" onClick="javascript:subActiMyData('{$ROWSUBACTI[index].activity_id}');" id="{$ROWSUBACTI[index].activity_id}">{$ROWSUBACTI[index].name}</a>
								{/section}
								
								</div>
								{/if}
								<div class="cl_both"><img src="images/spacer.gif" width="1" height="1" alt="" /></div>
								
							   <div  id="tblMyData">

							
								 <table width="100%" cellspacing="0" cellpadding="0" border="0" class="tbl_insides2">	
									<tbody><tr>
										<th width="10%">&nbsp;</th>
										<th width="33%" align="left">Note</th>
										<th width="30%" align="left">Date</th>
										<th width="13%" nowrap="" align="left">Count</th>
										<th width="14%" nowrap="" align="left">&nbsp;</th>
										</tr>
										{section name=index loop=$ROWDATA}
								<tr class="{cycle values='row2,row1'}">
									<td align="center"><div style="background-color: #{$ROWDATA[index].color}; margin: 0pt auto; width: 20px; font-size: 2px; line-height: 10px; color: #ffffff;" class="rounded">&nbsp;</div>
									</td>
									
									<td id="td_note_{$ROWDATA[index].id}">
									<a class="tooltip" href="javascript:">{$ROWDATA[index].note|truncate:40:"...":false}<b><em></em>{$ROWDATA[index].note}</b></a>

									
									</td>
									<td id="td_date_{$ROWDATA[index].id}" nowrap>{$ROWDATA[index].created_on}</td>
									<td id="td_amount_{$ROWDATA[index].id}">{$ROWDATA[index].amount}</td>
									
									<td align="right"  nowrap>
									{if $ownerFlag eq 1}
									<a href="javascript:;" title="Save"  id="a_save_{$ROWDATA[index].id}" style="display:none;" onClick="javascript:saveRow('{$ROWDATA[index].id}','{$ROWDATA[index].actId}');">Save</a><span style="display:none;" id="span_{$ROWDATA[index].id}">|</span><a href="javascript:;" title="Cancel"  id="a_cancel_{$ROWDATA[index].id}" style="display:none;" onClick="javascript:cancel('{$ROWDATA[index].id}');">Cancel</a>
									<a href="javascript:;"  title="Edit" id="a_edit_{$ROWDATA[index].id}" onClick="editRow('{$ROWDATA[index].id}');">Edit</a>&nbsp;<a title="Delete" href="javascript:deleAct('{$ROWDATA[index].id}');" class="iconImg"><img src="images/icons/delete.gif" border="0"></a>
									{/if}
									&nbsp;&nbsp;
									</td>
									
								</tr>
						{/section}
										
								</tbody></table>
							
								</div>
							</div>
								  <script type="text/javascript">
										Rounded('rounded', 6, 6);
								</script>
							{else}
							<div align="center"  id="tblMyData"><span class="error">No activity found.</span></div>

							{/if}						
							</div>
							
						  </td>
					</tr>
				</table></td>
			  <td width="185" align="right" valign="top"><table width="95%" border="0" cellspacing="0" cellpadding="0" class="tbl_insides_adds">
				<tr class="row1">
				  <th>Ads</th>
				</tr>
				<tr class="row1">
				  <td align="center" ><img src="images/google_adds.gif" width="160" height="649" alt="Ads by Google" /></td>
				</tr>
				</table></td>
			</tr>
		  </table>

		 </div>
		  
		  
		</div>
			  
		<div class="block_bot"><div>&nbsp;</div></div>
		</div>
        
</form>          
</div>
    
    <div id="container_bot">&nbsp;</div>

	<!-- Container Ends -->

<form name="frmsearch" method="post" action="{$SITEURL}search">
<input type="hidden" name="txtSearchKey" id="txtSearchKey" value="{$smarty.post.txtSearchKey}">
<input type='hidden' name='rdoOnlyEvery' value='{$smarty.post.rdoOnlyEvery}'>
<input type="hidden" name="ACT" value="search">
</form>





