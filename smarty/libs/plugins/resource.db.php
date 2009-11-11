<?php
/*
 * Smarty plugin
 * ------------------------------------------------------------- 
 * File:     resource.db.php
 * Type:     resource
 * Name:     db
 * Purpose:  Fetches templates from a database
 * -------------------------------------------------------------
 */
function smarty_resource_db_source($tpl_query, &$tpl_source, &$smarty)
{
    // do database call here to fetch your template,
    // populating $tpl_source
    $sql = new db_con();
    $sql->dbquery = $tpl_query;
    $sql->request_db();
    if ($sql->$affected_rows > 0) {
        $tpl_source = $sql->result;
        return true;
    } else {
        return false;
    }
}

function smarty_resource_db_timestamp($tpl_name, &$tpl_timestamp, &$smarty)
{
    // do database call here to populate $tpl_timestamp.
    $sql = new SQL;
    $sql->query("select tpl_timestamp
                   from my_table
                  where tpl_name='$tpl_name'");
    if ($sql->num_rows) {
        $tpl_timestamp = $sql->record['tpl_timestamp'];
        return true;
    } else {
        return false;
    }
}

function smarty_resource_db_secure($tpl_name, &$smarty)
{
    // assume all templates are secure
    return true;
}

function smarty_resource_db_trusted($tpl_name, &$smarty)
{
    // not used for templates
}
?>
