<?
	///////////////////////////////////////////////////////////////////////////
	//	FILENAME 			:	invite.php
	//	DESCRIPTION 		:	This is for inviting friends. 
	//	CREATED			:	Tuesday, September 29, 2009	
	//	CREATED BY 		:	Lalit Wankhade
	//	COMPANY 			:	EcoTech IT Solution Pvt Ltd..
	///////////////////////////////////////////////////////////////////////////////
	
	$objGeneral->chekUserSessionExist();// check user session	
	$err_msg = "";
	if($_GET['comp'] == 'sent')
	{
		$err_msg = "Invitation sent successfully.";
	}

	if($_POST['ACT'] == "INVITE")
	{
		$EmailIds = $_POST['txtEmailIds'];
		$Names = $_POST['txtNames'];
		$personal_message = $objGeneral->encodequotes($_POST['textarea']);
		$from_name =  $_SESSION["tz_user"]["username"];
		$from_email	=	$_SESSION["tz_user"]["emailaddress"];

		$txtEmailIds	=	explode(",",$EmailIds);
		$Ecnt			=	count($txtEmailIds);
		for($n=0;$n<$Ecnt;$n++)
		{
			$arrUemail[$n]=  "'" . $txtEmailIds[$n] .  "'" ;
		}

		$names		=	explode(",",$Names);
		$len		=	count($txtEmailIds);
		$arrName	=	array();

		for($i=0;$i<$len;$i++) {
				$arrName[$txtEmailIds[$i]]	=	$names[$i];
		}

			$subject = "Invitation On TallyZoo";

		foreach($arrName as $emailid=> $name)
		{
			$to_email	=	$emailid;
			$to_email	=	str_replace("'","", $to_email);

			$Message = "<p>Dear ". $name."<br>";
			$Message .= "Your have been invited by ". $from_name ."<br><br>";
			$Message.= "<br>".$personal_message;
			$Message.="<br><br>Please click on following URL<br><br><a href='http://www.test.tallyzoo.com'> http://www.test.tallyzoo.com</a>";
			$Message.="<br><br>Regards<br></p>";
			$Message.="<br>".$from_name;
			$objGeneral->sendMail($to_email,$emailid,$subject,$Message,"html");
		}
		header('Location:index.php?mod=Invite&comp=sent');
		exit;
	}
	$middle="Invite.tpl";
	$smarty->assign("error_msg",$err_msg);
	$smarty->assign("img_path",IMAGES_PATH);

?>