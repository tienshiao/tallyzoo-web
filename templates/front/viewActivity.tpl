<iframe id="activityframe" name="activityframe" width='0' height='0' frameborder="0"  border='0'>
</iframe>
<div id="container">
	<div align="center" class="error" id="mid_body"></div>
	<p class="hS5">&nbsp;</p>
<div class="tbl_block">
<table width="100%" border="0" cellspacing="0" cellpadding="2">
<tr ><td width="52%" valign="top">
		<table width="99%"	 border="0" cellspacing="0" cellpadding="0" class="tbl_grid" >
		   <tr>
				<th  colspan="2" align="left">View Activity</th>		
			</tr>
		  <tr>	
				<td width="100">Activity Name:</td>
				<td>{$ROW.name}</td>
		  </tr>
		  <tr>	
				<td>Note:</td>
				<td>{$ROW.default_note}</td>
		  </tr>
		  <tr>	
				<td>Tag:</td>
				<td>{$ROW.tags}</td>
		  </tr>
		  <tr>	
				<td>Type:</td>
				<td>{if $ROW.activity_type == 1}
					Composite 
				{else}
					Single
				{/if}
				</td>
		  </tr>
		  <tr>	
				<td>Public:</td>
				<td>{if $ROW.hidden == 1}
					Public
					{else}
					Private
				{/if}
				</td>
		  </tr>
		  
		  
		</table>
	<form name="frmCount" id="frmCount" target="activityframe" method="post" action="user/ajx_comman.php?case=5" onSubmit="javascript:return fnCountValidate();" >
	  <input type="hidden" name="actiId" value="{$smarty.post.editId}">
	 	<table  width="99%"	 border="0" cellspacing="0" cellpadding="0" class="tbl_form" style="margin-top:5px;">
			<tr>
				{if $ROW.activity_type eq 1}
				<td align="left"><strong>Activity</strong></td>
				{/if}
				<td align="left"><strong>Note</strong></td>
				<td align="left"><strong>Tag</strong></td>
				<td align="left"><strong>Count</strong></td>
			</tr>
			
			<tr>
			{if $ROW.activity_type eq 1}
				<td align="left" valign="top" nowrap>
					<select name="cmbActivity">
						<option value="">--Activity--</option>
						{section name=index loop=$ROWSUBACTI}	
							<option value="{$ROWSUBACTI[index].activity_id}">{$ROWSUBACTI[index].name}</option>
						{/section}
					</select><span class="error">*</span>
					
				</td>
			{/if}
				<td align="left" valign="top"><input type="text" id="txtNote" name="txtNote" class="fld_txt wd_100">

				</td>
				<td align="left"  valign="top"><input type="text"  id="txtTag" name="txtTag" class="fld_txt wd_100">

			
				</td>
				<td align="left"  valign="top"><input type="text"  id="txtCount" name="txtCount" class="fld_txt wd_100"><span class="error">*</span>
			
				</td>
			</tr>
			<tr>
				<td 
				{if $ROW.activity_type eq 1}
				colspan="3"
				{else}
				colspan="2"
				{/if}
				></td>
			</tr>
			<tr>
				<td><input type="button" onClick="javascript:location.href='{$BACKURL}'" value="Back" title="Back" class="btn_sty"></td>
				<td align="right"
				{if $ROW.activity_type eq 1}
				colspan="3"
				{else}
				colspan="2"
				{/if}
				><input type="submit" value="Add Count" title="Add Count" class="btn_sty">&nbsp;</td>
			</tr>
				<tr>
				<td 
				{if $ROW.activity_type eq 1}
				colspan="4"
				{else}
				colspan="3"
				{/if}
				></td>
			</tr>
		</table>
	
</form>
	</td>
	<td valign="top">
	<!-- Graph -->
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl_grid">
		   <tr>
				<th align="left">Activity Graph</th>		
			</tr>
			<tr><td>
				<img src="images/front/graph/graph3.gif" height="227" border="0">
			</td></tr>
	</table>
	<!-- End of graph -->
	</td>
	</tr>
</table>
</div>
  <div class="tbl_block_bot">&nbsp;</div>


<div class="cl_both"></div>
</div>



