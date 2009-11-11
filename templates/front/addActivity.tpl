
<iframe id="activityframe" name="activityframe" width='0' height='0' frameborder="0"  border='0'>
</iframe>
<div class="popup_box">
<h2><div class="close_icon"><a href="javascript:;"><img src="images/close.gif" border="0" onclick="javascript:fnHdnPopup('');" /></a></div>
      <div id="spnActiName" >
	  {if $ROWINPUT.txtName neq ''} 
	  {$ROWINPUT.txtName}
	  {else}
	  Add Activity Name
	  {/if}
	   <a href="javascript:;" onClick="javascript:showInputBox();" title="Edit">Edit Name</a></div></h2>
	<div class="popup_content">
    <p align="right" style="padding: 10px 0;"><strong><a href="#">Help</a></strong></p>
	<div class="error" id="mid_body" align="center"></div>
<form name='frmActivity' id="frmActivity" method="post" onSubmit="javascript:return submitForm();" action="user/ajx_comman.php?case=4" target="activityframe">
<input type="hidden" name='ACT' value="">
<input type="hidden" name='cnt' value="{$noOfact}">
<input type="hidden" name='activityIds' value="{$ROWINPUT.activityIds}">
<input type='hidden' name='editId' id='editId' value="{$smarty.get.id}">
<input type="hidden" name='graphId' value="{$ROWINPUT.graphId}">
<input type="hidden" name="firstCompositeFlag" value="0"> 
<input type="hidden" name='txtName' id="txtName" value="{$ROWINPUT.txtName}">
<input type="hidden" name="graphType" id="graphType" value="{$graphType}">
<input type="hidden" id='graphId' name='graphId' value="{$graphId}">
<input type="hidden" id="actiLimit" name="actiLimit" value="{$actiLimit}">
<input id="hidHaveData" name="hidHaveData" type="hidden" value="{$haveData}">
{if $haveData gt 0}
<input type='hidden' name="rdoActivityType" id="rdoActivityType" value="{$ROWINPUT.rdoActivityType}">
{/if}
<table border="0" cellpadding="2" cellspacing="0" width="100%">
<tbody><tr><td valign="top" width="55%" align="left">
		<table border="0" cellpadding="0" cellspacing="0" width="96%" class="tbl_form" id="tbl_form_pop1">
		   <tbody><tr>
				<th colspan="2" align="left">
					{if $smarty.get.id eq ""}
				Create Activity
				{else}
				Update Activity
				{/if}
				</th>		
			</tr>
			{if $haveData eq 0}
			 <tr>
			<td nowrap="nowrap" width="88">Activity Type</td>
			<td width="355">
				<table width="100%" border="0" cellspacing="0" cellpadding="0" class="noPad">
				  <tr>
				    <td width="8%"><input type="radio" name='rdoActivityType' value='0' onClick="javascript:showHideActivityList('0');"
				{if $ROWINPUT.rdoActivityType eq "0" or  $ROWINPUT.rdoActivityType eq ""}
				checked
				{/if} /></td>
				    <td width="32%" align="left"><img src="images/icons/single.gif" width="55" height="21" alt="Signle" /></td>
				    <td width="8%"><input type="radio" type="radio" name='rdoActivityType' value='1' onClick="javascript:showHideActivityList('1');"
				{if $ROWINPUT.rdoActivityType eq "1" }
				checked
				{/if} /></td>
				    <td width="52%" align="left"><img src="images/icons/combo.gif" width="55" height="21" alt="Combo" /></td>
				    </tr>
				  </table></td>
		  </tr>
		  {/if}
		  
		  <tr>
		    <td valign="top">Note</td>
		    <td><textarea name="txtNote" rows="3" class="fld_txt wd_345" id="txtNote" maxlength="250">{$ROWINPUT.txtNote}</textarea>
		      
		      </td>
		    </tr>
		  <tr>
		    <td>Privacy</td>
		    <td><input type="radio" value='1' name='rdoAccess' id='rdoAccess' 
			{if $ROWINPUT.rdoAccess eq "1" or $ROWINPUT.rdoAccess eq ""}
			checked
			{/if} />
		      Public &nbsp;&nbsp;
		      <input type="radio" value='0' name='rdoAccess' id='rdoAccess'
			{if $ROWINPUT.rdoAccess eq "0" }
			checked
			{/if} />
		      Private </td>
		    </tr>
		  <tr>
		    <td valign="top">Color</td>
		    <td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="noPad">
		      <tr>
		        <td width="67%" rowspan="2" valign="top">{$tblColor}</td>
		        <td width="33%" valign="top" align="left" nowrap>Selected:
<img id='imgCol' style="background-color:#{$ROWINPUT.txtColor}; height: 15px; width: 15px; border: 1px solid #999; " src="images/blank.gif" valign="absmiddle"/>&nbsp;<input id='txtColor' name="txtColor"  class="fld_txt_red wd_50" maxlength="7" 
				{if $ROWINPUT.txtColor neq ''}
				value="{$ROWINPUT.txtColor}"
				{else}
				value="ffffff"
				{/if}
				type="text"  />
				</td>
		        </tr>
		      <tr>
		        <td valign="top" align="right"><input value="Custom" title="Custom" class="btn_sty2 custom_colors" type="button" onclick="showColorGrid2('txtColor','none');"  />
				<div id="colorpicker201" class="colorpicker201"></div></td>
		        </tr>
		      </table></td>
		    </tr>
		   <tr>
		     <td>Goal</td>
		     <td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="noPad">
		       <tr>
		         <td width="32%" nowrap="nowrap"><input name="txtGoal" type="text"  class="fld_txt wd_50" id="txtGoal" value="{$ROWINPUT.txtGoal}" maxlength="7" />
		           <br /></td>
		         <td width="26%" valign="top">Intial Value</td>
		         <td width="42%" valign="top"><input name="txtIntial" id="txtIntial" class="fld_txt wd_50" type="text" 
				 {if $ROWINPUT.txtIntial gt 0}
				value="{$ROWINPUT.txtIntial}" 
				{else}
				value="0" 
				{/if}
				 /></td>
		         </tr>
		       </table></td>
		     </tr>
		   </tbody></table>
		  <br />
		<table class="tbl_form" border="0" cellpadding="0" cellspacing="0" width="96%" id="tbl_form_pop2" style="{if $ROWINPUT.rdoActivityType neq '1'}
			display:none;
			{/if};">
		  <tbody><tr>
				<th align="left">Activity List</th>
				<th align="right" class="search_bg"><input name="txtSearch" type="text" class="fld_txt_search2" id="txtSearch" value="search" onFocus="javascript:fnblank('txtSearch');"  onKeyUp="javascript:sendRequestForActi();" onKeyDown="javascript:setTimeForActlist();" /></th>				
			</tr>
			<tr>
			<td colspan="2" id="tdActiList">
			{if $noOfact gt 0}
			<div style="overflow: auto; height: 135px;">
				<center></center>
			<table border="0" width="80%">
					<tbody><tr>
						<td width="5%"></td>
						<td align="left"><strong>Activity Name</strong></td>
						<td align="left"><strong>Note</strong></td>
					</tr>
										
					{section name=index loop=$ROW }
					{assign var='cnt' value=$varCnt+1}
					<tr>
						<td><input type='checkbox' name='chkActi_{$cnt}' id="chkActi_{$cnt}" value="{$ROW[index].id}"
						{foreach from=$ACTIDARR  key=k item=v}
							{if $v eq $ROW[index].id}
								checked
							{/if}
						{/foreach}
						></td>
						<td>{$ROW[index].name}</td>
						<td>{$ROW[index].default_note}</td>
					</tr>
					{assign var='varCnt' value=$cnt}
					{/section}
					
					
										
				</tbody></table>
				</div>
				{else}
					<center class="error">No Activity Found.</center>
				{/if}
				</td>
		  </tr>	
			  
		</tbody></table>
	</td>
	<td valign="top">
	<!-- Graph -->
	<table class="tbl_form" border="0" cellpadding="0" cellspacing="0" width="100%" id="tbl_form_pop3">
		   <tbody><tr>
				<th colspan="2" align="left">Chart Type</th>		
			</tr>
			<tr> 
				<td colspan="2">Select Chart</td>
			</tr>
			<tr> 
				<td colspan="2">
					<table border="0" cellpadding="2" cellspacing="0" id="chart_types">
						<tbody><tr>
							<td>
							<a href="javascript:;" title="Line" onclick="javascript:graphPreView(5);dataOption(1,'',5);" id='ach_1'>
							{if $graphType eq 1}
									<img id="img_5" src="images/graph/g4-inactive.jpg" border="0" onmouseover="javascript:chartIconOnOver('img_5','g4-over.jpg');" onmouseout="javascript:chartIconOnOut('img_5','g4-inactive.jpg');">
								{else}
									<img  id="img_5" src="images/graph/g4-normal.jpg" border="0" onmouseover="javascript:chartIconOnOver('img_5','g4-over.jpg');" onmouseout="javascript:chartIconOnOut('img_5','g4-normal.jpg');">
								{/if}
							</a>
							</td>
							<td>
								<a id='ach_3' href="javascript:;" title="Bar Vertical" onclick="javascript:graphPreView(1);dataOption(3,'',1);">
								
								{if $graphType eq 3}
									<img id="img_1" src="images/graph/g1-inactive.jpg" border="0" onmouseover="javascript:chartIconOnOver('img_1','g1-over.jpg');" onmouseout="javascript:chartIconOnOut('img_1','g1-inactive.jpg');">
								{else}
									<img  id="img_1" src="images/graph/g1-normal.jpg" border="0" onmouseover="javascript:chartIconOnOver('img_1','g1-over.jpg');" onmouseout="javascript:chartIconOnOut('img_1','g1-normal.jpg');">
								{/if}
									
								</a>
							</td>
							<td>
							<a href="javascript:;" title="Bar Horizontal" onclick="javascript:graphPreView(2);dataOption(4,'',2);" id='ach_4'>
							{if $graphType eq 4}
									<img id="img_2" src="images/graph/g2-inactive.jpg" border="0" onmouseover="javascript:chartIconOnOver('img_2','g2-over.jpg');" onmouseout="javascript:chartIconOnOut('img_2','g2-inactive.jpg');">
								{else}
									<img  id="img_2" src="images/graph/g2-normal.jpg" border="0" onmouseover="javascript:chartIconOnOver('img_2','g2-over.jpg');" onmouseout="javascript:chartIconOnOut('img_2','g2-normal.jpg');">
								{/if}
							
							</a>
							</td>
							<td>
							<a href="javascript:;" title="Pie" onclick="javascript:graphPreView(3);dataOption(2,'',3);" id='ach_2'>

							{if $graphType eq 2}
									<img id="img_3" src="images/graph/g3-inactive.jpg" border="0" onmouseover="javascript:chartIconOnOver('img_3','g3-over.jpg');" onmouseout="javascript:chartIconOnOut('img_3','g3-inactive.jpg');">
								{else}
									<img  id="img_3" src="images/graph/g3-normal.jpg" border="0" onmouseover="javascript:chartIconOnOver('img_3','g3-over.jpg');" onmouseout="javascript:chartIconOnOut('img_3','g3-normal.jpg');">
								{/if}
							</a>
							</td>
							<td>
							<a href="javascript:;" title="Time Slide" onclick="javascript:graphPreView(4);dataOption(5,'',4);" id='ach_5'>
							{if $graphType eq 5}
									<img id="img_4" src="images/graph/g5-inactive.jpg" border="0" onmouseover="javascript:chartIconOnOver('img_4','g5-over.jpg');" onmouseout="javascript:chartIconOnOut('img_4','g5-inactive.jpg');">
								{else}
									<img  id="img_4" src="images/graph/g5-normal.jpg" border="0" onmouseover="javascript:chartIconOnOver('img_4','g5-over.jpg');" onmouseout="javascript:chartIconOnOut('img_4','g5-normal.jpg');">
								{/if}
							</a>
							</td>
							
							<td>
							<a href="javascript:;" title="Number" onclick="javascript:graphPreView(6);dataOption(6,'',6);" id='ach_6'>
							{if $graphType eq 6}
									<img id="img_6" src="images/graph/g6-inactive.jpg" border="0" onmouseover="javascript:chartIconOnOver('img_6','g6-over.gif');" onmouseout="javascript:chartIconOnOut('img_6','g6-inactive.gif');">
								{else}
									<img  id="img_6" src="images/graph/g6-normal.gif" border="0" onmouseover="javascript:chartIconOnOver('img_6','g6-over.gif');" onmouseout="javascript:chartIconOnOut('img_6','g6-normal.gif');">
								{/if}
							</a>
							</td>
							<td>
							<a href="javascript:;" title="Name" onclick="javascript:graphPreView(7);dataOption(7,'',7);" id='ach_7'>
							{if $graphType eq 7}
									<img id="img_7" src="images/graph/g7-inactive.gif" border="0" onmouseover="javascript:chartIconOnOver('img_7','g7-over.gif');" onmouseout="javascript:chartIconOnOut('img_7','g7-inactive.gif');">
								{else}
									<img  id="img_7" src="images/graph/g7-normal.gif" border="0" onmouseover="javascript:chartIconOnOver('img_7','g7-over.gif');" onmouseout="javascript:chartIconOnOut('img_7','g7-normal.gif');">
								{/if}
							</a>
							</td>
							<td>
							<a href="javascript:;" title="Time" onclick="javascript:graphPreView(8);dataOption(8,'',8);" id='ach_8'>
							{if $graphType eq 8}
									<img id="img_8" src="images/graph/g8-inactive.gif" border="0" onmouseover="javascript:chartIconOnOver('img_8','g8-over.gif');" onmouseout="javascript:chartIconOnOut('img_8','g8-inactive.gif');">
								{else}
									<img  id="img_8" src="images/graph/g8-normal.gif" border="0" onmouseover="javascript:chartIconOnOver('img_8','g8-over.gif');" onmouseout="javascript:chartIconOnOut('img_8','g8-normal.gif');">
								{/if}
							</a>
							</td>
							
						</tr><tr>
					</tr></tbody></table>
				</td>
			</tr>
			<tr>
				<td align="left" nowrap="nowrap" width="90">Data Options</td>
				<td align="left" id="tddataOpt">
					{$cmbDataOpt}
				</td>
			</tr>
		
	</tbody></table>
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
			   <input name="saveAdd" value="Save &amp; Add Another" title="Save &amp; Add Another" class="btn_sty2 btn_save_addmore" type="submit" /> &nbsp; &nbsp; <input value="Save" name="save" title="Save" class="btn_sty2 btn_save" type="submit">
			  </td>
		  </tr>

		</tbody></table>




<div class="cl_both"></div>
</form>

</div>

	





