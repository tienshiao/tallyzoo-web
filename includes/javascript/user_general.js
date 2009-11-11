///////////////////////////////////////////
// File Name        : admin_global.php 
// Craeted By       : SANJAY GURAV
// Created Date     : 17-Aug-2009
// LAST MODIFIED 	: 17-Aug-2009
// File Modified By : SANJAY GURAV
// Description      : This file is used for declaring all genaral js functions.	
///////////////////////////////////////////
var chartType = '';
/*****************************************************
Function Name: showWaitingImage
Purpose: To show waiting image while processing
Written By: Sanjay G
Written On: 17-Aug-2009
*****************************************************/
function showWaitingImage(divId) {
	var progres_str="<div class=\"mm h100 progress\"><p class=\"hS5\">&nbsp;</p><div><br/><strong><img src=\"images/admin/animated_processing.gif\"></strong></div></div>";
  	document.getElementById(divId).align ="center";
	document.getElementById(divId).innerHTML = progres_str;
}

/*****************************************************
Function Name: validate login
Purpose: To show waiting image while processing
Written By: Deepak Kamle
Written On: 24-Aug-2009
*****************************************************/
function fnLoginValidate()
{	
	
	$("#frmLogin").validate({
		rules: {
			
			txtUName: {
				required: true
			},
			txtPass: {
				required: true
			}
		},
		messages: {
			txtUName: "<br>Please enter username.",
			txtPass: "<br>Please enter password."
			}
	});
	return false;
}
/********************F******************************/


/*****************************************************************************
Function Name: fnPopupDiv
Purpose: To show content in a popup.
Written By: Sanjay G
Written On: 18/08/2009
*******************************************************************************/
function fnPopupDiv(fwidth, fheight, top, right, file, pgact, id)
{
	//var fTop='50';	
	
	//var scr_width=screen.width;
	var scr_width=document.documentElement.clientWidth
	var scr_height=screen.height;
	var thewidth=fwidth;
	var theheight=fheight;
	var topPos=0;
	if (top!=0)
	{
		topPos=top;
	}
	//preload image
	if(file== "addActivity")
	{
		for(i=1;i<=8;i++)
		{
			eval("objImage" + i + " = new Image();");
			eval("objImage" + i + ".src =\"" + sitePath + "images/graph/g" + i + "-inactive.jpg\"");
			
		}
	}
	var ppos= (scr_width-thewidth)/2;
	var topPos= 50; // added by deepak

	if(scr_width <1000)
	{
		var ppos= 40;
	}

	

	var tipobj=document.getElementById("popup_container");	
	//tipobj.innerHTML="<div class=\"mm\"><div class=\"mm h100 progress\"><p class=\"hS5\">&nbsp;</p><div><br/><strong><img src=\"images/admin/animated_processing.gif\"></strong></div></div></div>";

	if (typeof thewidth!="undefined") 
		tipobj.style.width=thewidth + "px";
	if (typeof theheight!="undefined") 
		tipobj.style.height=theheight + "px";

	var query_string ="";	
	if(pgact !="")
	{
		query_string ="&ACT=" + pgact;	
	}
	if(id != "")
	{
			query_string +="&id=" + id;	
	}
	var url = 'index_ajax.php?mod='+file+query_string;
	/*$.get(url, function(data){		
		//chval= data;
		tipobj.innerHTML="<div class=\"mm\">"+data+"</div>";
	});*/
	 var data = $.ajax({
	  url: url,
	  async: false
	 }).responseText;
	sitePath
		if(data.indexOf('Login')>0)
		{
			location.href=sitePath + "login";
		}
		tipobj.innerHTML="<div class=\"mm\">"+data+"</div>";
		
	
	/*var randomno = parseInt(Math.random()*99999999);  // cache buster	
	url=url + "&rand=" + randomno;
	http.open("GET", url, false);
	http.send(null);
	var chval=http.responseText;
	if(http.readyState=='4')
	{
		tipobj.innerHTML="<div class=\"mm\">"+chval+"</div>";		
	}*/

	if(ppos >=0 && topPos >=0)
	{
		tipobj.style.left=ppos+"px";
		tipobj.style.top=topPos + "px";
		

	}
	var popupHeight = document.getElementById('popup_container').offsetHeight; 
	var maskHeight = document.getElementById('idbody').offsetHeight;	
	if(popupHeight < maskHeight)
	{
	  document.getElementById("maskdiv").style.height = maskHeight + 'px';
	  document.getElementById("selectblocker").style.height = maskHeight + 'px';
	}
	else
	{
	  document.getElementById("maskdiv").style.height = popupHeight + 'px';
	  document.getElementById("selectblocker").style.height = popupHeight + 'px';
	}
	document.getElementById("maskdiv").style.width ="100%";
	document.getElementById("selectblocker").style.width ="98%";
	document.getElementById("maskdiv").style.display = "block";
	document.getElementById("selectblocker").style.display = "block";
	tipobj.style.visibility="visible";
	
}

/****************************************************************
Function Name: fnHdnPopup
Purpose: To hide process image with remove maski of parent window.
Written By: Sanjay G
Written On: 18/08/2009
*****************************************************************/
function fnHdnPopup(pdiv)
{
	var contObj=document.getElementById("popup_container");
	if(pdiv!='')
	{
		document.getElementById(pdiv).focus();
	}
	document.getElementById("maskdiv").style.display="none";
	document.getElementById("selectblocker").style.display = "none";
	contObj.style.visibility="hidden";
	contObj.style.width='';
}

/*****************************************************
Function Name: fnShowResult
Purpose: To fetch grid data with selected values.
Written By: Sanjay G
Written On: 18/08/2009
*****************************************************/
function fnShowResult(file,grid,frmname)
{	
	if (file='admin_ajax.php?mod=ajx_member_search')
	{		
		document.frmPost.mod.value='ajx_member_search';		
	}	
	new Ajax.Updater(grid, file, { parameters: $('frmPost').serialize(true), onLoading: showWaitingImage( grid ),evalScripts: true});
}

/*****************************************************
Function Name: getGridData
Purpose: To fetch grid data using ajax
Written By: Sanjay G
Written On: 18/08/2009
*****************************************************/
function getGridData(section,page,file)
{
	var frmname="frmPost";
	//var frmSrChId=document.getElementById('frmId').value;	
	if (file=='admin_ajax.php?mod=ajx_member_search')
	{
		document.frmPost.mod.value='ajx_member_search';
	}
	else if (file=='admin_ajax.php?mod=ajx_member_activity_details')
	{
		document.frmPost.mod.value='ajx_member_activity_details';
	}	
	document.getElementById('page').value=page;
	document.getElementById('section').value=section;
	var chval=new Ajax.Updater(section, file, { parameters: $(frmname).serialize(true), onLoading: showWaitingImage(section),evalScripts: true});	
}

/****************************************************************
Function Name: stripHTML
Purpose: To Strip all html from string
Written By: Sanjay G
Written On: 18/08/2009
*****************************************************************/
function stripHTML(oldString) {

   var newString = "";
   var inTag = false;
   for(var i = 0; i < oldString.length; i++)
   {
   
        if(oldString.charAt(i) == '<') inTag = true;
        if(oldString.charAt(i) == '>')
		{
              if(oldString.charAt(i+1)=="<")
              {
              		//dont do anything
			  }
			  else
			  {
			 	inTag = false;
				i++;
			   }
		}
        if(!inTag) newString += oldString.charAt(i);
   }
   return newString;
}

/****************************************************************
Function Name: isWhitespace
Purpose: To check white spaces.
Written By: Sanjay G
Written On: 18/08/2009
*****************************************************************/
function isWhitespace(str,msg) 
{
	 reWhiteSpace = new RegExp(/^\s+$/);
	 if (reWhiteSpace.test(str)) 
	 {
		 output = ' - Spaces are not allowed for '+msg+'';
		  return output;
	 }
}


/*****************************************************
Purpose: To show waiting image while processing
Written By: Deepak Kamle
Written On: 27-Aug-2009
*****************************************************/

function fnForgotValidate()
{
	$("#frmForgot").validate({
		rules: {
			
			txtEmail: {
				required: true,
				email: true
			}
		},
		messages: {
			txtEmail: "<br>Please enter a valid email address."
			}
	});
	return false;
}
/********************F******************************/


/*****************************************************
Purpose: To redirect
Written By: Deepak Kamle
Written On: 26-Aug-2009
*****************************************************/
function fnredirect(path)
{
	location.href=path;
}



function submitAjax(strCase,value)
{
	var responseText = $.ajax({
	type: "POST",
	url: "user/ajx_comman.php?case=" + strCase,
	data: value,
	async: false
	}).responseText;
	return responseText;
}

/****************************************************************
Function Name: fnHdnPopupRefreshParent
Purpose: To hide process image with remove maski of parent window and refresh it.
Written By: Sanjay G
Written On: 1/09/2009
*****************************************************************/
function fnHdnPopupRefreshParent(pdiv)
{
	var contObj=document.getElementById("popup_container");
	if(pdiv!='')
	{
		document.getElementById(pdiv).focus();
	}
	document.getElementById("maskdiv").style.display="none";
	document.getElementById("selectblocker").style.display = "none";
	contObj.style.visibility="hidden";
	contObj.style.width='';
	window.parent.document.location.href = window.parent.document.location.href;

	
}
function fnHdnPopupRefresh(pdiv)
{
	var contObj=window.parent.document.getElementById("popup_container");
	if(pdiv!='')
	{
		window.parent.document.getElementById(pdiv).focus();
	}
	window.parent.document.getElementById("maskdiv").style.display="none";
	window.parent.document.getElementById("selectblocker").style.display = "none";
	contObj.style.visibility="hidden";
	contObj.style.width='';
	window.parent.document.location.href = window.parent.document.location.href;

	
}



function createCookie() {
	if(document.frmLogin.remember.checked == true){
		name = "tzu"
		namevalue =document.frmLogin.txtUName.value;

		pass = "tzp"
		passvalue =document.frmLogin.txtPass.value;

		days = "30";
		if (days) {

			var date = new Date();

			date.setTime(date.getTime()+(days*24*60*60*1000));

			var expires = "; expires="+date.toGMTString();

		}

		else var expires = "";

		document.cookie = name+"="+namevalue+expires+"; path=/";
		document.cookie = pass+"="+passvalue+expires+"; path=/";
		
	}

}



function readCookie(name) {

	var nameEQ = name + "=";

	var ca = document.cookie.split(';');

	for(var i=0;i < ca.length;i++) {

		var c = ca[i];

		while (c.charAt(0)==' ') c = c.substring(1,c.length);

		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);

	}

	return '';

}

function IsEmail(InString) {
	if(InString != "" ) {
		if( (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(InString)) ) {
			return true;
		}
	}
	return false;
}

/*Following function are used for Quick Add*/
var flagcal = 0;
function showCal()
{
	
	if(flagcal == 0)
	{ 
		var d = new Date();
		var day = d.getDate();
		var month = d.getMonth() + 1;
		var year = d.getFullYear();
		if(month<10)
			month = "0" + month; 
		
		
		date = day + "/" + month + "/" + year +" " + getClockTime();
		
		document.getElementById("tdCal").innerHTML = "<input type=\"text\" name=\"txtDateQuick\"  id=\"txtDateQuick\" value=\"" + date + "\"> " + "<a href=\"javascript:;\" onClick=\"javascript:showCal();\"><img src=\"images/icons/cal.gif\" width=\"16\" height=\"20\" alt=\"Calendar\" /></a>";
		//document.getElementById("tdCal").innerHTML  = cal1.writeControl();
		flagcal = 1;
	}else{
		document.getElementById("tdCal").innerHTML = "<a href=\"javascript:;\" onClick=\"javascript:showCal();\"><img src=\"images/icons/cal.gif\" width=\"16\" height=\"20\" alt=\"Calendar\" /></a>";
		flagcal = 0;
	}
}
function showCalSmall()
{
	
	if(flagcal == 0)
	{ 
		var d = new Date();
		var day = d.getDate();
		var month = d.getMonth() + 1;
		var year = d.getFullYear();
		if(month<10)
			month = "0" + month; 
		
		
		date = day + "/" + month + "/" + year +" " + getClockTime();
		
		document.getElementById("tdCal").innerHTML = "<input type=\"text\" name=\"txtDateQuick\"  id=\"txtDateQuick\" class=\"fld_txt wd_50\" value=\"" + date + "\"> " + "<a href=\"javascript:;\" onClick=\"javascript:showCalSmall();\"><img src=\"images/icons/cal.gif\" width=\"16\" height=\"20\" alt=\"Calendar\" /></a>";
		flagcal = 1;
	}else{
		document.getElementById("tdCal").innerHTML = "<a href=\"javascript:;\" onClick=\"javascript:showCalSmall();\"><img src=\"images/icons/cal.gif\" width=\"16\" height=\"20\" alt=\"Calendar\" /></a>";
		flagcal = 0;
	}
}
function getClockTime()
{
   var now    = new Date();
   var hour   = now.getHours();
   var minute = now.getMinutes();
   var second = now.getSeconds();
   var ap = "AM";
   if (hour   > 11) { ap = "PM";             }
   if (hour   > 12) { hour = hour - 12;      }
   if (hour   == 0) { hour = 12;             }
   if (hour   < 10) { hour   = "0" + hour;   }
   if (minute < 10) { minute = "0" + minute; }
   if (second < 10) { second = "0" + second; }
   var timeString = hour +
                    ':' +
                    minute +
                    ':' +
                    second +
                    " " +
                    ap;
   return timeString;
}

function quickAdd(file)
{
	var date = "";
	var str = document.getElementById('txtQuickCnt').value;
	if(document.getElementById('txtDateQuick')){
	 date = document.getElementById('txtDateQuick').value;
	  if(!check_date('txtDateQuick'))
	  {
			document.getElementById('txtDateQuick').focus();
			return false;
	  }
	
	}
	if(Trim(str) != "")
	{
		if(str.indexOf(":") != -1 ){
			arr = str.split(":");
			
			value = "name=" + encodeURIComponent(arr[0]) + "&ACT=saveQuick&txtNote=" + "&txtTag=" + "&txtCount=" +  encodeURIComponent(arr[1]) + "&txtDate=" + date;
			responseText = submitAjax(6,value);
			alert(responseText);
			if(file != "dashboard")
			{
				location.href="index.php?mod=" + file;
			}
			/*if(responseText.indexOf("Added Successfully.") != -1)
			{
				//location.href="index.php?mod=" + file;
				var url = 'index_ajax.php?mod=' + file;
				 var data = $.ajax({
				  url: url,
				  async: false
				 }).responseText;
				  alert(data);
			}*/

		}else{
			alert("----------------------------WARNING--------------------------\n Invalid text format.Enter text in following format.\n \"Activity: Amount\" ");
			document.getElementById('txtQuickCnt').focus();
			return false;
		}
	}else{
		alert("Please enter text.");
		document.getElementById('txtQuickCnt').focus();
		return false;
	}
}

function blankAmt()
{ 
	var str = document.getElementById("txtQuickCnt").value;
	if(str == "Activity: Amount")
		document.getElementById("txtQuickCnt").value = "";
}






/*End of Quick Add*/
function check_date(id){
input = document.getElementById(id).value;
	if(input != "" && input.indexOf('/') !=-1)
	{
		arr =input.split(" "); 
		if(arr.length == 3)
		{
			arrDate = arr[0].split("/");
			strDate = arrDate[1] + "/" + arrDate[0] + "/" + arrDate[2];
			if(isDate(strDate) !=false && valideTime(arr[1],arr[2]) !=false)
			{
				return true;
			}
		}else{
			alert("Please enter valid date.");
			document.getElementById(id).focus();
			return false;
		}
	}else{
		alert("Please enter valid date.");
		document.getElementById(id).focus();
		return false;
	}
}


var dtCh= "/";
var minYear=1800;
var maxYear=2100;

function isInteger(s){
	var i;
    for (i = 0; i < s.length; i++){   
        // Check that current character is number.
        var c = s.charAt(i);
        if (((c < "0") || (c > "9"))) return false;
    }
    // All characters are numbers.
    return true;
}

function stripCharsInBag(s, bag){
	var i;
    var returnString = "";
    // Search through string's characters one by one.
    // If character is not in bag, append to returnString.
    for (i = 0; i < s.length; i++){   
        var c = s.charAt(i);
        if (bag.indexOf(c) == -1) returnString += c;
    }
    return returnString;
}

function daysInFebruary (year){
	// February has 29 days in any year evenly divisible by four,
    // EXCEPT for centurial years which are not also divisible by 400.
    return (((year % 4 == 0) && ( (!(year % 100 == 0)) || (year % 400 == 0))) ? 29 : 28 );
}
function DaysArray(n) {
	for (var i = 1; i <= n; i++) {
		this[i] = 31
		if (i==4 || i==6 || i==9 || i==11) {this[i] = 30}
		if (i==2) {this[i] = 29}
   } 
   return this
}

function isDate(dtStr){
	var daysInMonth = DaysArray(12)
	var pos1=dtStr.indexOf(dtCh)
	var pos2=dtStr.indexOf(dtCh,pos1+1)
	var strMonth=dtStr.substring(0,pos1)
	var strDay=dtStr.substring(pos1+1,pos2)
	var strYear=dtStr.substring(pos2+1)
	strYr=strYear
	if (strDay.charAt(0)=="0" && strDay.length>1) strDay=strDay.substring(1)
	if (strMonth.charAt(0)=="0" && strMonth.length>1) strMonth=strMonth.substring(1)
	for (var i = 1; i <= 3; i++) {
		if (strYr.charAt(0)=="0" && strYr.length>1) strYr=strYr.substring(1)
	}
	month=parseInt(strMonth)
	day=parseInt(strDay)
	year=parseInt(strYr)
	if (pos1==-1 || pos2==-1){
		alert("The date format should be : mm/dd/yyyy")
		return false
	}
	if (strMonth.length<1 || month<1 || month>12){
		alert("Please enter a valid month")
		return false
	}
	if (strDay.length<1 || day<1 || day>31 || (month==2 && day>daysInFebruary(year)) || day > daysInMonth[month]){
		alert("Please enter a valid day")
		return false
	}
	if (strYear.length != 4 || year==0 || year<minYear || year>maxYear){
		alert("Please enter a valid 4 digit year between "+minYear+" and "+maxYear)
		return false
	}
	if (dtStr.indexOf(dtCh,pos2+1)!=-1 || isInteger(stripCharsInBag(dtStr, dtCh))==false){
		alert("Please enter a valid date")
		return false
	}
return true
}
function valideTime(strTime,ampm)
{
	arrTime = strTime.split(":");
	if(arrTime.length <2){
		alert("Invalid Time1.");
		return false;
	}else{
		
		
		if(arrTime.length == 3)
		{
			if(arrTime[0] > 23 || arrTime[0] <0)
			{
				alert("Invalid Time.");
				return false;
			}
			if(arrTime[1] > 59 || arrTime[1]<0)
			{
				alert("Invalid Time.");
				return false;
			}
			if(arrTime[2] > 59 || arrTime[2] <0)
			{
				alert("Invalid Time.");
				return false;
			}
			ampm = ampm.toLowerCase()
			if(ampm !="am" && ampm !="pm" )
			{
				alert("Invalid Time.");
				return false;
			}
		}else{
			alert("Invalid Time.");
			return false;
		}
	}
}

/*
	add/edit activity page function
*/
function submitForm()
{
	var doc = document.frmActivity;
	var actiLimit = doc.actiLimit.value;
	if(Trim(doc.txtName.value) == "")
	{
		alert("Please add activity name.");
		showInputBox();
		//doc.txtName.focus();
		return false;
	}
	if(Trim(doc.txtColor.value) == "" || Trim(doc.txtColor.value.toLowerCase()) == "ffffff")
	{
		alert("Please select color.");
		doc.txtColor.focus();
		return false;
	}

	if(Trim(doc.txtIntial.value) !="")
	{
		if(isNaN(doc.txtIntial.value))
		{
			alert('Only numeric/float value is allowed.');
			doc.txtIntial.focus();
			return false;		
		}
	}
	if(Trim(doc.txtGoal.value) !="")
	{
		if(isNaN(doc.txtGoal.value))
		{
			alert("Only numeric/float value is allowed");
			doc.txtGoal.focus();
			return false;		
		}
	}
	if(doc.cmbDataOption.value=="")
			{
				alert('Please select data option.');
				doc.cmbDataOption.focus();
				return false;
			}
	if(document.frmActivity.hidHaveData.value == 0)
	{
		if(document.frmActivity.rdoActivityType[1].checked == true)
		{
		
			cnt = doc.cnt.value;
			id= "";
			if(cnt >0)
			{
				for(i=1;i<=cnt;i++)
				{
					chk = "chkActi_" + i;
					if(document.getElementById(chk).checked)
					{
						if(id == "")
							id = document.getElementById(chk).value;
						else
						id = id + "," + document.getElementById(chk).value;
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
				if(actiLimit > 0){
					if(arrId.length > actiLimit)
					{
						alert("You can select only " + actiLimit + " activities.");
						document.getElementById("chkActi_1").focus();
						return false;
					}
				}
				
				doc.activityIds.value = id;
				
			}
		} //end of hidden check
		
	}
	
	if(doc.editId.value == "")
		doc.ACT.value= "ADD";
	else
		doc.ACT.value= "UPDATE";

}
function showHideActivityList(type)
{
	
	cnt = document.frmActivity.cnt.value;
	if(type == 0 && document.frmActivity.rdoActivityType[0].checked == true)
	{
		document.getElementById('tbl_form_pop2').style.display = "none";
		//document.getElementById('iphoneRow1').style.display = "";
		
		
		
		
	}else{
		if(cnt >0){
		document.getElementById('tbl_form_pop2').style.display = "";
		//document.getElementById('iphoneRow1').style.display = "none";
		
		
		}else{
		document.frmActivity.rdoActivityType[0].checked = true;
		document.frmActivity.firstCompositeFlag.value = "1";
		alert("No activities available for creating a composite activity.");
		}
		
	}

}
function addPicker()
{
	var myPicker = new jscolor.color(document.getElementById('txtColor'), {})
	myPicker.fromString('6BFAFF')
}


/* Validation for email check by Lalit on Tuesday, September 29, 2009*/

	function isValidEmail(obj) {
		if(!echeck(obj.value)){
			alert("Enter Valid Email address.");
			obj.focus();
			return false;
		}	
		return true;
	}


	/// Email Checking Pass
	function echeck(str) {

		var at="@"
		var dot="."
		var lat=str.indexOf(at)
		var lstr=str.length
		var ldot=str.indexOf(dot)

		if (str.indexOf(at)==-1){
		   return false
		}

		if (str.indexOf(at)==-1 || str.indexOf(at)==0 || str.indexOf(at)==lstr){
		   return false
		}

		if (str.indexOf(dot)==-1 || str.indexOf(dot)==0 || str.indexOf(dot)==lstr){
		   return false
		}

		if (str.indexOf(at,(lat+1))!=-1){
		  return false
		}

		if (str.substring(lat-1,lat)==dot || str.substring(lat+1,lat+2)==dot){
		  return false
		}

		if (str.indexOf(dot,(lat+2))==-1){
		return false
		}

		if (str.indexOf(" ")!=-1){
		  return false
		}
		return true
	}// End Function


function calculate_time_zone() {
	var rightNow = new Date();
	var jan1 = new Date(rightNow.getFullYear(), 0, 1, 0, 0, 0, 0);  // jan 1st
	var june1 = new Date(rightNow.getFullYear(), 6, 1, 0, 0, 0, 0); // june 1st
	var temp = jan1.toGMTString();
	var jan2 = new Date(temp.substring(0, temp.lastIndexOf(" ")-1));
	temp = june1.toGMTString();
	var june2 = new Date(temp.substring(0, temp.lastIndexOf(" ")-1));
	var std_time_offset = (jan1 - jan2) / (1000 * 60 * 60);
	var daylight_time_offset = (june1 - june2) / (1000 * 60 * 60);
	var dst;
	if (std_time_offset == daylight_time_offset) {
		dst = "0"; // daylight savings time is NOT observed
	} else {
		// positive is southern, negative is northern hemisphere
		var hemisphere = std_time_offset - daylight_time_offset;
		if (hemisphere >= 0)
			std_time_offset = daylight_time_offset;
		dst = "1"; // daylight savings time is observed
	}
	var i;

	// check just to avoid error messages
	if (document.getElementById('cmbTimeZone')) {
		for (i = 0; i < document.getElementById('cmbTimeZone').options.length; i++) {
			if ((document.getElementById('cmbTimeZone').options[i].text).indexOf( convert(std_time_offset)) != -1) {
				document.getElementById('cmbTimeZone').selectedIndex = i;
				break;
			}
		}
	}
}

function convert(value) {
	var hours = parseInt(value);
   	value -= parseInt(value);
	value *= 60;
	var mins = parseInt(value);
   	value -= parseInt(value);
	value *= 60;
	var secs = parseInt(value);
	var display_hours = hours;
	// handle GMT case (00:00)
	if (hours == 0) {
		display_hours = "00";
	} else if (hours > 0) {
		// add a plus sign and perhaps an extra 0
		display_hours = (hours < 10) ? "+0"+hours : "+"+hours;
	} else {
		// add an extra 0 if needed 
		display_hours = (hours > -10) ? "-0"+Math.abs(hours) : hours;
	}
	
	mins = (mins < 10) ? "0"+mins : mins;
	return display_hours+":"+mins;
}
function fnblank(id)
{
	val = document.getElementById(id).value;
	if(val=="#" || val=="Notes" || val=="search" || val=="Name")
	{
		document.getElementById(id).value = "";
	}
}
var graphColor = "";
function setColor(color,id,divId)
{
	document.getElementById(id).value=color;
	document.getElementById(divId).style.background="#" + color;
	//document.getElementById(id).focus();
	gtype = document.getElementById('graphType').value;
	dataOpt = document.getElementById('cmbDataOption').value;
	dataOption(gtype,'',dataOpt);
}
function showInputBox()
{
	val = document.getElementById('txtName').value;
	if(val == "")
	{
		val = "(Add Activity Name)";
	}
	document.getElementById("spnActiName").innerHTML = "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" ><tr><td valign=\"bottom\">Name:&nbsp;</td><td><input type=\"text\" name=\"txtNameTemp\" id=\"txtNameTemp\" value=\"" + val + "\" class=\"wd_activity\"  onBlur=\"javascript:resetHead()\" onKeyDown=\"javascript:KeyCheck(event)\"></td><td></td><td valign=\"bottom\">&nbsp;<a href=\"javascript:;\" onClick=\"javascript:showInputBox();\" title=\"Edit Name\">Edit Name</a></td></tr></table>";
    document.getElementById('txtNameTemp').focus();
}

function resetHead()
{
	val = document.getElementById('txtNameTemp').value ;
	if(val == "(Add Activity Name)" || Trim(val)=="")
	{
		orgval = document.getElementById('txtName').value;

		if(Trim(orgval) != "")
		{
			val = orgval;		
		}else{
			val = "Add Activity Name";		
		}
		document.getElementById("spnActiName").innerHTML = val + "<a href=\"javascript:;\" onClick=\"javascript:showInputBox();\" title=\"Edit Name\">Edit Name</a>";
		

	}else{
		document.getElementById("spnActiName").innerHTML = "";
		document.getElementById('txtName').value = val;
		document.getElementById("spnActiName").innerHTML = val + "<a href=\"javascript:;\" onClick=\"javascript:showInputBox();\" title=\"Edit Name\">Edit Name</a>";
	}
}
function KeyCheck(e)

{

  if (!e) var e = window.event
	if (e.keyCode) code = e.keyCode;
	else if (e.which) code = e.which;
	
	if(code == 13)
	{
		resetHead();
	}

}
var timerIdForActi = "";
var sendRequestForActiTime = 0;
function actiList()
{ 
	id = document.frmActivity.editId.value;
	txtSearch = document.frmActivity.txtSearch.value;
	var responseText = $.ajax({
	type: "POST",
	url: "index_ajax.php?mod=activityList",
	data: "id=" + id + "&txtSearchKey=" + txtSearch,
	async: false
	}).responseText;
	document.getElementById("tdActiList").innerHTML = responseText;
	
}
function setTimeForActlist()
{
	 clearTimeout(timerIdForActi);
	 sendRequestForActiTime = 1000;
}
function sendRequestForActi()
{
	timerIdForActi = setTimeout ( "actiList()", sendRequestForActiTime);

}
function dataOption(chType,opt,imgId)
{	
	chartType = chType; // this variable is used in preview
	var flag = false;
	var actiType = 0;
	var chartName = "Line";
	var objRdo = document.frmActivity.rdoActivityType;
	var id = "0";
	

	if(document.getElementById('editId'))
	{
		id = document.getElementById('editId').value;
	}
	for(i=0;i<objRdo.length;i++)
	{
		if(objRdo[i].checked){
		 actiType = objRdo[i].value;
		}
	}
     switch(chType)
	 {
		 case 1:
			 //both allow - Line
			flag = true;
			chartName = "Line";
		 break;
		 case 2:
			 //combination - Pie
			 chartName = "Pie";
			if(actiType == 1)
				flag = true;

		 break;
		 case 3:
			//combination - Bar vertical
			 chartName = "Bar-Vertical";
			 if(actiType == 1)
				flag = true;
		 break;
		 case 4:
			 //combination - Bar horizantal
			 chartName = "Bar Horizontal";
			 if(actiType == 1)
				flag = true;		

		 break;
		 case 5:
			 //combination - time line
			 chartName = "Time Slide";
			 if(actiType == 1)
				flag = true;
		 break;
		 case 6:
			 //both - Number
			chartName = "Number";
			 flag = true;
		 break;
		 case 7:
			 //Combination - Name
			 chartName = "Name";
			 if(actiType == 1)
				flag = true;
		 break;
		 case 8: 
			 //both - Time
		 chartName = "Time";
			flag = true;
		 break;
	 }
  graphColor = document.getElementById("txtColor").value ;
		var responseText = $.ajax({
		type: "POST",
		url: "user/dataoptions.php",
		data: "chType=" + chType + "&opt=" + opt  + "&eid=" + id ,
		async: false
		}).responseText;
		document.getElementById("tddataOpt").innerHTML = responseText;
		document.getElementById("graphType").value = chType;
		
		//alert("You have selected - " + chartName + " graph");

		/*change css for chart icon*/
		for(i=1;i<=8;i++)
		{	aid = "ach_" + i;
			if(i==imgId)
			{   //document.getElementById(aid).className="chart_active";
				document.getElementById("img_" + i).src = "images/graph/g" + i + "-inactive.jpg";
			}else{
				//document.getElementById(aid).className="";
				document.getElementById("img_" + i).src = "images/graph/g" + i + "-normal.jpg";
			
			}
		}
		preViewGraph();
	
}
function graphPreView(caseId)
{ 
	var imgName = "";
	switch(caseId)
	{
		case 1:
		imgName = "graph4.gif";
		break;
		case 2:
		imgName = "graph2.gif";
		break;
		case 3:
		imgName = "graph1.gif";
		break;
		case 4:
		imgName = "graph3.gif";
		break;
		case 5:
		imgName = "graph3.gif";
		break;
		case 6:
		imgName = "number.jpg";
		break;	
		case 7:
		imgName = "name.jpg";
		break;
		case 8:
		imgName = "number.jpg";
		break;
	}
	
	strImage = "images/front/graph/" + imgName  ;
	if( document.getElementById('editId').value >0)
	{}else{ 
		
	document.getElementById("graphImg").src = strImage;
	}
	
}

function checkGraphAllowed()
{
	var actiType = document.frmActivity.rdoActivityType.value;

}

function preViewGraph()
{	var id = "0";
	
	lengendShowHid = 1; // this variable define in prev_chart.js
	if(document.getElementById('editId'))
	{
		id = document.getElementById('editId').value;
	}
	graphColor = document.getElementById("txtColor").value ;
	if(id >0)
	{  
		var opt = document.getElementById('cmbDataOption').value;    
		var chartType = document.getElementById('graphType').value;    
		var responseText = $.ajax({
		type: "POST",
		url: "user/fnJs.php",
		data: "chType=" + chartType + "&opt=" + opt  + "&eid=" + id + "&gColor=" + graphColor,
		async: false
		}).responseText;
		
		 if(responseText.length >2)
			{ 
				eval("top." + responseText);
			 //alert(responseText);
			}
	}
}

function chartIconOnOver(id,imgName)
{
	 document.getElementById(id).src ="images/graph/" + imgName;
}
function chartIconOnOut(id,imgName)
{		 if(document.getElementById(id).src.indexOf('inactive') == -1){
		  document.getElementById(id).src ="images/graph/" + imgName;
	 }
}
function actiListDashBoard()
{ 
	id = document.dashboardActiList.editId.value;
	txtSearch = document.dashboardActiList.txtSearch.value;
	var responseText = $.ajax({
	type: "POST",
	url: "index_ajax.php?mod=actListAjaxDashboard",
	data: "id=" + id + "&txtSearchKey=" + txtSearch,
	async: false
	}).responseText;
	document.getElementById("tdActiList").innerHTML = responseText;
	
}


function setTimeForDashBoardActlist()
{
	 clearTimeout(timerIdForActi);
	 sendRequestForActiTime = 1000;
}
function sendRequestForDashBoardActi()
{
	timerIdForActi = setTimeout ( "actiListDashBoard()", sendRequestForActiTime);

}