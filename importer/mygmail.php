<?
$service = 'gmail';
include_once ('includes/config.php');
include_once ('includes/tbs_class.php');
//include ('includes/service.php');
include ('includes/gmailservices.php');
//--------- -------------end of service-------- -------------\\

//WRITING OUTPUT TO CSV FILE

$myFile = $username;
$fh = fopen($myFile,'w') or die("can't open file");
fwrite($fh,$result);
fclose($fh);

// CHECKING IF LOGIN WAS SUCCESSFUL - by search of the @ sign in the csv

preg_match_all("/@/",$result,$array_at);

$at_sign = $array_at[0];

if (empty($at_sign)) {
    $show = 1;
    $error_message = "No contacts found - check your login details and try again";
}
else {

    //*********************** | START OF HTML | ***********************************\\

    //OPEING CSV FILE FOR PROCESSING

    $fp = fopen($username,"r");

    while (!feof($fp)) {

        $data = fgetcsv($fp,4100,",");//this uses the fgetcsv function to store the quote info in the array $data

        $dataname = $data[0];

        if (empty($dataname)) {

            $dataname = "None";

        }

        $email = $data[1];

        if (empty($email)) {//Skip table if email is blank

        }
        else {

            $email = $data[1];
            if ($dataname == "None") {
                $dataname = $email;
            }

            if ($dataname != "Name") {// skiping table to remove first line of csv file

					//remove none characters
					$email1 = preg_replace("/[^a-z0-9A-Z_-\s@\.]/","",$email);
					$dataname1 = preg_replace("/[^a-z0-9A-Z_-\s@\.]/","",$dataname);

                $result = array('contacts_email' => $email1,'contacts_name' => $dataname1);

                $display_array[] = $result;
            }
        }
    }
    $poweredby_bottom = $footer;//powered by
    $show_result = 1;//show results table
    unlink($username);//deleting csv file
    @unlink($mycookie);
}
$table = 1;//show table in main template (email or cvs upload)
$service = 'mygmail';
@unlink($username);//deleting csv file
@unlink($mycookie);
	$include_Path	=	"../";
	include_once ($include_Path.'user/imported_address.php');
?>