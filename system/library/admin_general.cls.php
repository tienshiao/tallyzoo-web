<?php
///////////////////////////////////////////
// File Name        : general.cls.php
// Craeted By       : SANJAY GURAV
// Created Date     : 17-Aug-2009
// LAST MODIFIED 	: 17-Aug-2009
// File Modified By : SANJAY GURAV
// Description      : This class file is used for Common function
///////////////////////////////////////////

class general {
	var $post;
	var $get;
	var $request;
	var $dbclass;

	function general($dbObj) {
		$this->dbclass = $dbObj;		
		$this->post = &$_POST;
		$this->get = &$_GET;
		$this->request = &$_REQUEST;
	}

	// This Function is used to send email
	function sendMail($fromEmail, $toEmail, $subject, $message){
		$headers = "From: $fromEmail <$fromEmail>\n" . "MIME-Version: 1.0\n" . "Content-type: text/html; charset=iso-8859-1";
		$rslt = @mail($toEmail, $subject, $message, $headers);
		return $rslt;
	}

   // This Function is used to get the setting variable value ==> SACHIN GUPTA
	function getSettingValue($code){
		$sql = "SELECT  var_value FROM system_settings WHERE var_name = '".$code."'";
		$rslt = $this->dbclass->select($sql);
		return $rslt[0]['var_value'];
	}

	// This Function is used to get the setting variable value
	function getSystemSettingGlobalValue($varCode, $sectionId = 1){
		$sql = "SELECT * FROM settings";
		$rslt = $this->dbclass->select($sql);		
		$cnt=count($rslt);
		if ($cnt!=0 && $cnt!="" )
		{
			/*foreach ($rslt as $key => $row) 
			{
				$k=$row['var_name'];
				$_SESSION['SETTING'][$k]=$row['var_value'];		
			}*/
		}
		//return $rslt[0]['var_value'];
	}
	
	// This Function is used to get the setting variable value
	function getSystemSettingValue($varCode, $sectionId = 1){
		  $sql = "SELECT IF(var_value <> '',  var_value, vdefault_value) as var_value
			FROM system_settings
			WHERE var_name = '".$varCode."'
			AND section_id = '".$sectionId."'";
			
		$rslt = $this->dbclass->select($sql);		
		return $rslt[0]['var_value'];
	}

	function checkLogin($user,$pwd)
	{
		$SQL_Chk_Login = "SELECT fldAdminId, fldAdminType,fldFirstName,fldLastName,fldEmailId,fldPassword,fldIsDelete FROM admin WHERE fldEmailId='".addslashes($user)."' AND ";
		$SQL_Chk_Login .= "fldPassword='".addslashes($pwd)."' AND fldIsDelete='no' AND fldStatus='active'";
		$result_Chk_Login = $this->dbclass->select($SQL_Chk_Login);
		if($result_Chk_Login['0']['fldEmailId']!="" && $result_Chk_Login['0']['fldPassword']!="")
		{
			$_SESSION['s_admin_id']		= $result_Chk_Login['0']['fldAdminId'];
			$_SESSION['s_admin_name']	= $result_Chk_Login['0']['fldFirstName'];
			$_SESSION['s_admin_email']	= $result_Chk_Login['0']['fldEmailId'];
			$_SESSION['s_hdnFlag']		= $result_Chk_Login['0']['fldAdminType'];
		}		
		return $result_Chk_Login;
	}

	/*****************************************************
	Function Name: setAdminMenu
	Purpose: To set admin menu.
	Written By: Ramamohan
	Written On: 12/24/2008 2:13 PM
	*****************************************************/
	function setAdminMenu($id)
	{
		if($id==1) 
		  {
			$str = "<div id=\"hdr\" class=\"fL h75\"><a href=\"#\" onclick=\"fnGoHome();\"><img src=\""._SITEURL_."images/logo.gif\" border=\"0\" alt=\"Tallyzoo\"></a></div>";

			$str .= "<div class=\"w500 fR p2\">";
			$str .= "<table class=\"nBr\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">";
			$str .= "<tr>";
			$str .= "<td width=\"85%\" align=\"right\" class=\"nBr\">Welcome,&nbsp;".$_SESSION['s_admin_name']."</td>";
			$str .= "<td width=\"15%\" align=\"right\" class=\"nBr\">";
			$str .= "<a href=\""._SITEURL_."admin.php?mod=home\" title=\"Home\"><img src='"._SITEURL_."images/admin/home.gif' border='0'></a>";
			$str .= "&nbsp;&nbsp;<a href=\""._SITEURL_."admin.php?mod=logout\" title=\"Logout\" alt=\"Logout\"><img src='"._SITEURL_."images/admin/logout1.gif' border='0'></a>";
			$str .= "</td>";
			$str .= "</tr>";
			$str .= "</table>";
			$str .= "</div>";
			
			$str .= "<div class=\"main_nav\" id=\"top_menu\">";
			
			$str .= "<a id=\"b\" href=\""._SITEURL_."admin.php?mod=search_member\">Member Management</a>&nbsp;";

			$str .= "&nbsp;";
			
			$str .= "<a id=\"c\" href=\""._SITEURL_."admin.php?mod=static_search\">CMS</a>&nbsp;";

			$str .= "&nbsp;";
			
			$str .= "<a id=\"d\" href=\""._SITEURL_."admin.php?mod=settings\">Settings</a>&nbsp;";

			$str .= "&nbsp;";
			
			$str .= "<a id=\"e\" href=\""._SITEURL_."admin.php?mod=report_abuse\">Abuse Reports</a>&nbsp;";

			$str .= "</div>";
		  }
		  return $str;
	}
	/***********************************************************
	Function Name: fnBuildCondition
	Purpose: To build condition string against select criteria.
	Written By: Ramamohan
	Written On: 12/29/2008 02:40 PM
	*************************************************************/
	function fnBuildSubMenu($section)
	{
		switch($section)
		{
			case member_details :
				$submenu = "<p class=\"submenu_strip\">&nbsp;<span>Member Details</span>&nbsp;|&nbsp;<a href=\"admin.php?mod=member_activity_details&act=mad&mid=".$_REQUEST['mid']."\">Activity Details</a></p><p class=\"w890 mm hS3\"><i></i></p>";
			break;
			case member_activity_details :
				$submenu = "<p class=\"submenu_strip\">&nbsp;<a href=\"admin.php?mod=member_activity_details&act=md&mid=".$_REQUEST['mid']."\">Member Details</a>&nbsp;|&nbsp;<span>Activity Details</span>&nbsp;</p><p class=\"w890 mm hS3\"><i></i></p>";
			break;
			case static_search :
				$submenu = "<p class=\"submenu_strip\">&nbsp;<span>Search Static Pages</span>&nbsp;|&nbsp;<a href=\"admin.php?mod=static_page\">Add/Edit Static Pages</a></p><p class=\"w890 mm hS3\"><i></i></p>";
			break;
			case static_page :
				$submenu = "<p class=\"submenu_strip\">&nbsp;<a href=\"admin.php?mod=static_search\">Search Static Pages</a></span>&nbsp;|&nbsp;<span>Add/Edit Static Pages</span></p><p class=\"w890 mm hS3\"><i></i></p>";
			break;
			case search_desc :
				$submenu = "<p class=\"submenu_strip\">&nbsp;<a href=\"StaticPageSearch\">Search Static Pages</a>&nbsp;|&nbsp;<a href=\"StaticPage\">Add/Edit Static Pages</a>&nbsp;|&nbsp;<span>Description Mgmt</span></p><p class=\"w890 mm hS3\"><i></i></p>";
			break;
			case settings :
				$submenu = "<p class=\"submenu_strip\">&nbsp;<a href=\"Settings\">Settings</a></span>&nbsp;|&nbsp;<span>Edit Settings</span></p><p class=\"w890 mm hS3\"><i></i></p>";
			break;
			case bottom_line :
				$submenu = "<p class=\"submenu_line\">&nbsp;</p><p class=\"w890 mm hS3\"></p>";
			break;
		}
		return $submenu;
	}

	/***********************************************************
	Function Name: fnBuildCondition
	Purpose: To build condition string against select criteria.
	Written By: Ramamohan
	Written On: 12/29/2008 02:40 PM
	*************************************************************/
	function fnBuildCondition($section,$flg="")
	{
		global $db;
		switch($section)
		{
			case member_search :
				//$condition =" WHERE m.id=a.user_id" ;
				if ($_REQUEST['q']=='All')
				{
					$condition="";
				}elseif ($_REQUEST['q']=='New')
				{
					$condition=" and DATEDIFF(DATE_FORMAT(m.created_on_UTC, '%Y-%c-%d'),curdate())=0";
				}elseif ($_REQUEST['q']=='blocked')
				{
					$condition=" and m.status='blocked'";
				}

				if($_REQUEST['txtUsername'])
					$condition .= " AND m.username LIKE('%".$this->encodequotes($_REQUEST['txtUsername'])."%')";
				if($_REQUEST['txtEmail'])
					$condition .= " AND m.email LIKE('%".$this->encodequotes($_REQUEST['txtEmail'])."%')";
				if($_REQUEST['txtDFrom'])
					$condition .= " AND m.created_on_UTC >'".$this->encodequotes($_REQUEST['txtDFrom'])."'";
				if($_REQUEST['txtDTo'])
					$condition .= " AND m.created_on_UTC <'".$this->encodequotes($_REQUEST['txtDTo'])."'";
				if(($_REQUEST['chkActive']=="on") && ($_REQUEST['chkInactive']=="on"))
					$condition .= " AND ((m.status='blocked') OR (m.status='unblocked'))";
				if(($_REQUEST['chkActive']=="on") && ($_REQUEST['chkInactive']!="on"))
					$condition .= " AND m.status='unblocked'";
				if(($_REQUEST['chkActive']!="on") && ($_REQUEST['chkInactive']=="on"))
					$condition .= " AND m.status='blocked'";
				$condition .= "  group by m.id";
			break;

			case static_search :
				$condition =" WHERE spd.fldStaticPageId = sp.fldStaticPageId AND sp.fldIsStatic=1 AND  spd.fldIsDelete='no'";
				if($_REQUEST['cmbStaticPage'])
					$condition .= " AND spd.fldStaticPageId LIKE('%".$this->encodequotes($_REQUEST['cmbStaticPage'])."%')";
				if($_REQUEST['txtTitle'])
					$condition .= " AND spd.fldTitle LIKE('%".$this->encodequotes($_REQUEST['txtTitle'])."%')";
				if(($_REQUEST['chkActive']=="on") && ($_REQUEST['chkInactive']=="on"))
					$condition .= " AND ((fldStatus='active') OR (fldStatus='inactive'))";
				if(($_REQUEST['chkActive']=="on") && ($_REQUEST['chkInactive']!="on"))
					$condition .= " AND fldStatus='active'";
				if(($_REQUEST['chkActive']!="on") && ($_REQUEST['chkInactive']=="on"))
					$condition .= " AND fldStatus='inactive'";
			break;
			case search_desc :
				$condition =" WHERE spd.fldStaticPageId = sp.fldStaticPageId AND sp.fldIsStatic=0 AND spd.fldIsDelete='no'";
				if($_REQUEST['txtPage'])
					$condition .= " AND sp.fldStaticPageName LIKE('%".$this->encodequotes($_REQUEST['txtPage'])."%')";
				if(($_REQUEST['chkActive']=="on") && ($_REQUEST['chkInactive']=="on"))
					$condition .= " AND ((fldStatus='active') OR (fldStatus='inactive'))";
				if(($_REQUEST['chkActive']=="on") && ($_REQUEST['chkInactive']!="on"))
					$condition .= " AND fldStatus='active'";
				if(($_REQUEST['chkActive']!="on") && ($_REQUEST['chkInactive']=="on"))
					$condition .= " AND fldStatus='inactive'";
			break;
		}
		return $condition;
	}

	/***********************************************************
	Function Name: To get member details by member id
	Purpose: To add slashes instead of quote.
	Written By: Sanjay G.
	Written On: 18/08/2009
	*************************************************************/	
	function getMemberCountByStatus($status){
		if ($status=='All')
		{
			$condition="";
		}elseif ($status=='New')
		{
			$condition=" and DATEDIFF(DATE_FORMAT(m.created_on_UTC, '%Y-%c-%d'),curdate())=0";
		}elseif ($status=='blocked')
		{
			$condition=" and m.status='blocked'";
		}
		//SELECT DATEDIFF(DATE_FORMAT(m.created_on_UTC, '%Y-%c-%d'),curdate());

		$sql = "SELECT count(m.id) as totAct FROM users m WHERE 1 ".$condition;
		$result =$this->dbclass->select($sql);
		return $result[0]['totAct'];
	}
	
	/***********************************************************
	Function Name: To get member details by member id
	Purpose: To add slashes instead of quote.
	Written By: Sanjay G.
	Written On: 18/08/2009
	*************************************************************/	
	function getMemberDetails($member_id){
		$sql = "SELECT m.*, count(a.id) as totAct FROM users m, activities a WHERE m.id=a.user_id and m.id=".$member_id." group by m.id";
		$result =$this->dbclass->select($sql);
		return $result;
	}

	/***********************************************************
	Function Name: encodequotes
	Purpose: To add slashes instead of quote.
	Written By: Sanjay G.
	Written On: 18/08/2009
	*************************************************************/
	function encodequotes($str)
	{
		$singlequotestr=str_replace("'","''",$str);
		$repdoublequotestr=stripslashes(str_replace('"','&quot;',$singlequotestr));
		return $repdoublequotestr;
	}
	/***********************************************************
	Function Name: decodequotes
	Purpose: To add quotes instead of slashes.
	Written By: Sanjay G.
	Written On: 18/08/2009
	*************************************************************/
	function decodequotes($str)
	{
		$singlequotestr=str_replace("''","'",$str);
		$repdoublequotestr=str_replace('&quot;','"',$singlequotestr);
		$repbackslashquotestr=stripslashes($repdoublequotestr);
		return $repbackslashquotestr;
	}

	/***********************************************************
	Function Name: To get member details by member id
	Purpose: To add slashes instead of quote.
	Written By: Sanjay G.
	Written On: 18/08/2009
	*************************************************************/	
	function getMemberActivityDetails($activity_id){
		$condition =" WHERE a.id=".$activity_id." and a.id=d.item_id group by a.id" ;		
		$sql = "SELECT a.*, sum(d.amount) as totDf FROM activities a, counts d $condition";
		$result =$this->dbclass->select($sql);
		return $result;
	}

	/*****************************************************
	Function Name: fnstaticPage
	Purpose: To build states combo box.
	Written By: Sanjay G.
	Written On: 18/08/2009
	*****************************************************/
	function fnstaticPage($selid="")
	{
		$str="";
		
		$SQL_TITLE = "SELECT * FROM staticpages WHERE fldIsStatic=1 and status='1' ORDER BY fldStaticPageName";
		$res = $this->dbclass->select($SQL_TITLE);	

		$str.="<OPTION value=\"0\"> - Select - </OPTION>";
		//while($row = $db->fn_fetch_array($res))
		$t=count($res);
		for($i=0;$i<$t;$i++)
		{
			if($res[$i]['fldStaticPageId'] == $selid)
			{
				$selected = "SELECTED";
			}
			else 
				$selected = '';
			if ($selected=='SELECTED')
				$sel_value=$res[$i]['fldStaticPageName'];

			$str.="<OPTION value=".$res[$i]['fldStaticPageId']." $selected>".$res[$i]['fldStaticPageName']."</OPTION>";
		}
		//return $str;
		return $sel_value;
	}

	/*****************************************************
	Function Name: fnsearchdesccombo
	Purpose: To build states combo box.
	Written By: Mahesh
	Written On: Monday, January 05, 2009 
	*****************************************************/
	function fnsearchdesccombo($utype,$selid="")
	{
		global $db;
		$str="";
		
		$SQL_TITLE = "SELECT * FROM staticpages WHERE fldIsStatic=0 AND fldUserTypeId='".$utype."' ORDER BY fldStaticPageName";
		$res = $this->dbclass->select($SQL_TITLE);	

		$str.="<OPTION value=\"0\"> - Select - </OPTION>";
		//while($row = $db->fn_fetch_array($res))
		$t=count($res);
		for($i=0;$i<$t;$i++)
		{
			if($row[$i]['fldStaticPageId'] == $selid)
				$selected = "SELECTED";
			else 
				$selected = '';
				
			$str.="<OPTION value=".$row[$i]['fldStaticPageId']." $selected>".$row[$i]['fldStaticPageName']."</OPTION>";
		}
		return $str;
	}
}
?>