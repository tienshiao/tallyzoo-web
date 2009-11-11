/*
This is used to load the Line chart
*/

var pre_width = 332;

//var goalValue= document.dashboard.getElementsByTagName(goal);
function dashboard_line(actiId,graphType,dataOpt,goal,divId)
{		
	var queryStr = "eid=" + actiId + "&graphType=" + graphType + "&opt=" + dataOpt + "&gColor=" + graphColor;
	var so = new SWFObject(sitePath + "chart/amline/amline.swf", "pre_amline", pre_width, "225", "8", "#FFFFFF");
	so.addVariable("path", sitePath + "chart/amline/");
	so.addVariable("settings_file", encodeURIComponent(sitePath + "chart/amline/amline_settings.xml"));                // you can set two or more different settings files here (separated by commas)
	//so.addVariable("additional_chart_settings", encodeURIComponent("<settings><graphs><graph gid='1'><color>ED00FF</color></graph></graphs></settings>"));
	so.addVariable("data_file", encodeURIComponent(sitePath + "user/data_chart.php?" + queryStr ));
	
	
	if(goal > 0)
	{
	       so.addVariable("additional_chart_settings", encodeURIComponent("<settings><guides><guide><start_value>" + goal + "</start_value><color>#0D8ECF</color></guide></guides></settings>"));
	}
    so.addVariable("additional_chart_settings", encodeURIComponent("<settings><legend><enabled>false</enabled></legend></settings>"));
	so.addParam("wmode", "transparent");
	so.write(divId);
	
}

/*
	This is used to load the Pie Chart
*/
function dashboard_pie(actiId,graphType,dataOpt,goal,divId)
{	
	var queryStr = "eid=" + actiId + "&graphType=" + graphType + "&opt=" + dataOpt + "&gColor=" + graphColor;
	var so = new SWFObject(sitePath + "chart/ampie/ampie.swf", "pre_ampie", pre_width, "225", "8", "#FFFFFF");
	so.addVariable("path", sitePath + "chart/ampie/");
	so.addVariable("settings_file", encodeURIComponent(sitePath +"chart/ampie/ampie_settings_dashboard.xml"));                // you can set two or more different settings files here (separated by commas)
	so.addVariable("data_file", encodeURIComponent(sitePath + "user/data_chart.php?" + queryStr ));
	so.addVariable("additional_chart_settings", encodeURIComponent("<settings><legend><enabled>false</enabled></legend></settings>"));
	so.addParam("wmode", "transparent");
	so.write(divId);
}


/*
	This function is used to load bar Chart
*/
function dashboard_barColoumn(actiId,graphType,dataOpt,type,goal,divId)
{	
		//document.getElementById('showHide').style.display = "";
		var queryStr = "eid=" + actiId + "&graphType=" + graphType + "&opt=" + dataOpt + "&gColor=" + graphColor;    
		var so = new SWFObject(sitePath + "chart/amcolumn/amcolumn.swf", "pre_amcolumn", pre_width, "225", "8", "#FFFFFF");
		so.addVariable("path", sitePath + "chart/amcolumn/");
		so.addVariable("settings_file", encodeURIComponent(sitePath + "chart/amcolumn/amcolumn_settings.xml"));        // you can set two or more different settings files here (separated by commas)
		so.addVariable("data_file", encodeURIComponent(sitePath + "user/data_chart.php?" + queryStr ));
		so.addVariable("additional_chart_settings", encodeURIComponent("<settings><legend><enabled>false</enabled></legend></settings>"));
		so.addVariable("additional_chart_settings", encodeURIComponent("<settings><legend><enabled>false</enabled></legend></settings>"));
		
		if(type==4){ //Bar
			so.addVariable("additional_chart_settings", encodeURIComponent("<settings><type>bar</type></settings>")); 
		}else{
			so.addVariable("additional_chart_settings", encodeURIComponent("<settings><type>colomn</type></settings>")); 
		}	
		so.addParam("wmode", "transparent");
		so.write(divId);
}
/*
 This function is used for timeslide (stock)
*/
function dashboard_timeslide(actiId,graphType,dataOpt,goal,divId)
{	
		var queryStr = "eid=" + actiId + "&graphType=" + graphType + "&opt=" + dataOpt + "&gColor=" + graphColor;    
		var so = new SWFObject(sitePath + "chart/amtimeslide/amstock.swf", "pre_amstock", pre_width, "225", "8", "#FFFFFF");
		so.addVariable("path", sitePath + "user/");
		so.addVariable("settings_file", encodeURIComponent(sitePath + "user/data_chart.php?" + queryStr ));
		//so.addVariable("additional_chart_settings", encodeURIComponent("<settings><data_sets><data_set did='0'><color>0E5720</color></data_set></data_sets></settings>"));
		so.addVariable("additional_chart_settings", encodeURIComponent("<settings><legend><enabled>false</enabled></legend></settings>"));
		so.addParam("wmode", "transparent");	
		so.write(divId);
		
}
/*
This function is used for name,number and time graph
*/
function dashboard_nameNumberTime(headText,midText,color,divId)
{  	strTbl = "<table  class=\"tbl_form\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" id=\"tblGraphC\"><tr> <th colspan=\"2\" align=\"left\">" + headText + "</th></tr><tbody>"; //<tr> <th colspan=\"2\" align=\"left\">" + headText + "</th></tr>
	strTbl += "						<tr> ";
	strTbl += "							<td  colspan=\"2\" align=\"center\"><div id=\"graphText\" style=\"color:#" + color+ "\">" + midText + "</div></td>";
	strTbl += "						</tr>";
//	strTbl += "						<tr height=\"20\">";
  // strTbl += "							<td colspan=\"1\" align=\"left\">&nbsp;</td>";		
  //  strTbl += "						</tr>";
	strTbl += "					</tbody></table>";

	document.getElementById(divId).innerHTML = strTbl;
}



