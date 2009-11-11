<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty {counter} function plugin
 *
 * Type:     function<br>
 * Name:     counter<br>
 * Purpose:  print out a counter value
 * @link http://smarty.php.net/manual/en/language.function.counter.php {counter}
 *       (Smarty online manual)
 * @param array parameters
 * @param Smarty
 * @return string|null
 */
function smarty_function_test123($params, &$smarty)
{
	global $dbobj;
	$msql = "Select * from mails where imailid='6'";
	//echo $msql."<br>";
	$mres = $dbobj->select($msql);
	$message_contents = stripslashes($mres[0]["vmailtext"]);
	return $message_contents;
}

/* vim: set expandtab: */

?>
