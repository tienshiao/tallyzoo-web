<? if ($service == "gmail") {     
	
$ArrA = array();    

$urlB = "http://mail.google.com/mail/";   

$browsername = "Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.7.12) Gecko/20050915 Firefox/1.0.7";   

$cookifilename = $username.'.cookie'; 

$fp = fopen($cookifilename,'w');  fclose($fp);    

$RF16B00F40343095F6D63FA66514678BF = realpath("$cookifilename");    

$fp1 = fopen($RF16B00F40343095F6D63FA66514678BF,'wb'); fclose($fp1);       

$gmailURl = "http://mail.google.com/mail/";  

$Fnreturn1 = F03698D31B2B2D52FB9EE46B665D44CC0($gmailURl,1,0);

$sendPath = "ltmpl=yj_blanco&ltmplcache=2&continue=http%3A%2F%2Fmail.google.com%2Fmail%3F&service=mail&rm=false&ltmpl=yj_blanco&Email=".      $username."&Passwd=".$password."&rmShown=1&null=Sign+in";  $gmailURl = 'https://www.google.com/accounts/ServiceLoginAuth';  

$result = FE6FA54A367C0E8B6B3A86AD9C1B69579($gmailURl,$sendPath,1,0);   

preg_match_all("/location.replace.\"(.*?)\"/",$result,$matches);  

$matches = $matches[1][0];       
$gmailURl = $matches;  

$result = F03698D31B2B2D52FB9EE46B665D44CC0($gmailURl,1,0);       

$gmailURl = 'http://mail.google.com/mail/?ui=html&zy=n';  

$result = F03698D31B2B2D52FB9EE46B665D44CC0($gmailURl,1,0);  

preg_match_all('/base href="(.*?)"/',$result,$matches);  

$matches = $matches[1][0];       

$gmailURl = 'https://mail.google.com/mail/?ik=&view=sec&zx=';  

$result = F03698D31B2B2D52FB9EE46B665D44CC0($gmailURl,1,0); 

preg_match_all("/value=\"(.*?)\"/",$result,$matches);  

$matches = $matches[1][0];       

$sendPath = 'at='.$matches.'&ecf=g&ac=Export Contacts';  

$gmailURl = 'https://mail.google.com/mail/?view=fec';  

$result = FE6FA54A367C0E8B6B3A86AD9C1B69579($gmailURl,$sendPath,1,0);       

}
?>