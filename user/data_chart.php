<?	session_start();
	header('Content-Type: text/xml');
	include_once '../system/configme/siteconfig.php';
	$path = str_replace("user/","",CLASS_PATH);
	require_once($path."activity.cls.php");
	require_once($path."dbclass.php");
	require($path."chart.cls.php");
	$dbObj = new dbclass(); // db object
	$objChart = new chart('../');
	$objActivity = new activity();
	 $tempGgraphcolor = $_GET['gColor'];
	if($_GET["eid"] >0){
	$ROW = $objActivity->getActivity($_GET["eid"]);
	if($_GET['graphType'] == "")
	{
		$opt = $ROW['dataOption'];
		$graphType = $ROW['graph_type'];
	}else{
		$opt= $_GET['opt'];
		$graphType = $_GET['graphType'];
	}
	
	$objChart->returnXml($_GET["eid"],$graphType,$opt,$tempGgraphcolor);
	}else{
		
	}
?>
