<?
class user
{

	function __construct()
	{
		global $dbObj;
		global $objGeneral;
		$this->db = $dbObj;
		$this->general = $objGeneral;
	}
	function fnCreateUser()
	{
		Global $objImage;
		foreach($_POST as $key=>$val)
		{
			$$key = $this->general->encodequotes($val);
		}
		
		$sql = "Select id FROM users WHERE username=\"$txtUName\"";
		$result = $this->db->select($sql);
		
		if($this->db->num_rows == 0)
		{
			$currDate = date("Y-m-d H:i:s");
			$currDateUserPC = $this->general->convertInTimeZone($currDate,$cmbTimeZone);

			if($_FILES["userPic"]["tmp_name"] !=""){
				$extentsion =  $objImage->getFileExtension($_FILES["userPic"]["name"]);
				$destfilename = $objImage->createRandFileName("user") ."." .$extentsion;
				$destPath = USER_IMAGES_PATH ;
				(int)$status = $objImage->upload_image_actual($_FILES["userPic"],$destfilename,$destPath);
				
				if($status){
					$sourceImg_name = $destfilename;
					$dimension[0] = 50;
					$dimension[1] = 50;									
					$destImg_name = "50x50".$destfilename; 
					$objImage->imageResize($sourceImg_name,$destPath,$destPath,$destImg_name,$dimension);
				}
			}
			 $txtPass = md5($txtPass);
			 $sql = "INSERT into users(username,password,email,about,timezone,created_on,created_on_UTC,imagename,hidden,disabled) values(\"$txtUName\",\"$txtPass\",\"$txtEmail\",\"$txtAboutMe\",\"$cmbTimeZone\",\"$currDateUserPC\",\"$currDate\",\"$destfilename\",0,0)";
			$this->db->insert($sql);
			return 1;
		}else{
			return 0;
		}


	}
	function fnUpdateUser($userId)
	{
		Global $objImage;
		foreach($_POST as $key=>$val)
		{
			$$key = $this->general->encodequotes($val);
		}
		
			$currDate = date("Y-m-d H:i:s");
			$currDateUserPC = $this->general->convertInTimeZone($currDate,$cmbTimeZone);

			if($_FILES["userPic"]["tmp_name"] !=""){
				$extentsion =  $objImage->getFileExtension($_FILES["userPic"]["name"]);
				$destfilename = $objImage->createRandFileName("user") ."." .$extentsion;
				$destPath = USER_IMAGES_PATH ;
				(int)$status = $objImage->upload_image_actual($_FILES["userPic"],$destfilename,$destPath);
				
				if($status){
					$sourceImg_name = $destfilename;
					$dimension[0] = 50;
					$dimension[1] = 50;									
					$destImg_name = "50x50".$destfilename; 
					$objImage->imageResize($sourceImg_name,$destPath,$destPath,$destImg_name,$dimension);
				}
				$imgFiled = ",imagename=\"$destfilename\"";
			}

			if($txtPass != "")
			{
				$txtPass = md5($txtPass);
				$txtPass = ",password=\"$txtPass\"";
			}
			$sql = "UPDATE users SET email=\"$txtEmail\" $txtPass ,about=\"$txtAboutMe\",timezone=\"$cmbTimeZone\",modified_on=\"$currDateUserPC\",modified_on_UTC=\"$currDate\" $imgFiled WHERE id=\"$userId\"";
			
			 $this->db->edit($sql);
			


	}
	function fnUserLogin()
	{
		$userName = $this->general->encodequotes($_POST["txtUName"]);
		$userPassword = md5($this->general->encodequotes($_POST["txtPass"]));

		$sql = "SELECT id,email,username from users WHERE username=\"$userName\" AND password=\"$userPassword\" AND status=\"unblocked\"";
		$ROW = $this->db->select($sql);
		$numRows = $this->db->num_rows;
		if($numRows >0){
			
			session_register("tz_user");
			$_SESSION["tz_user"]["userid"] = $ROW[0]["id"];
			$_SESSION["tz_user"]["username"] = $ROW[0]["username"];
			$_SESSION["tz_user"]["emailaddress"] = $ROW[0]["email"];
			return true;
		}
		else{
			return false;
		}

	}
	function fnforgotPassword()
	{
		$emailAdd = $this->general->encodequotes($_POST["txtEmail"]);
		$newPassword = $this->generatePassword();
		$sql = "SELECT username FROM users WHERE email=\"$emailAdd\"";
		$ROW = $this->db->select($sql);
		$numRows = $this->db->num_rows;
		if($numRows >0){
			$sql = "UPDATE users SET password=\"$newPassword\" WHERE email=\"$emailAdd\"";
			$this->db->edit($sql);
			$row = $ROW[0];	
			$to = $emailAdd ;
			$subject = "Login Details";
			$Message = "<p>Dear User<br>";
			$Message .= "Your Login details are following<br>";
			$Message.= "Username: $row[username] <br>";
			$Message.="Password: $newPassword<br>";
			$Message.="Regards<br></p>";
			$Message.="Tallyzoo Admin";

			$sql = "SELECT adimEmailAddress FROM  settings WHERE id=\"1\"";
			$row = $this->db->select($sql);
			$from = $row[0]["adimEmailAddress"];
			
			 $this->general->sendMail($to,$from,$subject,$Message,"html");
			return true;
		}else{
			return false;
			}
	}

	//This function return Timezone combo
	function timeZone($timeZone="")
	{
		$arrTimeZone = array("Pacific/Kwajalein"=>"(GMT-12:00) International Date Line West",
		"Pacific/Samoa"=>"(GMT-11:00) Midway Island, Samoa",
		"Pacific/Honolulu"=>"(GMT-10:00) Hawaii",
		"America/Anchorage"=>"(GMT-09:00) Alaska",
		"America/Los_Angeles"=>"(GMT-08:00) Pacific Time (US & Canada)",
		"America/Tijuana"=>"(GMT-08:00) Tijuana, Baja California",
		"America/Denver"=>"(GMT-07:00) Mountain Time (US & Canada)",
		"America/Chihuahua"=>"(GMT-07:00) Chihuahua, La Paz, Mazatlan",
		"America/Phoenix"=>"(GMT-07:00) Arizona",
		"Canada/East-Saskatchewan"=>"(GMT-06:00) Saskatchewan",
		"America/Tegucigalpa"=>"(GMT-06:00) Central America",
		"America/Chicago"=>"(GMT-06:00) Central Time (US & Canada)",
		"America/Mexico_City"=>"(GMT-06:00) Guadalajara, Mexico City, Monterrey",
		"America/New_York"=>"(GMT-05:00) Eastern Time (US & Canada)",
		"America/Bogota"=>"(GMT-05:00) Bogota, Lima, Quito, Rio Branco",
		"America/Indiana/Indianapolis"=>"(GMT-05:00) Indiana (East)",
		"America/Caracas"=>"(GMT-04:30) Caracas",
		"Canada/Atlantic"=>"(GMT-04:00) Atlantic Time (Canada)",
		"America/Manaus"=>"(GMT-04:00) Manaus",
		"America/Santiago"=>"(GMT-04:00) Santiago",
		"America/La_Paz"=>"(GMT-04:00) La Paz",
		"Canada/Newfoundland"=>"(GMT-03:30) Newfoundland",
		"America/Sao_Paulo"=>"(GMT-03:00) Brasilia",
		"America/Godthab"=>"(GMT-03:00) Greenland",
		"America/Montevideo"=>"(GMT-03:00) Montevideo",
		"America/Argentina/Buenos_Aires"=>"(GMT-03:00) Georgetown",
		"Atlantic/South_Georgia"=>"(GMT-02:00) Mid-Atlantic",
		"Atlantic/Azores"=>"(GMT-01:00) Azores",
		"Atlantic/Cape_Verde"=>"(GMT-01:00) Cape Verde Is.",
		"Europe/London"=>"(GMT) Greenwich Mean Time : Dublin, Edinburgh, Lisbon, London",
		"Atlantic/Reykjavik"=>"(GMT) Monrovia, Reykjavik",
		"Africa/Casablanca"=>"(GMT) Casablanca",
		"Europe/Belgrade"=>"(GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague",
		"Europe/Sarajevo"=>"(GMT+01:00) Sarajevo, Skopje, Warsaw, Zagreb",
		"Europe/Brussels"=>"(GMT+01:00) Brussels, Copenhagen, Madrid, Paris",
		"Africa/Algiers"=>"(GMT+01:00) West Central Africa",
		"Europe/Amsterdam"=>"(GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna",
		"Europe/Minsk"=>"(GMT+02:00) Minsk",
		"Africa/Cairo"=>"(GMT+02:00) Cairo",
		"Europe/Helsinki"=>"(GMT+02:00) Helsinki, Kyiv, Riga, Sofia, Tallinn, Vilnius",
		"Europe/Athens"=>"(GMT+02:00) Athens, Bucharest, Istanbul",
		"Asia/Jerusalem"=>"(GMT+02:00) Jerusalem",
		"Asia/Amman"=>"(GMT+02:00) Amman",
		"Asia/Beirut"=>"(GMT+02:00) Beirut",
		"Africa/Windhoek"=>"(GMT+02:00) Windhoek",
		"Africa/Harare"=>"(GMT+02:00) Harare, Pretoria",
		"Asia/Kuwait"=>"(GMT+03:00) Kuwait, Riyadh",
		"Asia/Baghdad"=>"(GMT+03:00) Baghdad",
		"Africa/Nairobi"=>"(GMT+03:00) Nairobi",
		"Asia/Tbilisi"=>"(GMT+03:00) Tbilisi",
		"Europe/Moscow"=>"(GMT+03:00) Moscow, St. Petersburg, Volgograd",
		"Asia/Tehran"=>"(GMT+03:30) Tehran",
		"Asia/Muscat"=>"(GMT+04:00) Abu Dhabi, Muscat",
		"Asia/Baku"=>"(GMT+04:00) Baku",
		"Asia/Yerevan"=>"(GMT+04:00) Yerevan",
		"Asia/Yekaterinburg"=>"(GMT+05:00) Ekaterinburg",
		"Asia/Karachi"=>"(GMT+05:00) Islamabad, Karachi",
		"Asia/Tashkent"=>"(GMT+05:00) Tashkent",
		"Asia/Calcutta"=>"(GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi",
		"Asia/Colombo"=>"(GMT+05:30) Sri Jayawardenepura",
		"Asia/Katmandu"=>"(GMT+05:45) Kathmandu",
		"Asia/Dhaka"=>"(GMT+06:00) Astana, Dhaka",
		"Asia/Novosibirsk"=>"(GMT+06:00) Almaty, Novosibirsk",
		"Asia/Rangoon"=>"(GMT+06:30) Yangon (Rangoon)",
		"Asia/Krasnoyarsk"=>"(GMT+07:00) Krasnoyarsk",
		"Asia/Bangkok"=>"(GMT+07:00) Bangkok, Hanoi, Jakarta",
		"Asia/Beijing"=>"(GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi",
		"Asia/Ulaanbaatar"=>"(GMT+08:00) Irkutsk, Ulaan Bataar",
		"Asia/Kuala_Lumpur"=>"(GMT+08:00) Kuala Lumpur, Singapore",
		"Asia/Taipei"=>"(GMT+08:00) Taipei",
		"Australia/Perth"=>"(GMT+08:00) Perth",
		"Asia/Seoul"=>"(GMT+09:00) Seoul",
		"Asia/Tokyo"=>"(GMT+09:00) Osaka, Sapporo, Tokyo",
		"Asia/Yakutsk"=>"(GMT+09:00) Yakutsk",
		"Australia/Darwin"=>"(GMT+09:30) Darwin",
		"Australia/Adelaide"=>"(GMT+09:30) Adelaide",
		"Australia/Sydney"=>"(GMT+10:00) Canberra, Melbourne, Sydney",
		"Australia/Brisbane"=>"(GMT+10:00) Brisbane",
		"Australia/Hobart"=>"(GMT+10:00) Hobart",
		"Asia/Vladivostok"=>"(GMT+10:00) Vladivostok",
		"Pacific/Guam"=>"(GMT+10:00) Guam, Port Moresby",
		"Asia/Magadan"=>"(GMT+11:00) Magadan, Solomon Is., New Caledonia",
		"Pacific/Fiji"=>"(GMT+12:00) Fiji, Kamchatka, Marshall Is.",
		"Pacific/Auckland"=>"(GMT+12:00) Auckland, Wellington",
		"Pacific/Tongatapu"=>"(GMT+13:00) Nuku'alofa");

		foreach($arrTimeZone as $key=>$val)
		{
			if($timeZone == $key)
				$str .="<option value=\"$key\" Selected>$val</option>";
			else
				$str .="<option value=\"$key\">$val</option>";
		}

		return $str;

	}
	function getUserDetails($userId)
	{
		$sql = "SELECT username,password,email,about,timezone,
		CASE WHEN imagename != '' 
		THEN concat('<img src=\""._SITEURL_."images/user/50x50',imagename,'\">')
		WHEN imagename = '' 
		THEN '<img src=\""._SITEURL_."/images/nophotp.jpg\">'
		END as imagename,imagename as exImage
		FROM users WHERE id=\"$userId\"";
		
		$ROW = $this->db->select($sql);
		$numRows = $this->db->num_rows;
		if($numRows >0){
			$arrRow = $ROW[0];
			foreach($arrRow as $k=>$v)
			{
				$arrRow[$k] = $this->general->decodequotes($v);
			}
			return $arrRow;
		}
	}
	function generatePassword ($length = 8)
	{


	  $password = "";
	  $possible = "0123456789bcdfghjkmnpqrstvwxyz"; 
	  $i = 0; 
	  while ($i < $length) { 
		  $char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
		if (!strstr($password, $char)) { 
		  $password .= $char;
		  $i++;
		}

	  }

	  return $password;

	}


	
//End of class
}
?>