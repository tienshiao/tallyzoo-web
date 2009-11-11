/*
This is used to load the Line chart
*/
var lengendShowHid = 1;
if(location.href.indexOf("myActivity") == -1)
{
var width = 450;
}else{
var width = 350;
lengendShowHid = 1;
}
var so;
function line(actiId,graphType,dataOpt)
{	document.getElementById('showHide').style.display = "";
	if(document.getElementById('idOwnFlag').value != 1)
	{
		width = 600;
	}
	var queryStr = "eid=" + actiId + "&graphType=" + graphType + "&opt=" + dataOpt;
	var so = new SWFObject(sitePath + "chart/amline/amline.swf", "amline", width, "282", "8", "#FFFFFF");
	so.addVariable("path", sitePath + "chart/amline/");
	so.addVariable("settings_file", encodeURIComponent(sitePath + "chart/amline/amline_settings.xml"));                // you can set two or more different settings files here (separated by commas)
	so.addVariable("data_file", encodeURIComponent(sitePath + "user/data_chart.php?" + queryStr ));
		
//	if(lengendShowHid == 1)
//	{ 
		so.addVariable("additional_chart_settings", encodeURIComponent("<settings><guides><enabled>false</enabled></guides></settings>"));
		so.addVariable("additional_chart_settings", encodeURIComponent("<settings><legend><enabled>false</enabled></legend></settings>"));
//		lengendShowHid = 0;
//		document.getElementById('a_showhide').innerHTML = "Show Legend";
		
//	}else{

//		so.addVariable("additional_chart_settings", encodeURIComponent("<settings><legend><enabled>true</enabled></legend></settings>"));
//		if(document.getElementById('txtGoal').value >0)
//		{
//			so.addVariable("additional_chart_settings", encodeURIComponent("<settings><guides><guide><start_value>" + document.getElementById('txtGoal').value + "</start_value><color>#0D8ECF</color> <width>2</width></guide></guides></settings>"));
//		}
//		lengendShowHid = 1;
//		document.getElementById('a_showhide').innerHTML = "Hide Legend";
		
//	}
	
	
	so.addParam("wmode", "transparent");
	so.write("chartContainer");
	
}

/*
	This is used to load the Pie Chart
*/
function pie(actiId,graphType,dataOpt)
{	
	var title = "";
	document.getElementById('showHide').style.display = "";
	if(document.getElementById('idOwnFlag').value != 1)
	{
		width = 600;
	}
	var queryStr = "eid=" + actiId + "&graphType=" + graphType + "&opt=" + dataOpt;

	var so = new SWFObject(sitePath + "chart/ampie/ampie.swf", "ampie", width, "282", "8", "#FFFFFF");
	so.addVariable("path", sitePath + "chart/ampie/");
	so.addVariable("settings_file", encodeURIComponent(sitePath +"chart/ampie/ampie_settings.xml"));                // you can set two or more different settings files here (separated by commas)
	so.addVariable("data_file", encodeURIComponent(sitePath + "user/data_chart.php?" + queryStr ));
//	if(lengendShowHid == 1)
//	{ 
		so.addVariable("additional_chart_settings", encodeURIComponent("<settings><legend><enabled>false</enabled></legend></settings>"));
//		lengendShowHid = 0;
//		document.getElementById('a_showhide').innerHTML = "Show Legend";
		
//	}else{
//		so.addVariable("additional_chart_settings", encodeURIComponent("<settings><legend><enabled>true</enabled></legend></settings>"));
//		lengendShowHid = 1;
//		document.getElementById('a_showhide').innerHTML = "Hide Legend";
		
//	}
	//so.addVariable("additional_chart_settings", encodeURIComponent("<settings><data_labels><enabled>false</enabled></data_labels></settings>"));
	so.addParam("wmode", "transparent");
	so.write("chartContainer");
}


/*
	This function is used to load bar Chart
*/
function barColoumn(actiId,graphType,dataOpt,type)
{	
		var settingFile = "amcolumn_settings.xml";
		document.getElementById('showHide').style.display = "";
		if(document.getElementById('idOwnFlag').value != 1)
		{
			width = 600;
		}
		
		if(type == 4)
		{
			settingFile = "amcolumn_settings_bar.xml";
		}
		var queryStr = "eid=" + actiId + "&graphType=" + graphType + "&opt=" + dataOpt;
		var so = new SWFObject(sitePath + "chart/amcolumn/amcolumn.swf", "amcolumn", width, "282", "8", "#FFFFFF");
		so.addVariable("path", sitePath + "chart/amcolumn/");
		so.addVariable("settings_file", encodeURIComponent(sitePath + "chart/amcolumn/" + settingFile));        // you can set two or more different settings files here (separated by commas)
		so.addVariable("data_file", encodeURIComponent(sitePath + "user/data_chart.php?" + queryStr ));
		
//		if(lengendShowHid == 1)
//		{ 
			so.addVariable("additional_chart_settings", encodeURIComponent("<settings><legend><enabled>false</enabled></legend></settings>"));
//			lengendShowHid = 0;
//			document.getElementById('a_showhide').innerHTML = "Show Legend";
			
//		}else{

//			so.addVariable("additional_chart_settings", encodeURIComponent("<settings><legend><enabled>true</enabled></legend></settings>"));
//			lengendShowHid = 1;
//			document.getElementById('a_showhide').innerHTML = "Hide Legend";
			
//		}
		/*if(type==4){ //Bar
			so.addVariable("additional_chart_settings", encodeURIComponent("<settings><type>bar</type></settings>")); 
		}else{
			so.addVariable("additional_chart_settings", encodeURIComponent("<settings><type>colomn</type></settings>")); 
		}*/
		so.addParam("wmode", "transparent");
		
		so.write("chartContainer");
}
/*
 This function is used for timeslide (stock)
*/
function timeslide(actiId,graphType,dataOpt)
{		document.getElementById('showHide').style.display = "";
		if(document.getElementById('idOwnFlag').value != 1)
		{
			width = 600;
		}
		var queryStr = "eid=" + actiId + "&graphType=" + graphType + "&opt=" + dataOpt;
		var so = new SWFObject(sitePath + "chart/amtimeslide/amstock.swf", "amstock", width, "400", "8", "#FFFFFF");
		so.addVariable("path", sitePath + "user/");
		so.addVariable("settings_file", encodeURIComponent(sitePath + "user/data_chart.php?" + queryStr ));

//		if(lengendShowHid == 1)
//		{ 
			so.addVariable("additional_chart_settings", encodeURIComponent("<settings><data_set_selector><enabled>false</enabled></data_set_selector></settings>"));
//			lengendShowHid = 0;
//			document.getElementById('a_showhide').innerHTML = "Show Legend";
			
//		}else{

//			so.addVariable("additional_chart_settings", encodeURIComponent("<settings><data_set_selector><enabled>true</enabled></data_set_selector></settings>"));
//			lengendShowHid = 1;
//			document.getElementById('a_showhide').innerHTML = "Hide Legend";
			
//		}
		so.addParam("wmode", "transparent");
		so.write("chartContainer");
		
}
/*
This function is used for name,number and time graph
*/