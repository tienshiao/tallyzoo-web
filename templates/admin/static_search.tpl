{literal}
<script language="javascript">
function fnedit(id)
{
 document.frmPost.action="admin.php";
 document.frmPost.staticid.value=id;
 document.frmPost.act.value='';
 document.frmPost.pgaction.value='editview'; 
 document.frmPost.mod.value='static_page';
 document.frmPost.submit();
}
</script>
{/literal}

<form id="frm" name="frm" method="post">
{$SUBMENU}
</form>
<form id="frmPost" name="frmPost" method="post">
<input type="hidden" name="mod" value="">
<input type="hidden" name="act" value="">
<p class="w890 mm h05">&nbsp;</p>
<div class="mm dispN" id="err_msg_list"></div>
<p class="hS4"><i></i></p>
<div class="w890 mm">
<label class="font_brown">Static Pages List</label>
</div>
<div class="w890 mm" id="static_grid">
{ if $err_msg neq ''}
	<div class="err_list mm w355" id="err_msg_list">&nbsp;&nbsp;&nbsp;&nbsp;{$err_msg}</div>
	<p class="hS2"><i></i></p>
{ /if }
<!-- Dategrid starts from here -->
{$DATAGRID}
<!-- Dategrid ends here -->
</div>
<input type='hidden' name='pgaction' id="pgaction">
<input type='hidden' name='staticid' id="staticid">
</form>