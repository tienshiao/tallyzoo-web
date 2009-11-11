<script type="text/javascript" src="{$SITEURL}includes/javascript/jscolor/jscolor.js"></script>

<script src="{$SITEURL}includes/javascript/round.js" type="text/javascript"></script>


<div id="sub_menu_out">
	  	<div id="sub_menu">
		<div class="error_div" style="float:right" id="tips">Tips: Click the name of your activitiy to view the graph. <a href="javascript:" onClick="javascript:hideTips()" class="hideLink" title="Hide Tips">Hide Tips</div>

		<a href="javascript:;" id="subActive" title="My Activities"><span class="ln_lft">&nbsp;</span>My Activities<span class="ln_rgt">&nbsp;</span></a> <a href="{$SITEURL}myData"  title="My Data Feed"><span class="ln_lft">&nbsp;</span>My Data Feed<span class="ln_rgt">&nbsp;</span></a> </div>
    </div>
<div id="container">
<div align="center" class="error" id="mid_body">{$err_msg}&nbsp;</div>
<form name="activity" method="post">
<input type="hidden" name='editId' value="">
<input type="hidden" name='ACT' value="">
<input type="hidden" id="txtPage" name="txtPage">
<input type="hidden" id="perpage" name="perpage">
<input type="hidden" id="idOwnFlag" name="idOwnFlag" value="1">
<input type="hidden" id="txtSortType"  name="txtSortType" value="DESC">
<!--
<div class="blue_block">
        
			<div class="blue_block_in">
        	  
        	  <table border="0" cellspacing="0" cellpadding="0">
        	    <tr>
        	      <td><input name="txtQuickCnt" type="text" id="txtQuickCnt" value="Activity: Amount" class="fld_txt wd_250" onFocus="javascript:blankAmt();" /></td>
				   <td class="calendar" id="tdCal"><a href="javascript:;" onClick="javascript:showCal();"><img src="images/icons/cal.gif" width="16" height="20" alt="Calendar" /></a></td>
        	      <td><a href="javascript:;" onClick="javascript:quickAdd('myActivity');"><img src="images/btn_quick_add.gif" width="90" height="23" alt="Quick Add" /></a></td>
      	      </tr>
      	    </table>
       	  </div>
       </div>
-->		
		<div class="block_content">
		  <table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td  width="135"><h2>My Activities</h2></td>
					<td align="left">
					
					<table border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td id="td_add_block" style="display:none">
							<div class="blue_block">
								<div class="blue_block_in" valign="middle">
									<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td>
										<input type="text" name="txtActiName" id="txtActiName" value="Name"  onfocus="javascript:fnblank('txtActiName');" class="fld_txt_quickAdd">					
										</td>
										<td align="center">&nbsp;
										<input type="button" class="btn_sty2 btn_save" title="Save" name="Save" value="Save" onClick="addQuckActi();" >
										</td>
										<td><a href="javascript:;" onClick="javascript:showQuickCancel();" title="cancel">Cancel</a></td>
									</tr>
								</table>
								</div>
							</div>
							</td>
							<td align="left" id="td_bt_quickAdd">&nbsp;&nbsp;<input type="button" class="btn_sty2 btn_quick_add_acti" title="Quick Add" name="Quick Add" value="Quick Add" onClick="javascript:showQuickAdd()"></td>
						</tr>
					</table>
					
					</td>
					<td align="right" id="advance"><a  onClick="javascript:fnPopupDiv('900', '250', '30', '40', 'addActivity', 'ADD','');" title="Advanced Add">Advanced Add</a></td>
				</tr>
			</table>
		  {if $actCount gt 0}
<div id="resultContainer">  <!-- assing search/sort result -->
		  <div class="showSettingDiv">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td  class="error_block"><span class="error_div" id="spn_error" style="display:none;"></span></td>
					<td width="200" class="showSettingDiv">
					<input type="checkbox" name="showPrivacy" id="showPrivacy" value="yes" onClick="javascript:searchMyActi();"
					{if $smarty.post.showPrivacy eq 'yes'}
						checked
					{/if}
					> Show Privacy Settings
					</td>
				</tr>
			</table>
		  </div>
		  <div class="pagingtable" style="float: left; width: 520px; text-align: left;">
		  	<span class="search_bgImg">
				<input type="text" onfocus="javascript:fnblank('txtSearch');" value="search" id="txtSearch" class="fld_txt_search2" name="txtSearch" onkeyup="javascript:sendRequest();" onkeyDown="javascript:setTimeForSearchRequest();">
			</span>
		</div>
		 <div id="search_result"> <!-- Start of search ajax --->
		  {if $pagelist neq ""}
		  <div class="pagingtable">
			{$pagelist}
		  </div>
		 {/if}
          <div class="tbl_block" style="clear:both;">


	
	    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl_grid">	
	
		<tr>
		  <th width="4%" class="plusIcon"><a href="javascript:" onClick="javascript:expandFolder('');"><img id="plusminus" src="images/icons/plus_smal.gif"  border='0'></a></th>
		  <th width="20%">Activity Name</th>
		  <th width="19%">&nbsp;</th>
		   <th width="18%">
		   <a href="javascript:" onClick="javascript:setSortType('{$sortType}');searchMyActi();">
		   <img 
		   {if $sortType eq 'DESC'}
		   src="images/icons/arw_down2.gif"
		   {else}
		   src="images/icons/arw_up2.gif"
		   {/if}
		   border="0">
		   </a>&nbsp;Date Started</th>
		  <th width="10%">Count</th>
		  <th width="17%" align='right'><div align='right'>Actions&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div></th>
    </tr>
{section name=index loop=$ROW}
	<tr  class="{cycle values='row2,row1'}">
		      <td align="center" class="actiRow action_icons">
			  {if $ROW[index].relateActivity neq ""}
			   <a href="javascript:" onClick="javascript:expandFolder({$ROW[index].id});"><img src="images/icons/folder.gif" border='0'></a>
			  {else}
			  <div style="background-color: #{$ROW[index].color}; margin: 0pt auto; width: 20px; font-size: 2px; line-height: 10px; color: #ffffff;" class="rounded">&nbsp;</div>
			  {/if}
			  </td>
		      <td class="actiRow" 
			  
			  class="activities"><span class="act_head"><a href="activities/{$ROW[index].id}/{$ROW[index].name|sanitize_title_with_dashes}" >{$ROW[index].name}</a></span>
			  {if $smarty.post.showPrivacy eq 'yes' }
				  {if $ROW[index].relateActivity eq ''}
					<img src="images/icons/lock.gif" title="Private">
				  {else}
				  <img src="images/icons/public2.gif" title="Public">
				  {/if}
			  {/if}
			  <span>
			  <br />
              
              {$ROW[index].default_note|truncate:40:"...":false}
              
              </td>
			  
			  <td class="actiRow"><span  id='td_related_{$ROW[index].id}' style="display:none;">
				{if $ROW[index].relateActivity neq ""}
				{assign var='ractId' value=`$ractId`,`$ROW[index].id`}
					{$ROW[index].relateActivity}
				{/if}
				</span>
			  </td>
			  
			  
		      <td class="countTd">{$ROW[index].created_on}</td>
		      <td class="countTd" id="td_total_{$ROW[index].id}">{$ROW[index].total}</td>
		      <td class="action_icons actiRow" align="right">
			  {if $ROW[index].relateActivity eq ""}
			  <a  title="Add" href="javascript:showAddCnt('{$ROW[index].id}');"><img src="images/icons/plus.gif" alt="Add" border="0"/></a>
			  {else}
			  <img src="images/icons/plus2.gif" alt="Add" border="0"/>
			  {/if}

			  <a  title="Edit" onClick="javascript:fnPopupDiv('900', '250', '30', '40', 'addActivity', 'EDIT','{$ROW[index].id}');{$ROW[index].graphJsFn}"><img src="images/icons/setting.gif" alt="Edit" border="0"/></a>
			  
			  <a  title="Delete" href="javascript:deleAct('{$ROW[index].id}');"><img src="images/icons/trash.gif" alt="Delete" border="0"/></a></td>
	 </tr>
	<tr id="tr_{$ROW[index].id}" class="{cycle name='cntRow' values='row2,row1'}" style="display:none">	
		<td colspan=6 align="right" valign="top" class="countTd">
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td><input type="text" name="txtCnt_{$ROW[index].id}" id="txtCnt_{$ROW[index].id}" class="fld_txt wd_50"></td>
					<td><a href="javascript:;" onClick="javascript:saveMyCnt({$ROW[index].id});" title="Save">Save</a></td>
					<td><a href="javascript:;" onClick="javascript:cancelCnt({$ROW[index].id});" title="Cancel">Cancel</a></td>
				</tr>
			</table>
		</td>
	</tr>


{/section}
<input type="hidden" id="idsOfcombos" value="{$ractId}">
	</table>
          </div>
          <div class="tbl_block_bot">&nbsp;</div>
		  {if $pagelist neq ""}
		  <div class="pagingtable">
			{$pagelist}
		  </div>
		 {/if}
		
	<script type="text/javascript">
			Rounded('rounded', 6, 6);
	</script>

{else}
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl_grid">	
	
		<tr>
		  <th width="4%" class="plusIcon">&nbsp;</th>
		  <th width="20%">Activity Name</th>
		  <th width="19%">&nbsp;</th>
		   <th width="18%">
		   Date Started</th>
		  <th width="10%">Count</th>
		  <th width="17%">Edit</th>
		</tr>
			<tr><td colspan="6" align='center' id="td_quick_msg">
				Welcome! Click <a href="javascript:;" onClick="javascript:showQuickAdd();">Quick Add</a> to get Started
			</td>
		</tr>
	</table>

{/if}
</div> <!-- End of search result for ajax -->
</div>  <!-- End assing search/sort result -->
</form>
</div>
</div>
<div id="container_bot">&nbsp;</div>
{literal}
<script language="javascript">
objImage = new Image();
objImage.src = "images/icons/minus.gif";
function showpagingresult(pageno,numrecordperrow)
{
	document.getElementById('txtPage').value = pageno;
	document.getElementById('perpage').value = numrecordperrow;
	if(document.getElementById('txtSearch').value == "Search"){
		document.getElementById('txtSearch').value = "";
	}
	//document.activity.submit();
	searchMyActi();

}
function deleAct(id)
{
	if(confirm('                  !! WARNING !!\n------------------------------------------------------------\n                  Activity will be deleted.\n                  Are you sure?'))
	{  
		document.activity.editId.value = id;
		document.activity.ACT.value = "DELETE";
		document.activity.action = "{/literal}{$SITEURL}myActivity{literal}";
		document.activity.submit();
	}
}
function viewActivity(id)
{
		document.activity.editId.value = id;
		document.activity.ACT.value = "VIEWFACTI";
		document.activity.action = "index.php?mod=activityDetails";
		document.activity.submit();
}




function onlyC()
{
	
	if(document.activity.composite.checked == true){
		location.href="{/literal}{$SITEURL}myActivity/1{literal}";
	}else{
	 location.href="index.php?mod=myActivity";
	}
}

function showAddCnt(actiId)
{
	document.getElementById("tr_" + actiId).style.display="";
}
function cancelCnt(actiId)
{
	document.getElementById("tr_" + actiId).style.display="none";
}
function saveMyCnt(actiId)
{ 
	var cnt = document.getElementById("txtCnt_" + actiId).value;
	if(Trim(cnt) =="")
	{
		alert("Please enter count.");
		document.getElementById("txtCnt_" + actiId).focus();
		return false;
	}else{
		if(isNaN(cnt))
		{
			alert('Only numeric/float value is allowed.');
			document.getElementById("txtCnt_" + actiId).focus();
			return false		
		}
	}

	document.activity.editId.value=actiId;
	value = "txtCount=" + cnt + "&editId=" + actiId + "&txtDate=''&txtNote=''";
	response = submitAjax(8,value);
	arr = response.split("###");
	document.getElementById('spn_error').style.display= "";
	document.getElementById('spn_error').innerHTML = arr[0] ;
	document.getElementById("td_total_" + actiId).innerHTML =arr[1];
	document.getElementById("tr_" + actiId).style.display="none";
}
var openFlag = 0;
function expandFolder(strIds)
{  
	if(strIds == "")
	{
		strIds = document.getElementById('idsOfcombos').value;
		arr = strIds.split(",");
		if(openFlag == 0)
		{
			for(i=0;i<arr.length;i++)
			{			
				if(arr[i] != "")
				{
					document.getElementById("td_related_" + arr[i]).style.display="";

				}
			}
			document.getElementById("plusminus").src="images/icons/minus.gif";
			openFlag = 1;
		}else{
			for(i=0;i<arr.length;i++)
			{			
				if(arr[i] != "")
				{
					document.getElementById("td_related_" + arr[i]).style.display="none";

					
				}
			}
			document.getElementById("plusminus").src="images/icons/plus_smal.gif";
			openFlag = 0;
		}
	}else{ 
		if(document.getElementById("td_related_" + strIds).style.display == "")
		{
			document.getElementById("td_related_" + strIds).style.display="none";
		}
		else{
			document.getElementById("td_related_" + strIds).style.display ="";
		}
	}
}
function showSettings()
{
	document.activity.submit();
}
function showQuickAdd()
{
	
	document.getElementById("td_add_block").style.display = "";
	//document.getElementById("txtActiName").focus(); 
	
	if(document.getElementById('td_bt_quickAdd'))
	{
		document.getElementById('td_bt_quickAdd').style.display="none";
	}
	if(document.getElementById('td_quick_msg'))
	{
		document.getElementById('td_quick_msg').innerHTML ="Welcome! Click Quick Add to get Started"
	}
}
function showQuickCancel()
{
	document.getElementById("td_add_block").style.display = "none";
	document.getElementById("td_bt_quickAdd").style.display = "";

}
function addQuckActi()
{
	var txtObj = document.getElementById("txtActiName");
	var msg = "";
	if(Trim(txtObj.value) == "" || Trim(txtObj.value) == "name")
	{
		alert("Please enter activitiy name.");
		txtObj.focus();
		return false;
	}else{
		value = "txtName=" + txtObj.value + "&graphType=1&cmbDataOption=1&rdoAccess=1";
		response = Trim(submitAjax(9,value));
		if(response == 0)
		{
			msg = "Acitivity name already exists.";
			txtObj.focus();
			return false;
		}else{
			msg = "<b>" + txtObj.value + "</b> Added Successfully.";
			document.getElementById("td_add_block").style.display = "none";
			document.getElementById("td_bt_quickAdd").style.display = "";
		}
		
		document.getElementById('spn_error').style.display= "";
		document.getElementById('spn_error').innerHTML= msg;
		searchMyActi();
	}
}
var sendRequestTime = 0;
var timerId="";
function searchMyActi()
{
	 pageno = document.getElementById('txtPage').value ;
	numrecordperrow = document.getElementById('perpage').value;
	var settings = "";
	var search  = "";
	
	if(document.getElementById('showPrivacy').checked)
	{
		settings = "yes";
	}
	if(document.getElementById('txtSearch').value == "search" || document.getElementById('txtSearch').value == "")
	{
		search = "";
	}else{
		search = document.getElementById('txtSearch').value;
		
	}
	sortyType = document.getElementById('txtSortType').value;
	var responseText = $.ajax({
	type: "POST",
	url: "{/literal}{$SITEURL}index_ajax.php?mod=myActivity_search_sor{literal}",
	data: "txtSearch=" + search + "&showPrivacy=" + settings + "&txtSortType=" + sortyType + "&txtPage=" + pageno + "&perpage=" + numrecordperrow,
	async: false
	}).responseText;
	document.getElementById('search_result').innerHTML =responseText;
	Rounded('rounded', 6, 6);
	document.getElementById('txtSearch').focus();
	
}
function setTimeForSearchRequest()
{
	 clearTimeout(timerId);
	 sendRequestTime = 1000;
}
function sendRequest()
{
	timerId = setTimeout ( "searchMyActi()", sendRequestTime);

}

function setSortType(type)
{ 
	if(type == "DESC")
	{
		type = "ASC";
	}else{
	
		type = "DESC";
	
	}
	
	document.getElementById('txtSortType').value =type;
}
function hideTips()
{
	document.getElementById('tips').style.display ="none";
}

</script>
{/literal}