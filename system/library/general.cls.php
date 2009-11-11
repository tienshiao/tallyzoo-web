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
	function getSystemSettingGlobalValue(){
		$sql = "SELECT * FROM settings where 1";
		$rslt = $this->dbclass->select($sql, MYSQLI_ASSOC);
		$cnt=count($rslt);
		if ($cnt!=0 && $cnt!="" )
		{
			foreach ($rslt[0] as $key => $row)
			{
				$k=$key;
				if ($k!='id')
					$arr[$k]=$rslt[0][$k];
			}
		}
		$_SESSION['SETTING']=$arr;
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

	/***********************************************************
	Purpose: convert in given timezine
	Written By: DEEPAK K.
	Written On: 20/08/2009
	*************************************************************/	
	function convertInTimeZone($date,$timeZone)
	{	$str = $date;
		$d = new Date($str);
		// set local time zone
		//$serverTimeZone = ini_get('date.timezone');
		$serverTimeZone = date_default_timezone_get();
		$d->setTZByID($serverTimeZone);
		// convert to foreign time zone
		$d->convertTZByID($timeZone);
		return $d->getDate();

	}
	/***********************************************************
	Purpose: check user session exist
	Written By: DEEPAK K.
	Written On: 25/08/2009
	*************************************************************/
	function chekUserSessionExist()
	{ 
		if(!isset($_SESSION['tz_user']) || count($_SESSION['tz_user']) == 0)
		{
			
			header("Location:" ._SITEURL_ ."login");
			
		}
	}
	function returnColorPlate($color="")
	{
		$arrColor[] = "124684";
		$arrColor[] = "660000";
		$arrColor[] = "B22222";
		$arrColor[] = "FF8C00";
		$arrColor[] = "A0522D";
		$arrColor[] = "FF0000";
		$arrColor[] = "5F9EA0";
		$arrColor[] = "6B8E23";
		$arrColor[] = "8B4513";
		$arrColor[] = "2244B2";
		$arrColor[] = "00F0FF";
		$arrColor[] = "862DA0";
		$arrColor[] = "848484";
		$arrColor[] = "004A4C";
		
		$strColor = "<table border=\"0\" id=\"tbl_color\" cellpadding=\"0\"  cellspacing=\"0\"><tr>";
		$cnt = 0;
		foreach($arrColor as $i)
		{
			$cnt++;
			$select = "";
			if($i == $color)
			{
				$select = "border: 1px solid #999;";
			}
			$strColor .= "<td class=\"colorblock\"><a href=\"javascript:;\" onClick=\"javascript:setColor('$i','txtColor','imgCol')\"><img src=\"images/blank.gif\" style=\"background:#$i;\" ></td><td style='width:1px;'></a></td>";
			if($cnt == 7)
			{
				$cnt=0;
				$strColor .= "</tr><tr height=\"3\"><td colspan=\"14\"></td></tr>";
			}
		}

		$strColor .= "</tr>";
		$strColor .= "</table>";
		return $strColor;
	}
}
?>