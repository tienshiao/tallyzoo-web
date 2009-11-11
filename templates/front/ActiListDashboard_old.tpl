<script type="text/javascript" src="{$SITEURL}includes/javascript/jscolor/jscolor.js"></script>

<script src="{$SITEURL}includes/javascript/round.js" type="text/javascript"></script>

{literal}
<script language="javascript">
$().ready(function() {	
	
	$("#dashboardActiList").validate({
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
	

function showpagingresult(pageno,numrecordperrow)
{
	document.getElementById('txtPage').value = pageno;
	document.getElementById('perpage').value = numrecordperrow;
	document.dashboardActiList.submit();

}
function viewActivity(id)
{
		document.dashboardActiList.editId.value = id;
		document.dashboardActiList.ACT.value = "VIEWFACTI";
		document.dashboardActiList.action = "index.php?mod=activityDetails";
		document.dashboardActiList.submit();
}
function showpagingresult(pageno,numrecordperrow)
{
 	document.getElementById('hidFilter').value = "{/literal}{$smarty.post.hidFilter}{literal}"
	document.getElementById('txtPage').value = pageno;
	document.getElementById('perpage').value = numrecordperrow;
	document.dashboardActiList.submit();

}

function setFilter(setFilter)
{
	document.dashboardActiList.hidFilter.value = setFilter;
	document.dashboardActiList.submit();

}
/*
function showProfile(uid)
{
	document.dashboardActiList.userId.value = uid;
	document.dashboardActiList.action = "{/literal}{$SITEURL}viewProfile/" + uid + "{literal}";
	document.dashboardActiList.submit();
}
*/
</script>
{/literal}
 <div id="sub_menu_out">
    	<div id="sub_menu"><a href="ActiListDashboard" id="subActive"><span class="ln_lft">&nbsp;</span>Dashboard Activity List<span class="ln_rgt">&nbsp;</span></a></div>
    </div>
<div id="container">
<div align="center" class="error" id="mid_body">{$err_msg}&nbsp;</div>
<form name="dashboardActiList" method="post" onsubmit="javascript:return submitForm();" >
<input type="hidden" name='editId' value="" />
<input type="hidden" name='ACT' value="search"/>
<input type="hidden" id="txtPage" name="txtPage" value="" />
<input type="hidden" id="perpage" name="perpage" value="" />
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
						<td nowrap="nowrap" width="92%"><h2>Dashboard Activity List</h2></td>
					</tr>
				</tbody>
			</table>
		</div>
       
  
 
         			  <div class="mid_inside">
				<!--
<div>
					<div  class="lbl_about"><label class="cGrayN"></label></div>
					<div class="lbl_PubAct">Public Activities  is tracking:</div>
				</div>
-->
{if $actCount gt 0}
                <div class="w800N">

	      
<div style="clear:both;">
</div>

						<table width="100%" cellspacing="0" cellpadding="0" border="0" class="tbl_insides2" id="tbl_new">	
							<tr>
                                <th width="1%" align="left"><!--
<input name="checkall" type="checkbox" value="" onclick="Javascript: return SetAllCheckBoxes('SelectedItems','container',this.checked);"  />
--></th>
								<th width="10%">&nbsp;</th>
								<th width="55%" align="left">Name</th>
								<th width="10%" align="left">Count</th>
								<th nowrap="" width="20%" align="left">Time</th>
							</tr>
        
{section name=index loop=$ROW}
	<tr  class="{cycle values='row2,row1'}">
              <td align="left"  width="1%">
              
              <div>
            
              <input type="checkbox"       
              {assign var="i" value=$i|default:0}
                      
   
              {foreach from=$ACTIVITY key="key" item="value"}
                   {if $ROW[index].id eq $value}
                        checked 
                   {/if}
              {/foreach}           
                                             
               name="id[]" value="{$ROW[index].id}" onclick="return check(this);" onselect="{$ROW[index].id}" />
              <input type="hidden" name="selecteditems"  value=" "/>
              
              </div>
			  </td>
		      <td align="center"  width="10%">
			  <div style="background-color:  {$ROW[index].color}; margin: 0pt auto; width: 20px; font-size: 2px; line-height: 10px; color: #ffffff;" class="rounded">&nbsp;</div>
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
		      <td nowrap="" width="20%" align="left">{$ROW[index].timeInMin}</td>
		      
		     
	 </tr>
{/section}

			</table>
                 
							<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center"></div>
       	    <tr>
       	      <td align="center">
             
                 <p class="btn_back" align="center"><a href="javascript:fnredirect('dashboard');" title="Back To Dashboard">Back</a> </p>
                <input type='submit' value="Save" name="submit" title="Save" class="btn_sty2 btn_save" />
                 </td>
   	        </tr>
   	      </table>
	
		
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

function submitForm()
{
   
	var doc = document.dashboardActiList;
   
    document.dashboardActiList.submit();
}

function SetAllCheckBoxes(FormName, AreaID, CheckValue)
{

var objCheckBoxes = document.getElementById(AreaID).getElementsByTagName('input');
if(!objCheckBoxes)
return;
var countCheckBoxes = objCheckBoxes.length;
if(!countCheckBoxes)
objCheckBoxes.checked = CheckValue;
else
for(var i = 0; i < countCheckBoxes; i++)
objCheckBoxes[i].checked = CheckValue;
}

function fnredirect(path)
{
	location.href=path;
}

var maxChecks=4

function check(obj)
{
	var checkedArr=new Array();
	checkedArr=document.getElementsByName("id[]");
    
 	var checkCount=0;
    
	for(i=0;i<checkedArr.length;i++){
		if(checkedArr[i].checked){
		  checkCount += 1;
		}
	}
     if (checkCount == 0){
   	 alert('you may choose minimum of 1 options');
     	obj.checked=false;
	checkCount=checkCount-1;
     return false;
	}
	else if (checkCount > 4){
    alert('you may only choose up to '+maxChecks+' options');
	obj.checked=false;
	checkCount=checkCount-1;
	return false;
	}
    
    return true;
    
	
}



</script>
{/literal}