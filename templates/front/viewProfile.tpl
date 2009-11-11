<script type="text/javascript" src="{$SITEURL}includes/javascript/jscolor/jscolor.js"></script>

<script src="{$SITEURL}includes/javascript/round.js" type="text/javascript"></script>

 <div id="sub_menu_out">
    	<div id="sub_menu"><a href="#" id="subActive"><span class="ln_lft">&nbsp;</span>Public Profile<span class="ln_rgt">&nbsp;</span></a></div>
    </div>
<div id="container">
<form name="viewProfile" method="post">
<input type="hidden" name='editId' value="" />
<input type="hidden" name='ACT' value="" />
<input type="hidden" id="txtPage" name="txtPage" />
<input type="hidden" id="perpage" name="perpage" />
<input type="hidden" name="currUserid" id="currUserid" value="{$smarty.session.tz_user.userid}"/>
<input type="hidden" id="hidFilter" name="hidFilter" value=""/>
<input type="hidden" name="userId" id="userId"/>
<div>
   	<div class="block_top"><div>&nbsp;</div></div>
    
    	<div class="block_mid brdN">
   
		<div class="block_midinN">
			<table cellspacing="0" cellpadding="0" border="0" width="100%">
				<tbody>
					<tr>
                    	<td class="img_link" width="8%">{if $DETAILS.exImage neq ""}                  
                		{$DETAILS.imagename}{else}
				<img src="images/nophotp.jpg" border="0" /><br/>
				{/if}</td>
						<td nowrap="nowrap" width="92%"><h2>{$DETAILS.username}</h2></td>
					</tr>
				</tbody>
			</table>
		</div>
       
   
 
         			  <div class="mid_inside">
				<div>
					<div  class="lbl_about"><label class="cGrayN">{if $DETAILS.about neq ''}{$DETAILS.about}{/if}</label></div>
					<div class="lbl_PubAct">Public Activities {$DETAILS.username} is tracking:</div>
				</div>
                  {if $actCount gt 0}
                <div class="w800N">
<div class="filters">
<label>Display:</label>
<a
{if $smarty.post.hidFilter eq 'mr' or $smarty.post.hidFilter eq ''} 
id="filter_act" 
{/if} href="javascript:setFilter('mr')" title="Most Recent">Most Recent</a>
 <a {if $smarty.post.hidFilter eq 'aph'} 
id="filter_act" 
{/if}
href="javascript:setFilter('aph')"  title="Alphabetically">Alphabetically</a>

</div>
{if $pagelist neq ""}
		  <div class="pagingtable">
			{$pagelist}
		  </div>
		 {/if}
<div style="clear:both;">
</div>

						<table width="100%" cellspacing="0" cellpadding="0" border="0" class="tbl_insides2" id="tbl_new">	
							<tr>
								<th width="10%">&nbsp;</th>
								<th width="60%" align="left">Name</th>
								<th width="10%" align="left">Count</th>
								<th nowrap="" width="20%" align="left">Time</th>
							</tr>
{section name=index loop=$ROW}
	<tr  class="{cycle values='row2,row1'}">
		      <td align="center"  width="10%">
			  <div style="background-color: #{$ROW[index].color}; margin: 0pt auto; width: 20px; font-size: 2px; line-height: 10px; color: #ffffff;" class="rounded">&nbsp;</div>
			  </td>
		      <td 
			  {if $ROW[index].relateActivity eq ""}
			  colspan="1"
			  {/if}
			  class="activities" width="60%" align="left" >
              <span class="act_head"><a href="activities/{$ROW[index].id}/{$ROW[index].name|sanitize_title_with_dashes}" >{$ROW[index].name}</a></span><br />
              
              {$ROW[index].default_note|truncate:40:"...":false}
              
              </td>
			  
              <td width="10%" align="left">{$ROW[index].total}</td>
		      <td nowrap="" width="20%" align="left">{$ROW[index].created_on}</td>
		      
		     
	 </tr>
{/section}
						</table>
							</div>
                            
		
	<script type="text/javascript">
			Rounded('rounded', 6, 6);
	</script>
{else}
	<div align="center" class="error" id="mid_body">No activity found.</div>

{/if}  </div></div>
							</div>
                             
						  </div>
                          </form>
						 </div>
							 	
						</div>
	 
  
       	      
    <div class="block_bot"></div>
    
    </div>
        
          
</div>
    
    <div id="container_bot">&nbsp;</div>
	<!-- Container Ends -->
{literal}
<script language="javascript">
function showpagingresult(pageno,numrecordperrow)
{
    
	document.getElementById('txtPage').value = pageno;
	document.getElementById('perpage').value = numrecordperrow;
	document.viewProfile.submit();

}
function deleAct(id)
{
	if(confirm('                !! WARNING !!\n------------------------------------------------------------\n                  Activity will be deleted.\n                  Are you sure?'))
	{  
		document.viewProfile.editId.value = id;
		document.viewProfile.ACT.value = "DELETE";
		document.viewProfile.action = "{/literal}{$SITEURL}myActivity{literal}";
		document.viewProfile.submit();
	}
}
function viewActivity(id)
{
		document.viewProfile.editId.value = id;
		document.viewProfile.ACT.value = "VIEWFACTI";
		document.viewProfile.action = "index.php?mod=activityDetails";
		document.viewProfile.submit();
}

function setFilter(setFilter)
{
	document.viewProfile.hidFilter.value = setFilter;
	document.viewProfile.submit();

}
</script>
{/literal}