<?php
include('openinviter.php');
$inviter=new OpenInviter();
$oi_services=$inviter->getPlugins();

$username = explode('@',$_POST['username']);

$username = $username[0];

if ($_SERVER['REQUEST_METHOD']=='POST')
{
			$inviter->startPlugin("aol");

			$inviter->login($username ,$_POST['password']);
			
			$contacts=$inviter->getMyContacts();

}
else
	{
	$_POST['username']='';
	$_POST['password']='';
	}

//print_r($contacts);exit;

if(is_array($contacts))
{
	$i = 0;
	foreach($contacts as $key=>$val)
	{
		 $resultarray[$i]["contacts_email"]	=	$key;
		 $resultarray[$i]["contacts_name"]	=	$val;
		$i++;
	}
}
	$display_array = $resultarray;
	$include_Path	=	"../";
	include_once ($include_Path.'user/imported_address.php');
?>