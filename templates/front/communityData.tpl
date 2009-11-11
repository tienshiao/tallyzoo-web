<script src="{$SITEURL}includes/javascript/round.js" type="text/javascript"></script>
{literal}

<script language="javascript">
$().ready(function() {	
	
	$("#communityData").validate({
		rules: {
			
			txtSearchKey: {
				required: true
			}
		},
		messages: {
			txtSearchKey: "<br>&nbsp;Required. "
			
			}
	});
	return false;
});
	
	
	
	
function setText()
{
	if(Trim(document.communityData.txtSearchKey.value) == "Enter search terms here")
		document.communityData.txtSearchKey.value = "";
}
function showpagingresult(pageno,numrecordperrow)
{
	document.getElementById('txtPage').value = pageno;
	document.getElementById('perpage').value = numrecordperrow;
	document.communityData.submit();

}
function viewActivity(id)
{
		document.communityData.editId.value = id;
		document.communityData.ACT.value = "VIEWFACTI";
		document.communityData.action = "index.php?mod=activityDetails";
		document.communityData.submit();
}
function showpagingresult(pageno,numrecordperrow)
{
 	document.getElementById('hidFilter').value = "{/literal}{$smarty.post.hidFilter}{literal}"
	document.getElementById('txtPage').value = pageno;
	document.getElementById('perpage').value = numrecordperrow;
	document.communityData.submit();

}
function checkLoginOnlyMe()
{
	if(document.communityData.currUserid.value == "")
	{
		alert("You need to login first before using \"Only me\".");
		window.location.href = "index.php?mod=login";
	}else
	{
		if(Trim(document.communityData.txtSearchKey.value) !="")
		{
			document.communityData.submit();
		}
	}
}

function setFilter(setFilter)
{
	document.communityData.hidFilter.value = setFilter;
	document.communityData.submit();

}
function showProfile(uid)
{
	document.communityData.userId.value = uid;
	document.communityData.action = "{/literal}{$SITEURL}viewProfile/" + uid + "{literal}";
	document.communityData.submit();
}
</script>
{/literal}
 <div id="sub_menu_out">
    	<div id="sub_menu"><a href="{$SITEURL}communityData" id="subActive"><span class="ln_lft">&nbsp;</span>Community Data<span class="ln_rgt">&nbsp;</span></a></div>
    </div>
    
	<!-- Container Starts -->
	<div id="container">
  <div align="center" class="error" id="mid_body">{$err_msg}&nbsp;</div>
<form name="communityData" method="post">
		<input type="hidden" id="txtPage" name="txtPage" value="1"/>
		<input type="hidden" id="perpage" name="perpage" value="4"/>
		<input type="hidden" name="ACT" value="search"/>
		<input type="hidden" name="editId" id="editId" value=""/>
		<input type="hidden" name="currUserid" id="currUserid" value="{$smarty.session.tz_user.userid}"/>
		<input type="hidden" id="hidFilter" name="hidFilter" value="every">
		<input type="hidden" name="userId" id="userId"/>
	
    
    	<div class="block_content">
        
        
        <div class="blue_block">
        	<div class="blue_block_in">
        	  
        	  <table border="0" cellspacing="0" cellpadding="0">
        	    <tr>
        	      <td><input name="txtQuickCnt" type="text" id="txtQuickCnt" value="Activity: Amount" class="fld_txt wd_250" onFocus="javascript:blankAmt();" /></td>
				   <td class="calendar" id="tdCal"><a href="javascript:;" onClick="javascript:showCal();"><img src="images/icons/cal.gif" width="16" height="20" alt="Calendar" /></a></td>
        	      <td><a href="javascript:;" onClick="javascript:quickAdd('communityData');"><img src="images/btn_quick_add.gif" width="90" height="23" alt="Quick Add" /></a></td>
      	      </tr>
      	    </table>
       	  </div>
       </div>
      
      {if $actCount gt 0}
       
			
				{if $pagelist eq ""}
					<div class="pagingtable">&nbsp;</div>
				{/if}
		
              {if $pagelist neq ""}
			  <div class="pagingtable">		
				{$pagelist}
			  </div>
			{/if}
			
			<!-- Every One -->
			 <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl_grid">
             <tr class="row1">
        <th align="center" class="curved_main">&nbsp;</th>
        <th colspan="2" class="activities">Community Data Feed</th>
        <th>Count</th>
        <th>Time</th>
      </tr>
			 {section name=index loop=$ROW}
              <tr class="{cycle values='row2,row1'}">
                <td width="11%" align="center" class="img_link">
				{if $ROW[index].imagename neq ''}
					<img src="images/user/50x50{$ROW[index].imagename}" border="0"/>
				{else}
				<img src="images/nophotp.jpg" border="0" /><br>
				{/if}
				
				</a></td>
                <td 
				  {if $ROW[index].relateActivity eq ""}
				  colspan="2"
				  {/if}
				  class="activities"><span class="act_head"><a href="{$SITEURL}activities/{$ROW[index].id}/{$ROW[index].name|sanitize_title_with_dashes}">{$ROW[index].name}</a></span><br />
				  
				  {$ROW[index].default_note|truncate:40:"...":false}
						  
			  </td>
			  {if $ROW[index].relateActivity neq ""}
				  <td >
					{$ROW[index].relateActivity}
				  </td>
			  {/if}
                <td width="14%">{$ROW[index].total}</td>
                <td width="15%">{$ROW[index].timeInMin}</td>
              </tr>
              {/section}
            </table>
			<!-- End of Every One -->
		{if $pagelist neq ""}
		  <div class="pagingtable">
			{$pagelist}
		  </div>
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
	<!-- Container Ends -->