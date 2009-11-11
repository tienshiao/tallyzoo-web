<?php

include_once 'system/configme/siteconfig.php';
include_once CLASS_PATH.'dbclass.php';
include_once CLASS_PATH.'general.cls.php';
include_once CLASS_PATH.'user.cls.php';

$dbObj = new dbclass();
$dbObj->Open();
$objGeneral = new general($dbObj);
$objUser = new user();

$userId = -1;

function activities_list($req) {
    global $dbObj;
    global $objGeneral;
    global $userId;
    $dbObj->Open();

    if ($req->match) {
    } else {
        if ($req->since) {
            $since = $objGeneral->encodequotes($req->since['datetime']);
        } else {
            $since = '0000-00-00 00:00:00';
        }
        $sql = "SELECT *
                  FROM activities
                 WHERE user_id = $userId
                   AND modified_on_UTC > '$since'
                   AND activity_type = '0'";
        $activities1 = $dbObj->select($sql, MYSQLI_ASSOC);
        if (!$activities1) {
            $activities1 = array();
        }

        $sql = "SELECT DISTINCT a.*
                  FROM activities a,
                       counts c
                 WHERE c.item_id = a.id
                   AND a.user_id = $userId
                   AND c.modified_on_UTC > '$since'
                   AND a.activity_type = 0";
        $activities2 = $dbObj->select($sql, MYSQLI_ASSOC);
        if (!$activities2) {
            $activities2 = array();
        }

        $activities = array_merge($activities1, $activities2);
        
        $already_processed = array();

        $response .= '<response>';
        if ($activities) {
            foreach ($activities as $activity) {
                if (in_array($activity['id'], $already_processed)) {
                    continue;
                } else {
                    $already_processed[] = $activity['id'];
                }
                $response .= '<activity ';
                foreach ($activity as $key => $value) {
                    // TODO how to encode this?
                    $response .= "$key=\"$value\" ";
                }
                $response .= '>';
                                
                $activity_id = $activity['id'];

                // do groups
                $sql = "SELECT g.*
                          FROM groups g,
                               groups_graphs gg,
                               activities a
                         WHERE g.id = gg.group_id
                           AND gg.graph_id = a.graph_id
                           AND a.id = $activity_id";
                $groups = $dbObj->select($sql, MYSQLI_ASSOC);
                if ($groups) {
                    foreach ($groups as $group) {
                        $response .= '<group ';
                        foreach ($group as $key => $value) {
                            // TODO how to encode this?
                            $response .= "$key=\"$value\" ";
                        }
                        $response .= '/>';
                    }
                }

                // do counts
                $sql = "SELECT *
                          FROM counts
                         WHERE item_id = $activity_id";
                $counts = $dbObj->select($sql, MYSQLI_ASSOC);
                if ($counts) {
                    foreach ($counts as $count) {
                        $response .= '<count ';
                        foreach ($count as $key => $value) {
                            // TODO encode value
                            $response .= "$key=\"$value\" ";
                        }
                        $response .= ' />';
                    }
                }

                $response .= '</activity>';
            }
        }
        $response .= '</response>';
        error_log($response);
        echo $response;
    }
}

function activities_create($req) {
}

function activities_update($req) {
    global $dbObj;
    global $objGeneral;
    global $userId;
    $dbObj->Open();
    
    $data = $req->activity;
    foreach ($data as $key => $value) {
        $data[$key] = $objGeneral->encodequotes($value);
    }

error_log(print_r($data, true));

    $guid = $data['guid'];

    $sql = "SELECT id, graph_id
              FROM activities
             WHERE guid = '$guid'
               AND user_id = $userId";
    $activity = $dbObj->select($sql);
    if ($activity) {
        // update
        $activity_id = $activity[0]['id'];
        $graph_id = $activity[0]['graph_id'];
        error_log('updating');
        $sql = "UPDATE activities
                   SET name = '$data[name]',
                       default_note = '$data[default_note]',
                       initial_value = '$data[initial_value]',
                       init_sig = '$data[init_sig]',
                       default_step = '$data[default_step]',
                       step_sig = '$data[step_sig]',
                       color = '$data[color]',
                       count_updown = '$data[count_updown]',
                       display_total = '$data[display_total]',
                       screen = '$data[screen]',
                       position = '$data[position]',
                       deleted = '$data[deleted]',
                       created_on = '$data[created_on]',
                       created_on_UTC = '$data[created_on_UTC]',
                       modified_on = '$data[modified_on]',
                       modified_on_UTC = '$data[modified_on_UTC]'
                 WHERE id = $activity_id";
        $dbObj->edit($sql);

        // TODO proper support for generic groups
        if ($req->activity->group) {
            $sql = "INSERT IGNORE INTO groups_graphs (group_id, graph_id)
                        VALUES (0, $graph_id)";
            $dbObj->insert($sql);
        } else {
            $sql = "DELETE FROM groups_graphs 
                     WHERE group_id = 0 
                       AND graph_id = $graph_id";
            $dbObj->sql_query($sql);
        }
    } else {
        error_log('inserting');
        // insert
        $sql = "INSERT INTO activities
                    (user_id, guid, name, default_note, initial_value,
                     init_sig, default_step, step_sig, color, count_updown,
                     display_total, screen, position, deleted,
                     created_on, created_on_UTC, modified_on, modified_on_UTC,
                     activity_type, status)
                VALUES
                    ($userId, '$data[guid]', '$data[name]', '$data[default_note]', '$data[initial_value]',
                     '$data[init_sig]', '$data[default_step]', 
                     '$data[step_sig]', '$data[color]', '$data[count_updown]',
                     '$data[display_total]', '$data[screen]', '$data[position]',
                     '$data[deleted]', '$data[created_on]', 
                     '$data[created_on_UTC]', '$data[modified_on]',
                     '$data[modified_on_UTC]', '0', 'unblocked')";
        $dbObj->insert($sql);
        $activity_id = $dbObj->last_insert_id;

        $sql = "INSERT INTO graphs
                    (user_id, graph_type, dataOption, hidden, created_on, created_on_UTC,
                     modified_on, modified_on_UTC) 
                VALUES
                    ('$userId', '1', '1', '1',
                     '$data[created_on]', '$data[created_on_UTC]',
                     '$data[modified_on]', '$data[modified_on_UTC]')";
        $dbObj->insert($sql);
        $graph_id = $dbObj->last_insert_id;

        $sql = "UPDATE activities SET graph_id='$graph_id' WHERE id='$activity_id'";
        $dbObj->edit($sql);
    }
}

function counts_create($req) {
}

function counts_update($req) {
    global $dbObj;
    global $objGeneral;
    global $userId;
    $dbObj->Open();
    
    $data = $req->count;
    foreach ($data as $key => $value) {
        $data[$key] = $objGeneral->encodequotes($value);
    }

error_log(print_r($data, true));

    $guid = $data['guid'];

    $sql = "SELECT id
              FROM counts
             WHERE guid = '$guid'";
    $count = $dbObj->select($sql);
    if ($count) {
        // update
        error_log('updating');
        $count_id = $count[0]['id'];
        $sql = "UPDATE counts
                   SET note = '$data[note]',
                       amount = '$data[amount]',
                       amount_sig = '$data[amount_sig]',
                       latitude = '$data[latitude]',
                       longitude = '$data[longitude]',
                       deleted = '$data[deleted]',
                       created_on = '$data[created_on]',
                       created_on_UTC = '$data[created_on_UTC]',
                       modified_on = '$data[modified_on]',
                       modified_on_UTC = '$data[modified_on_UTC]'
                 WHERE id = $count_id";
        $dbObj->edit($sql);
    } else {
        // insert
        error_log('inserting');
        // need activity id

        $activity_guid = $data['activity_guid'];

        $sql = "SELECT id
                  FROM activities
                 WHERE guid = '$activity_guid'
                   AND user_id = $userId";
        $activity = $dbObj->select($sql);

        if (!$activity) {
            return;
        }

        $activity_id = $activity[0]['id'];

        $sql = "INSERT INTO counts
                    (guid, item_id, note, amount, amount_sig,
                     latitude, longitude, deleted,
                     created_on, created_on_UTC, modified_on, modified_on_UTC)
                VALUES
                    ('$data[guid]', '$activity_id', '$data[note]',
                     '$data[amount]', '$data[amount_sig]', 
                     '$data[latitude]', '$data[longitude]', '$data[deleted]',
                     '$data[created_on]',
                     '$data[created_on_UTC]', '$data[modified_on]',
                     '$data[modified_on_UTC]')";
        $dbObj->insert($sql);
    }
}

$userName = $objGeneral->encodequotes($_SERVER['PHP_AUTH_USER']);
$userPassword = $objGeneral->encodequotes($_SERVER['PHP_AUTH_PW']);
if (trim($userName) == '' || trim($userPassword) == '') {
    header('WWW-Authenticate: Basic realm="TallyZoo API"');
    header('HTTP/1.0 401 Unauthorized');
    echo '401 Unauthorized';
    exit;
}
$sql = "SELECT id,email,username from users WHERE username=\"$userName\" AND password=MD5(\"$userPassword\") AND status=\"unblocked\"";
$ROW = $dbObj->select($sql);
$numRows = $dbObj->num_rows;
if($numRows == 0){
    header('WWW-Authenticate: Basic realm="TallyZoo API"');
    header('HTTP/1.0 401 Unauthorized');
    echo '401 Unauthorized';
    exit;
}
$userId = $ROW[0]['id'];

$method = trim($_SERVER['PATH_INFO'], '/');
$method = str_replace('.', '_', $method);

if (function_exists($method)) {
    $body = @file_get_contents('php://input');
    $request = @simplexml_load_string($body);
    if ($request !== FALSE) {
        call_user_func($method, $request);
    } else {
        error_log("Bad Request: $body");
        foreach(libxml_get_errors() as $error) {
            error_log($error->message);
        } 
        header("HTTP/1.0 400 Bad Request");
    } 
} else {
    header("HTTP/1.0 404 Not Found");
    echo "End point $method not found for $userName";
}
?>
