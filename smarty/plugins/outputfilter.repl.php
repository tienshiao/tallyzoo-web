<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */

/**
 * Smarty trimwhitespace outputfilter plugin
 *
 * File:     outputfilter.trimwhitespace.php<br>
 * Type:     outputfilter<br>
 * Name:     trimwhitespace<br>
 * Date:     Jan 25, 2003<br>
 * Purpose:  trim leading white space and blank lines from
 *           template source after it gets interpreted, cleaning
 *           up code and saving bandwidth. Does not affect
 *           <<PRE>></PRE> and <SCRIPT></SCRIPT> blocks.<br>
 * Install:  Drop into the plugin directory, call 
 *           <code>$smarty->load_filter('output','trimwhitespace');</code>
 *           from application.
 * @author   Monte Ohrt <monte@ispi.net>
 * @author Contributions from Lars Noschinski <lars@usenet.noschinski.de>
 * @version  1.3
 * @param string
 * @param Smarty
 */
 function smarty_outputfilter_repl($source, &$smarty)
 {
      return eregi_replace(" ", "-" , $source);
 }

?>
