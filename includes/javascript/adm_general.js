///////////////////////////////////////////
// File Name        : admin_global.php 
// Craeted By       : SANJAY GURAV
// Created Date     : 17-Aug-2009
// LAST MODIFIED 	: 17-Aug-2009
// File Modified By : SANJAY GURAV
// Description      : This file is used for declaring all genaral js functions.	
///////////////////////////////////////////


var http = null;
var isOpera=navigator.userAgent.indexOf('Opera')>-1;
var isIE=navigator.userAgent.indexOf('MSIE')>1&&!isOpera;
var isMoz=navigator.userAgent.indexOf('Mozilla/5.')==0&&!isOpera;
if(isIE)
	http = new ActiveXObject("Microsoft.XMLHTTP");
else if(isMoz)
	http = new XMLHttpRequest();

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
Function Name: showWaitingImage
Purpose: To show waiting image while processing
Written By: Sanjay G
Written On: 17-Aug-2009
*****************************************************/
function fnLogin(frmObj)
{	
	if(!validateInputField(frmObj.txtLoginNm, FIELD_TYPE_VARCHAR, CNT_NOT_NULL, 'Email-id'))
		return false;
	else if(!validateInputField(frmObj.txtPwd, FIELD_TYPE_VARCHAR, CNT_NOT_NULL, 'Password'))
		return false;
	else
	{		
		frmObj.mod.value="ajx_login";
		new Ajax.Updater('mid_body', 'admin_ajax.php', { parameters: $('frmPost').serialize(true)
			, onLoading: showWaitingImage( 'mid_body' ),	evalScripts: true});
	}	
}
/********************F******************************/


/*****************************************************************************
Function Name: fnPopupDiv
Purpose: To show content in a popup.
Written By: Sanjay G
Written On: 18/08/2009
*******************************************************************************/
function fnPopupDiv(fwidth,fheight,file,pgact,id)
{
	var fTop='110';	
	var scr_width=screen.width;
	var scr_height=screen.height;
	var thewidth=fwidth;
	var theheight=fheight;
	var topPos=fTop;
	var leftPos=(scr_width-thewidth)/2;
	var tipobj=document.getElementById("popup_container");
	if (typeof thewidth!="undefined") 
		tipobj.style.width=thewidth + "px";
	if (typeof theheight!="undefined") 
		tipobj.style.width=theheight + "px";

	var url = 'admin_ajax.php?mod='+file+'&AJAX=true&aid='+id;		
	var randomno = parseInt(Math.random()*99999999);  // cache buster	
	url=url + "&rand=" + randomno;
	http.open("GET", url, false);
	http.send(null);
	
	var chval=http.responseText;	
	if(http.readyState=='4')
	{
		tipobj.innerHTML="<div class=\"mm\">"+chval+"</div>";		
	}
	if(leftPos >=0 && topPos >=0)
	{
		tipobj.style.left=leftPos+"px";
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

/*****************************************************************************
Function Name: fnStatus
Purpose: To change status active or inactive.
Written By: Sanjay G
Written On: 18/08/2009
*******************************************************************************/
function fnStatus(grid,file)
{
	if(document.getElementById('hidIds').value!="")
	{
		if(file=="admin_ajax.php?mod=ajx_member_search")
		{
			if(confirm('Are you sure you want to change status of this record(s)?'))
			{
				document.frmPost.mod.value='ajx_member_search';
				document.frmPost.act.value='status';				
				var chval=new Ajax.Updater(grid, file, { parameters: $('frmPost').serialize(true), onLoading: showWaitingImage( grid ),	evalScripts: true});
				if(chval!="")
				{
					//fnSetMsg('4');
					document.getElementById(grid).focus();
				}
			}
		}		
		else if(file=="admin_ajax.php?mod=ajx_member_activity_details")
		{
			if(confirm('Are you sure you want to change status of this record(s)?'))
			{
				document.frmPost.act.value='status';
				document.frmPost.mod.value='ajx_member_activity_details';				
				var chval=new Ajax.Updater(grid, file, { parameters: $('frmPost').serialize(true), onLoading: showWaitingImage( grid ),	evalScripts: true});
				if(chval!="")
				{
					//fnSetMsg('4');
					document.getElementById(grid).focus();
				}
			}
		}
		else if(file=="admin_ajax.php?mod=ajx_static_search")
		{
			if(confirm('Are you sure you want to change status of this record(s)?'))
			{
				document.frmPost.act.value='status';
				document.frmPost.mod.value='ajx_static_search';				
				var chval=new Ajax.Updater(grid, file, { parameters: $('frmPost').serialize(true), onLoading: showWaitingImage( grid ),	evalScripts: true});
				if(chval!="")
				{
					//fnSetMsg('4');
					document.getElementById(grid).focus();
				}
			}
		}
	}
	else
	{
		alert('Please select atleast one record.');
		return false;
	}
}

/*****************************************************************************
Function Name: fnDelete
Purpose: To delete record confirm validation.
Written By: Sanjay G
Written On: 18/08/2009
*******************************************************************************/
//fnDelete Button
function fnDelete(grid,file)
{	
	if(document.getElementById('hidIds').value!="")
	{
		if(file=="admin_ajax.php?mod=ajx_member_search")
		{
			if(confirm('Are you sure you want to delete this record(s)?'))
			{
				document.frmPost.mod.value='ajx_member_search';
				document.frmPost.act.value='delete';				
				var chval=new Ajax.Updater(grid, file+'?act=delete', { parameters: $('frmPost').serialize(true), onLoading: showWaitingImage( grid ),	evalScripts: true});
				if(chval!="")
				{
					//fnSetMsg('3');
					document.getElementById(grid).focus();
				}
			}
		}
		else if(file=="admin_ajax.php?mod=ajx_member_activity_details")
		{
			if(confirm('Are you sure you want to delete this record(s)?'))
			{	
				document.frmPost.mod.value='ajx_member_activity_details';
				document.frmPost.act.value='delete';				
				var chval=new Ajax.Updater(grid, file, { parameters: $('frmPost').serialize(true), onLoading: showWaitingImage( grid ),	evalScripts: true});
				if(chval!="")
				{
					//fnSetMsg('3');
					document.getElementById(grid).focus();
				}
			}
		}
		else if(file=="admin_ajax.php?mod=ajx_static_search")
		{
			if(confirm('Are you sure you want to delete this record(s)?'))
			{	
				document.frmPost.mod.value='ajx_static_search';
				document.frmPost.act.value='delete';				
				var chval=new Ajax.Updater(grid, file, { parameters: $('frmPost').serialize(true), onLoading: showWaitingImage( grid ),	evalScripts: true});
				if(chval!="")
				{
					//fnSetMsg('3');
					document.getElementById(grid).focus();
				}
			}
		}
		else if(file=="admin_ajax.php?mod=ajx_report_abuse")
		{
			if(confirm('Are you sure you want to delete this record(s)?'))
			{	
				document.frmPost.mod.value='ajx_report_abuse';
				document.frmPost.act.value='delete';				
				var chval=new Ajax.Updater(grid, file, { parameters: $('frmPost').serialize(true), onLoading: showWaitingImage( grid ),	evalScripts: true});
				if(chval!="")
				{
					//fnSetMsg('3');
					document.getElementById(grid).focus();
				}
			}
		}
	}
	else
	{
		alert('Please select atleast one record.');
		return false;
	}
}

/*****************************************************
Function Name: setAdminMenuActive
Purpose: To set current menu active
Written By: Sanjay G
Written On: 18/08/2009
*****************************************************/
function setAdminMenuActive(id) {
	document.getElementById(id).className ='current_menu';
}

/*****************************************************
Function Name: fnSingleCheck
Purpose: To check each check box
Written By: Sanjay G
Written On: 18/08/2009
*****************************************************/
function fnSingleCheck(val)
{

	var obj=document.frmPost;
	flag=0;
	if(obj.chkRecord.length == undefined)
	{
		if(!obj.chkRecord.checked)
			flag=1;
	}
	for(i=0;i<obj.chkRecord.length;i++)
	{
		if(!obj.chkRecord[i].checked)
		{
			flag=1;
			break;
		}
	}
	if(flag==0)
	{
		obj.chkCheckAll.checked = true;
	}
	else
	{
		obj.chkCheckAll.checked = false;
	}
	if(val.checked==true) {
		if(document.frmPost.hidIds.value=='')
			document.frmPost.hidIds.value=val.value;
		else
			document.frmPost.hidIds.value=document.frmPost.hidIds.value + "," +val.value;
	}else{
		var str="";
		if(document.frmPost.hidIds.value!=''){
			var TempArray = document.frmPost.hidIds.value.split(",");
			for(var i=0;i<TempArray.length;i++){
				if(val.value!=TempArray[i]){
					if(str=="")
						str=TempArray[i];
					else
						str +="," + TempArray[i];
				}
			}
		}
		document.frmPost.hidIds.value=str;
	}
}
/*****************************************************
Function Name: fnCheckAll
Purpose: To check all check boxes at once
Written By: Sanjay G
Written On: 18/08/2009
*****************************************************/
function fnCheckAll(val)
{
  var len=document.frmPost.chkRecord.length;
  var i;
  var str = '';
  if(val.checked==false)
  {
	 if(len>1)
	 {
	   for(i=0;i<len;i++)
	   {
		document.frmPost.chkRecord[i].checked=false;
	   }
	 }
	 else
	  {
	   document.frmPost.chkRecord.checked=false;
	  }
	 document.frmPost.hidIds.value=str;
  }
  else
  {
	 if(len>1)
	 {
		for(i=0;i<len;i++)
		{
		  document.frmPost.chkRecord[i].checked=true;
		  if(str=='')
			str = document.frmPost.chkRecord[i].value;
		  else
			str += "," +  document.frmPost.chkRecord[i].value;
		}
	 }
	 else
	  {
		document.frmPost.chkRecord.checked=true;
		str = document.frmPost.chkRecord.value;
	  }
	  document.frmPost.hidIds.value=str;
  }
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
Function Name: jsIsComboUnselected
Purpose: To check combo selected or not.
Written By: Sanjay G
Written On: 18/08/2009
*****************************************************************/
function jsIsComboUnselected(obj,objname)
{ 
	if (obj.value == "" || obj.value == " " || obj.value == "0" || obj.value == 0 || obj.value == '-1')
	{
		output = display('UNSELECTED_COMBOBOX',objname);
		return output;
	}
}

/*****************************************************
Function Name: ShowProgress
Purpose: To show process image with masking parent window.
Written By: Sanjay G
Written On: 18/08/2009
*****************************************************/
function ShowProgress(fnname)
{
	document.getElementById('hdr').focus();
	var fdiv='progress';
	var fwidth='310';
	var fheight='160';
	var fTop='260';
	document.getElementById('err_msg_list').className="";
	document.getElementById('err_msg_list').innerHTML="";
	var fn=fnname+"()";
	var progres_str="<div class=\"mm h100 progress\"><p class=\"hS5\">&nbsp;</p><div><br/><strong><img src=\"images/admin/animated_processing.gif\"></strong></div></div>";

	var scr_width=screen.width;
	var scr_height=screen.height;
	var thewidth=fwidth;
	var topPos=fTop;
	var leftPos=(scr_width-thewidth)/2;
	var tipobj=document.getElementById("popup_container");
	if (typeof thewidth!="undefined") 
		tipobj.style.width=thewidth + "px";
	
	tipobj.innerHTML=progres_str;
	
	if(leftPos >=0 && topPos >=0)
	{
		tipobj.style.left=leftPos+"px";
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
	document.getElementById("selectblocker").style.width ="100%";
	document.getElementById("maskdiv").style.display = "block";
	tipobj.style.visibility="visible";
	setTimeout(""+fn+"", 1500);
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
Function Name: IsEmail,isDotExpression
Purpose: To check valid email address
Written By: Sanjay G
Written On: 18/08/2009
*****************************************************/
function IsEmail(InString) {
	var left, right;
	if(InString.length==0) return(false);
	for(Count=0;Count<InString.length;Count++) {
		TempChar = InString.substring(Count,Count + 1);
		if("1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ.@_-".indexOf(TempChar,0)==-1) return(false); 
	}
	if(InString.indexOf('@')< 1) return(false);
	if(InString.lastIndexOf('@')!= InString.indexOf('@')) return(false);
	left = InString.substring(0,InString.indexOf('@'));
	right = InString.substring(InString.indexOf('@') + 1,InString.length);
	if((!isDotExpression(left,0))||(!isDotExpression(right,1))) return(false);
	
	return(true);
}

function isDotExpression(InString,NeedsDot) {
	var dots,index,tmpNeedDot;
	dots=0;
	for(index=0;index<InString.length;index++) {
		if(InString.substring(index,index+1)==".") {
		if((index==0)||(index==InString.length-1)) return(false);
			dots ++;
			if(dots>1)tmpNeedDot=1;
			else tmpNeedDot=0;
			if(!isDotExpression(InString.substring(0,index),tmpNeedDot)) return(false);	
		}      
	}
	if((NeedsDot==1)&&(dots<1)) return (false);
	if(InString.length < dots * 2+1) return (false);
	return (true);
}

/*Static page js code*/
/*****************************************************
Function Name: fnShowResult
Purpose: To Showcontent with selected values.
Written By: Sanjay G
Written On: 18/08/2009
*****************************************************/
function fnShowContent()
{	
 document.frmPost.action="admin.php";
 document.frmPost.staticid.value=id;
 document.frmPost.act.value='';
 document.frmPost.pgaction.value='editview'; 
 document.frmPost.mod.value='static_page';
 document.frmPost.submit();
}

/**************************************************
Function Name: fnSave
Purpose: To save the content.
Written By: Sanjay G
Written On: 18/08/2009
**************************************************/
function fnSave()
{
	/*	
	var oEditor = window.FCKeditorAPI.GetInstance('txaDesc') ;*/
	var Output ='';
	var count=0;
	var get;
	
	var oEditor = FCKeditorAPI.GetInstance('txaDesc') ;
	var Editorvalue = oEditor.GetXHTML( true );

	val =oEditor.GetXHTML( true );
	var txacontent=val;
	var formcontent;
	formcontent=stripHTML(txacontent)

	/*if(get = jsIsComboUnselected(document.getElementById('selpage'),'Page'))
		Output = Output + get + "<br/>";*/
	if(get = isWhitespace(document.getElementById('txtTitle').value,'Title'))
		Output = Output + get + "<br/>";
	if(oEditor.GetXHTML( true )=='')
	 {
		get='- Content';
		Output = Output + get + "<br/>";
	 }else if(formcontent.length>6000)
	 {
        get='Content should not greater than 6000 characters.'
	    Output = Output + get + "<br/>";
	 }
	if(Output.length > 0)
	{
		Output = "<strong class=\"pad_left20\">Check the following information</strong><br/><br/>" + Output;
		document.getElementById('err_msg_list').className='mm w880 p5 err_list dispB';
		document.getElementById('err_msg_list').innerHTML=Output;
		document.getElementById('err_msg_list').focus();
		fnHdnPopup('');
		return false;
	}
	else
	{
		document.getElementById('txahdncontent').value=oEditor.GetXHTML( true );
		var j="";
		for(var i=0;i<=5;i++)
		{
			if(j=="")
				j+=document.getElementById('txahdncontent').value.charAt(i);
			else
				j+=document.getElementById('txahdncontent').value.charAt(i);
		}
		if(j=="&nbsp;")
		{
			Output = "<strong class=\"pad_left20\">Check the following information</strong><br/><br/>" + "- Check spaces for content.";
			document.getElementById('err_msg_list').className='mm w880 p5 err_list dispB';
			document.getElementById('err_msg_list').innerHTML=Output;
			document.getElementById('err_msg_list').focus();
			fnHdnPopup('');
			return false;
		}
		else
		{
			//document.frmPost.staticid.value=document.frmPost.selpage.value;
			document.frmPost.pgaction.value='edit'; 
			document.frmPost.mod.value='static_page'; 
			document.frmPost.submit();
		}
		/*document.frmPost.staticid.value=document.frmPost.selpage.value;	
		document.frmPost.pgaction.value='edit'; 
		document.frmPost.submit();	*/
	}
}
function fnSaveSetting()
{

	var Output ='';
	var count=0;
	var get;

	if(document.getElementById('txtAdminEmailAddress').value=="" || !IsEmail(document.getElementById('txtAdminEmailAddress').value))
	{
		get="-  Admin Email Address.";
		Output = Output + get + "<br/>";
	}
	
	if(trim(document.frmPost.txtVersion.value) != "")
	{
		if(!isNumeric(document.frmPost.txtVersion.value))
		{
			get="-  Only numeric value is allowed for Free Version.";
			Output = Output + get + "<br/>";
		}
	}

	

	if(trim(document.frmPost.txtNoChartsForFree.value) != "")
	{
		if(!isNumeric(document.frmPost.txtNoChartsForFree.value))
		{
			get="-  Only numeric value is allowed for No. of Charts For Premium Member.";
			Output = Output + get + "<br/>";
		}
	}

	if(trim(document.frmPost.txtNoChartsForPremium.value) != "")
	{
		if(!isNumeric(document.frmPost.txtNoChartsForPremium.value))
		{
			get="-  Only numeric value is allowed for  No. of Dashboards For Free Member.";
			Output = Output + get + "<br/>";
		}
	}

	if(trim(document.frmPost.txtNoOfDashBoardForFree.value) != "")
	{
		if(!isNumeric(document.frmPost.txtNoOfDashBoardForFree.value))
		{
			get="-  Only numeric value is allowed for No. of Dashboards For Premium Membe.";
			Output = Output + get + "<br/>";
		}
	}
	if(trim(document.frmPost.txtNoOfRecordsPerPage.value) != "")
	{
		if(!isNumeric(document.frmPost.txtNoOfRecordsPerPage.value))
		{
			get="-  Only numeric value is allowed for No. of Records Per Page.";
			Output = Output + get + "<br/>";
		}
	}
	

	if(trim(document.frmPost.txtOfPagesList.value) != "")
	{
		if(!isNumeric(document.frmPost.txtOfPagesList.value))
		{
			get="-  Only numeric value is allowed for No. of Pages for a List.";
			Output = Output + get + "<br/>";
		}
	}

	if(Output.length > 0)
	{
		Output = "<strong class=\"pad_left20\">Check the following information</strong><br/><br/>" + Output;
		document.getElementById('err_msg_list').className='mm w880 p5 err_list dispB';
		document.getElementById('err_msg_list').innerHTML=Output;
		document.getElementById('err_msg_list').focus();
		fnHdnPopup('');
		return false;
	}
	else
	{
		document.frmPost.pgaction.value='edit'; 
		document.frmPost.submit();
	
	}
}
/**************************************************
Function Name: fncancel
Purpose: To Cancel action.
Written By: Mahesh
Written On: Wednesday, December 31, 2008 11:25 AM
**************************************************/
function fncancel()
{
	location.href='admin.php?mod=static_search';
}
/**************************************************
Function Name: fnPreview
Purpose: To Preview .
Written By: Mahesh
Written On: Wednesday, December 31, 2008 11:25 AM
**************************************************/
function fnPreview()
{
	var Output ='';
	var count=0;
	var get;
	
	/*if(get = jsIsComboUnselected(document.getElementById('selpage'),'Select Page to preview'))
		Output = Output + get + "<br/>";*/
	if(Output.length > 0)
	{
		Output = "<strong class=\"pad_left20\">Check the following information</strong><br/><br/>" + Output;
		document.getElementById('err_msg_list').className='mm w880 p5 err_list dispB';
		document.getElementById('err_msg_list').innerHTML=Output;
		document.getElementById('err_msg_list').focus();
		fnHdnPopup('');
		return false;
	}
	else
	{
		var fileName='admin/preview.php';
		var scr_width=screen.width;
		var thewidth='570';
		var leftPos=(scr_width-thewidth)/2;
		window.open(fileName,"","toolbar=0,left="+leftPos+",top=200,width=570,height=360,resizable=1,scrollbars=1");
		return false;
	}

}
// function to reset
function fnreset()
{
	var oEditor = FCKeditorAPI.GetInstance('txaDesc');
	oEditor.SetHTML("");
}

//removes the trailing spaces
function trim(pstrString){
	return pstrString.replace(/^\s+|\s+$/g,"");
}
//check for numeric value
function isNumeric(val){
	for(var i=0;i<val.length;i++){
		if(!isDigit(val.charAt(i))){return false;}
		}
	return true;
}
function isDigit(num) {
	if (num.length>1){return false;}
	var string="1234567890";
	if (string.indexOf(num)!=-1){return true;}
	return false;

}

/*****************************************************
Function Name: fnSetOrder
Purpose: To set order of the colomn
Written By: Ramamohan
Written On: 1/8/2009 2:13 PM
*****************************************************/
function fnSetOrder(ordby,grid,file)
{
	//var frmSrChId=document.getElementById('frmId').value;
	if(document.getElementById('hidOrder').value=="ASC")
		document.getElementById('hidOrder').value="DESC";
	else if(document.getElementById('hidOrder').value=="DESC")
		document.getElementById('hidOrder').value="ASC";
	document.getElementById('hidOrderBy').value=ordby;
	document.getElementById('page').value=document.getElementById('page').value;
	document.getElementById('section').value=grid;
	if (file=='admin_ajax.php?mod=ajx_member_search')
	{
		document.frmPost.mod.value='ajx_member_search';
	}
	else if (file=='admin_ajax.php?mod=ajx_member_activity_details')
	{
		document.frmPost.mod.value='ajx_member_activity_details';
	}
	else if (file=='admin_ajax.php?mod=ajx_static_search')
	{
		document.frmPost.mod.value='ajx_static_search';
	}
	
	var chval=new Ajax.Updater(grid, file,{ parameters: $('frmPost').serialize(true), onLoading: showWaitingImage( grid ),evalScripts: true});

}