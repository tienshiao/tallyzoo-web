<?php
class Pager
{
	public $toatalPages;
	function findStart($limit,$pageno){
		
		if ($pageno==""){
			$start = 0;
			$pageno = 1;
		}
		else{
			$start = ($pageno-1) * $limit;
		}
		return $start;
	}

	function getPageLimit($numrows,$rowsperpage,$pageNum){

		$rowsPerPage = $rowsperpage;
		$offset = $this->findStart($pageNum,$rowsPerPage);
		$this->toatalPages = $maxPage = ceil($numrows/$rowsPerPage);
		$mid	=	$pageNum;

		$start	=	$mid-2;
		$end	=	$mid+2;

		if($start<1)
		{
			$start	=	1;
			if($maxPage>4)
				$end	=	4;
			else
				$end	=	$maxPage;
		}
		if($end>$maxPage)
		{
			$start=$maxPage-4;
			$end=$maxPage;
		}

		if($start<1) {
			$start	=	1;
		}

		for($m=$start;$m<=$end;$m++)
		{
			if($pageNum==$m)
			{
				$pages.= "<span class=\"cRed\"><b>".$m."</b></span>&nbsp;";  
			}
			else
			{
				$pages.="<a href=\"javascript:showpagingresult('$m','$rowsPerPage');\" class=\"pagelist\">".$m."</a>  ";
			} 
		}
		if ($pageNum > 1)
		{
			$page = $pageNum - 1;
			$prev = "<a href=\"javascript:showpagingresult('1','$rowsPerPage');\"  title=\"First\" class=\"pagelist\"><<</a>&nbsp;<a href=\"javascript:showpagingresult('$page','$rowsPerPage');\" class=\"pagelist\">Prev</a> ";
		}
		if ($pageNum < $maxPage)
		{
			$page = $pageNum + 1;

			$next = " <a href=\"javascript:showpagingresult('$page','$rowsPerPage');\" class=\"pagelist\">Next</a>&nbsp;<a href=\"javascript:showpagingresult('$maxPage','$rowsPerPage');\" title=\"Last\" class=\"pagelist\">>></a>";
		} 
		if($numrows!=0 && $maxPage >1)
		{
			$tplstring2= "".$prev.$pages.$next."";
		}else {
			$tplstring2= "&nbsp;";
		}
		$this->varpageList =  $tplstring2;
	}
}

?>
