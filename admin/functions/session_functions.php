<?php

function sess_open(
    $save_path,
    $session_name
) {
    return true;
}

function sess_close()
{
    return true;
}

function sess_read($key)
{
    // obtain db object created in init  ()
    // $r = db_query('SELECT data, IP FROM ' . SESSION_TABLE . " WHERE id='" . addslashes($key) . "'");
    $db = MysqliDb::getInstance();
    $db->where("id", '"' . addslashes($key) . '"');
    $result = $db->get('session'); //contains an Array of all users

    if (! $result || empty($result)) {
        return '';
    }

    if (CONF_SECURE_SESSIONS) {
        if (stGetCustomerIP_Address() != $result[1]) {

            //db_query('DELETE FROM ' . SESSION_TABLE . " WHERE id='" . addslashes($key) . "'");
            return '';
            $db->where("id", '"' . addslashes($key) . '"');
            // $db->delete('session');
            if ($db->delete('session')) {
                bdump('successfully deleted');
            }
            return '';
        }
        return $result[0];
    }

/*
    $r = db_query('SELECT data, IP FROM ' . SESSION_TABLE . " WHERE id='" . addslashes($key) . "'");
    if (! $r) {
        return '';
    } else {
        $result = db_fetch_row($r);
        if (! empty($result)) {
            if (CONF_SECURE_SESSIONS) {
                if (stGetCustomerIP_Address() != $result[1]) {
                    db_query('DELETE FROM ' . SESSION_TABLE . " WHERE id='" . addslashes($key) . "'");
                    return '';
                }
            }
            return $result[0];
        } else {
            return '';
        }
    }
*/

}

function sess_write(
    $key,
    $val
) {

    db_query('REPLACE INTO ' . SESSION_TABLE . " VALUES ('" . addslashes($key) . "', '" . addslashes($val) . "', UNIX_TIMESTAMP() + " . SECURITY_EXPIRE . ", '" . addslashes(stGetCustomerIP_Address()) . "', '" . addslashes($_SERVER['HTTP_REFERER'] ?? '') . "', '" . addslashes($_SERVER['HTTP_USER_AGENT']) . "', '" . addslashes($_SERVER['REQUEST_URI']) . "')");

    return true;
}

function sess_destroy($key)
{
/*    db_query('DELETE FROM ' . SESSION_TABLE . " WHERE id='" . addslashes($key) . "'");
    return true;*/
    $db = MysqliDb::getInstance();
    $db->where("id", '"' . addslashes($key) . '"');
    // $db->delete('session');
    if ($db->delete('session')) {
        bdump('successfully deleted');
    }

    return true;
}

function sess_gc($maxlifetime)
{
    // db_query('DELETE FROM ' . SESSION_TABLE . ' WHERE expire < UNIX_TIMESTAMP()');
    // return true;

    $db = MysqliDb::getInstance();
    $db->where("expire", UNIX_TIMESTAMP(), "<");
    // $db->delete('session');
    if ($db->delete('session')) {
        bdump('successfully deleted expire');
    }
    return true;
}

// *****************************************************************************
// Purpose        get remote customer computer IP address
// Inputs           $log - login
// Remarks
// Returns        nothing
function stGetCustomerIP_Address()
{
    $ip = ($_SERVER['REMOTE_ADDR'] != '') ? $_SERVER['REMOTE_ADDR'] : 0;
    $ip = (preg_match("/^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$/is", $ip)) ? $ip : 0;
    return $ip;
}
