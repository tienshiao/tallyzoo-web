<? include_once '../system/configme/siteconfig.php';
	$path = str_replace("user/","",CLASS_PATH);
	require_once($path."activity.cls.php");
	require($path."chart.cls.php");
	$objChart = new chart('');
	$objActivity = new activity();
	$chartType= $_POST['chType'];
	$opt= $_POST['opt'];

	/*$arrDefaultDataOpt[1] = 1;
	$arrDefaultDataOpt[3] = 1;
	$arrDefaultDataOpt[4] = 1;
	$arrDefaultDataOpt[2] = 1;
	$arrDefaultDataOpt[5] = 1;
	$arrDefaultDataOpt[6] = 1;
	$arrDefaultDataOpt[7] = 1;
	$arrDefaultDataOpt[8] = 1;
	*/
	if($opt == "")
		$opt = 1;
	
	$str = $objChart->returnCombo($chartType,$opt);
	echo $str;

