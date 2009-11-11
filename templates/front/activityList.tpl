{if $noOfact gt 0}
			<div style="overflow: auto; height: 135px;">
				<center><label id="lblChk" class="error" style="display: none;">Please select atleast one activity.</label></center>
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