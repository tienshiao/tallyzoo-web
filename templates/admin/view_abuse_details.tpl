<div class="popup_box">
	<div class="pad_rgt5">
		<img src="{$SITEURL}images/admin/close.gif" alt="Close" class="popup_close"  onclick="fnHdnPopup('');" />
	</div>
	<p class="hS5">&nbsp;</p>
<div id="staticpage" class="w400 mm bAllGry">
	<fieldset class="fL w390">	
		<div class="clFx">
			<div class="fL w140"><label id="lblTitle">URL</label></div>
			<div>{$ROW[0].url}</div>
		</div>
		<p class="hS1"><i></i></p>
		<div class="clFx">
			<div class="fL w140"><label id="lblTitle">Reason</label></div>
			<div>{$ROW[0].reason}</div>
		</div>
		<p class="hS1"><i></i></p>
		<div class="clFx">
			<div class="fL w140"><label id="lblTitle">Details</label></div>
			<div>{$ROW[0].details}</div>
		</div>
		<p class="hS1"><i></i></p>
		<div class="clFx">
			<div class="fL w140"><label id="lblTitle">Email id</label></div>
			<div>{$ROW[0].email_id}</div>
		</div>				
		<p class="hS1"><i></i></p>
		<div class="clFx">
			<div class="fL w140"><label id="lblTitle">Date Reported</label></div>
			<div>{$ROW[0].date_reported}</div>
		</div>
	</fieldset>
</div>
</div>