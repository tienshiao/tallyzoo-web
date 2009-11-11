<?PHP?>
<script>
	var oEditor = window.opener.FCKeditorAPI.GetInstance('txaDesc') ;
	document.write(window.opener.document.getElementById("txtTitle").value);
	document.write("<br>");
	document.write(oEditor.GetXHTML( true ));
</script>
<div id="prev"></div>