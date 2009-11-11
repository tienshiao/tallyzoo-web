<iframe id="activityframe" name="dashboardFrame" width='0' height='0' frameborder="0"  border='0'>
</iframe>
<div class="popup_box">
<div align="center"  id="mid_body" style="display:none;">{$err_msg}</div>
<h3>
<div class="close_icon"><a href="javascript:;"><img src="images/close.gif" border="0" onclick="javascript:fnHdnPopup('');" /></a>&nbsp;&nbsp;</div>
Which Graphs would you like to add to your dashboard?
      </h3>
	<div class="popup_content">
  	
<form name="dashboardActiList" method="post" onsubmit="javascript:return submitFormDashBoard();" action="user/ajx_comman.php?case=7" target="dashboardFrame">
<input type="hidden" name='ACT' value="">
<input type="hidden" name='cnt' value="{$actCount}">
<input type="hidden" name='activityIds' value="{$ROWINPUT.activityIds}">
<input type='hidden' name='editId' id='editId' value="{$smarty.get.id}">
<input type="hidden" name='graphId' value="{$ROWINPUT.graphId}">
<input type="hidden" name="firstCompositeFlag" value="0"> 
<input type="hidden" name='txtName' id="txtName" value="{$ROWINPUT.txtName}">
<input type="hidden" name="graphType" id="graphType" value="{$graphType}">
<input type="hidden" id='graphId' name='graphId' value="{$graphId}">
<input type="hidden" id="actiLimit" name="actiLimit" value="{$actiLimit}">
<input id="hidHaveData" name="hidHaveData" type="hidden" value="{$haveData}">

<table border="0" cellpadding="2" cellspacing="0" width="100%">
<tbody><tr><td valign="top" width="55%" align="left">
  <br />
		<table class="tbl_form" border="0" cellpadding="0" cellspacing="0" width="96%" id="tbl_form_pop2">
		  <tbody><tr>
				<th align="left">My Activities</th>
				<th align="right" class="search_bg"><input name="txtSearch" type="text" class="fld_txt_search2" id="txtSearch" value="search" onFocus="javascript:fnblank('txtSearch');"  onKeyUp="javascript:sendRequestForDashBoardActi();" onKeyDown="javascript:setTimeForDashBoardActlist();" /></th>				
			</tr>
			<tr>
			<td colspan="2" id="tdActiList">
			{if $actCount gt 0}
			
			<table border="0" width="98%">
					<tbody><tr>
						<td width="5%"></td>
						<td align="left"><strong>Activity Name</strong></td>
						<td align="left"><strong>Note</strong></td>
					</tr>
										
					{section name=index loop=$ROW }
					{assign var='cnt' value=$varCnt+1}
					<tr>
						<td><input type='checkbox' name='chkActi_{$cnt}' id="chkActi_{$cnt}" value="{$ROW[index].id}"
						{foreach from=$ACTIVITY  key=k item=v}
							{if $v eq $ROW[index].id}
								checked
							{/if}
						{/foreach}
						></td>
						<td>{$ROW[index].name}</td>
						<td>{$ROW[index].default_note}</td>
						<td>
						{if $ROW[index].graphJsFn neq ''}
						<a href="javascript:{$ROW[index].graphJsFn}" title="View">
						{else}
						<a href="javascript:;" title="View">
						{/if}
						View
						</a>
						</td>
					</tr>
					{assign var='varCnt' value=$cnt}
					{/section}
					
					
										
				</tbody></table>
				
				{else}
					<center class="error">No Activity Found.</center>
				{/if}
				</td>
		  </tr>	
			  
		</tbody></table>
	</td>
	<td valign="top">
	
    <br />
	  <table class="tbl_form" border="0" cellpadding="0" cellspacing="0" width="100%" id="tbl_form_pop4">
		   <tbody><tr>
				<th colspan="2" align="left">Preview Chart</th>		
			</tr>
			<tr> 
			  <td height="282" colspan="2" align="center" valign="middle">
			  <div id="prev_chartContainer">
			  <img src="images/front/graph/{$imgChart}" name="graphImg" width="332" height="225" border="0" id="graphImg">
			  </div>
			<p id="showHide" align="right" style="display:none;"></strong>&nbsp; &nbsp; </p>
			  </td>
			  </tr>
			</tbody>
         </table>
	
	<!-- End of graph -->
	</td>
	</tr>
</tbody></table>
<br />
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tbody><tr>
			<td align="left">
			  <input value="Cancel" title="Cancel" class="btn_sty2 btn_cancel" onclick="javascript:fnHdnPopup('');" type="button"></td>
             <td align="right">
			   <input value="Add" name="Add" title="Add" class="btn_sty2 btn_save" type="submit">
			  </td>
		  </tr>

		</tbody></table>




<div class="cl_both"></div>
</form>

</div>





