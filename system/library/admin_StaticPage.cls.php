<?PHP
/*****************************************************
Page Name: clsDataGrid.php
Purpose: To Build Static Page
Created By: Mahesh L
Created On: 12/30/2008 10:42 AM
*****************************************************/

class Staticpage
{
	// Constructor of class ********************************************************************************/	
	function StaticPage($db)
	{
		global $objGeneral;	
		$this->db = $db;
		$this->objGeneral = $objGeneral;
		$this->tblname="descriptions";
	}
	// Declare varriables **********************************************************************************/
    function Populate()
	{
		$this->pageid=$_POST['staticid'];
		$this->title=$this->objGeneral->encodequotes($_POST['txtTitle']);
		$this->description=$this->objGeneral->encodequotes($_POST['txaDesc']);
		if($_POST['chkActive']=='on')
			$this->status='active';
		else
			$this->status='inactive';

		$this->usertype=$_POST['rd1'];
		$this->adminTypeId=$_SESSION['s_admin_id'];
	}
	// Add Pages *******************************************************************************************/
	function fnUpdatePages($id)
	{
		if($this->fnPageExist($id))
		 {	
			$Sql="UPDATE $this->tblname SET fldTitle='".$this->title."', fldDescription='".$this->description."',fldStatus='".$this->status."',fldUserTypeId='".$this->usertype."',fldAddedById='".$this->adminTypeId."',fldLastUpdatedOn=NOW() WHERE fldStaticPageId='".$this->pageid."'";
			$this->db->Query($Sql);
			return 1;
		 }
		 else
		 {
			 $Sql="INSERT INTO $this->tblname (fldTitle,fldDescription,fldStaticPageId,fldStatus,fldUserTypeId,fldAddedOn) VALUES ('".$this->title."','".$this->description."','".$this->pageid."','".$this->status."','".$this->usertype."',NOW())";
			 $this->db->fn_execute_sql($Sql);
			return 2;
		 }
	}	
	// Page already Exist **************************************************************************************/
	function fnPageExist($id)
	{
		 $Sql="SELECT fldStaticPageId FROM $this->tblname WHERE fldStaticPageId='".$this->pageid."' AND fldIsDelete='no'";
		 $result=$this->db->select($Sql);
		 if(count($result)>0)
			 return true;
		 else
			return false;
	}
	// Get All Values ******************************************************************************************/
	function fnGetAlldesc($id,$uid)
	{	
		if(!empty($id))
		{
			 $Sql="SELECT * FROM $this->tblname WHERE fldStaticPageId='".$id."' AND fldUserTypeId='".$uid."' AND fldIsDelete='no'";
		 //exit;
		 $result=$this->db->select($Sql);
		 if(count($result)>0)
			  $row=$result;
		}
		 return $row;
	}
		
	function fnGetAll($id)
	{	
		if(!empty($id))
		{
			 $Sql="SELECT * FROM $this->tblname WHERE fldStaticPageId='".$id."' AND fldIsDelete='no'";
		 //exit;
		 $result=$this->db->select($Sql);
		 if(count($result)>0)
			  $row=$result;
		}
		 return $row;
	}

	// Delete static Pages *************************************************************************************/
	function fnDelete($id)
	{
		 $id_arr=split("," ,$id);
		 for($i=0; $i<count($id_arr) ; $i++) 
		 {
			$ids=$id_arr[$i];
			$query="UPDATE $this->tblname SET fldIsDelete='yes' WHERE fldDescriptionId='".$ids."'";
			$this->db->Query($query);	
		 }
	}
	// Active/Inactive  ****************************************************************************************/
	function fnStatus($id)
	{
		 $id_arr=split("," ,$id);

		 for($i=0; $i<count($id_arr) ; $i++) 
		 {
			$ids=$id_arr[$i];
			$Sql="SELECT IF(fldStatus='active','inactive','active') as fldStatus FROM $this->tblname WHERE fldDescriptionId='".$ids."'";
			 $result=$this->db->select($Sql);
			 if(count($result)>0)
				  $row=$result;

			$query="UPDATE $this->tblname SET fldStatus='".$row[0]['fldStatus']."' WHERE fldDescriptionId='".$ids."'";
		
			$this->db->Query($query);
		 }
	}
} 
?>