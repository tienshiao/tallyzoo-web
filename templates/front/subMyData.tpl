{if $actCount gt 0}

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
									<a href="javascript:;"  title="Edit" id="a_edit_{$ROWDATA[index].id}" onClick="editRow('{$ROWDATA[index].id}');">Edit</a>&nbsp;<a  title="Delete" href="javascript:deleAct('{$ROWDATA[index].id}');" class="iconImg"><img src="images/icons/delete.gif" border="0"></a>
									{/if}
									&nbsp;&nbsp;
									</td>
									
								</tr>
						{/section}
										
								</tbody></table>
			{else}
							<div align="center" class="error" id="mid_body">No activity found.</div>

							
			{/if}