<?
class chart{
	/*
	Graph Type:
		1: Line
		2: Pie
		3: Bar Verticle
		4: Bar horigental
		5: Time Slide
		6: Number
		7: Name
		8: Time
	*/
	private $xAxis;
	private $yAxis;
	private $arrDataOpt;
	private $arrColor;
	private $ROW;
	private $arrName;
	private $graphLebel;
	private $tmpColor;
	function __construct($root)
	{
		global $dbObj;
		global $objGeneral;
		
		$this->db = $dbObj;
		$this->sitePath = _SITEURL_;
		$this->general = $objGeneral;
		$this->root = $root;
		$this->graphLebel ="";
		$this->tmpColor = "";
		
	}
	function dataOptions($chType)
	{
		//Line
		$this->arrDataOpt[1][1]="values over time";
		$this->arrDataOpt[1][2]="adding up over time";
		$this->arrDataOpt[1][3]="Daily Totals Over Time";

		//Pie
		$this->arrDataOpt[2][1]="Amounts";
		$this->arrDataOpt[2][2]="% of Total";

		//Bar Verticle
		$this->arrDataOpt[3][1]="Amounts";
		$this->arrDataOpt[3][2]="% of Total";
		
		//Bar Horizantal
		$this->arrDataOpt[4][1]="Amounts";
		$this->arrDataOpt[4][2]="% of Total";
		
		//Time slid
		$this->arrDataOpt[5][1]="values over time";
		$this->arrDataOpt[5][2]="adding up over time";
		$this->arrDataOpt[5][3]="subtracting over time";
		
		//Number
		$this->arrDataOpt[6][1]="Total - all counts";
		$this->arrDataOpt[6][2]="Total - Today";
		$this->arrDataOpt[6][3]="Total - last 7 days";
		$this->arrDataOpt[6][4]="Total - last 30 days";
		$this->arrDataOpt[6][5]="Average - Total Time";
		$this->arrDataOpt[6][6]="Average - last 7 days";
		$this->arrDataOpt[6][7]="Average - last 30 days";
		//Name 
		$this->arrDataOpt[7][1]="Of last counted";
		$this->arrDataOpt[7][2]="Of largest count";
		$this->arrDataOpt[7][3]="Of smallest count";

		//Time
		$this->arrDataOpt[8][1]="Since last entry";
		return $this->arrDataOpt[$chType];


	}
	function returnXml($actiId,$graphType="",$dataOpt="",$tempGgraphcolor="")
	{
		
		$this->tmpColor =  $tempGgraphcolor; //for preview purpos
		
		
		$sql = "SELECT * FROM activities WHERE id=\"$actiId\" AND deleted=\"0\"";
		$this->ROW = $this->db->select($sql);
		$activityId = $actiId;
		$graphId = $this->ROW[0]["graph_id"];
		$activityType = $this->ROW[0]["activity_type"];
		//for preview purpos
		
		if($activityType == 1){
			$this->tmpColor = "";
		}

		if($graphType == "" && $dataOpt == ""){
			$sql = "SELECT dataOption,graph_type FROM graphs WHERE id=\"$graphId\"";
			$ROWGRAPH = $this->db->select($sql);
			$dataOpt = $ROWGRAPH[0]['dataOption'];
			$graphType = $ROWGRAPH[0]['graph_type'];
			
		}
		
		$this->dataOptions($graphType);
		$this->graphLebel = ucfirst($this->arrDataOpt[$graphType][$dataOpt]) ;
		$path =  $this->root."xml/data_".$graphType."_".$actiId.".xml";
				
		switch($graphType)
		{

			case 1:
				$this->fetchData($graphType,$dataOpt,$activityId,$graphId,$activityType);
				$this->createXmlForLineGraph($path);
			break;
			case 2:
				$this->createXmlForPieGraph($path,$activityId,$dataOpt);
			break;
			case 3:
				$this->createXmlForColumnBarGraph($path,$activityId,$dataOpt);
			break;
			case 4:
				$this->createXmlForColumnBarGraph($path,$activityId,$dataOpt);
			break;
			case 5:
				$this->timeSlid($graphType,$dataOpt,$activityId,$graphId,$activityType);
			break;
			
		}
	}
	/*
	This function is used to generat the xml and data file for Time Slid
*/
	function timeSlid($graphType,$graphDataType,$activityId,$graphId,$activityType=0)
	{
		$arrActivityId = array();
		$arrData = array();
		if($activityType == 1)
		{ //get the all activity id for composite
			$sql = "SELECT activity_id FROM graphs_activities g INNER JOIN activities a ON  a.id=g.activity_id WHERE g.graph_id=\"$graphId\" AND a.deleted=\"0\" ORDER BY a.name";
			$ROW = $this->db->select($sql);
			
			foreach($ROW as $i)
			{
				$arrActivityId[] = $i['activity_id'];
			}
		}else{ //single
					$arrActivityId[] = $activityId;
		}
		//$cnt = 0;
		switch($graphDataType)
		{
			case 1:
				//value over time
				foreach($arrActivityId as $actiId)
				{
					$sql = "SELECT color,name FROM activities WHERE id=\"$actiId\" AND status=\"unblocked\" AND deleted=\"0\"";
					$ROW = $this->db->select($sql);	
					$this->arrName[$actiId] = $ROW[0]['name'];
					$this->arrColor[$actiId] = $ROW[0]['color'];
					
					$sql = "SELECT modified_on as modified,sum(amount) as amount FROM counts WHERE item_id=\"$actiId\" AND deleted=\"0\" GROUP BY modified order by modified DESC";

					$ROW = $this->db->select($sql);
					$tmp = 0;
					$cnt = 0;
					foreach($ROW as $i)
					{  	
						 $arrData[$actiId][$cnt]['date'] = $i['modified'];
						 $arrData[$actiId][$cnt]['value'] = $i['amount'];
						 $arrData[$actiId][$cnt]['valume'] =  $i['amount'];
						 //$tmp = $tmp + $i['amount'];
						
						$cnt++;
					}
				}
			break;
			case 2:
				//Adding over time
			foreach($arrActivityId as $actiId)
			{
				$sql = "SELECT color,name FROM activities WHERE id=\"$actiId\" AND status=\"unblocked\" AND deleted=\"0\"";
				$ROW = $this->db->select($sql);	
				$this->arrName[$actiId] = $ROW[0]['name'];
				$this->arrColor[$actiId] = $ROW[0]['color'];

				$sql = "SELECT modified_on as modified ,sum(amount) as amount FROM counts WHERE item_id=\"$actiId\" AND deleted=\"0\" GROUP BY modified order by modified DESC";
				$ROW = $this->db->select($sql);
				$tmp = 0;
				$cnt = 0;
				foreach($ROW as $i)
				{  			
					 $arrData[$actiId][$cnt]['date'] = $i['modified'];
					 
					 $arrData[$actiId][$cnt]['value'] = $i['amount'];
					 $arrData[$actiId][$cnt]['valume'] = $tmp +  $i['amount'];
					
					 $tmp = $tmp + $i['amount'];
					$cnt++;
				}
			}
			break;
			case 3:
				 //Subtrackting over time
				foreach($arrActivityId as $actiId)
				{
					$sql = "SELECT color,name FROM activities WHERE id=\"$actiId\" AND status=\"unblocked\" AND deleted=\"0\"";
					$ROW = $this->db->select($sql);	
					$this->arrName[$actiId] = $ROW[0]['name'];
					$this->arrColor[$actiId] = $ROW[0]['color'];

					$sql = "SELECT sum(amount) as total FROM counts WHERE item_id=\"$actiId\" group by item_id";
					$ROW = $this->db->select($sql);
					$cnt = 0;
					if($this->db->num_rows > 0)
					{
						 $total = $ROW[0]['total'];
						
						$sql = "SELECT modified_on as modified ,sum(amount) as amount FROM counts WHERE item_id=\"$actiId\" AND deleted=\"0\" GROUP BY modified order by modified DESC";

						$ROW = $this->db->select($sql);
						$tmp = 0;
						$cnt = 0;
						foreach($ROW as $i)
						{  			
							
							$tmp = $total -  $i['amount'];
							if($tmp >0)
							{
																
									$arrData[$actiId][$cnt]['valume'] = $total ;
								
								
							}else{
								
								$arrData[$actiId][$cnt]['valume'] =  $i['amount'];
							}

							 $total = $total -  $i['amount'];
							

							

							$arrData[$actiId][$cnt]['date'] = $i['modified'];
							$arrData[$actiId][$cnt]['value'] = $i['amount'];
							//$tmp =  $arrData[$actiId]['valume'];

							$cnt++;	
						}
					}
				}
			break;
		}//end switch

		if(is_array($arrData))
		{ 
			$flag = 0;
			foreach($arrData as $key=>$arr)
			{	
				 $dataString = "";
				 
				if($this->tmpColor != "")
				{
					 $this->arrColor[$key] = $this->tmpColor;
				}
				// echo strtoupper();
				 $dataFile = "data_" .$key.".csv";
				 $str .= "<data_set>";
				  $str .= "<title>".$this->arrName[$key]."</title>";
				  $str .= "<color>".$this->arrColor[$key]."</color>";
				 // $str .= "<bullet>round_outline</bullet>";
				 //$str .= "<compare_list_box selected=\"false\"></compare_list_box>";
				 $str .="<compare_list_box>false</compare_list_box>";
				  $str .= "<short>".strtoupper(substr($this->arrName[$key],0,1))."</short>";
				  $str .= "<file_name>timeSlidData.php?file=".$dataFile."</file_name>";
				  $str .= "<csv>";
					$str .= "<reverse>true</reverse>";
					$str .= "<separator>,</separator>";
					$str .= "<date_format>YYYY-MM-DD hh:mm:ss</date_format>";
					$str .= "<decimal_separator>.</decimal_separator>";
					$str .= "<columns>";
					  $str .= "<column>date</column>";
					  $str .= "<column>close</column>  ";
					$str .= "</columns>";
				  $str .= "</csv>";
			   $str .= "</data_set>"; 

			   foreach($arr as $i)
				 {
					 $dataString .= $i['date'].",".$i['value'].",".$i['valume'] ."\n";
				 }
				 $path = $this->root ."chart/amtimeslide/data/"	 .$dataFile;
					$_SESSION[$dataFile] = $dataString;
					
				
				 //file_put_contents($path,$dataString);
			}
		}
		
		$path = $this->root ."chart/amtimeslide/settings/"	 ."settings_".$activityId .".xml";
		$templateXmlPath = $this->root ."chart/amtimeslide/templateXml.xml";
		$setString = file_get_contents($templateXmlPath);
		$setString = str_replace("(DataSet)",$str,$setString);	
		echo $setString;
		//file_put_contents($path,$setString);
		//echo $str;
	}



	/******************************************
	This function is used for Line chart's data
	******************************************/

	function fetchData($graphType,$graphDataType,$activityId,$graphId,$activityType=0)
	{
		$arrActivityId = array();
		
		if($activityType == 1)
		{ //get the all activity id for composite
			$sql = "SELECT activity_id FROM graphs_activities g INNER JOIN activities a ON  a.id=g.activity_id WHERE g.graph_id=\"$graphId\" AND a.deleted=\"0\" ORDER BY a.name";
			$ROW = $this->db->select($sql);
			
			foreach($ROW as $i)
			{
				$arrActivityId[] = $i['activity_id'];
			}
		}else{ //single
					$arrActivityId[] = $activityId;
		}
		$cnt = 0;
		switch($graphDataType)
		{
			case 1:
				//value over time
				foreach($arrActivityId as $actiId)
				{
					$sql = "SELECT color,name FROM activities WHERE id=\"$actiId\" AND status=\"unblocked\" AND deleted=\"0\"";
					$ROW = $this->db->select($sql);	
					$this->arrName[$actiId] = $ROW[0]['name'];
					$this->arrColor[$actiId] = $ROW[0]['color'];
					 $sql = "SELECT modified_on as modified ,amount FROM counts WHERE item_id=\"$actiId\" AND deleted=\"0\"  order by modified ASC";
					$ROW = $this->db->select($sql);
					$tmp = 0;
					foreach($ROW as $i)
					{  			
						 $this->xAxis[$i['modified']] = $i['modified'];
						 $this->yAxis[$actiId][$i['modified']] = $i['amount'];
						 $tmp = $this->yAxis[$actiId][$i['modified']];
						
						$cnt++;
					}
				}
				
			break;
			case 2:
				//Adding over time
			foreach($arrActivityId as $actiId)
			{
				$sql = "SELECT color,name FROM activities WHERE id=\"$actiId\" AND status=\"unblocked\" AND deleted=\"0\"";
				$ROW = $this->db->select($sql);	
				$this->arrName[$actiId] = $ROW[0]['name'];
				$this->arrColor[$actiId] = $ROW[0]['color'];

				
				$sql = "SELECT modified_on as modified ,amount FROM counts WHERE item_id=\"$actiId\"  AND deleted=\"0\"  order by modified ASC";

				$ROW = $this->db->select($sql);
				$tmp = 0;
				
				foreach($ROW as $i)
				{  			
					 $this->xAxis[$i['modified']] = $i['modified'];
					 $this->yAxis[$actiId][$i['modified']] = $tmp +  $i['amount'];
					 $tmp = $this->yAxis[$actiId][$i['modified']];
					
					$cnt++;
				}
			}
			break;
			case 3:
				 //Daily Totals Over Time
				foreach($arrActivityId as $actiId)
				{
					$sql = "SELECT color,name FROM activities WHERE id=\"$actiId\" AND status=\"unblocked\" AND deleted=\"0\"";
					$ROW = $this->db->select($sql);	
					$this->arrName[$actiId] = $ROW[0]['name'];
					$this->arrColor[$actiId] = $ROW[0]['color'];

					
					$sql = "SELECT DATE_FORMAT(modified_on,'%Y-%m-%d') as modified ,sum(amount) as amount FROM counts WHERE item_id=\"$actiId\"  AND deleted=\"0\" GROUP BY modified order by modified ASC";

					$ROW = $this->db->select($sql);
					$tmp = 0;
					foreach($ROW as $i)
					{  			
						 $this->xAxis[$i['modified']] = $i['modified'];
						 //$this->yAxis[$actiId][$i['modified']] = $tmp +  $i['amount'];
						 $this->yAxis[$actiId][$i['modified']] =  $i['amount'];
						 $tmp = $this->yAxis[$actiId][$i['modified']];
						
						$cnt++;
					}
				}
			break;
		}//end switch
		
		//uksort($this->xAxis,"cmp");
		
		$xAsixArr = $this->xAxis;
		$this->xAxis = $this->sortDateTime($xAsixArr,$graphDataType);
	
		
		
		
		
	}
	function sortDateTime($mainArr,$dataOpt)
	{ 
		$arr = array();
		$arrTemp = array();
		
		
		foreach($mainArr as $xkey=>$xval)
		{
			//$xval = str_replace("/","-",$xval) ;
			
			$arr[$xkey] = strtotime($xval);
		}
		asort($arr);
		foreach($arr as $xkey=>$xval)
		{ 
			if($dataOpt == 3){
			$arrTemp[$xkey] = date("d/m/y",$xval);
			}else{
			$arrTemp[$xkey] = date("d/m/y H:i:s",$xval);
			}
		}
		
		return $arrTemp;
	}
	function createXmlForLineGraph($path)
	{
		$str .= "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
		$str .= "<chart><xaxis>";
				//loop
		foreach($this->xAxis as $xkey=>$xval)
		{
		$str .= "<value xid=\"$xkey\">$xval</value>";
		}
		$str .= "</xaxis>";
		$str .= "<graphs>";
			//loop

		foreach($this->yAxis as $ykey=>$yval)
		{ 
			//preview purpose
			if($this->tmpColor != "")
			{
				 $this->arrColor[$ykey] = $this->tmpColor;
			}
			$str .= "<graph  gid=\"$ykey\" line_width=\"2\" title=\"".$this->arrName[$ykey]."\" color=\"#".$this->arrColor[$ykey]."\" bullet=\"round_outline\">";
				//loop
			foreach($yval as $dkey=>$dval)
			{
				$str .= "<value xid=\"$dkey\">$dval</value>";
			}
			$str .= "</graph>";
		}
			$str .= "</graphs>";
		$str .=" <labels>
    <label>
      <x>0</x>
      <y>0</y>
      <rotate></rotate>
      <width></width>
      <align>center</align>
      <text_color>999999</text_color>
      <text_size>10</text_size>
      <text>
        <![CDATA[<b>".$this->graphLebel."</b>]]>
      </text>
    </label>
  </labels>
	";
		$str .= "</chart>";
echo $str;
		//file_put_contents($path,$str);

	}
/*
This function is used for Pie Chart
*/

	function createXmlForPieGraph($path,$actiId,$dataOpt)
	{
		$total = 0;
		$arrData = array();
		/*$sql = "SELECT graph_id,user_id,activity_type,name,modified_on_UTC,modified_on,user_id FROM activities WHERE id=$actiId";
		*/
		$ROW = $this->ROW;
		if($ROW[0]['activity_type'] == 1){
		$sql = "SELECT sum(c.amount) as amt,a.name,a.color FROM counts c INNER JOIN activities a ON a.id=c.item_id  WHERE c.item_id IN(SELECT activity_id FROM graphs_activities WHERE graph_id=\"" .$ROW[0]['graph_id'] ."\") AND a.status=\"unblocked\" AND a.deleted=\"0\" AND c.deleted=\"0\" GROUP BY c.item_id ORDER BY a.name";
		}else{
			$sql = "SELECT sum(c.amount) as amt,a.name,a.color FROM counts c INNER JOIN activities a ON a.id=c.item_id  WHERE c.item_id=\"" .$ROW[0]['id'] ."\" AND a.status=\"unblocked\" AND a.deleted=\"0\"  AND c.deleted=\"0\" GROUP BY c.item_id";
		}
		$ROWDATA = $this->db->select($sql);
		
		

		if($this->db->num_rows > 0)
		{ 
			foreach($ROWDATA as $i)
			{
				
				$arrData[$i['name']]["amt"] = $i['amt'];
				$arrData[$i['name']]["color"] = $i['color'];
				$total +=$i['amt'];
			}
		}

		$str .= "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
		$str .= "<pie>";
				//loop
				if($dataOpt == 1)
				{
				  
					foreach($arrData as $key=>$val)
					{
						//preview purpose
						if($this->tmpColor != "")
						{
							 $val['color'] = $this->tmpColor;
						}
						
						$str .= "<slice title=\"".$key."\" color=\"#".$val['color']."\">".round($val['amt'],2)."</slice>";
					}
				}else{
					foreach($arrData as $key=>$val)
					{
						//preview purpose
						if($this->tmpColor != "")
						{
							 $val['color'] = $this->tmpColor;
						}
						$percent = ($val['amt'] * 100) / $total;
						$str .= "<slice title=\"".$key."\" color=\"#".$val['color']."\">". round($percent,2)."</slice>";
					}

				}
		echo $str .= "</pie>";
		//file_put_contents($path,$str);

	}

/*
	This function is used to create the xml file for Bar/Column
*/
function createXmlForColumnBarGraph($path,$actiId,$dataOpt)
	{
		$total = 0;
		$arrData = array();
		/*$sql = "SELECT graph_id,user_id,activity_type,name,modified_on_UTC,modified_on,user_id FROM activities WHERE id=$actiId";
		*/
		$ROW = $this->ROW;
		if($ROW[0]['activity_type'] == 1){
		$sql = "SELECT sum(c.amount) as amt,a.name,a.color FROM counts c INNER JOIN activities a ON a.id=c.item_id  WHERE c.item_id IN(SELECT activity_id FROM graphs_activities WHERE graph_id=\"" .$ROW[0]['graph_id'] ."\") AND a.status=\"unblocked\" AND a.deleted=\"0\" AND c.deleted=\"0\" GROUP BY c.item_id ORDER BY a.name";
		}else{
			$sql = "SELECT sum(c.amount) as amt,a.name,a.color FROM counts c INNER JOIN activities a ON a.id=c.item_id  WHERE c.item_id=\"" .$ROW[0]['id'] ."\" AND a.status=\"unblocked\"  AND a.deleted=\"0\"  AND c.deleted=\"0\" GROUP BY c.item_id";
		}
		$ROWDATA = $this->db->select($sql);

		if($this->db->num_rows > 0)
		{ 
			foreach($ROWDATA as $i)
			{
				
				$arrData[$i['name']]["amt"] = $i['amt'];
				$arrData[$i['name']]["color"] = $i['color'];
				$total +=$i['amt'];
			}
		}

		$str .= "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
		$str .= "<chart>";
			$str .= "<series>";
				//loop
				$cntX =0;
				foreach($arrData as $key=>$val)
				{
					
					$cntX++;
					//$str .= "<value xid=\"$cntX\" bg_color=\"#FFFFFF\">$key</value>";
					$str .= "<value xid=\"$cntX\" bg_color=\"#FFFFFF\"></value>";
					break;
				}
			
			$str .= "</series>";
			$str .= "<graphs>";
					
				
					
						//loop
					$cntX =0;
					$cntG = 0;
					if($dataOpt == 1)
					{
						foreach($arrData as $key=>$val)
						{
							$cntX++;
							$cntG++;
							//preview purpose
							if($this->tmpColor != "")
							{
								 $val['color'] = $this->tmpColor;
							}
							$str .= "<graph gid=\"$cntG\"  title=\"$key\" color=\"".$val['color']."\">";
							$str .= "<value xid=\"1\" color=\"#".$val['color']."\" >".round($val['amt'],2)."</value>";
							$str .= "</graph>";
						}
					}else{
						foreach($arrData as $key=>$val)
						{
							$cntX++;
							$cntG++;
							//preview purpose
							if($this->tmpColor != "")
							{
								 $val['color'] = $this->tmpColor;
							}
							$percent = ($val['amt'] * 100) / $total;
							$str .= "<graph   title=\"$key\" color=\"".$val['color']."\">";
							$str .= "<value xid=\"1\" color=\"".$val['color']."\">".round($percent,2)."</value>";
							$str .= "</graph>";
						}
					}
				//	$str .= "</graph>";
			
			$str .= "</graphs>";
			$str .="<labels>
    <label>
      <text><![CDATA[<b>".$this->graphLebel."</b>]]></text>
      <y>18</y>
      <text_color>999999</text_color>
      <text_size>10</text_size>
      <align>center</align>
    </label>
  </labels>";
			
		echo $str .= "</chart>";
		//file_put_contents($path,$str);

	}
	function chekOwnere($userId)
	{
		$ownerFlag = 0;
		if($userId == $_SESSION["tz_user"]["userid"])
		{
			$ownerFlag = 1;
		}	
		return $ownerFlag;
	}
	/*
		This Function is used to create graph for Time
	*/
	function timeGraph($actiId)
	{
		
		$ownerFlag = 0;
		 $sql = "SELECT id, graph_id,user_id,activity_type,name,modified_on_UTC,modified_on,user_id FROM activities WHERE id=\"$actiId\" AND status=\"unblocked\"  AND deleted=\"0\"";
		 $ROW = $this->db->select($sql);
		 //$ROW = $this->ROW;
		
		$ownerFlag= $this->chekOwnere($ROW[0]["user_id"]);

		if($ROW[0]['activity_type'] == 0)
		{
			$sql = "SELECT modified_on_UTC,modified_on FROM counts WHERE item_id=\"$actiId\"  AND deleted=\"0\" ORDER BY modified_on DESC LIMIT 0,1";
		}else{
			$sql = "SELECT modified_on_UTC,modified_on FROM counts WHERE item_id IN(SELECT activity_id FROM graphs_activities WHERE graph_id=\"" .$ROW[0]['graph_id'] ."\")  AND deleted=\"0\" ORDER BY modified_on DESC LIMIT 0,1";
		}

		$ROWDATA = $this->db->select($sql);
		$noofRows = $this->db->num_rows;
		$datetime = $ROWDATA[0]['modified_on_UTC'];
			
		
		$currDate = gmdate("Y-m-d H:i:s");
			
		if($noofRows > 0){
			$timeTmp = strtotime($currDate) - strtotime($datetime);
			
			$minute = ceil($timeTmp/60);
			$mod = $minute % 60;
			$hr= ($minute -$mod) / 60; 

			$time = $hr .":" . $mod;
			$arr['main_acti_name'] = "Time Since Last " .$ROW[0]['name'];
			$arr['number'] = $time;
		}else{
			$arr['main_acti_name'] = "Time Since Last " .$ROW[0]['name'];
			$arr['number'] = "";
		}
		return $arr;
	}

	function nameGraph($actiId,$optId)
	{
		$ownerFlag = 0;
		$sql = "SELECT id,graph_id,user_id,activity_type,name,modified_on_UTC,modified_on,user_id FROM activities WHERE id=\"$actiId\" AND status=\"unblocked\"  AND deleted=\"0\"";
		$ROW = $this->db->select($sql);

		//$ROW = $this->ROW;
		$ownerFlag= $this->chekOwnere($ROW[0]["user_id"]);
	
		switch($optId)
		{
		 case 1:
			 //Last counted
			if($ROW[0]['activity_type'] == 1){
			$sql = "SELECT a.name FROM counts c INNER JOIN activities a ON a.id=c.item_id WHERE c.item_id IN(SELECT activity_id FROM graphs_activities WHERE graph_id=\"" .$ROW[0]['graph_id'] ."\")AND a.status=\"unblocked\" AND a.deleted=\"0\" AND c.deleted=\"0\" ORDER BY c.modified_on DESC LIMIT 0,1";
			}else{
			 $sql = "SELECT a.name FROM counts c INNER JOIN activities a ON a.id=c.item_id WHERE c.item_id=\"" .$ROW[0]['id'] ."\" AND a.status=\"unblocked\" AND a.deleted=\"0\" AND c.deleted=\"0\" ORDER BY c.modified_on DESC LIMIT 0,1";
			}
		 break;
		 case 2:
			 //Largest Counted
			if($ROW[0]['activity_type'] == 1){
				$sql = "SELECT sum(c.amount) as amt,a.name FROM counts c INNER JOIN activities a ON a.id=c.item_id  WHERE c.item_id IN(SELECT activity_id FROM graphs_activities WHERE graph_id=\"" .$ROW[0]['graph_id'] ."\") AND a.status=\"unblocked\" AND a.deleted=\"0\" AND c.deleted=\"0\" GROUP BY c.item_id ORDER BY amt DESC LIMIT 0,1";
			}else{
				$sql = "SELECT sum(c.amount) as amt,a.name FROM counts c INNER JOIN activities a ON a.id=c.item_id  WHERE c.item_id=\"" .$ROW[0]['id'] ."\" AND a.status=\"unblocked\" AND a.deleted=\"0\" AND c.deleted=\"0\" GROUP BY c.item_id ORDER BY amt DESC LIMIT 0,1";
			}
		 break;
		 case 3:
			 //Smallest Counted
			 if($ROW[0]['activity_type'] == 1){
				 $sql = "SELECT  sum(c.amount) as amt, a.name FROM activities a LEFT JOIN counts c ON a.id=c.item_id  WHERE a.id IN(SELECT activity_id FROM graphs_activities WHERE graph_id=\"" .$ROW[0]['graph_id'] ."\") AND a.status=\"unblocked\" AND a.deleted=\"0\" AND c.deleted=\"0\"  GROUP BY a.id ORDER BY amt ASC LIMIT 0,1";
			 }else{
				 $sql = "SELECT  sum(c.amount) as amt, a.name FROM activities a LEFT JOIN counts c ON a.id=c.item_id  WHERE a.id=\"" .$ROW[0]['id'] ."\" AND a.status=\"unblocked\" AND a.deleted=\"0\" AND c.deleted=\"0\"  GROUP BY a.id ORDER BY amt ASC LIMIT 0,1";
			 }
		 break;
		}
		$ROWSUB = $this->db->select($sql);
		$arr['main_acti_name'] = $ROW[0]['name'];
		$arr['number'] = $ROWSUB[0]['name'];
		return $arr;


	}
	function numberGraph($actiId,$optId)
	{
		$ownerFlag = 0;
		 $sql = "SELECT a.id, a.graph_id,a.user_id,a.activity_type,a.name,a.modified_on_UTC,a.modified_on,a.user_id FROM activities a WHERE a.id=\"$actiId\"  AND a.status=\"unblocked\"  AND a.deleted=\"0\"";
		
		$ROW = $this->db->select($sql);

		$ownerFlag= $this->chekOwnere($ROW[0]["user_id"]);
		$type = $ROW[0]['activity_type'];
		switch($optId)
		{
		 case 1:
			 //Total of all count
			$total = 0;
			if($type == 1){
			$sql = "SELECT sum(c.amount) as amt,a.name FROM counts c INNER JOIN activities a ON a.id=c.item_id  WHERE c.item_id IN(SELECT activity_id FROM graphs_activities WHERE graph_id=\"" .$ROW[0]['graph_id'] ."\") AND a.status=\"unblocked\"  AND a.deleted=\"0\" AND c.deleted=\"0\" GROUP BY c.item_id";	
			}else{
				$sql = "SELECT sum(c.amount) as amt,a.name FROM counts c INNER JOIN activities a ON a.id=c.item_id  WHERE c.item_id=\"".$ROW[0]['id']."\"  AND a.status=\"unblocked\"  AND a.deleted=\"0\" AND c.deleted=\"0\" GROUP BY c.item_id";	
			}
			$ROW = $this->db->select($sql);
			if($this->db->num_rows >0)
			{
				foreach($ROW as $i)
				{
					$total += $i['amt'];
				}
			}
			 
		 break;

		 case 2:
			 //Total- Today
			$now = time();
			$currDateUTC = gmdate("Y-m-d", $now);
			$total = 0;
			$cnt = 0;
			if($type == 1){
			$sql = "SELECT count(c.id) as cnt,sum(c.amount) as amt,a.name FROM counts c INNER JOIN activities a ON a.id=c.item_id  WHERE c.item_id IN(SELECT activity_id FROM graphs_activities WHERE graph_id=\"" .$ROW[0]['graph_id'] ."\") AND c.modified_on_UTC LIKE \"%$currDateUTC%\" AND a.status=\"unblocked\" AND a.deleted=\"0\" AND c.deleted=\"0\" GROUP BY c.item_id";	
			}else{
			 $sql = "SELECT count(c.id) as cnt,sum(c.amount) as amt,a.name FROM counts c INNER JOIN activities a ON a.id=c.item_id  WHERE c.item_id=\"".$ROW[0]['id']."\" AND c.modified_on_UTC LIKE \"%$currDateUTC%\" AND a.deleted=\"0\" AND a.status=\"unblocked\" AND c.deleted=\"0\" GROUP BY c.item_id";	
			}
			$ROW = $this->db->select($sql);
			
			if($this->db->num_rows >0)
			{
				foreach($ROW as $i)
				{
					$cnt += $i['cnt'];
					$total += $i['amt'];
				}
			$total = $total;
			} 
			
		 break;
		 case 3:
			 //Total- last 7 day
			$now = time() - (24*60*60*7);
			$currDateUTC = gmdate("Y-m-d", $now);
			$total = 0;
			$cnt = 0;
			if($type == 1){
			 $sql = "SELECT count(c.id) as cnt,sum(c.amount) as amt,a.name FROM counts c INNER JOIN activities a ON a.id=c.item_id  WHERE c.item_id IN(SELECT activity_id FROM graphs_activities WHERE graph_id=\"" .$ROW[0]['graph_id'] ."\") AND c.modified_on_UTC >= \"$currDateUTC\" AND a.status=\"unblocked\" AND a.deleted=\"0\" AND c.deleted=\"0\" GROUP BY c.item_id";	
			}else{
			$sql = "SELECT count(c.id) as cnt,sum(c.amount) as amt,a.name FROM counts c INNER JOIN activities a ON a.id=c.item_id  WHERE c.item_id=\"".$ROW[0]['id']."\" AND c.modified_on_UTC >= \"$currDateUTC\" AND a.status=\"unblocked\" AND a.deleted=\"0\" AND c.deleted=\"0\" GROUP BY c.item_id";	

			}
			$ROW = $this->db->select($sql);
			
			if($this->db->num_rows >0)
			{
				foreach($ROW as $i)
				{
					$cnt += $i['cnt'];
					$total += $i['amt'];
				}
			$total = $total;
			} 
			
		 break;
		  case 4:
			 //Total- last 30 day
			$now = time() - (24*60*60*30);
			$currDateUTC = gmdate("Y-m-d", $now);
			$total = 0;
			$cnt = 0;
			if($type == 1){
			 $sql = "SELECT count(c.id) as cnt,sum(c.amount) as amt,a.name FROM counts c INNER JOIN activities a ON a.id=c.item_id  WHERE c.item_id IN(SELECT activity_id FROM graphs_activities WHERE graph_id=\"" .$ROW[0]['graph_id'] ."\") AND c.modified_on_UTC >= \"$currDateUTC\" AND a.status=\"unblocked\" AND a.deleted=\"0\" AND c.deleted=\"0\" GROUP BY c.item_id";	
			}else{
			$sql = "SELECT count(c.id) as cnt,sum(c.amount) as amt,a.name FROM counts c INNER JOIN activities a ON a.id=c.item_id  WHERE c.item_id=\"".$ROW[0]['id']."\" AND c.modified_on_UTC >= \"$currDateUTC\" AND a.status=\"unblocked\" AND a.deleted=\"0\" AND c.deleted=\"0\" GROUP BY c.item_id";	

			}
			$ROW = $this->db->select($sql);
			
			if($this->db->num_rows >0)
			{
				foreach($ROW as $i)
				{
					$cnt += $i['cnt'];
					$total += $i['amt'];
				}
			$total = $total;
			} 
			
		 break;
		 case 5:
			 //Average- total time
			if($type == 1){
			$sql = "SELECT count(c.id) as cnt,sum(c.amount) as amt,a.name FROM counts c INNER JOIN activities a ON a.id=c.item_id  WHERE c.item_id IN(SELECT activity_id FROM graphs_activities WHERE graph_id=\"" .$ROW[0]['graph_id'] ."\") AND a.status=\"unblocked\" AND a.deleted=\"0\" AND c.deleted=\"0\" GROUP BY c.item_id";	
			}else{
			 $sql = "SELECT count(c.id) as cnt,sum(c.amount) as amt,a.name FROM counts c INNER JOIN activities a ON a.id=c.item_id  WHERE c.item_id=\"".$ROW[0]['id']."\" AND a.status=\"unblocked\" AND a.deleted=\"0\" AND c.deleted=\"0\" GROUP BY c.item_id";	
			}
			$ROW = $this->db->select($sql);
			$cnt = 0;
			if($this->db->num_rows >0)
			{
				foreach($ROW as $i)
				{
					$total += $i['amt'];
					$cnt += $i['cnt'];
				}
				
				$total = $total/$cnt;
			}

			
		 break;
		
		 case 6:
			 //Average- last 7 days
			$now = time() - (24*60*60*7);
			$currDateUTC = gmdate("Y-m-d H:i:s", $now);
			$total = 0;
			$cnt = 0;
			if($type == 1){
			 $sql = "SELECT count(c.id) as cnt,sum(c.amount) as amt,a.name FROM counts c INNER JOIN activities a ON a.id=c.item_id  WHERE c.item_id IN(SELECT activity_id FROM graphs_activities WHERE graph_id=\"" .$ROW[0]['graph_id'] ."\") AND c.modified_on_UTC >= \"$currDateUTC\" AND a.status=\"unblocked\" AND a.deleted=\"0\" AND c.deleted=\"0\" GROUP BY c.item_id";	
			}else{
			$sql = "SELECT count(c.id) as cnt,sum(c.amount) as amt,a.name FROM counts c INNER JOIN activities a ON a.id=c.item_id  WHERE c.item_id=\"".$ROW[0]['id']."\" AND c.modified_on_UTC >= \"$currDateUTC\" AND a.status=\"unblocked\" AND a.deleted=\"0\" AND c.deleted=\"0\" GROUP BY c.item_id";	

			}
			$ROW = $this->db->select($sql);
			
			if($this->db->num_rows >0)
			{
				foreach($ROW as $i)
				{
					$cnt += $i['cnt'];
					$total += $i['amt'];
				}
			$total = $total/$cnt;
			} 
			
		 break;
		 case 7:
			 //Average- last 30 days
			$now = time() - (24*60*60*30);
			$currDateUTC = gmdate("Y-m-d H:i:s", $now);
			$total = 0;
			$cnt = 0;
			if($type == 1){
			$sql = "SELECT count(c.id) as cnt,sum(c.amount) as amt,a.name FROM counts c INNER JOIN activities a ON a.id=c.item_id  WHERE c.item_id IN(SELECT activity_id FROM graphs_activities WHERE graph_id=\"" .$ROW[0]['graph_id'] ."\") AND c.modified_on_UTC>=\"$currDateUTC\" AND a.status=\"unblocked\" AND a.deleted=\"0\" AND c.deleted=\"0\" GROUP BY c.item_id";	
			}else{
			$sql = "SELECT count(c.id) as cnt,sum(c.amount) as amt,a.name FROM counts c INNER JOIN activities a ON a.id=c.item_id  WHERE c.item_id=\"".$ROW[0]['id']."\"  AND c.modified_on_UTC>=\"$currDateUTC\" AND a.status=\"unblocked\" AND a.deleted=\"0\" AND c.deleted=\"0\"  GROUP BY c.item_id";	

			}
			$ROW = $this->db->select($sql);
			
			if($this->db->num_rows >0)
			{
				foreach($ROW as $i)
				{
					$cnt += $i['cnt'];
					$total += $i['amt'];
				}
				$total = $total/$cnt ;
			} 
			
		 break;
		}
		
		
		//$arr['main_acti_name'] = $ROW[0]['name'];
		$arr['main_acti_name'] = "Number";
		$arr['number'] = round($total,2);
		
		return $arr;


	}

	function returnCombo($gtype,$dataOpt="")
	{	
		$arr = $this->dataOptions($gtype);
		$str ="<select id=\"cmbDataOption\"  name=\"cmbDataOption\" onChange=\"preViewGraph();\">";

		$str .="<option value=\"\">--Select--</option>";
		foreach($arr as $key=>$val)
		{
			if($dataOpt == $key)
				$str .="<option value=\"$key\" Selected>$val</option>";
			else
				$str .="<option value=\"$key\">$val</option>";

		}

		$str .="</select>";
		return $str;
	}
	function returnPevieImg($gType)
	{
		$str = "graph3.gif";
		switch($gType)
		{
			case 1:
				$str = "graph3.gif";
			break;
			case 2:
				$str = "graph1.gif";
			break;
			case 3:
				$str = "graph4.gif";
			break;
			case 4:
				$str = "graph2.gif";
			break;
			case 5:
				$str = "graph3.gif";
			break;
			case 6:
				$str = "number.jpg";
			break;
			case 7:
				$str = "name.jpg";
			break;
			case 8:
				$str = "number.jpg";
			break;
			

		}
		return $str;
	}
	function returnUserTimeZone($currDate)
	{
		$sql = "SELECT timezone FROM users WHERE id=\"".$_SESSION["tz_user"]["userid"]."\"";
		$ROW = $this->db->select($sql);
		$this->db->num_rows;
		if($this->db->num_rows > 0)
		{
			$timeZone = $ROW[0]['timezone'];
			$currDateUserPC = $this->general->convertInTimeZone($currDate,$timeZone);
		}
		return $currDateUserPC;
	}



} //class end
?>
