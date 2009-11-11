<? session_start();
	include_once '../system/configme/siteconfig.php'; // include configuration file here	
	$path = str_replace("user/","",CLASS_PATH);
	include_once $path .'dbclass.php'; // database class include here	
	include_once $path .'user.cls.php'; // this is general class  include here	
	include_once$path.'general.cls.php';
	require_once($path."/timezone/Date.php");
	require_once($path."clsManageImages.php");
	require_once($path.'chart.cls.php');
	$objImage = new clsManageImages();
	$dbObj = new dbclass(); // db object
	$objGeneral = new general($dbObj);
	$objUser = new user();
	$objChart = new chart('../');
	$case = $_GET['case'];

	switch($case){
	  case 1:
		  //Login case
		$Login=$objUser->fnUserLogin($_REQUEST['txtUName'],$_REQUEST['txtPass']);
		if($Login)
		{  
			//header("Location:../index.php?mod=viewProfile");
		?>
		<script language='javascript'>
		window.parent.location.href="../index.php?mod=viewProfile";
		</script>
		<?
		}
		else
		{
			 $err_msg = "Invalid username or Password.";
			
		}
		?>
	<script language='javascript'>
		window.parent.document.getElementById('mid_body').innerHTML = "<?=$err_msg?>";
	</script>
	<?
	break;
	case 2:
		//Forgot case
		$result=$objUser->fnforgotPassword($_REQUEST['txtUName'],$_REQUEST['txtPass']);
		if($result)
		{
			$err_msg = "Password Sent Successfully.";
			
		}
		else
		{
			 $err_msg = "Invalid email address.";			
		}
	?>
	<script language='javascript'>
		window.parent.document.getElementById('mid_body').innerHTML = "<?=$err_msg?>";
	</script>
	<?
	break;
	case 3:
		//registration case
		if(!$objUser->fnCreateUser())
		{
			$err_msg = "Username already exists.";
			
		}else{
			$err_msg = "You have been registered successfully.";
		}

	?>
	<script language='javascript'>
		window.parent.document.getElementById('mid_body').innerHTML = "<?=$err_msg?>";
	</script>
	<?
	break;

	case 4:
		//Add/Edit Acitvity case
		require_once($path."activity.cls.php");
		$objActivity = new activity();
		if($_POST['ACT'] == "ADD")
		{
			 $flag = $objActivity->addAcitivity($_SESSION["tz_user"]["userid"]);
			 
			if($flag == 0)
			{
				$err_msg = "Acitivity name already exists.";
				}else{
				$err_msg = "Your activity has been added successfully.";
				//header("Location: index.php?mod=myActivity&msg=1");
			}
			
		}
		if($_POST['ACT'] == "UPDATE")
		{
			 $flag = $objActivity->updateAcitivity($_POST["editId"],$_SESSION["tz_user"]["userid"]);
			if($flag == 0)
			{
				$err_msg = "Acitivity name already exists.";
				//header("Location: index.php?mod=myActivity&msg=2");
			}else{
				$err_msg = "Your activity has been updated successfully.";
			}
		}
		if($_POST["save"] == "Save")
			{
			?>
			<script language='javascript'>
				var flag = '<?=$flag?>';
				alert("<?=$err_msg?>");
				if(flag != 0)
				{
					top.fnHdnPopup('');
					if(parent.document.getElementById('tabactive'))
					{
						//no need to refresh page
						window.parent.document.location.href = window.parent.document.location.href;
					}else{ 
						parent.document.activity.submit();
					}
				}
			</script>
			<?
			}else{
			?>
			<script language='javascript'>
				alert("<?=$err_msg?>");
				top.fnPopupDiv('900', '100', '30', '40', 'addActivity', 'ADD','');
			</script>
			<?
			}
	break;
	case 5:
		//add Count from view activity page case
		require_once($path."activity.cls.php");
		$objActivity = new activity();
		$objActivity->addCount();
		if($_POST["cmbActivity"] != "")
		{
			$actiId = $_POST["cmbActivity"];
		}else{
			$actiId = $editId;
		}
		$ROW = $objActivity->getActivity($actiId);
		$err_msg = "Added " . $txtCount . " to ".$ROW["name"].".";
		
		//Here i used edit it becaus it is id of main category
		$ROW = $objActivity->getActivity($editId);
		$fn = $objActivity->returnChartJsFn($editId,$ROW['graph_type'],$ROW['dataOption']);
		if($fn != ""){
			$funload = "top." .$fn .";";
			$fn  = "prev_" .$fn;
		}
		?>
		<script language='javascript'>
			lengendShowHid = 1;
			window.parent.document.getElementById('mid_body').innerHTML = "<div><span class=\"error_div\"><?=$err_msg?><\span></div>";
			top.subActiMyDataForIframe('<?=$actiId?>');
			<?=$funload?>
			window.parent.document.frmView.txtCount.value = "#";
			window.parent.document.frmView.txtDateQuick.value = "";
			window.parent.document.getElementById("edit_link").href="javascript:fnPopupDiv('900','250','40','40','addActivity','EDIT','<?=$editId?>');<?=$fn?>";
		  </script>
		<?
	break;
	case 6:
		//get count data for mydata page
		$ACT = $_POST['ACT'];
		require_once($path."activity.cls.php");
		$objActivity = new activity();
		$actiId = $_POST['actiId'];
		if($ACT == "edit"){ 
			 echo $objActivity->getDataItem($_POST["id"]);
		}
		elseif($ACT == "save"){
			 $objActivity->updateCount($_POST["id"]);
			 $ROW = $objActivity->getActivity($actiId);
			$fn = $objActivity->returnChartJsFn($actiId,$ROW['graph_type'],$ROW['dataOption']);
			if($fn != ""){
				echo "lengendShowHid = 1;";
				echo $fn .";";
				
			}
			
		}elseif($ACT =="saveQuick")
		{
			
			echo $objActivity->quickAddCount();

			
		}
		
		

	break;

	case 7:
		//For dashboard actilist save
	require_once($path."activity.cls.php");
	$objActivity = new activity();
	$id= explode(",",$_POST["activityIds"]);
	$currentUserId = $_SESSION["tz_user"]["userid"];
	$id_count=count($id);
		$objActivity->deleteDashboardValues($currentUserId);
			while (list($key,$val) = @each ($id)) {
				$objActivity->insertintoDashboard('1',$currentUserId,$val,'',1);
			 } 
			$err_msg = "Your dashboard updated successfully.";
	 ?>
	 <script language="javascript"> 
		 window.parent.document.getElementById('mid_body').style.display= "";
		 alert("<?=$err_msg?>");
		 window.parent.document.location.href = window.parent.document.location.href;
	</script>
	 <?
	
	break;
	case 8:
		//add Count from view myactivity page case
		require_once($path."activity.cls.php");
		$objActivity = new activity();
		$actiId = $_POST['editId'];
		$objActivity->addCount();
		$ROW = $objActivity->getSignleActiCount($actiId);
		$cntTotal= round($ROW[0]['total'],2);
		$actiName = $ROW[0]['name'];
		$cnt = $_POST['txtCount'];
		echo "<b>Counted $cnt to $actiName###" . $cntTotal ."</b>";
	
	break;
	case 9:
		//add activitity from myactivity page
		require_once($path."activity.cls.php");
		 $objActivity = new activity();
  	     echo $flag = $objActivity->addAcitivity($_SESSION["tz_user"]["userid"]);
	
	}
	
?>