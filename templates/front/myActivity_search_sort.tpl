 {if $actCount gt 0}
 <!--
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
				<input type="text" onfocus="javascript:fnblank('txtSearch');" value="{$smarty.post.txtSearch}" id="txtSearch" class="fld_txt_search2" name="txtSearch" onkeyup="javascript:searchMyActi();">
			</span>
		</div>
		 -->
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
		   <th width="18%"> <a href="javascript:" onClick="javascript:setSortType('{$sortType}');searchMyActi();">
		   <img 
		   {if $sortType eq 'DESC'}
		   src="images/icons/arw_down2.gif"
		   {else}
		   src="images/icons/arw_up2.gif"
		   {/if}
		   border="0">
		   </a>&nbsp;Date Started</th>
		  <th width="10%">Count</th>
		  <th width="17%"><div align='right'>Actions&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div></th>
    </tr>
{section name=index loop=$ROW}
	<tr  class="{cycle values='row2,row1'}">
		      <td align="center" class="actiRow">
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
  <div  style="clear:both;">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl_grid">	
	
		<tr>
		  <th class="plusIcon">&nbsp;</th>
		  
		</tr>
			<tr><td  align='center'>
			<div align="center" class="error" id="mid_body">No activity found.</div>
			</td>
		</tr>
	</table>



{/if}



