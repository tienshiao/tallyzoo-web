<? 
	$id = $_REQUEST["descId"];
	 $sql = "SELECT fldTitle,fldDescription FROM descriptions WHERE fldDescriptionId=\"$id\"";
	$ROW = $dbObj->select($sql);
	
	$pageTitle = $ROW[0]["fldTitle"];
	$content = $ROW[0]["fldDescription"];
	$middle = "content.tpl";
	$smarty->assign("PAEGTITLE",$pageTitle);
	$smarty->assign("CONTENT",$content);
?>