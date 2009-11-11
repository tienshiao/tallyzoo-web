	<form id="frmpopup" name="frmpopup" method="post">
	<iframe id="selectblocker" style="display:none;position:absolute;z-index:100;filter: alpha(opacity=60);" src="" frameborder="0" scrolling="no"></iframe>
		<div id="popup_container"></div>
		<div id="maskdiv" class="divMask">&nbsp;</div>
	</form>
	{$SUBMENU}
	<form id="frmPost" name="frmPost" method="post">
	<input type="hidden" name="mod" value="">
	<p class="w890 mm h2">&nbsp;</p>
	<div class="mm dispN" id="err_msg_list"></div>
	  <p class="hS2"><i></i></p>
		<div class="w890 mm" id="ttl">
			<div class="fL w240">
				<label class="font_brown">Edit Static Page</label>
			</div>
			<div>
				{$MANDATORY}
			</div>
		</div>  
		<p class="h20"><i></i></p>
		<div id="staticpage" class="w890 mm bAllGry">
		<fieldset class="fL w880">	
			<div class="clFx">
				<div class="fL w240">
					<label id="lblTitle">Page</label><span class="txtInfo">*</span>
				</div>
				<div>{$STATICPAGEDROPDOWN}
					<!--<select name="selpage" id="selpage" class="w270" onChange="javascript: fnShowContent();">					
				   </select>-->
				</div>
			</div>
			<p class="hS1"><i></i></p>
			<div class="clFx">
				<div class="fL w240">
					<label id="lblFname">Title</label>
				</div>
				<div>
					<input type="text" value="{$TITLE}" class="w270" name="txtTitle" id="txtTitle" maxlength="100" />
				</div>
			</div>
			<p class="hS1"><i></i></p>
			<div class="clFx">
				<div class="fL w240">
					<label id="lblLoginName">Content</label><span class="txtInfo">*</span>
				</div>
				<div>
					{$DESC_TEXTAREA}
					<textarea name="txahdncontent" id="txahdncontent" style="visibility:hidden;width:0px;height:0px;"></textarea>
				</div>
			</div>
			<p class="hS1"><i></i></p>
			<div class="clFx">
				<div class="fL w240">
					<label id="Label1">Active</label>
				</div>
				<div>
					<input type="checkbox" name="chkActive" id="chkActive" class="nBr" 
					{if $STATUS eq 'active' || $STATUS eq '' } CHECKED {/if}/>
				</div>
			</div>
			<p class="hS1"><i></i></p>
			<div class="clFx">
				<div class="mm w400">
					<input type='hidden' name='pgaction'>
					<input type='hidden' name='staticid' value={$staticid}>
					<input  class="btnSty" type="button" name="Save" value="Save" alt="Save" title="Save" onclick="ShowProgress('fnSave');"/>
					<input  class="btnSty" type="reset" name="Reset" value="Reset" alt="Reset" title="Reset" onClick="fnreset();"/>
					<!-- onClick="fnSave();" -->
					<input  class="btnSty" type="reset"  name="Cancel" value="Cancel"  alt="Cancel" title="Cancel" onClick="fncancel();"/>&nbsp;
					<input  class="btnSty" type="button" name="Preview" value="Preview"  alt="Preview" title="Preview" onclick="fnPreview();" />
				</div>
			</div>
			</fieldset>
		</div>
		</form>