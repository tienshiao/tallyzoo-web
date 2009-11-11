<iframe id="selectblocker" style="display:none;position:absolute;z-index:100;filter: alpha(opacity=60);" src="" frameborder="0" scrolling="no"></iframe>
<div id="popup_container"></div>
<div id="maskdiv" class="divMask">&nbsp;</div>
{$SUBMENU}
<form id="frmPost" name="frmPost" method="post">
<input type="hidden" name="mod" value="">
<input type="hidden" name="act" value="">
<input type='hidden' name='mid' id="mid" value="{$ActID}">
<p class="w890 mm h05">&nbsp;</p>
<div class="mm dispN" id="err_msg_list"></div>
<p class="hS2"><i></i></p>		
<div class="w890 mm">
	<label class="font_brown">User Activity Details</label>
</div>
<div class="w890 mm" id="activity_grid">
	<!-- Dategrid starts from here -->
	{$DATAGRID}
	<!-- Dategrid ends here -->
</div>
</form>