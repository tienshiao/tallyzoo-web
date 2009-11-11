<link href="{$SITEURL}includes/style/inettuts.css" rel="stylesheet" type="text/css" />
<link href="{$SITEURL}includes/style/inettuts.js.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="{$SITEURL}includes/javascript/jscolor/jscolor.js"></script>

<script src="{$SITEURL}includes/javascript/round.js" type="text/javascript"></script>
<script type="text/javascript" language="javascript" src="{$SITEURL}includes/javascript/dashboard.js"></script>

<div id="container">

	<div class="blue_block">
		<div class="blue_block_in">
		  
		  <table border="0" cellspacing="0" cellpadding="0">
        	    <tr>
        	      <td><input name="txtQuickCnt" type="text" id="txtQuickCnt" value="Activity: Amount" class="fld_txt wd_250" onFocus="javascript:blankAmt();" /></td>
				   <td class="calendar" id="tdCal"><a href="javascript:;" onclick="javascript:showCal();"><img src="images/icons/cal.gif" width="16" height="20" alt="Calendar" /></a></td>
        	      <td><a href="javascript:;" onclick="javascript:quickAdd('dashboard');"><img src="images/btn_quick_add.gif" width="90" height="23" alt="Quick Add" /></a></td>
      	      </tr>
      	    </table>
	  </div>
   </div>
  
	<!-- Mid Column Starts -->
	<div id="mid_col" >
    
    <form name="dashboard" method="get" method="post" action="{$SITEURL}ActiListDashboard" >
		<input type="hidden" name="ACT" id="ACT" value=""/>
		<input type="hidden" name="editId" id="editId" />
		<input type="hidden" name="txtDashBordId" id="txtDashBordId" value="">







<div id="columns">
	<!-- first Column Starts -->
<table width="100%"><tr><td valign="top">

		<ul id="column1" class="column" > 
		{section name=index loop=$RESULT1}
				<li class="widget" > 
				<div class="gray_block wd_365">

			<div class="bl_top"><img src="images/front/blocks/gray_top_lft.gif" width="9" height="6" alt="" /></div>
			<div class="bl_mid">
				<div class="bl_mid_in">
				 
				  <div class="bl_main">
				 <table border="0" cellspacing="0" cellpadding="0" width="100%" class="tbl_dash_head">
						<tr>
							<td width="15"><div class="widget-head" id="mod_{$RESULT1[index].id}"><img src="images/dots.gif"></div>
							</td>
							<td nowrap="nowrap">
								<h2><a id="a_{$RESULT1[index].id}" href="activities/{$RESULT1[index].id}/{$RESULT1[index].name|sanitize_title_with_dashes}" >{$RESULT1[index].name}</a>&nbsp;</h2>
							</td>
							
							<td width="30" align="center"><a 
								  {if $RESULT1[index].d_id gt 0}
								  href="Javascript:;" onClick="Javascript:removeChart({$RESULT1[index].d_id},{$RESULT1[index].id})"
								  {else}
								  href="Javascript:;"
								  {/if}
								  title="Remove"><img src="images/front/icons/close.gif" width="14" height="14"  /></a>
							</td>
						</tr>
					</table>
    				{if $RESULT1[index].id neq ""}
					<div id="dashboardGraph_{$RESULT1[index].id}"></div>
					<p class="share_btn" id="p_{$RESULT1[index].id}"><a href="#"><img src="images/icons/public2.gif" width="55" height="21" alt="Public" /></a></p>
					{else}
					 <div class="graph">&nbsp;</div>
					{/if}	
					
				  </div>
				 
				</div>
			</div>
			<div class="bl_bot"><img src="images/front/blocks/gray_bot_lft.gif" width="16" height="10" alt="" /></div>
			 
		</div>	
	</li>
	{/section}
	</ul>
	
<!-- first column end -->
</td>
<td valign="top">
<!-- second column start -->	

	<ul id="column2" class="column">
			{section name=index loop=$RESULT2}
				<li class="widget" > 
				<div class="gray_block wd_365">

			<div class="bl_top"><img src="images/front/blocks/gray_top_lft.gif" width="9" height="6" alt="" /></div>
			<div class="bl_mid">
				<div class="bl_mid_in">
				 
				  <div class="bl_main">
				 <table border="0" cellspacing="0" cellpadding="0" width="100%" class="tbl_dash_head">
						<tr>
							<td width="15"><div class="widget-head" id="mod_{$RESULT2[index].id}"><img src="images/dots.gif"></div>
							</td>
							<td nowrap="nowrap">
								<h2><a id="a_{$RESULT2[index].id}" href="activities/{$RESULT2[index].id}/{$RESULT2[index].name|sanitize_title_with_dashes}" >{$RESULT2[index].name}</a>&nbsp;</h2>
							</td>
							
							<td width="30" align="center"><a 
								  {if $RESULT2[index].d_id gt 0}
								  href="Javascript:;" onClick="Javascript:removeChart({$RESULT2[index].d_id},{$RESULT2[index].id})"
								  {else}
								  href="Javascript:;"
								  {/if}
								  title="Remove"><img src="images/front/icons/close.gif" width="14" height="14"  /></a>
							</td>
						</tr>
					</table>
    				{if $RESULT2[index].id neq ""}
					<div id="dashboardGraph_{$RESULT2[index].id}"></div>
					<p class="share_btn" id="p_{$RESULT2[index].id}"><a href="#"><img src="images/icons/public2.gif" width="55" height="21" alt="Public" /></a></p>
					{else}
					 <div class="graph">&nbsp;</div>
					{/if}	
					
				  </div>
				 
				</div>
			</div>
			<div class="bl_bot"><img src="images/front/blocks/gray_bot_lft.gif" width="16" height="10" alt="" /></div>
			 
		</div>	
	</li>
	{/section}
	</ul>
</td></tr></table>
</div>
<!-- second column End -->	
		<script type="text/javascript" src="{$SITEURL}includes/javascript/widget/jquery-1.2.6.min.js"></script>
		<script type="text/javascript" src="{$SITEURL}includes/javascript/widget/jquery-ui-personalized-1.6rc2.min.js"></script>
		<script type="text/javascript" src="{$SITEURL}includes/javascript/widget/inettuts.js"></script>





<div class="cl_both"><img src="images/front/blank.gif" width="1" height="1" alt="" /></div>
		<p><a href="javascript:;"><img src="images/front/btn_add_graph.gif" width="120" height="38" alt="Add a Graph" onclick="javascript:fnPopupDiv('900', '250', '30', '40', 'ActiListDashboard', 'Dashboard','');"/></a></p>
        
        </form>
  </div>
	<!-- Mid Column Ends -->	
	<!-- Right Column Starts -->
	<div id="right_col">
	<img src="images/front/google_adds.gif" width="160" height="649" alt="Ads by Google" /></div>
	<!-- Right Column Ends -->
	<div class="cl_both"></div>
</div>
<div id="container_bot">&nbsp;</div>


{literal}
<script language="javascript">

function viewActivity(id)
{
		document.dashboard.editId.value = id;
		document.dashboard.ACT.value = "VIEWFACTI";
		document.dashboard.action = "index.php?mod=activityDetails";
		document.dashboard.submit();
}


function noActiOnclick(filename)
{
	location.href=sitePath +  filename;
}
function removeChart(id,actiId)
{
	if(confirm('                  !! WARNING !!\n------------------------------------------------------------\n                  Graph will be deleted.\n                  Are you sure?'))
	{	
		value ="ACT=DELETE&dashBordId=" + id + "&actiId=" + actiId; 
		var responseText = $.ajax({
		type: "POST",
		url: "user/dashbordOperation.php",
		data: value,
		async: false
		}).responseText;

	document.getElementById('a_' + actiId).innerHTML="";
	document.getElementById('a_' + actiId).href="javascript:;";
	document.getElementById('dashboardGraph_' + actiId).innerHTML=" ";
	document.getElementById('dashboardGraph_' + actiId).className="graph";
	document.getElementById('p_' + actiId).style.display="none";
	//document.getElementById('p_' + actiId).innerHTML="";

 }
}
function submitFormDashBoard()
{
   
	var doc = document.dashboardActiList;
	cnt = doc.cnt.value;
			id= "";
			if(cnt >0)
			{
				for(i=1;i<=cnt;i++)
				{
					chk = "chkActi_" + i;
					if(document.getElementById(chk)){
						if(document.getElementById(chk).checked)
						{
							if(id == "")
								id = document.getElementById(chk).value;
							else
							id = id + "," + document.getElementById(chk).value;
						}
					}
				}
				
				if(id == "")
				{
					alert("Please select activity.");
					document.getElementById("chkActi_1").focus();
					return false;
				}
				arrId = id.split(",");
				if(arrId.length ==0)
				{
					alert("Please select atleast one activity.");
					document.getElementById("chkActi_1").focus();
					return false;
				}
				if(arrId.length > 4)
					{
						document.getElementById("mid_body").style.display ="";
						document.getElementById("mid_body").innerHTML ="<div ><span class=\"error_div_dashboard\">The dashboard can display 4 graph. Please reduce the number of graphs your are trying to add.</span></div>";
						document.getElementById("chkActi_1").focus();
						return false;
			     }
				
				doc.activityIds.value = id;
				
			}
   
 }
 function saveCloumn()
{ 
	var isdColumnMid ="";
	var isdColumnRight ="";
	objMid = document.getElementById('column1').getElementsByTagName('DIV');
	len = objMid.length;

	for(i=0;i<len;i++)
	{
		id = objMid[i].id;
		if(id.indexOf('mod_') != -1)
		{ 
			arr = id.split("mod_");
			if(isdColumnMid == ""){
				isdColumnMid = arr[1];
			}else{
				isdColumnMid += "," +  arr[1];
			}
		}
	}

	objRight = document.getElementById('column2').getElementsByTagName('DIV');
	len = objRight.length;

	for(i=0;i<len;i++)
	{
		id = objRight[i].id;
		if(id.indexOf('mod_') != -1)
		{ 
			arr = id.split("mod_");
			if(isdColumnRight == ""){
				isdColumnRight = arr[1];
			}else{
				isdColumnRight += "," +  arr[1];
			}
		}
	}
	//alert(isdColumnMid);
	//alert(isdColumnRight);

	value ="ACT=DRAG&dashBordId=1&firstCol=" + isdColumnMid + "&secondCol=" + isdColumnRight; 
		var responseText = $.ajax({
		type: "POST",
		url: "user/dashbordOperation.php",
		data: value,
		async: false
		}).responseText;

}
</script>
{/literal}