<div id="header">
	<div id="header_in">
		<div class="logo"><img src="images/front/logo.gif" width="248" height="62" alt="TallyZoo" /></div>
		<div class="top_links">
			<div class="top_links_in">Already a member? 
			{if $smarty.get.mod neq "login"}
			<a href="{$SITEURL}login" >Login Now</a>{/if} 
			{if $smarty.get.mod neq "register"}
			<a  href="{$SITEURL}register" >Sign Up</a>
			{/if}
			<a  href="{$SITEURL}search" class="search">Search</a></div>
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
					{if $smarty.get.mod eq 'activities' and $ownerFlag eq 1}
					id="current"
					{/if}
				{/if}	
				><span>My Activities</span></a>
				<a href="{$SITEURL}communityData"
				{if $smarty.get.mod eq "commumity"}
				id="current"
				{/if}
				><span>Community</span></a>
			</div>
		</div>
	</div>
</div>
{literal}
<script language="javascript">

</script>
{/literal}
	