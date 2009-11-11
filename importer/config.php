<?php
	$openinviter_settings=array(
		"filter_emails"=>FALSE, //Tell OpenInviter whether to compare the emails with its blacklist or not. Default value: TRUE (compare enabled).
		"transport"=>"curl", //Replace "curl" with "wget" if you would like to use wget instead
		"local_debug"=>"on_error", //Available options: on_error => log only requests containing errors; always => log all requests; false => don`t log anything
		"remote_debug"=>FALSE //When set to TRUE OpenInviter sends debug information to our servers. Set it to FALSE to disable this feature
	);
	?>