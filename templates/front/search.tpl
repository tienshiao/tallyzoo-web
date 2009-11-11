<script src="{$SITEURL}includes/javascript/round.js" type="text/javascript"></script>
{literal}

<script language="javascript">
/*$().ready(function() {	
	
	$("#searchForm").validate({
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
});*/
	
	
function submitSearchForm()
{ 
	if(Trim(document.searchForm.txtSearchKey.value) == "")
	{
		alert("Please enter search key.");
		document.searchForm.txtSearchKey.focus();
		return false;
	}
	document.searchForm.action = "{/literal}{$SITEURL}search{literal}/" + document.searchForm.txtSearchKey.value;
	//document.searchForm.submit();
	return true;
}
	
function setText()
{
	if(Trim(document.searchForm.txtSearchKey.value) == "Enter search terms here")
		document.searchForm.txtSearchKey.value = "";
}
function showpagingresult(pageno,numrecordperrow)
{
	document.getElementById('txtPage').value = pageno;
	document.getElementById('perpage').value = numrecordperrow;
	document.searchForm.submit();

}
function viewActivity(id)
{
		document.searchForm.editId.value = id;
		document.searchForm.ACT.value = "VIEWFACTI";
		document.searchForm.action = "index.php?mod=activityDetails";
		document.searchForm.submit();
}
function showpagingresult(pageno,numrecordperrow)
{
	document.getElementById('hidFilter').value = "{/literal}{$smarty.post.hidFilter}{literal}"
	document.getElementById('txtPage').value = pageno;
	document.getElementById('perpage').value = numrecordperrow;
	document.searchForm.submit();

}
function checkLoginOnlyMe()
{
	if(document.searchForm.currUserid.value == "")
	{
		alert("You need to login first before using \"Only me\".");
		window.location.href = "{/literal}{$SITEURL}{literal}login";
	}else
	{
		if(Trim(document.searchForm.txtSearchKey.value) !="")
		{
			document.searchForm.submit();
		}
	}
}
function submitSearch()
{
	if(Trim(document.searchForm.txtSearchKey.value) !="")
	{
		document.searchForm.submit();
	}
}
function setFilter(setFilter)
{
	document.searchForm.hidFilter.value = setFilter;
	document.searchForm.submit();

}
function showProfile(uid)
{
	document.searchForm.userId.value = uid;
	document.searchForm.action = "{/literal}{$SITEURL}viewProfile/" + uid + "{literal}";
	document.searchForm.submit();
}
</script>
{/literal}
 <div id="sub_menu_out">
    	<div id="sub_menu"><a href="#" id="subActive"><span class="ln_lft">&nbsp;</span>Search<span class="ln_rgt">&nbsp;</span></a></div>
    </div>
    
	<!-- Container Starts -->
	<div id="container">
    <form id="searchForm" name="searchForm"  method="post"  onSubmit="javascript: return submitSearchForm();">
		<input type="hidden" id="txtPage" name="txtPage">
		<input type="hidden" id="perpage" name="perpage">
		<input type="hidden" name="ACT" value="search">
		<input type="hidden" name="editId" id="editId" value="">
		<input type="hidden" name="currUserid" id="currUserid" value="{$smarty.session.tz_user.userid}">
		<input type="hidden" id="hidFilter" name="hidFilter" value="">
		<input type="hidden" name="userId" id="userId">
		<div class="block_content">
        
        	<div class="blue_block_content bl_search">
        	<div class="block_top"><div>&nbsp;</div></div>
        	<div class="block_mid">
            	<table width="100%" border="0" cellspacing="0" cellpadding="0">
            	  <tr>
            	    <td width="88%"><input name="txtSearchKey" type="text" class="fld_txt_search" id="txtSearchKey" value="{$searchKey}" />
                      </td>
            	    <td width="12%" align="center" valign="top"><input type="image" src="images/btn_go.gif" width="70" height="34" title="go" /></td>
          	      </tr>
          	  </table>
           	  
            </div>
        	<div class="block_bot"><div>&nbsp;</div></div>
       </div>
		
        <div class="bl_search_criteria">
        	<input type="radio" name="rdoOnlyEvery" onClick="javascript:checkLoginOnlyMe();"  value="only" 
			  {if $rdochk eq 'only'}
				checked
			{/if}
			  />
            Only me &nbsp; 
            &nbsp; 
            <input type="radio" name="rdoOnlyEvery"  value="every"
			{if $rdochk eq 'every'}
				checked
			{/if} onClick="javascript:submitSearch();"
			/> 
            Everyone
       </div>

      {if $actCount gt 0}
          <div class="search_result">
            
            <h3>Results</h3>
			{if $rdochk neq 'only'}
			<div class="filters"> <strong>Filter:</strong> <a href="javascript:setFilter('all')" title="All"
			{if $smarty.post.hidFilter eq '' or $smarty.post.hidFilter eq 'all'}
			id="filter_act"
			{/if}
			>All</a> <a href="javascript:setFilter('user')"  title="Users"
			{if $smarty.post.hidFilter eq 'user'}
			id="filter_act"
			{/if}
			>Users</a> <a href="javascript:setFilter('activity')"  title="Activities"
			{if $smarty.post.hidFilter eq 'activity'}
			id="filter_act"
			{/if}
			>Activities</a></div>
				{if $pagelist eq ""}
					<div class="pagingtable">&nbsp;</div>
				{/if}
			{/if}
              {if $pagelist neq ""}
			  <div class="pagingtable">		
				{$pagelist}
			  </div>
			{/if}
			{if $rdochk eq 'only'}
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl_grid">
			{section name=index loop=$ROW}
              <tr class="{cycle values='row2,row1'}">
                <td width="8%" align="center" class="curved_main"><div style="background-color: #{$ROW[index].color}; margin: 0pt auto; width: 20px; font-size: 2px; line-height: 10px; color: #ffffff;" class="rounded">&nbsp;</div></td>
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
			
			{else}
			<!-- Every One -->
			 <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl_grid">
			 {section name=index loop=$ROW}
              <tr class="{cycle values='row2,row1'}">
                <td width="11%" align="center" class="img_link">
				<a href="{$SITEURL}viewProfile/{$ROW[index].uid}">
				{if $ROW[index].imagename neq ''}
					<img src="images/user/50x50{$ROW[index].imagename}" border="0"/>
				{else}
				<img src="images/nophotp.jpg" border="0" /><br>
				{/if}
				{$ROW[index].username}
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
			{/if}
            <script type="text/javascript">
			Rounded('rounded', 6, 6);
			</script>
			
            {if $pagelist neq ""}
			  <div class="pagingtable">
				{$pagelist}
			  </div>
			{/if}
          </div>
		</div>

		
	</div>
		
		{else}
		{if $smarty.post.txtSearchKey neq ''}
			<div align="center" class="error" id="mid_body"><br>No record(s) found.</div>
		{/if}

	{/if}
		</div>
	</div>
		</form>
	</div>
    
    <div id="container_bot">&nbsp;</div>
	<!-- Container Ends -->