<div id="header">
	<div id="header_in">
		<div class="logo"><img src="{$SITEURL}images/front/logo.gif" width="248" height="62" alt="TallyZoo" /></div>

		<div class="top_links">
			<div class="top_links_in">Welcome {$smarty.session.tz_user.username} <a href="{$SITEURL}updateProfile">Profile</a> <a href="{$SITEURL}Invite" >Invite</a> <a href="user/logout.php">Logout</a> <a href="{$SITEURL}search" class="search">Search</a></div>
		</div>
		
		<div id="topMenu">
		<!-- Main Menu bar #1 -->
			<div id="mnuBar">
				<a href="{$SITEURL}dashboard"
				{if $smarty.get.mod eq "dashboard"}
					id="current"
				{/if}	
				><span>Dashboard</span></a>
				<a 	href="{$SITEURL}myActivity" 
				{if $smarty.get.mod eq "myActivity" or $smarty.get.mod eq "myData"}
					id="current"
				{else}
					{if $smarty.get.mod eq 'activityDetails' and $ownerFlag eq 1}
					id="current"
					{/if}
				{/if}	
				><span>My Activities</span></a>
				<a href="{$SITEURL}communityData"
                {if $smarty.get.mod eq "communityData"}
					id="current"
				{/if}			
				><span>Community</span></a>
			</div>
		</div>

	</div>
</div>