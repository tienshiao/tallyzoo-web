/*
This is used to load the Line chart
*/

var pre_width = 350;
function returnActiType()
{		var actiType="0";
		if(document.frmActivity.hidHaveData.value == 0)
		{
			var obj=document.getElementById('txtColor');
			for(i=0;i<obj.length;i++)
			{
				if(obj[i].selected)
					actiType=obj[i].value;
			}
		}
		return actiType;
		

}
function prev_line(actiId,graphType,dataOpt)
{	
	title="";
	var actiType = returnActiType();
	document.getElementById('showHide').style.display = "";
	document.getElementById('prev_chartContainer').innerHTML = "<img src=\"" + sitePath + "images\indicatorbar.gif\">";
	var queryStr = "eid=" + actiId + "&graphType=" + graphType + "&opt=" + dataOpt + "&gColor=" + graphColor;
	var so = new SWFObject(sitePath + "chart/amline/amline.swf", "pre_amline", pre_width, "282", "8", "#FFFFFF");
	so.addVariable("path", sitePath + "chart/amline/");
	so.addVariable("settings_file", encodeURIComponent(sitePath + "chart/amline/amline_settings.xml"));                // you can set two or more different settings files here (separated by commas)
	so.addVariable("data_file", encodeURIComponent(sitePath + "user/data_chart.php?" + queryStr ));
	so.addVariable("additional_chart_settings", encodeURIComponent("<settings><legend><enabled>false</enabled></legend></settings>"));
	
	
	if(document.getElementById('txtGoal').value >0)
	{
	so.addVariable("additional_chart_settings", encodeURIComponent("<settings><guides><guide><start_value>" + document.getElementById('txtGoal').value + "</start_value><color>#0D8ECF</color></guide></guides></settings>"));
	
	}
	so.addParam("wmode", "transparent");
	so.write("prev_chartContainer");
	
}

/*
	This is used to load the Pie Chart
*/
function prev_pie(actiId,graphType,dataOpt)
{	document.getElementById('showHide').style.display = "";
	document.getElementById('prev_chartContainer').innerHTML = "<img src=\"" + sitePath + "images\indicatorbar.gif\">";
	
	var queryStr = "eid=" + actiId + "&graphType=" + graphType + "&opt=" + dataOpt + "&gColor=" + graphColor;
	
	var so = new SWFObject(sitePath + "chart/ampie/ampie.swf", "pre_ampie", pre_width, "282", "8", "#FFFFFF");
	so.addVariable("path", sitePath + "chart/ampie/");
	so.addVariable("settings_file", encodeURIComponent(sitePath +"chart/ampie/ampie_settings.xml"));                // you can set two or more different settings files here (separated by commas)
	so.addVariable("data_file", encodeURIComponent(sitePath + "user/data_chart.php?" + queryStr ));
	
	so.addVariable("additional_chart_settings", encodeURIComponent("<settings><legend><enabled>false</enabled></legend></settings>"));
				
	
	so.addParam("wmode", "transparent");
	so.write("prev_chartContainer");
}


/*
	This function is used to load bar Chart
*/
function prev_barColoumn(actiId,graphType,dataOpt,type)
{	
		document.getElementById('showHide').style.display = "";
		document.getElementById('prev_chartContainer').innerHTML = "<img src=\"" + sitePath + "images\indicatorbar.gif\">";
		var queryStr = "eid=" + actiId + "&graphType=" + graphType + "&opt=" + dataOpt + "&gColor=" + graphColor;
		var so = new SWFObject(sitePath + "chart/amcolumn/amcolumn.swf", "pre_amcolumn", pre_width, "282", "8", "#FFFFFF");
		so.addVariable("path", sitePath + "user/");
		so.addVariable("settings_file", encodeURIComponent(sitePath + "chart/amcolumn/amcolumn_settings.xml"));        // you can set two or more different settings files here (separated by commas)
		so.addVariable("data_file", encodeURIComponent(sitePath + "user/data_chart.php?" + queryStr ));
		
		so.addVariable("additional_chart_settings", encodeURIComponent("<settings><legend><enabled>false</enabled></legend></settings>"));
		
		if(type==4){ //Bar
			so.addVariable("additional_chart_settings", encodeURIComponent("<settings><type>bar</type></settings>")); 
		}else{
			so.addVariable("additional_chart_settings", encodeURIComponent("<settings><type>colomn</type></settings>")); 
		}	
		so.addParam("wmode", "transparent");
		so.write("prev_chartContainer");
}
/*
 This function is used for timeslide (stock)
*/
function prev_timeslide(actiId,graphType,dataOpt)
{		document.getElementById('showHide').style.display = "";
		document.getElementById('prev_chartContainer').innerHTML = "<img src=\"" + sitePath + "images\indicatorbar.gif\">";
		var queryStr = "eid=" + actiId + "&graphType=" + graphType + "&opt=" + dataOpt + "&gColor=" + graphColor;
		var so = new SWFObject(sitePath + "chart/amtimeslide/amstock.swf", "pre_amstock", pre_width, "400", "8", "#FFFFFF");
		so.addVariable("path", sitePath + "user/");
		so.addVariable("settings_file", encodeURIComponent(sitePath + "user/data_chart.php?" + queryStr ));
		so.addVariable("additional_chart_settings", encodeURIComponent("<settings><data_set_selector><enabled>false</enabled></data_set_selector></settings>"));
		so.addParam("wmode", "transparent");
		so.write("prev_chartContainer");
		
}
/*
This function is used for name,number and time graph
*/
function prev_nameNumberTime(headText,midText)
{
	var color = document.getElementById('txtColor').value;
	document.getElementById('prev_chartContainer').innerHTML = "<img src=\"" + sitePath + "images\indicatorbar.gif\">";
	strTbl = "<table  class=\"tbl_form\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" id=\"tblGraphC\"><tbody><tr>							<th colspan=\"2\" align=\"left\">" + headText + "</th></tr>";
	strTbl += "						<tr> ";
	strTbl += "							<td  colspan=\"2\" class=\"min_ht\" valign=\"middle\"><span style=\"color:#" + color+ "\">" + midText + "</span></td>";
	strTbl += "						</tr>";
	strTbl += "						<tr>";
	strTbl += "							<td colspan=\"2\" align=\"left\" height=\"5\">&nbsp;</td>";		
	strTbl += "						</tr>";
	strTbl += "					</tbody></table>";
	document.getElementById('prev_chartContainer').innerHTML = strTbl;
}




