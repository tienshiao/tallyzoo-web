<?PHP
ini_set('session.gc_maxlifetime',7200);
ob_start(); 
session_cache_limiter('private, must-revalidate');
$filepath = ini_get('session.save_path').'/sess_'.session_id();
$url=_SITEURL_."admin.php?mod=logout";
if(file_exists($filepath)) 
{
    $filetime = filemtime ($filepath);
    $timediff = mktime() - $filetime;
}
if($timediff>7200)
{
	session_destroy();
?>
<script>
location.href="<?php echo $url?>";
</script> 
<?
}
if($_SESSION['s_hdnFlag']!="1")	
{
	session_destroy();
	$url=_SITEURL_."admin.php?mod=logout";
?>
<script>
location.href="<?php echo $url?>";
</script> 
<?
}
?>