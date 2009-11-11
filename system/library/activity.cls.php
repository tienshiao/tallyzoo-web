<?
class activity
{
	public $precision;
	function __construct()
	{
		global $dbObj;
		global $objGeneral;
		global $objChart;
		$this->db = $dbObj;
		$this->general = $objGeneral;
		$this->objChart = $objChart;
	}
	
	function addAcitivity($userId)
	{
		foreach($_POST as $key=>$val)
		{
			$$key = $this->general->encodequotes($val);
		}
		$arrActId  = explode(",",$activityIds);
		
		$sql = "SELECT id FROM activities WHERE name=\"$txtName\" AND user_id=\"$userId\"";
		$ROW = $this->db->select($sql);

		if($this->db->num_rows == 0)
		{
			if(trim($txtColor) == "")
			{
				$txtColor = "000000";
			}
			$now = time();
			$currDateUTC = gmdate("Y-m-d H:i:s", $now);
			$currDate = date("Y-m-d H:i:s", $now);
			$currDateUserPC = $this->returnUserTimeZone($currDate);
			
			$sql = "INSERT INTO activities(user_id,name,default_note,tags,initial_value,goal,color,created_on,created_on_UTC,activity_type,guid,status,modified_on,modified_on_UTC) VALUES(\"$userId\",\"$txtName\",\"$txtNote\",\"$txtTag\",\"$txtIntial\",\"$txtGoal\",\"$txtColor\",\"$currDateUserPC\",\"$currDateUTC\",\"$rdoActivityType\",UUID(),\"unblocked\",\"$currDateUserPC\",\"$currDateUTC\")";
			
			$this->db->insert($sql);
			$activityId = $this->db->last_insert_id;
			
			
			//Insert a row in graphs table.
			$sqlGraph = "INSERT INTO graphs(user_id,hidden,created_on,created_on_UTC,modified_on,modified_on_UTC,graph_type,dataOption) VALUES(\"$userId\",\"$rdoAccess\",\"$currDateUTC\",\"$currDateUserPC\",\"$currDateUTC\",\"$currDateUserPC\",\"$graphType\",\"$cmbDataOption\")";
			$this->db->insert($sqlGraph);
			$graphId = $this->db->last_insert_id;

			//Update activity table
			$sqlUpdateActivity = "UPDATE activities SET graph_id=\"$graphId\" WHERE id=\"$activityId\"";
			$this->db->edit($sqlUpdateActivity);

			//check if activity type is composite then enter data in graph_setting
			if($rdoActivityType == 1)
			{
				$arrActId  = explode(",",$activityIds);
				foreach($arrActId as $i)
				{
					 echo $sqlGActivity = "INSERT INTO graphs_activities(graph_id,activity_id) VALUES(\"$graphId\",\"$i\")";
					$this->db->insert($sqlGActivity);
				}
			}
			
		
			return 1;
		}else{
			return 0;
		}
	}

	function updateAcitivity($Id,$userId)
	{ 
		foreach($_POST as $key=>$val)
		{
			$$key = $this->general->encodequotes($val);
		}
				
		 $sql = "SELECT id FROM activities WHERE name=\"$txtName\" AND id !=\"$Id\" AND user_id=\"$userId\" AND deleted=\"0\"";
		
		$ROW = $this->db->select($sql);
				
		if($this->db->num_rows == 0)
		{
			if(trim($txtColor) == "")
			{
				$txtColor = "ffffff";
			}
			
			$now = time();
			$currDateUTC = gmdate("Y-m-d H:i:s", $now);
			$currDate = date("Y-m-d H:i:s", $now);
			$currDateUserPC = $this->returnUserTimeZone($currDate);

			 $sql = "UPDATE activities SET name=\"$txtName\",default_note=\"$txtNote\",tags=\"$txtTag\",initial_value=\"$txtIntial\",goal=\"$txtGoal\",color=\"$txtColor\",modified_on=\"$currDateUserPC\",modified_on_UTC=\"$currDateUTC\", activity_type=\"$rdoActivityType\" WHERE id=\"$Id\"";
			$this->db->edit($sql);

			//update graph for access
			$sqlGraph = "UPDATE graphs SET hidden=\"$rdoAccess\",modified_on=\"$currDateUserPC\",modified_on_UTC=\"$currDateUTC\",graph_type=\"$graphType\",dataOption=\"$cmbDataOption\" WHERE id=\"$graphId\"";
			$this->db->edit($sqlGraph);


			$sql = "DELETE FROM graphs_activities WHERE graph_id=\"$graphId\"";
			$this->db->sql_query($sql);

			if($rdoActivityType == 1)
			{
				$arrActId  = explode(",",$activityIds);
				foreach($arrActId as $i)
				{
					$sqlGActivity = "INSERT INTO graphs_activities(graph_id,activity_id) VALUES(\"$graphId\",\"$i\")";
					$this->db->insert($sqlGActivity);
				}
			}

			return 1;
		}else{
			return 0;
		}
	}
	function deleteActivity($Id)
	{

	$sql = "DELETE FROM activities WHERE id=\"$Id\"" ;

		//$sql = "DELETE FROM activities WHERE id=\"$Id\"" ;
		$sql = "UPDATE activities SET deleted='1' WHERE id=\"$Id\"" ;

		$this->db->sql_query($sql);

		$sql = "UPDATE counts SET deleted='1' WHERE item_id=\"$Id\"" ;
		$this->db->sql_query($sql);
	}
	
	function getUsersActivityWithCount($userId,$pageLimit="",$filer="",$sort="DESC")
	{
		  Global $arrFilter; //This used for top filer above list.
		  if(trim($filer) != "" && trim($filer) != "all"){
			  $fieldfiler = " AND a.name LIKE \"$filer%\"";
		  }
		  if($_GET['s'] ==1)
		  {
			$fieldfiler = " AND a.activity_type= \"1\"";
		  }

		 
		  $sql = "SELECT a.activity_type,a.color,a.graph_id,a.activity_type, a.id,a.name,a.default_note,a.tags,DATE_FORMAT(a.created_on,'%d/%m/%Y') as created_on,sum(amount) as total,max(c.amount_sig) as amount_sig FROM activities as a LEFT JOIN counts c on (c.item_id=a.id AND c.deleted=\"0\") WHERE a.user_id=\"$userId\" AND a.deleted=\"0\"  $fieldfiler group by a.id ORDER BY a.created_on $sort";

		 
		$ROW = $this->db->select($sql);


		if($pageLimit!="")
		$sql	.=	$pageLimit;
		$ROW = $this->db->select($sql);
		$nrows = $this->db->num_rows;
		if(is_array($ROW)){
			foreach($ROW as $mkey=>$mval)
			{
				
				foreach($mval as $k=>$v)
				{ 
					$tmpKey = (string)$k;
					if($tmpKey == "name")
					{ 
						 $chr = substr(trim($v),0,1);
						 $arrFilter[strtoLower($chr)] = strtoUpper($chr);
					}
					$ROW[$mkey][$k] = $this->general->decodequotes($v);
				}
				
				if($ROW[$mkey]["activity_type"] == 1)
				{
					 $ROW[$mkey]["name"] ."|".$ROW[$mkey]["activity_type"] ."<br>";
					 $sql = "SELECT sum(amount) as total from counts WHERE item_id IN(select activity_id from graphs_activities where graph_id=\"".$ROW[$mkey]["graph_id"] ."\") AND deleted=\"0\"";
					$ROWTOTAL = $this->db->select($sql);
					$ROW[$mkey]["total"] = $ROWTOTAL[0]['total'];

					//get Activity Name.
					 $sql = "SELECT name,id from activities WHERE id IN(select activity_id from graphs_activities where graph_id=\"".$ROW[$mkey]["graph_id"] ."\") AND deleted=\"0\" ORDER BY name";
					$ROWNAME = $this->db->select($sql);
					
					$strName = "";
					if(is_array($ROWNAME)){
						foreach($ROWNAME as $i)
						{
							if($strName == ""){
								$strName = "<a href=\"" ._SITEURL_."activities/".$i["id"]."/".sanitize_title_with_dashes($i["name"])."\">".$i["name"]."</a>";
							}else{
								$strName .= ","."<a href=\"" ._SITEURL_."activities/".$i["id"]."/".sanitize_title_with_dashes($i["name"])."\">".$i["name"]."</a>";
							}
						}
					$ROW[$mkey]["relateActivity"] = $strName;
					
					}
				}
				$sqlGraph = "SELECT graph_type,dataOption FROM graphs WHERE id=\"".$ROW[$mkey]["graph_id"]."\"";
				$ROWGRAPH = $this->db->select($sqlGraph);
				
				$grows = $this->db->num_rows;
				if($grows > 0){
				 $ROW[$mkey]["graphJsFn"]="prev_". $this->returnChartJsFn($ROW[$mkey]["id"],$ROWGRAPH[0]['graph_type'],$ROWGRAPH[0]['dataOption']) .";";
				}else{
					$ROW[$mkey]["graphJsFn"]="";
				}
			}
			
		}
		$this->db->num_rows = $nrows;
		return $ROW;
	}

	function getUsersActivity($userId,$activityId="",$searkey="")
	{
		
		if($activityId == "" && $searkey == ""){
			$sql = "SELECT a.id,a.name,a.default_note,a.tags,a.created_on_UTC FROM activities as a  WHERE a.user_id=\"$userId\" AND a.activity_type='0' AND a.status=\"unblocked\" AND a.deleted=\"0\"";
			
		}elseif(trim($searkey) != "")
		{
			$searkey =  $this->general->encodequotes($searkey);
			$sql = "SELECT a.id,a.name,a.default_note,a.tags,a.created_on_UTC FROM activities as a  WHERE a.user_id=\"$userId\" AND a.activity_type='0' AND name LIKE \"%$searkey%\" AND a.status=\"unblocked\" AND a.deleted=\"0\"";
		}
		else{ 
			$sql = "SELECT a.id,a.name,a.default_note,a.tags,a.created_on_UTC FROM activities as a  WHERE a.user_id=\"$userId\" and a.id NOT IN($activityId) AND a.status=\"unblocked\"AND a.activity_type='0' AND a.deleted=\"0\"";
		}
		
		$ROW = $this->db->select($sql);
		return $ROW;
	}
	function getActivity($actId)
	{
		$sql = "SELECT a.*,g.hidden,g.graph_type,g.dataOption FROM activities as a inner join graphs g on g.id=a.graph_id WHERE a.id=\"$actId\" AND a.deleted=\"0\"";
		$ROW = $this->db->select($sql);
	
		return $ROW[0];
	}
	function getRealatedActIds($graphId)
	{
		$sql = "SELECT activity_id FROM graphs_activities g INNER JOIN activities a ON  a.id=g.activity_id WHERE g.graph_id=\"$graphId\" AND a.deleted=\"0\" ORDER BY a.name";
		$ROW = $this->db->select($sql);
		$ids = "";
		foreach($ROW as $i)
		{
			if($ids == "")
				$ids = $i['activity_id'];
			else
				$ids .= ",". $i['activity_id'];
		}
		return $ids;
	}
	function addCount()
	{
		foreach($_POST as $key=>$val)
		{
			$$key = $this->general->encodequotes($val);
		}
		if($_POST["cmbActivity"] != "")
		{
			$actiId = $_POST["cmbActivity"];
		}else{
			$actiId = $editId;
		}
		
		$currDate = date("Y-m-d H:i:s");
		$txtDate = $txtDateQuick;
		if(trim($txtDate) != "")
			{
				$arr = explode("/",$txtDate);
				$arrY = explode(" ",$arr[2]);
				$strDate = $arrY[0]."-".$arr[1]."-".$arr[0]." ".$arrY[1]." ".$arrY[2];
				$currDateUserPC = date('Y-m-d H:i:s',strtotime($strDate));
				$currDateUTC = gmdate("Y-m-d H:i:s", strtotime($currDateUserPC));
				
				
			}else{
				
				$now = time();
				$currDateUTC = gmdate("Y-m-d H:i:s", $now);
				$currDate = date("Y-m-d H:i:s", $now);
				$currDateUserPC = $this->returnUserTimeZone($currDate);
			}
		
		


		$decimalCnt = 0;
		$tmpCnt = " ".$txtCount;
		if(strstr($txtCount,".") !=FALSE){
			$arrF = explode(".",$txtCount);
			$decimalCnt = strlen($arrF[1]);
		}

		 $sql = "INSERT INTO counts(item_id,note,tags,amount,amount_sig,created_on,created_on_UTC,guid,modified_on,modified_on_UTC)
		VALUES(\"$actiId\",\"$txtNote\",\"$txtTag\",\"$txtCount\",\"$decimalCnt\",\"$currDateUserPC\",\"$currDateUTC\",UUID(),\"$currDateUserPC\",\"$currDateUTC\")
		";
		$this->db->insert($sql);
		

	}
	function quickAddCount()
	{
		
		
		foreach($_POST as $key=>$val)
		{
			$$key = $this->general->encodequotes($val);
		}
		$sql = "SELECT id FROM activities WHERE name=\"$name\" and user_id=\"".$_SESSION["tz_user"]["userid"]."\" AND deleted=\"0\"";
		$ROW = $this->db->select($sql);

		if($this->db->num_rows >0)
		{
			$currDate = date("Y-m-d H:i:s");
			//$currDateUserPC = $this->returnUserTimeZone($currDate);
			
			if(trim($txtDate) != "")
			{
				$arr = explode("/",$txtDate);
				$arrY = explode(" ",$arr[2]);
				$strDate = $arrY[0]."-".$arr[1]."-".$arr[0]." ".$arrY[1]." ".$arrY[2];
				$currDateUserPC = date('Y-m-d H:i:s',strtotime($strDate));
				$currDateUTC = gmdate("Y-m-d H:i:s", strtotime($currDateUserPC));
				
				
			}else{
				$now = time();
				$currDateUTC = gmdate("Y-m-d H:i:s", $now);
				$currDate = date("Y-m-d H:i:s", $now);
				$currDateUserPC = $this->returnUserTimeZone($currDate);
			}
			$decimalCnt = 0;
			$tmpCnt = " ".$txtCount;
			if(strstr($txtCount,".") !=FALSE){
				$arrF = explode(".",$txtCount);
				$decimalCnt = strlen($arrF[1]);
			}
			$actiId = $ROW[0]["id"];
			 $sql = "INSERT INTO counts(item_id,note,tags,amount,amount_sig,created_on,created_on_UTC,modified_on,modified_on_UTC)
			VALUES(\"$actiId\",\"$txtNote\",\"$txtTag\",\"$txtCount\",\"$decimalCnt\",\"$currDateUserPC\",\"$currDateUTC\",\"$currDateUserPC\",\"$currDateUTC\")
			";
			$this->db->insert($sql);
			return "Added Successfully.";
		}else{
			return "Activity name does not exists.";
		}
		

	}
	function updateCount($Id)
	{
		foreach($_POST as $key=>$val)
		{
			$$key = $this->general->encodequotes($val);
		}
		$now = time();
		$currDateUTC = gmdate("Y-m-d H:i:s", $now);
		$currDate = date("Y-m-d H:i:s", $now);
		$currDateUserPC = $this->returnUserTimeZone($currDate);

		$decimalCnt = 0;
		$tmpCnt = " ".$txtCount;
		if(strstr($txtCount,".") !=FALSE){
			$arrF = explode(".",$txtCount);
			$decimalCnt = strlen($arrF[1]);
		}
		
		if($txtDate != "")
		{
			$arr = explode("/",$txtDate);
			$arrY = explode(" ",$arr[2]);
			$strDate = $arrY[0]."-".$arr[1]."-".$arr[0]." ".$arrY[1]." ".$arrY[2];
			$strDate = date('Y-m-d H:i:s',strtotime($strDate));
			//$strDate = ",created_on=\"$strDate\"";
			$currDateUserPC = $strDate;
			$currDateUTC = gmdate("Y-m-d H:i:s", strtotime($strDate));
		}
		
		 $sql = "UPDATE counts SET note=\"$txtNote\",amount=\"$txtCount\",amount_sig=\"$decimalCnt\",modified_on=\"$currDateUserPC\",modified_on_UTC=\"$currDateUTC\" WHERE id=\"$Id\"";
		$this->db->insert($sql);
		

	}
	function convertForWithAmtSig($arr)
	{
		$precision = 0;
		$ROW = array();
		if(is_array($arr)){
		foreach($arr as $i)
		{ 
			$tmpArray[] = $i['amount_sig'];
		}
		}
		if(is_array($tmpArray))
		{ 
			sort($tmpArray);
			$this->precision = $tmpArray[count($tmpArray) -1];
		}
		
		
		if(is_array($arr)){
			foreach($arr as $i)
			{
				 $i["total"] = round($i["total"],$this->precision);
				 $ROW[] = $i;
			}
		}
		return $ROW;

	}
	function getUsersMyData($userId,$pageLimit="",$activityId="")
	{
		if($activityId == ""){
			$whereCond = "a.user_id=\"$userId\"";
		}else{
			$whereCond = "a.id=\"$activityId\"";
		}
		 $sql = "SELECT a.id as actId,a.color,a.name,c.id,c.item_id,c.note, c.tags, c.amount, c.amount_sig, DATE_FORMAT(c.modified_on,'%d/%m/%Y &nbsp;%I:%i %p') as created_on
				FROM counts AS c
				INNER JOIN activities AS a ON c.item_id = a.id  WHERE $whereCond AND a.activity_type='0' AND c.deleted=\"0\" AND a.deleted=\"0\" ORDER BY c.id DESC";
		
		$ROW = $this->db->select($sql);

		if($pageLimit!="")
		$sql	.=	$pageLimit;
		$ROW = $this->db->select($sql);
		return $ROW;
	}

	function getUsersMyDataALL($activityId,$type,$graphId)
	{
		if($type == 0){
			$whereCond = "a.id=\"$activityId\"";
		}else{
			$whereCond = "a.id IN (SELECT activity_id FROM graphs_activities WHERE graph_id=\"$graphId\")";
		}
		
		 $sql = "SELECT a.id as actId,a.color,a.name,c.id,c.item_id,c.note, c.tags, c.amount, c.amount_sig, DATE_FORMAT(c.modified_on,'%d/%m/%Y &nbsp;%I:%i %p') as created_on
				FROM counts AS c
				INNER JOIN activities AS a ON c.item_id = a.id  WHERE $whereCond AND a.activity_type='0'  AND c.deleted=\"0\" AND a.deleted=\"0\" ORDER BY c.modified_on DESC";
		
		$ROW = $this->db->select($sql);

		if($pageLimit!="")
		$sql	.=	$pageLimit;
		$ROW = $this->db->select($sql);
		return $ROW;
	}

	function deleteMydata($Id)
	{
		//$sql = "DELETE FROM counts WHERE id=\"$Id\"" ;
		$sql = "UPDATE counts SET deleted='1' WHERE id=\"$Id\"" ;
		$this->db->sql_query($sql);
	}
	function getDataItem($id)
	{ 
		$sql = "SELECT c.id,c.item_id,c.note, c.tags, c.amount, c.amount_sig, DATE_FORMAT(c.modified_on,'%d/%m/%Y %I:%i %p') as created_on FROM counts AS c WHERE id=\"$id\"";
		$ROW = $this->db->select($sql);
		$str = $ROW[0]["note"] . "@**#" .$ROW[0]["tags"] ."@**#" .$ROW[0]["amount"]."@**#" .$ROW[0]["created_on"];
		return $str;
	}
	function getRealatedActivity($graphId)
	{
		 $sql = "SELECT a.name,a.color,g.activity_id FROM graphs_activities as g INNER JOIN activities as a ON a.id=g.activity_id WHERE g.graph_id=\"$graphId\" AND a.deleted=\"0\" ORDER BY a.name";
		$ROW = $this->db->select($sql);
		return $ROW;
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
 //This function search users
function seachUserActivty($searchKey,$pageLimit="")
{
	
	$searchKey = $this->general->encodequotes($searchKey);
	$flddate = "modified_on_UTC";
	$where = "";
	$filter = "";
	$groupBy = "GROUP BY a.id";
	if(isset($_SESSION['tz_user']['userid']))
	{
		$flddate = "modified_on";
		if($_POST['rdoOnlyEvery'] == "only")
		{
			$where = "AND a.user_id=\"".$_SESSION['tz_user']['userid']."\"";
		}
	}
	if($_POST['rdoOnlyEvery'] == "every")
	{
		 $where = "AND a.user_id !=\"".$_SESSION['tz_user']['userid']."\" AND g.hidden='1'";
		
	}
	/*if($_POST['hidFilter'] == "mydata")
	{
		$filter = "OR a.id IN(select item_id from counts group by item_id having sum(amount) = \"$searchKey\")";
	}*/

	$filter = "(a.name LIKE \"%$searchKey%\" OR a.default_note LIKE \"%$searchKey%\" OR  u.username LIKE \"%$searchKey%\")";
	if($_POST['rdoOnlyEvery'] == "every")
	{
		if($_POST['hidFilter'] == "user")
		{
			$filter = "u.username LIKE \"%$searchKey%\"";
			$groupBy = "GROUP BY u.id";
		}
		if($_POST['hidFilter'] == "activity")
		{
			$filter = "(a.name LIKE \"%$searchKey%\" OR a.default_note LIKE \"%$searchKey%\")";
		}
	}
	 $sql = "SELECT u.username,u.id as uid,u.imagename,a.activity_type,a.color,a.graph_id,a.id,a.name,a.default_note,a.tags,a.".$flddate." as a_date,sum(amount) as total,max(c.amount_sig) as amount_sig,(select ".$flddate." from counts where item_id=a.id AND deleted=\"0\" order by $flddate DESC limit 0,1 ) as c_date,g.hidden FROM activities as a LEFT JOIN counts c on (c.item_id=a.id AND c.deleted=\"0\") INNER JOIN graphs g ON g.id=a.graph_id INNER JOIN users u ON u.id=a.user_id WHERE a.deleted=\"0\" AND  $filter $where   $groupBy  ORDER BY a.id";
		 
		$ROW = $this->db->select($sql);
		if($pageLimit!="")
		$sql	.=	$pageLimit;

		$ROW = $this->db->select($sql);
		$nrows = $this->db->num_rows;
		if(is_array($ROW)){
			foreach($ROW as $mkey=>$mval)
			{
				
				foreach($mval as $k=>$v)
				{ 
					$ROW[$mkey][$k] = $this->general->decodequotes($v);
				}
				
				if($ROW[$mkey]["activity_type"] == 1)
				{
					 $ROW[$mkey]["name"] ."|".$ROW[$mkey]["activity_type"] ."<br>";
					 $sql = "SELECT sum(amount) as total from counts WHERE item_id IN(select activity_id from graphs_activities where graph_id=\"".$ROW[$mkey]["graph_id"] ."\") AND deleted=\"0\"";
					$ROWTOTAL = $this->db->select($sql);
					$ROW[$mkey]["total"] = $ROWTOTAL[0]['total'];

					//get Activity Name.
					 $sql = "SELECT name,id from activities WHERE id IN(select activity_id from graphs_activities where graph_id=\"".$ROW[$mkey]["graph_id"] ."\") AND deleted=\"0\" ORDER BY name";
					$ROWNAME = $this->db->select($sql);
					
					$strName = "";
					if(is_array($ROWNAME)){
						foreach($ROWNAME as $i)
						{
							if($strName == ""){
								$strName = "<a href=\"" ._SITEURL_."activities/".$i["id"]."/".sanitize_title_with_dashes($i["name"])."\">".$i["name"]."</a>";
							}else{
								$strName .= ","."<a href=\"" ._SITEURL_."activities/".$i["id"]."/".sanitize_title_with_dashes($i["name"])."\">".$i["name"]."</a>";
							}
						}
					$ROW[$mkey]["relateActivity"] = $strName;
					
					}
				}

				//get the time
				$tmpDate = "";
				
				if(!is_null($ROW[$mkey]["c_date"]) && $ROW[$mkey]["c_date"] !='0000-00-00' && trim($ROW[$mkey]["c_date"]) !="")
				{
					 $tmpDate = $ROW[$mkey]["c_date"];
					
				}
				else{
					$tmpDate = $ROW[$mkey]["a_date"];
					
				}

				$currDate = gmdate("Y-m-d H:i:s");
				if(isset($_SESSION['tz_user']['userid']))
				{
					$currDate = date("Y-m-d H:i:s");	
					$currDate = $this->returnUserTimeZone($currDate);
				}

				$timeInMin = floor((strtotime($currDate) - strtotime($tmpDate))/(60));
               
				if($timeInMin > 1)
				{
					$ROW[$mkey]["timeInMin"] = $timeInMin ." minutes ago";
				}else{
					$ROW[$mkey]["timeInMin"] = "1 minute ago";
				}


			}
			
		}
		$this->db->num_rows = $nrows;
		return $ROW;
	}
/*****************for viewProfile page **************/
 


 	function getUsersActivityProfile($userId,$pageLimit="",$filer="")
	{
		  Global $arrFilter; //This useed for top filer above list.
		  $orderby = "";
	  	if($_POST['hidFilter'] == "mr" || $_POST[hidFilter] == "")
		{
			$orderby = " ORDER BY  created_on DESC";
		  }
          elseif($_POST['hidFilter'] == "aph")
          {
            $orderby = " ORDER BY a.name ASC";
          }

		  if($_SESSION['tz_user']['userid'] !=$userId)
		 {
			 $where = " AND g.hidden=1";
		 }
		$sql = "SELECT a.activity_type,a.color,a.graph_id,a.activity_type, a.id,a.name,a.default_note,a.tags,DATE_FORMAT(a.created_on,'%d/%m/%Y') as created_on,sum(amount) as total,max(c.amount_sig) as amount_sig FROM activities as a LEFT JOIN counts c on (c.item_id=a.id AND c.deleted=\"0\") INNER JOIN graphs g ON g.id=a.graph_id  WHERE a.user_id=\"$userId\" AND a.deleted=\"0\"   $where group by a.id $orderby";

		$ROW = $this->db->select($sql);

		if($pageLimit!="")
		$sql	.=	$pageLimit;
		$ROW = $this->db->select($sql);
		$nrows = $this->db->num_rows;
		if(is_array($ROW)){
			foreach($ROW as $mkey=>$mval)
			{
				
				foreach($mval as $k=>$v)
				{ 
					$tmpKey = (string)$k;
					if($tmpKey == "name")
					{ 
						 $chr = substr(trim($v),0,1);
						 $arrFilter[strtoLower($chr)] = strtoUpper($chr);
					}
					$ROW[$mkey][$k] = $this->general->decodequotes($v);
				}
				
				if($ROW[$mkey]["activity_type"] == 1)
				{
					 $ROW[$mkey]["name"] ."|".$ROW[$mkey]["activity_type"] ."<br>";
					 $sql = "SELECT sum(amount) as total from counts WHERE item_id IN(select activity_id from graphs_activities where graph_id=\"".$ROW[$mkey]["graph_id"] ."\") AND deleted=\"0\" ";
					$ROWTOTAL = $this->db->select($sql);
					$ROW[$mkey]["total"] = $ROWTOTAL[0]['total'];

					//get Activity Name.
					 $sql = "SELECT name,id from activities WHERE id IN(select activity_id from graphs_activities where graph_id=\"".$ROW[$mkey]["graph_id"] ."\") AND deleted=\"0\" ORDER BY name";
					$ROWNAME = $this->db->select($sql);
					
					$strName = "";
					if(is_array($ROWNAME)){
						foreach($ROWNAME as $i)
						{
							if($strName == ""){
								$strName = "<a href=\"" ._SITEURL_."activities/".$i["id"]."/".sanitize_title_with_dashes($i["name"])."\">".$i["name"]."</a>";
							}else{
								$strName .= ","."<a href=\"" ._SITEURL_."activities/".$i["id"]."/".sanitize_title_with_dashes($i["name"])."\">".$i["name"]."</a>";
							}
						}
					$ROW[$mkey]["relateActivity"] = $strName;
					
					}
				}
                //get the time
				$tmpDate = "";
				
				if(!is_null($ROW[$mkey]["c_date"]) && $ROW[$mkey]["c_date"] !='0000-00-00' && trim($ROW[$mkey]["c_date"]) !="")
				{
					 $tmpDate = $ROW[$mkey]["c_date"];
					
				}
				else{
					$tmpDate = $ROW[$mkey]["a_date"];
					
				}

				$currDate = gmdate("Y-m-d H:i:s");
				if(isset($_SESSION['tz_user']['userid']))
				{
					$currDate = date("Y-m-d H:i:s");	
					$currDate = $this->returnUserTimeZone($currDate);
				}
			//	$timeInMin = floor((strtotime($currDate) - strtotime($tmpDate))/(60));
                $timeInSec = floor((strtotime($currDate) - strtotime($tmpDate)));
                $nrMinutes = floor($timeInSec / 60);
                $nrHours=floor($timeInSec / (60*60));
                $nrDaysPassed = floor($timeInSec / 86400); // see explanations below to see what this does 
                $nrWeeksPassed = floor($timeInSec / 604800); // same as above 
                $nrYearsPassed = floor($timeInSec / 31536000); // same as above 
                               
                if($timeInSec > 1)
				{
				    if($nrMinutes > 1)
        				{
    				    if($nrHours > 1)
        				{
                         if($nrDaysPassed > 1)
        				{
        				    if($nrWeeksPassed > 1){
        				        
        				        if($nrYearsPassed  > 1){
        				            
        				           $ROW[$mkey]["timeInMin"] = "about " .$nrYearsPassed ." years ago"; 
        				        }else{
        				            $ROW[$mkey]["timeInMin"] = "about " .$nrWeeksPassed ." weeks ago";         				            
        				        }
                                
        				    }else{
        				        $ROW[$mkey]["timeInMin"] = $nrDaysPassed ." days ago";   
        				    }
        				}else{
        				        $ROW[$mkey]["timeInMin"] = $nrHours ." hours ago";   
        				    }
                        }else{
        				        $ROW[$mkey]["timeInMin"] = $nrMinutes ." Minutes ago";   
        				    }
                        }
                        else{
					$ROW[$mkey]["timeInMin"] = "1 minute ago";
				}
              }
                /*
				if($timeInMin > 1)
				{
					$ROW[$mkey]["timeInMin"] = $timeInMin ." minutes ago";
				}else{
					$ROW[$mkey]["timeInMin"] = "1 minute ago";
				}
                */
			}
			
		}
		$this->db->num_rows = $nrows;
		return $ROW;
	}

 function searchCommunityData($searchKey,$pageLimit="")
{
	
	$searchKey = $this->general->encodequotes($searchKey);
	$flddate = "created_on_UTC";//modified_on_UTC
	$where = "";
	$filter = "";
	if(isset($_SESSION['tz_user']['userid']))
	{
		       $flddate = "created_on";//modified_on
	
			$where = " a.user_id !=\"".$_SESSION['tz_user']['userid']."\" AND g.hidden='1'";

	}


	$sql = "SELECT u.username,u.id as uid,u.imagename,a.activity_type,a.color,a.graph_id,a.activity_type, a.id,a.name,a.default_note,a.tags,a.".$flddate." as a_date,sum(amount) as total,max(c.amount_sig) as amount_sig,(select ".$flddate." from counts where item_id=a.id  AND deleted=\"0\"  order by $flddate DESC limit 0,1 ) as c_date,g.hidden FROM activities as a LEFT JOIN counts c on (c.item_id=a.id AND c.deleted=\"0\") INNER JOIN graphs g ON g.id=a.graph_id INNER JOIN users u ON u.id=a.user_id WHERE  $filter AND g.hidden='1' AND a.deleted=\"0\"   group by a.id  ORDER BY a.id ";

		$ROW = $this->db->select($sql);
		if($pageLimit!="")
		$sql	.=	$pageLimit;

		$ROW = $this->db->select($sql);
		$nrows = $this->db->num_rows;
		if(is_array($ROW)){
			foreach($ROW as $mkey=>$mval)
			{
				
				foreach($mval as $k=>$v)
				{ 
					$ROW[$mkey][$k] = $this->general->decodequotes($v);
				}
				
				if($ROW[$mkey]["activity_type"] == 1)
				{
					 $ROW[$mkey]["name"] ."|".$ROW[$mkey]["activity_type"] ."<br>";
					 $sql = "SELECT sum(amount) as total from counts WHERE item_id IN(select activity_id from graphs_activities where graph_id=\"".$ROW[$mkey]["graph_id"] ."\")  AND deleted=\"0\" ";
					$ROWTOTAL = $this->db->select($sql);
					$ROW[$mkey]["total"] = $ROWTOTAL[0]['total'];

					//get Activity Name.
					 $sql = "SELECT name,id from activities WHERE id IN(select activity_id from graphs_activities where graph_id=\"".$ROW[$mkey]["graph_id"] ."\") AND deleted=\"0\" ORDER BY name";
					$ROWNAME = $this->db->select($sql);
					
					$strName = "";
					if(is_array($ROWNAME)){
						foreach($ROWNAME as $i)
						{
							if($strName == ""){
								$strName = "<a href=\"" ._SITEURL_."activities/".$i["id"]."/".sanitize_title_with_dashes($i["name"])."\">".$i["name"]."</a>";
							}else{
								$strName .= ","."<a href=\"" ._SITEURL_."activities/".$i["id"]."/".sanitize_title_with_dashes($i["name"])."\">".$i["name"]."</a>";
							}
						}
					$ROW[$mkey]["relateActivity"] = $strName;
					
					}
				}

				//get the time
				$tmpDate = "";
				
				if(!is_null($ROW[$mkey]["c_date"]) && $ROW[$mkey]["c_date"] !='0000-00-00' && trim($ROW[$mkey]["c_date"]) !="")
				{
					 $tmpDate = $ROW[$mkey]["c_date"];
					
				}
				else{
		     	$tmpDate = $ROW[$mkey]["a_date"];
           
					
				}

				$currDate = gmdate("Y-m-d H:i:s");
				/*if(isset($_SESSION['tz_user']['userid']))
				{
					$currDate = date("Y-m-d H:i:s");	
					$currDate = $this->returnUserTimeZone($currDate);
				}*/

		//	$timeInMin = floor((strtotime($currDate) - strtotime($tmpDate))/(60));
               $timeInSec = floor((strtotime($currDate) - strtotime($tmpDate)));
                $nrMinutes = floor($timeInSec / 60);
                $nrHours=floor($timeInSec / (60*60));
                $nrDaysPassed = floor($timeInSec / 86400); // see explanations below to see what this does 
                $nrWeeksPassed = floor($timeInSec / 604800); // same as above 
                $nrYearsPassed = floor($timeInSec / 31536000); // same as above 
                               
                if($timeInSec > 1)
				{
				    if($nrMinutes > 1)
        				{
    				    if($nrHours > 1)
        				{
                         if($nrDaysPassed > 1)
        				{
        				    if($nrWeeksPassed > 1){
        				        
        				        if($nrYearsPassed  > 1){
        				            
        				           $ROW[$mkey]["timeInMin"] = "about " .$nrYearsPassed ." years ago"; 
        				        }else{
        				            $ROW[$mkey]["timeInMin"] = "about " .$nrWeeksPassed ." weeks ago";         				            
        				        }
                                
        				    }else{
        				        $ROW[$mkey]["timeInMin"] = $nrDaysPassed ." days ago";   
        				    }
        				}else{
        				        $ROW[$mkey]["timeInMin"] = $nrHours ." hours ago";   
        				    }
                        }else{
        				        $ROW[$mkey]["timeInMin"] = $nrMinutes ." Minutes ago";   
        				    }
                        }
                        else{
					$ROW[$mkey]["timeInMin"] = "1 minute ago";
				}
              }
              /*
				if($timeInMin > 1)
				{
					$ROW[$mkey]["timeInMin"] = $timeInMin ." minutes ago";
				}else{
					$ROW[$mkey]["timeInMin"] = "1 minute ago";
				}
                */

			}
			
		}
		$this->db->num_rows = $nrows;
		return $ROW;
	}

	function returnChartJsFn($actiId,$graphType,$dataOpt)
	{  
		global $objChart;
		$fileName = "data_".$graphType."_".$actiId.".xml";
		switch($graphType)
		{

			case 1:
				$str = "line($actiId,$graphType,$dataOpt)";
			break;
			case 2:
				$str = "pie($actiId,$graphType,$dataOpt)";
			break;
			case 3:
				$str = "barColoumn($actiId,$graphType,$dataOpt,3)";
			break;
			case 4:
				$str = "barColoumn($actiId,$graphType,$dataOpt,4)";
			break;
			case 5:
				//$fileName = "settings_" .$actiId .".xml";
				$str = "timeslide($actiId,$graphType,$dataOpt)";
			break;
			case 6:
			//Number
			//echo $dataOpt ."##";
			$arr = $objChart->numberGraph($actiId,$dataOpt);
			$str = "nameNumberTime('$arr[main_acti_name]','$arr[number]')";
			break;
			
			case 7:
			//Name
			
			$arr = $objChart->nameGraph($actiId,$dataOpt);
			$str = "nameNumberTime('$arr[main_acti_name]','$arr[number]')";
			break;
			case 8:
			//Time
			$arr = $objChart->timeGraph($actiId);
			$str = "nameNumberTime('".$arr['main_acti_name']."','".$arr['number']."')";
			break;
			
		}
		return $str;
	}
    
   
function deleteDashboardValues($currentUserId){    
  $sql_Delete = "DELETE FROM dashboard WHERE user_id= \"$currentUserId\"";
   $this->db->sql_query($sql_Delete);   
}
function selectDashboardValues($currentUserId){
    
  $sql_select = "select activity_id from dashboard where user_id= \"$currentUserId\" group by activity_id order by activity_id ";
  $ROWActiId = $this->db->select($sql_select);
   
    return $ROWActiId;
       
    
}
function UpdateDashboard($dashboardId,$userId,$activityId,$graphid=''){
    
   $sqlUpdateDashboard="UPDATE dashboard SET dashboard_id=\"$dashboardId\",user_id=\"$userId\",activity_id=\"$activityId\",graph_id=\"$graphId\" ";
   $this->db->edit($sqlUpdateDashboard);

    
}
function InsertIntoDashboard($dashboardId,$userId,$activityId,$graphid='',$dashboardId=''){
    
 $sqlInsertDashboard="Insert into dashboard(dashboard_id,user_id,activity_id,graph_id) values(\"$dashboardId\",\"$userId\",\"$activityId\",\"$graphId\") ";//WHERE (activity_id=\"$activityId\" AND user_id=\"$userId\")";
 $this->db->insert($sqlInsertDashboard);

	//removing the history of dashboard
	$sql = "Delete from dashboard_graph_position where userId=\"$userId\" AND dashboard_id=\"$dashboardId\"";
	$ROW = $this->db->select($sql);
   
}

function activityIdfetch($sql_select,$count)
{
 
for ($row = 0; $row < $count; $row++)
{
    
   // $activity_id = Array();
    
    foreach($sql_select[$row] as $key => $value)
    {
      $key[$row]=$value;
    }
  $values[]=$value;
}
return $values;
} 
function returnActiLimit()
	{
		$sql = "SELECT noOfActiForCombo FROM  settings";
		$ROW = $this->db->select($sql);
		return $ROW[0]['noOfActiForCombo'];
	}

	function returnInterval($seconds)
	{
		if ($seconds < 60) {
		// if less than a minute ago use seconds
		$value = $seconds;
		$unit = 'seconds';
		} else if ($seconds < 60 * 60 * 2) {
		// if less than two hours ago, use minutes
		$value = $seconds / 60;
		$units = 'minutes';
		} else if ($seconds < 60 * 60 * 24) {
		// if less than 24 hours ago, use hours
		$value = $seconds / (60 * 60);
		$units = 'hours';
		} else if ($seconds < 60 * 60 * 24 * 7 * 2) {
		// if less than 2 weeks, use days
		$value = $seconds / (60 * 60 * 24);
		$units = 'days';
		} else {
		// use weeks
		$value = $seconds / (60 * 60 * 24 * 7);
		$units = 'weeks';
		}

		$result = floor($value) ." ". $units;
		return $result;
	}

function getDashboardActivityGraph($actId,$ids="")
	{ 
	 if($ids == ""){
		$sql = "SELECT a.*,g.hidden,g.graph_type,g.dataOption,d.id as d_id FROM activities as a inner join graphs g on g.id=a.graph_id,dashboard AS d WHERE (a.user_id=\"$actId\" AND d.activity_id = a.id) order by g.id";
	 }else{

		 $sql = "SELECT a.*,g.hidden,g.graph_type,g.dataOption,d.id as d_id FROM activities as a inner join graphs g on g.id=a.graph_id,dashboard AS d WHERE a.user_id=\"$actId\" AND d.activity_id = a.id AND a.id IN($ids) order by field( a.id, ".$ids.")";

	 }
		$ROW = $this->db->select($sql);
         
		return $ROW;
	}

	function returnActiIdByDataItemId($did)
	{
		$sql = "SELECT item_id from counts WHERE id='$did'";
		$ROW = $this->db->select($sql);
		return $ROW[0]['item_id'];
	}
	function getActivityDashBoard($userId,$searkey="")
	{
		
		if($searkey == ""){
			$sql = "SELECT a.color,a.graph_id,a.id,a.name,a.default_note,a.tags,a.created_on_UTC FROM activities as a  WHERE a.user_id=\"$userId\"  AND a.status=\"unblocked\" AND a.deleted=\"0\"";
			
		}elseif(trim($searkey) != "")
		{
			$searkey =  $this->general->encodequotes($searkey);
			$sql = "SELECT a.color,a.graph_id,a.id,a.name,a.default_note,a.tags,a.created_on_UTC FROM activities as a  WHERE a.user_id=\"$userId\"  AND name LIKE \"%$searkey%\" AND a.status=\"unblocked\" AND a.deleted=\"0\"";
		}
		
		
		$ROW = $this->db->select($sql);
		
		foreach($ROW as $mkey=>$mVal){
			$sqlGraph = "SELECT graph_type,dataOption FROM graphs WHERE id=\"".$ROW[$mkey]["graph_id"]."\"";
			$ROWGRAPH = $this->db->select($sqlGraph);
			$grows = $this->db->num_rows;
			if($grows > 0){
			$fnJs = $this->returnChartJsFn($ROW[$mkey]["id"],$ROWGRAPH[0]['graph_type'],$ROWGRAPH[0]['dataOption']);
			if(strlen($fnJs) > 1){
				if($ROWGRAPH[0]['graph_type'] >5){
					$goal = $ROW[$mkey]['color'];
				}
				$fnJs = substr($fnJs,0,-1);
				
				$ROW[$mkey]["graphJsFn"]="dashboard_" ."$fnJs" .",'$goal','prev_chartContainer');";
				}
			}else{
			$ROW[$mkey]["graphJsFn"]="";
			}
		
		}
		return $ROW;
	}

	function removeFromDashBoard($d_id,$actiId)
	{
		$sql = "DELETE FROM dashboard WHERE id=\"$d_id\"";
		$this->db->sql_query($sql);

		//removing the history of dashboard
		$userId = $_SESSION["tz_user"]["userid"];
		 $sql = "select id from dashboard_graph_position where userId=\"$userId\" AND acti_id=\"$actiId\"";
		$ROW = $this->db->select($sql);
	}

	function saveGraphPostion($ip,$dashboardId,$arrCol1,$arrCol2)
	{
		$userId = $_SESSION["tz_user"]["userid"];
		 $sql = "DELETE FROM dashboard_graph_position WHERE ip=\"$ip\" AND userId=\"$userId\" AND dashboard_id=\"$dashboardId\"";
		$this->db->sql_query($sql);
		foreach($arrCol1 as $i)
		{
			if($i != 0)
			{
				$sql = "Insert into dashboard_graph_position(ip,userId,dashboard_id,acti_id,column_no) values('$ip','$userId','$dashboardId','$i','1')";
				$this->db->insert($sql);
			}
		}

		foreach($arrCol2 as $i)
		{
			if($i != 0)
			{
				$sql = "Insert into dashboard_graph_position(ip,userId,dashboard_id,acti_id,column_no) values('$ip','$userId','$dashboardId','$i','2')";
				$this->db->insert($sql);
			}
		}
	}

	function selectGraphPosition($dashboardId)
	{	$str1 = "";
		$str2 = "";
		$IP = $_SERVER["REMOTE_ADDR"];
		$userId = $_SESSION["tz_user"]["userid"];
		$sql = "select id from dashboard_graph_position where userId=\"$userId\" AND dashboard_id=\"$dashboardId\"";
		 $ROW = $this->db->select($sql);
		 if($this->db->num_rows >0){
			 $sql = "select acti_id from dashboard_graph_position WHERE  userId=\"$userId\" AND dashboard_id=\"$dashboardId\" AND column_no='1' order by id ASC";
			 $ROW = $this->db->select($sql);
			 foreach($ROW as $i){
				if($str1 == "")
				{
					$str1 = $i['acti_id'];
				}else{
					$str1 .= "," .$i['acti_id'];
				}
			 }

			  $sql = "select acti_id from dashboard_graph_position WHERE  userId=\"$userId\" AND dashboard_id=\"$dashboardId\" AND column_no='2' order by id ASC";
			 $ROW = $this->db->select($sql);
			 foreach($ROW as $i){
				if($str2 == "")
				{
					$str2 = $i['acti_id'];
				}else{
					$str2 .= "," .$i['acti_id'];
				}
			 }
			 return $str1 ."###" .$str2;

			return $ROW;
		}else{
			return 0;
		}
	}

	function getSignleActiCount($actiId)
	{
		 $sql = "SELECT  SUM(c.amount) as total,a.name	FROM counts AS c
				INNER JOIN activities AS a ON c.item_id = a.id  WHERE a.id=\"$actiId\"  AND c.deleted=\"0\" AND a.deleted=\"0\" group by a.id";
		$ROW = $this->db->select($sql);
		return $ROW;
	}
} //class end


?>

