<form id="frmpopup" name="frmpopup" method="post">
	<iframe id="selectblocker" style="display:none;position:absolute;z-index:100;filter: alpha(opacity=60);" src="" frameborder="0" scrolling="no"></iframe>
		<div id="popup_container"></div>
		<div id="maskdiv" class="divMask">&nbsp;</div>
	</form>
	<form id="frmPost" name="frmPost" method="post">	
	{$SUBMENU}
	<p class="w890 mm h2">&nbsp;</p>
	{if $msg neq ''}
		<center><span class='txtInfo'>{$msg}</span></center>
	{/if}
	<div class="mm dispN" id="err_msg_list"></div>
	  <p class="hS2"><i></i></p>
		<div class="w890 mm" id="ttl">
			<div class="fL w240">
				<label class="font_brown">Edit Settings</label>
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
					<label id="lblTitle">Admin Email Address</label><span class="txtInfo">*</span>
				</div>
				<div>
					<input type="text" name='txtAdminEmailAddress' id='txtAdminEmailAddress' class="w270" value="{$ROW[0].adimEmailAddress}"   />
				</div>
			</div>
			<p class="hS1"><i></i></p>
			<div class="clFx">
				<div class="fL w240">
					<label id="lblFname">Site Title</label>
				</div>
				<div>
					<input type="text" name='txtSiteTitle' class="w270" value="{$ROW[0].siteTitle}"   />
				</div>
			</div>
			<p class="hS1"><i></i></p>
			<div class="clFx">
				<div class="fL w240">
					<label id="lblFname">Meta Keywords</label>
				</div>
				<div>
					<input type="text" name='txtMetaKeywords' class="w270" value="{$ROW[0].metaKeyWords}"   />
				</div>
			</div>
			<p class="hS1"><i></i></p>
			<div class="clFx">
				<div class="fL w240">
					<label id="lblFname">Meta Description</label>
				</div>
				<div>
					<textarea name='txtMetaDesc' class="w270">{$ROW[0].metaDescription}</textarea>
				</div>
			</div>
			<p class="hS1"><i></i></p>
			<div class="clFx">
				<div class="fL w240">
					<label id="lblFname">Free Version</label>
				</div>
				<div>
					<input type="text" name='txtVersion'  class="w30" value="{$ROW[0].freeVersion}"   maxlength="4"/>
				</div>
			</div>
			<p class="hS1"><i></i></p>
			<div class="clFx">
				<div class="fL w240">
					<label id="lblFname">No. of Charts For Free Member</label>
				</div>
				<div>
					<input type="text" name='txtNoChartsForFree' class="w30" value="{$ROW[0].noOfChartsForFree}"  maxlength="4" />
				</div>
			</div>
			<p class="hS1"><i></i></p>
			<div class="clFx">
				<div class="fL w240">
					<label id="lblFname">No. of Charts For Premium Member</label>
				</div>
				<div>
					<input type="text" name='txtNoChartsForPremium' class="w30" value="{$ROW[0].noOfChartsForPremium}"  maxlength="4" />
				</div>
			</div>
			<p class="hS1"><i></i></p>
			<div class="clFx">
				<div class="fL w240">
					<label id="lblFname">No. of  Dashboards  For Free Member</label>
				</div>
				<div>
					<input type="text" name='txtNoOfDashBoardForFree' class="w30" value="{$ROW[0].noOfDashBoardForFree}" maxlength="4"  />
				</div>
			</div>
			<p class="hS1"><i></i></p>
			<div class="clFx">
				<div class="fL w240">
					<label id="lblFname">No. of  Dashboards  For Premium Member</label>
				</div>
				<div>
					<input type="text" name='txtNoOfDashBoardForPremium' class="w30" value="{$ROW[0].noOfDashBoardForPremium}" maxlength="4"  />
				</div>
			</div>
			<p class="hS1"><i></i></p>
			<div class="clFx">
				<div class="fL w240">
					<label id="lblFname">No. of Records Per Page</label>
				</div>
				<div>
					<input type="text" name='txtNoOfRecordsPerPage' class="w30" value="{$ROW[0].noOfRecordPerPage}"  maxlength="4" />
				</div>
			</div>
			<p class="hS1"><i></i></p>
			<div class="clFx">
				<div class="fL w240">
					<label id="lblFname">No. of Pages for a List</label>
				</div>
				<div>
					<input type="text" name='txtOfPagesList' class="w30" value="{$ROW[0].noOfPagesPerList}"  maxlength="4" />
				</div>
			</div>
			<p class="hS1"><i></i></p>
			<div class="clFx">
				<div class="fL w240">
					<label id="lblFname">No. of Activity for a Combo</label>
				</div>
				<div>
					<input type="text" name='txtNoOfActiForCombo' class="w30" value="{$ROW[0].noOfActiForCombo}"  maxlength="4" />
				</div>
			</div>
			
			
			<p class="hS1"><i></i></p>
			<div class="clFx">
				<div class="mm w400">
					<input type='hidden' name='pgaction'>
					<input  class="btnSty" type="button" name="Save" value="Save" alt="Save" title="Save" onclick="ShowProgress('fnSaveSetting');"/>
					<input  class="btnSty" type="reset" name="Reset" value="Reset" alt="Reset" title="Reset" onClick="fnreset();"/>
					
					
				</div>
			</div>
			</fieldset>
		</div>
	</form>