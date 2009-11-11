<?php
/**
 * Smarty shared plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Function: smarty_file_exists<br>
 * Purpose:  used by other smarty functions to test
 *           if a file exists.
 * @param string
 * @return string
 */
function smarty_file_exists($path)
{
    
	$file_ex = true;
	if(empty($path)) {
	
		$file_ex = false;
  
    }elseif(!file_exists($path)){
	
	 	$file_ex = false;
		
	}
	
	return $file_ex;
}



?>
