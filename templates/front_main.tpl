<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv='content-type' content='text/html; charset=UTF-8' />
<meta name='description' content='{$metaDescription}' />
<meta name='keywords' content='{$metaKeyWords}' />
<meta name='authenticity-token' id='authenticity-token' content='' />
<link rel='shortcut icon' href='/favicon.ico' />
<title>{$title} > {$prefix}</title>
{literal}
	<script language="javascript">
		var sitePath = "{/literal}{$SITEURL}{literal}";
	</script>
{/literal}
<script type="text/javascript" language="javascript" src="{$SITEURL}includes/javascript/jquery-1.3.2.js"></script>
<script type="text/javascript" language="javascript" src="{$SITEURL}includes/javascript/user_general.js"></script>
<script type="text/javascript" language="javascript" src="{$SITEURL}includes/javascript/frmvalidation.js"></script>
<script type="text/javascript" language="javascript" src="{$SITEURL}includes/javascript/chart.js"></script>
<script type="text/javascript" language="javascript" src="{$SITEURL}includes/javascript/prev_chart.js"></script>

<!-- Chart files -->
<script type="text/javascript" src="{$SITEURL}chart/ampie/swfobject.js"></script>
<script type="text/javascript" src="{$SITEURL}chart/amcolumn/swfobject.js"></script>
<!-- End Chart files -->
<script src="{$SITEURL}includes/javascript/201a.js" type="text/javascript"></script>
<link href="{$SITEURL}includes/style/tallyZoo.css" rel="stylesheet" type="text/css" />
<!--[if lte IE 6]>
<link rel="stylesheet" type="text/css" href="{$SITEURL}includes/style/ie_hacks.css" />
<![endif]-->
<link href="{$SITEURL}includes/style/dropdown.css" rel="stylesheet" type="text/css" />
<link href="{$SITEURL}includes/style/spiffyCalTime.css" rel="stylesheet" type="text/css" />

<script src="{$SITEURL}includes/javascript/jquery.js" type="text/javascript"></script>
<script src="{$SITEURL}includes/javascript/jquery.validate.js" type="text/javascript"></script>
<script src="{$SITEURL}includes/javascript/spiffyCalTime.js" type="text/javascript"></script>
 <base href="{$SITEURL}">

</head>
<body id="idbody" onLoad="javascript:{$onLoad};">
<div id="spiffycalendar" class="text"></div>
<iframe id="selectblocker" name="selectblocker" style="display:none;position:absolute;z-index:100;filter: alpha(opacity=60);" src="" frameborder="0" scrolling="no"></iframe>
<div id="popup_container"></div>
<div id="maskdiv" class="divMask">&nbsp;</div>
<!-- Header Starts -->
{include file=$header}
<!-- Header Ends -->

<!--<div id="sub_menu_out">
	<div id="sub_menu"><a href="#" id="subActive"><span class="ln_lft">&nbsp;</span>Health<span class="ln_rgt">&nbsp;</span></a> <a href="#"><span class="ln_lft">&nbsp;</span>Food &amp; Cold Drinks<span class="ln_rgt">&nbsp;</span></a> <a href="#"><span class="ln_lft">&nbsp;</span>Exercise<span class="ln_rgt">&nbsp;</span></a> <a href="#"><span class="ln_lft">&nbsp;</span>Travel<span class="ln_rgt">&nbsp;</span></a></div>
</div>-->
<!-- Container Starts -->
{include file=$middle}
<!-- Container Ends -->

<!-- Footer Starts -->
{include file=$footer}
<!-- Footer Ends -->
</body>
</html>