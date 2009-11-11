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