<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>{$SITENAME}</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<link rel="stylesheet" href="{$SITEURL}style/admin/mpp.css" type="text/css" />
		<script type="text/javascript" language="javascript" src="{$SITEURL}scripts/common/declaration.js"></script>
		<script type="text/javascript" language="javascript" src="{$SITEURL}scripts/common/messages.js"></script>
		<script type="text/javascript" language="javascript" src="{$SITEURL}scripts/common/prototype.js"></script>
		<script type="text/javascript" language="javascript" src="{$SITEURL}scripts/admin/desc_mang_add.js"></script>
	</head>
	<body id="thispage" onLoad="setAdminMenuActive('c');{$ONLOAD}"ondblclick="return false;">
		<form id="frmpopup" name="frmpopup" method="post">
		<iframe id="selectblocker" style="display:none;position:absolute;z-index:100;filter: alpha(opacity=60);" src="" frameborder="0" scrolling="no"></iframe>
			<div id="popup_container"></div>
			<div id="maskdiv" class="divMask">&nbsp;</div>
		</form>
		<form id="frm" name="frm" method="post">
		{include file="../templates/admin/header.tpl"}
		{$SUBMENU}
<!-- 		<form id="frmPost" name="frmPost" > -->
<input type="hidden" id="hdnUType1" name="hdnUType1">
		<p class="w890 mm h5">&nbsp;</p>
		<div class="mm dispN" id="err_msg_list"></div>
		  <p class="hS2"><i></i></p>
			<div class="w890 mm" id="ttl">
				<div class="fL w240">
					<label class="font_brown">Add/Edit Description</label>
					</div>
				<div>
					<span class="fR">[<label><a href="admin/search_desc_mang.php">&nbsp;<strong>Search</strong>&nbsp;</a></label>]</span>
				</div>
			  </div> 
			  <p class="hS2"><i></i></p>
				<div>
					{$MANDATORY}
				</div>
		    <p class="hS5"><i></i></p>
			<p class="h5"><i></i></p>
			<div id="staticpage" class="w890 mm bAllGry">
			<fieldset class="mm w870">	
			<div class="clFx">
					<div class="fL w240">
						<label id="lblFname">User Type</label>
					</div>
					<div>
					<input type="hidden" name="uTp" id="uTp">
						<input type="radio" name="rd1" id="rd1" class="nBr" value="3" onclick="fnsetVal(this);" {if $USERTYPE eq '3' || $USERTYPE eq '0' ||  $USERTYPE eq ''}checked{/if} />&nbsp;Landlord&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="radio" name="rd1" id="rd1"  class="nBr" value="4" onclick="fnsetVal(this);" {if $USERTYPE eq '4'	}checked{/if}/> &nbsp;Tenant&nbsp;&nbsp;
						</div>
				</div>
				<p class="hS1"><i></i></p>
				<div class="clFx">
					<div class="fL w240">
						<label id="lblTitle">Page</label><span class="txtInfo">*</span>
					</div>
					<div>
							<span id="userllortt">
								<select name="selpage" id="selpage" class="w270" onChange="javascript: fnShowContent();">
								{$STATICPAGEDROPDOWN}
								</select>
						   </span>
					   </div>
				</div>
				
				<p class="hS1"><i></i></p>
				<div class="clFx">
					<div class="fL w240">
						<label id="lblLoginName">Description</label><span class="txtInfo">*</span>
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
						<input type="checkbox" name="chkActive" id="chkActive" class="nBr" {if $STATUS eq 'active' || $STATUS eq ''} CHECKED {/if}/>
					</div>
				</div>
				<p class="hS1"><i></i></p>
				<div class="clFx">
					<div class="mm w400">
						<input type='hidden' name='pgaction' id='pgaction'>
						<input type='hidden' name='staticid' id='staticid'>
						<input type='hidden' name='staticttid' id='staticttid'>
						<input type='hidden' name='hdnflag' id='hdnflag'>
						<input  class="btnSty" type="button" name="Save" value="Save" alt="Save" title="Save" onclick="ShowProgress('fnSave');"/>&nbsp;
						<!-- onClick="fnSave();" -->
						<input  class="btnSty" type="reset"  name="Cancel" value="Cancel"  alt="Cancel" title="Cancel" onClick="fncancel();"/>&nbsp;
					</div>
				</div>
				</fieldset>
			</div>
		</form>
		{include file="../templates/admin/footer.tpl"}
	</body>
</html>