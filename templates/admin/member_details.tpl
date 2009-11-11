{$SUBMENU}
<form id="frm" name="frm" method="post">
	<p class="w890 mm h2">&nbsp;</p>
	<p class="hS2"><i></i></p>
	<div class="w890 mm" id="ttl">
		<div class="fL w240">
			<label class="font_brown">Member Details</label>
		</div>
		<div>
			{$MANDATORY}
		</div>
	</div>  
	<p class="h20"><i></i></p>
	<div id="staticpage" class="w890 mm bAllGry">
	<fieldset class="fL w880">	
		<div class="clFx">
			<div class="fL w240"><label id="lblTitle">Username</label></div>
			<div>{$ROW[0].username}</div>
		</div>
		<p class="hS1"><i></i></p>
		<div class="clFx">
			<div class="fL w240"><label id="lblTitle">E-mail Id</label></div>
			<div>{$ROW[0].email}</div>
		</div>
		<p class="hS1"><i></i></p>
		<div class="clFx">
			<div class="fL w240"><label id="lblTitle">About me</label></div>
			<div>{$ROW[0].about}</div>
		</div>
		<p class="hS1"><i></i></p>
		<div class="clFx">
			<div class="fL w240"><label id="lblTitle">Date Registered</label></div>
			<div>{$ROW[0].created_on}</div>
		</div>
		<p class="hS1"><i></i></p>
		<div class="clFx">
			<div class="fL w240"><label id="lblTitle">Photo</label></div>
			<div>-</div>
		</div>
		<p class="hS1"><i></i></p>
		<div class="clFx">
			<div class="fL w240"><label id="lblTitle">TimeZone</label></div>
			<div>{$ROW[0].timezone}</div>
		</div>
		<p class="hS1"><i></i></p>
		<div class="clFx">
			<div class="fL w240"><label id="lblTitle">Total Activity</label></div>
			<div><a href="admin.php?mod=member_activity_details&act=mad&mid={$ROW[0].id}">{$ROW[0].totAct}</a></div>
		</div>
		</fieldset>
	</div>
</form>