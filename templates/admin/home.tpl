
		<iframe id="selectblocker" style="display:none;position:absolute;z-index:100;filter: alpha(opacity=60);" src="" frameborder="0" scrolling="no"></iframe>
		<div id="popup_container"></div>
		<div id="maskdiv" class="divMask">&nbsp;</div>
		{$SUBMENU}
        <p class="hS2"><i></i></p>
        <p class="h3 cBr">&nbsp;{$PAGETITLE}</p>
        <p class="h25"><i></i></p>
        <div class="w800 mm bAllGry">
          <fieldset class="mm w790">
		  <div class="w800 mm bAllGry">
          <fieldset class="mm w790">
		  <div class="mm w755">
          <div class="fL w350">
		  	<fieldset>
            <div id="user_stats" class="pad_bot20"><b class="btnLft">&nbsp;</b><b class="btnCen">User Stats</b><b class="btnRgt">&nbsp;</b></div>
              <div class="bDgry">
              <ul class="pad_top5 pad_bot5">
                <li class="pad_top3">No. of Registered User - { if $tot_Members neq 0 }<a href="admin.php?mod=search_member&q=All">({$tot_Members})</a> { else } ({$tot_Members}) { /if }</li>
                <li class="pad_top3">No. of New User - { if $tot_New_Members neq 0 }<a href="admin.php?mod=search_member&q=New">({$tot_New_Members})</a>{ else } ({$tot_New_Members}) { /if }</li>
				 <li class="pad_top3">No. of Blocked User - { if $tot_Blocked_Members neq 0 }<a href="admin.php?mod=search_member&q=blocked">({$tot_Blocked_Members})</a>{ else } ({$tot_Blocked_Members}) { /if }</li>
				 <form method="post" id="frmHome" name="frmHome">
					<input type="hidden" name="chkInactive" id="chkInactive"/>
				 </form>
              </ul>
             </div>
              </fieldset>
          
          </div>
            <!--<div class="fL w350 mgrleft55">
            <fieldset>
            <div id="fcs" class="pad_bot20"><b class="btnLft">&nbsp;</b><b class="btnCen">Fees Collection Stats</b><b class="btnRgt">&nbsp;</b></div>
              <div class="bDgry">
              <ul class="pad_bot5 pad_top5">
                <li class="pad_top3">Total Fees Collection - <a title="Total Fees  Collection" onclick="" href="#fcs">($ 0.00)</a></li>
				<input type="hidden" id="recid" name="recid"/>
				<input type="hidden" id="pgaction" name="pgaction"/>
				<li class="pad_top3">Current year Fees Collection - <a title="Current year Fees   Collection" onclick="" href="#fcs">($ 0.00)</a></li>
				<li class="pad_top3">Current month Fees Collection - <a title="Current month Fees Collection" onclick="" href="#fcs">($ 0.00)</a></li>
              </ul>
              </div>
              </fieldset>
            </div>
            <p class="h25"><i/></p>
			</div>-->
          </fieldset>
        </div>
          </fieldset>
        </div>