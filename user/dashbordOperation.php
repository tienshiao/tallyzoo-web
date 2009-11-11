<?	session_start();
	require_once '../system/configme/siteconfig.php'; // include configuration file here	
	$path = str_replace("user/","",CLASS_PATH);
	require_once($path .'dbclass.php'); // database class include here	
	require_once($path.'general.cls.php');
	require_once($path."activity.cls.php");
	$dbObj = new dbclass(); // db object
	$objGeneral = new general($dbObj);
	$objActivity = new activity();
	$strCase = $_POST['ACT'];
	switch($strCase)
	{
		case 'DELETE':
			$objActivity->removeFromDashBoard($_POST['dashBordId'],$_POST['actiId']);
		break;
		case 'DRAG':
			$IP = $_SERVER["REMOTE_ADDR"];
			$arrCol1 = explode(",",$_POST["firstCol"]);
			$arrCol2 = explode(",",$_POST["secondCol"]);
			$objActivity->saveGraphPostion($IP,1,$arrCol1,$arrCol2);
		break;
	}

?>