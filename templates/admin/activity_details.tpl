<div class="popup_box">
	<div class="pad_rgt5">
		<img src="{$SITEURL}images/admin/close.gif" alt="Close" class="popup_close"  onclick="fnHdnPopup('');" />
	</div>
	<p class="hS5">&nbsp;</p>
<div id="staticpage" class="w400 mm bAllGry">
	<fieldset class="fL w390">	
		<div class="clFx">
			<div class="fL w140"><label id="lblTitle">Name</label></div>
			<div>{$ROW[0].name}</div>
		</div>
		<p class="hS1"><i></i></p>
		<div class="clFx">
			<div class="fL w140"><label id="lblTitle">Note</label></div>
			<div>{$ROW[0].default_note}</div>
		</div>
		<p class="hS1"><i></i></p>
		<div class="clFx">
			<div class="fL w140"><label id="lblTitle">Tags</label></div>
			<div>{$ROW[0].tags}</div>
		</div>
		<p class="hS1"><i></i></p>
		<div class="clFx">
			<div class="fL w140"><label id="lblTitle">About</label></div>
			<div>{$ROW[0].tags}</div>
		</div>				
		<p class="hS1"><i></i></p>
		<div class="clFx">
			<div class="fL w140"><label id="lblTitle">Total Counts</label></div>
			<div>{$ROW[0].totDf}</div>
		</div>
	</fieldset>
</div>
</div>