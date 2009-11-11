<? include_once '../system/configme/siteconfig.php';
	$path = str_replace("user/","",CLASS_PATH);
	require_once($path."activity.cls.php");
	require_once($path."dbclass.php");
	require($path."chart.cls.php");
	$dbObj = new dbclass(); // db object
	$objChart = new chart('../');
	$objActivity = new activity();
	$tempGgraphcolor = $_POST['gColor'];

	if($_POST["eid"] >0){
		$ROW = $objActivity->getActivity($_POST["eid"]);
		if($_POST['chType'] == "")
		{
			$opt = $ROW['dataOption'];
			$graphType = $ROW['graph_type'];
		}else{
			$opt= $_POST['opt'];
			$graphType = $_POST['chType'];
		}
		if($opt >0){
		//$objChart->returnXml($_POST["eid"],$graphType,$opt,$tempGgraphcolor);
		$fnJs= $objActivity->returnChartJsFn($_POST["eid"],$graphType,$opt);
		echo "prev_" ."$fnJs;";
		}
	}else{
		
	}


