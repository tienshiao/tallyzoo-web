<?PHP
/*****************************************************
Page Name: clsDataGrid.php
Purpose: To Build Data Grid
Created By: Ramamohan
Created On: 12/30/2008 10:42 AM
*****************************************************/

class clsDataGrid
{
	function clsDataGrid($db)
	{
		//global $db;
		$this->db=$db;
	}
	function DataGrid($sql='',
		              $pagevariable='',
					  $recs_per_page='',
		              $order='',
		              $orderby='',
		              $cname='',
		              $cdbname='',
		              $cwidth='',
					  $unique_field='',
		              $checkbox='',
		              $buttons='',
		              $tabindex='',
					  $section_name='',
					  $field_names='',
					  $ajx_file='',
					  $cmb_req='1'
	                )
					{
						$perpage = $recs_per_page;
						$section = $section_name;
						$QUERY = $sql;
		
						$rs = $this->db->select($QUERY);
						$numrows = count($rs);	
						$paging = $this->paging($perpage,$numrows,$section,$ajx_file);
						$pagingstr = $paging[0];
						$offset = $paging[1];
						$GRID = $QUERY." ORDER BY $orderby $order LIMIT $offset, $perpage";
						$res = $this->db->select($GRID);
						
						$columns = $cname;
						$cfileds = $field_names;
						$column_width = $cwidth;
						if($checkbox==1)
						{
							$colspan=count($columns)+1;
						}
						else
						{
							$colspan=count($columns);
						}
						
						$startLimit=$offset+1;
						$endlimit=count($res)+$offset;
						$page=$_REQUEST['page'];
						
						$DATA_LIST = "";
						/***************** Hidden Values assigned here *******************/
						
						$DATA_LIST .= "<input type=\"hidden\" id=\"page\" name=\"page\" value=\"".$page."\">";

						$DATA_LIST .= "<input type=\"hidden\" id=\"maxpages\" name=\"maxpages\" value=\"".$paging[2]."\">";
						$DATA_LIST .= "<input type=\"hidden\" id=\"section\" name=\"section\" value=\"".$section."\">";
						$DATA_LIST .= "<input type=\"hidden\" id=\"hidIds\" name=\"hidIds\">";
						$DATA_LIST .= "<input type=\"hidden\" id=\"hidOrder\" name=\"hidOrder\" value=\"".$order."\">";
						$DATA_LIST .= "<input type=\"hidden\" id=\"hidOrderBy\" name=\"hidOrderBy\" value=\"".$orderby."\">";
						
						/***************** Hidden Values assigned here *******************/						
						if($this->db->num_rows > 0)
						{
							if($pagevariable!='enotifi')
							{
								$DATA_LIST .= "<TABLE cellspacing=\"0\" cellpadding=\"0\" align=\"center\" border=\"0\" width=\"100%\">";
								$DATA_LIST .= "<tr class=\"bBr\">";
								$DATA_LIST .= "<td align=\"left\" colspan=\"".$colspan."\">";
								
								$DATA_LIST .= "<div class=\"fL\">Showing ".$startLimit." To ".$endlimit." of ".$numrows."</div>";
								
								$DATA_LIST .= "<div class=\"fR rTx\">";
								if ($cmb_req==1)
								{
									$DATA_LIST .= "<select name=\"Show\" id=\"Show\" onChange=\"getGridData('".$section."','1','".$ajx_file."');\">";
									
									$DATA_LIST .= $this->fnNumRows($recs_per_page);
									$DATA_LIST .= "</select>";
								}
								else
									$DATA_LIST .= "&nbsp;";
								$DATA_LIST .= "</div>";
								$DATA_LIST .= "</td>";
								$DATA_LIST .= "</tr></TABLE>";
							}
							$DATA_LIST .= "<!--startprint--><TABLE id=\"tblChart\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" border=\"0\" width=\"100%\">";
							$DATA_LIST .= "<THEAD><tr class=\"header\">";
							if($checkbox==1)
							{
								$DATA_LIST .= "<td width=\"5%\">&nbsp;";
								//if($pagevariable!='enotifi')
								//{
								$DATA_LIST .="<input type=\"checkbox\" tabindex=\"$tabindex\" name=\"chkCheckAll\" id=\"chkCheckAll\" onClick=\"javascript:fnCheckAll(this);\"  class=\"nBr\">";
								//}
								$DATA_LIST .= "</td>";
							}
							
							for($i=0;$i<count($columns);$i++)
							{
								if($columns[$i]=="Actions")
								{
									if($pagevariable=='tenant')
										{
											$DATA_LIST .= "<td align=\"center\">".ucfirst($columns[$i])."</td>";
										}
										else
										{
											$DATA_LIST .= "<td align=\"center\">".ucfirst($columns[$i])."</td>";
										}
								}
								else
								{
									$DATA_LIST .= "<td alt=\"Sort by ".$columns[$i]."\" title=\"Sort by ".$columns[$i]."\" onClick=\"fnSetOrder('".$cfileds[$i]."','".$section."','".$ajx_file."');\" width=\"".$column_width[$i]."\" align=\"left\" style=\"cursor:pointer;\"><a>".ucfirst($columns[$i])."</a></td>";
								}
							}
							$DATA_LIST .= "</tr></THEAD><TBODY>";

							$color = 0;
							//while($row=$this->db->fn_fetch_array($res))
							for ($i=0; $i<count($res); $i++)
							{
								 if($color == 0)
								 {
									$color = 1;
									$DATA_LIST .= "<tr class=\"even\" onMouseOver=\"this.className='ruled';\" onMouseOut=\"this.className='even';\">";
								 }
								 else if($color == 1)
								 {
									$color = 0;
									$DATA_LIST .= "<tr class=\"odd\" onMouseOver=\"this.className='ruled';\" onMouseOut=\"this.className='odd';\">";
								 }
								if($checkbox==1)
								{
									$DATA_LIST .= "<td>&nbsp;<input type=\"checkbox\" name=\"chkRecord\" id=\"chkRecord[]\" value=\"".$res[$i][$unique_field]."\" onClick=\"javascript:fnSingleCheck(this);\" tabindex=\"".$tabindex."\" class=\"nBr\"></td>";
								}
								
								for($j=0;$j<count($columns);$j++)
								{
									if($columns[$j]=="Actions")
									{
										$DATA_LIST .= "<td align=\"center\">".$res[$i][$j]."</td>";
									}
									else
									{
										
										$DATA_LIST .= "<td align=\"left\">".$this->decodequotes($res[$i][$j])."</td>";
									}
								}
								$DATA_LIST .= "</tr>";
							}
						}
						else
						{
							$DATA_LIST .= "<TABLE cellspacing=\"0\" cellpadding=\"0\" align=\"center\" border=\"0\" width=\"100%\">";
							$DATA_LIST .= "<tr class=\"bBr\">";
							$DATA_LIST .= "<td align=\"left\" colspan=\"".$colspan."\">";
							$DATA_LIST .= "&nbsp;</td>";
							$DATA_LIST .= "</tr></TABLE>";
							
							$DATA_LIST .= "<TABLE id=\"tblChart\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" border=\"0\" width=\"100%\">";

							$DATA_LIST .= "<TBODY><tr><td align=\"center\" colspan=\"".$colspan."\"><strong>". _NO_RECORDS_MSG_."</strong></td></tr>";
						}
						$DATA_LIST .= "</TBODY><!--endprint-->";
						$DATA_LIST .= "<TFOOT>";
						$DATA_LIST .= "<tr class=\"footer\">";
						$DATA_LIST .= "<td align=\"center\" colspan=\"".$colspan."\">&nbsp;".$pagingstr."</td></tr>";
						$DATA_LIST .= "</TFOOT></table>";
						if(count($res) > 0 && $buttons!="")
						{
							if($pagevariable=='requests')
							{
								$DATA_LIST .= "<br><div align=\"left\" class=\"w730\">".$buttons."</div><p class=\"hS2\"></p>";
							}
							else
							{
								$DATA_LIST .= "<br><div align=\"left\" class=\"w730\">".$buttons."</div><p class=\"hS2\"></p>";
							}
						}						
						return $DATA_LIST;
					}
	/*****************************************************
	Function Name: fnNumRows
	Purpose: To set number of rows array.
	Written By: Ramamohan
	Written On: 12/27/2008 09:13 AM
	*****************************************************/
	function fnNumRows($selid="")
	{
		$arrNumRows = array("5" => "5","10" => "10","30" => "30","50" => "50","100" => "100");
		foreach ($arrNumRows as $crd=>$cvalue)
		{
			if($crd == $selid)
				$selected = "SELECTED";
			else 
				$selected = '';
				
			$str.="<OPTION value=".$crd." $selected>".$cvalue."</OPTION>";
		}
		return $str;
	}

	/*****************************************************
	Function Name: paging
	Purpose: To set paging.
	Written By: Ramamohan
	Written On: 12/26/2008 2:13 PM
	*****************************************************/
	function paging($rowsperpage,$numrows,$section='',$ajx_file='')
	{
		$rowsPerPage = $rowsperpage;
		$pageNum = 1;
		if(isset($_POST['page']) && $_POST['page']!="" )
		{
			$pageNum = $_POST['page'];
		}
		$offset = ($pageNum - 1) * $rowsPerPage;
		$maxPage = ceil($numrows/$rowsPerPage);
		$self = $_SERVER['PHP_SELF'];
		$mid=$_POST['page'];
		
		$start=$mid-10;
		$end=$mid+10;
		if($start<1)
		{
			$start=1;
			if($maxPage>10)
				$end=10;
			else
				$end=$maxPage;
		}
		if($end>$maxPage)
		{
			$start=$maxPage-10;
			$end=$maxPage;
		}
		for($m=$start;$m<=$end;$m++)
		{
			if($pageNum==$m)
			{
				$pages.= "<span class=\"footer_active\">".$m."</span>&nbsp;";  
			}
			else
			{
				$pages.="<a href=\"javascript:getGridData('".$section."','".$m."','".$ajx_file."');\">".$m."</a>&nbsp;";
			} 
		}
		if ($pageNum > 1)
		{
			$page = $pageNum - 1;
			$prev = "<a href=\"javascript:getGridData('".$section."','1','".$ajx_file."');\"><<</a>&nbsp;&nbsp;&nbsp;<a href=\"javascript:getGridData('".$section."','".$page."','".$ajx_file."');\">Prev</a> ";
		} 
		if ($pageNum < $maxPage)
		{
			$page = $pageNum + 1;

			$next = " <a href=\"javascript:getGridData('".$section."','".$page."','".$ajx_file."');\">Next</a>&nbsp;&nbsp;&nbsp;<a href=\"javascript:getGridData('".$section."','".$maxPage."','".$ajx_file."');\">>></a>";
		} 
		if($numrows!=0 && $maxPage >1)
		{
			$tplstring = "<span>".$prev."</span>&nbsp;&nbsp;";
			$tplstring .= "<span>".$pages."</span>&nbsp;&nbsp;";
			$tplstring .= "<span>".$next."</span>";
		}
		$Arraypagevar =  array($tplstring,$offset,$maxPage);
		return $Arraypagevar;
	}

	/***********************************************************
	Function Name: decodequotes
	Purpose: To add quotes instead of slashes.
	Written By: Ramamohan
	Written On: 12/31/2008 01:40 PM
	*************************************************************/
	function decodequotes($str)
	{
		$singlequotestr=str_replace("''","'",$str);
		$repdoublequotestr=str_replace('&quot;','"',$singlequotestr);
		$repbackslashquotestr=stripslashes($repdoublequotestr);
		return $repbackslashquotestr;
	}

				
}
?>