<?php

function checkLoginMe()
{
    // cls();
    $rls = [];
    echo ghryej(__DIR__);

    //look for user in the database
    if (isset($_SESSION['log'])) {

        // $q   = db_query('SELECT cust_password, actions FROM ' . CUSTOMERS_TABLE . "WHERE Login = '" . trim($_SESSION['log']) . "'");
        // $row = db_fetch_row($q);

        $db = MysqliDb::getInstance();
        $db->where("Login", trim($_SESSION['log']));
        $row = $db->getOne('customers', "cust_password, actions");
        dump($row);
        //found customer - check password
        //unauthorized access
        if (! $row || ! isset($_SESSION['pass']) || $row[0] != $_SESSION['pass']) {
            unset($_SESSION['log']);
            unset($_SESSION['pass']);
        } else {
            $rls = unserialize($row[1]);
            unset($row);
            # fix log errors WARNING: in_array() expects parameter 2 to be array, boolean given
            if (! is_array($rls)) {
                $rls = [];
            }
        }
    }
    return $rls;
}

function sess_open(
    $save_path,
    $session_name
) {
    dump([$save_path,
        $session_name]);

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
    $db->where('id', $key);
    $result = $db->getOne('session'); //contains an Array of all users

    if (! $result || empty($result)) {
        return '';
    }

    if (CONF_SECURE_SESSIONS) {
        if (stGetCustomerIP_Address() != $result['IP']) {
            $db->where('id', $key);
            // $db->delete('session');
            if ($db->delete('session')) {
                dump('successfully deleted');
            }
        }
    }

    return $result['data'];
}

function sess_write(
    $key,
    $val
) {

    // db_query('REPLACE INTO ' . SESSION_TABLE . " VALUES ('" . addslashes($key) . "', '" . addslashes($val) . "', UNIX_TIMESTAMP() + " . SECURITY_EXPIRE . ", '" . addslashes(stGetCustomerIP_Address()) . "', '" . addslashes($_SERVER['HTTP_REFERER'] ?? '') . "', '" . addslashes($_SERVER['HTTP_USER_AGENT']) . "', '" . addslashes($_SERVER['REQUEST_URI']) . "')");

    $data = [
        'id'         => $key,
        'data'       => $val,
        'expire'     => time() + SECURITY_EXPIRE,
        'IP'         => stGetCustomerIP_Address(),
        'Referer'    => $_SERVER['HTTP_REFERER'] ?? '',
        'user_agent' => $_SERVER['HTTP_USER_AGENT'],
        'URL'        => $_SERVER['REQUEST_URI'],
    ];
    $db = MysqliDb::getInstance();
    $id = $db->replace('session', $data);

    if ($db->replace('session', $data)) {
        echo $db->count . ' records were updated' . ' :: ' . $id;
    } else {
        echo 'replace failed: ' . $db->getLastError();
    }

    return true;
}

function sess_destroy($key)
{
/*    db_query('DELETE FROM' . SESSION_TABLE . " WHERE id='" . addslashes($key) . "'");
    return true;*/
    $db = MysqliDb::getInstance();
    $db->where('id', $key);
    // $db->delete('session');
    if ($db->delete('session')) {
        bdump('successfully deleted');
    }

    return true;
}

function sess_gc($maxlifetime)
{
    // db_query('DELETE FROM' . SESSION_TABLE . 'WHERE expire < UNIX_TIMESTAMP()');
    // return true;

    $db = MysqliDb::getInstance();
    $db->where('expire', time(), '<');
    // $db->delete('session');
    if ($db->delete('session')) {
        bdump('successfully deletedexpire');
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
