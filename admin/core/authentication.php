<?php
// echo __DIR__ . '-auth.php-<br>';
### authentication.php

const PATH_CORE            = 'admin/core/';
const CONF_SECURITY_EXPIRE = 12; //   {$smarty.const.CONF_SECURITY_EXPIRE}
const CONF_SECURE_SESSIONS = 1;  //   {$smarty.const.CONF_SECURE_SESSIONS}  Использовать безопасные сессии    При использовании данной опции ip адрес и поле user_agent будут сверяться с начальным значением при старте сессии

define('SECURITY_EXPIRE', 60 * 60 * CONF_SECURITY_EXPIRE);

require_once PATH_CORE . 'database_connect.php';
$sqli_connect = [
    'host'     => DB_HOST,
    'username' => DB_USER,
    'password' => DB_PASS,
    'db'       => DB_NAME,
    'port'     => DB_PORT,
    'prefix'   => DB_PRFX,
    'charset'  => DB_CHARSET,
];

//Advanced initialization:
$db = new MysqliDb($sqli_connect);

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
    // $r = db_query('SELECT data, IP FROM' . SESSION_TABLE . " WHERE id='" . addslashes($key) . "'");
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
                bdump($result['IP'] . ' successfully deleted');
            }
        }
    }

    return $result['data'];
}

function sess_write(
    $key,
    $val
) {
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
        bdump($db->count . 'records were updated' . '::' . $id);
    } else {
        bdump('replace failed: ' . $db->getLastError());
    }

    return true;
}

function sess_destroy($key)
{
    $db = MysqliDb::getInstance();
    $db->where('id', $key);
    // $db->delete('session');
    if ($db->delete('session')) {
        bdump("'id'=> {$key}" . ' successfully deleted');
    }

    return true;
}

function sess_gc($maxlifetime)
{

    $db = MysqliDb::getInstance();
    $db->where('expire', time(), ' < ');
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

function set_cookie(
    $Name,
    $Value = '',
    $Expires = '',
    $Secure = false,
    $Path = '',
    $Domain = '',
    $HTTPOnly = false
) {
    header('Set-Cookie: ' . rawurlencode($Name) . '=' . rawurlencode($Value)
        . (empty($Expires) ? '' : ' ; expires=' . gmdate('D, d-M-Y H:i:s', $Expires) . ' GMT')
        . (empty($Path) ? '' : ' ; path=' . $Path)
        . (empty($Domain) ? '' : ' ; domain=' . $Domain)
        . (! $Secure ? ' ; flavor=choco; SameSite=Lax' : ' ; SameSite=None; Secure ')
        . (! $HTTPOnly ? '' : '; HttpOnly'), false);
}

function checkLogin__OLD()
{

    $rls = [];
    //look for user in the database
    if (isset($_SESSION['log'])) {

        $db = MysqliDb::getInstance();
        $db->where('Login', trim($_SESSION['log']));
        $row = $db->getOne('customers', 'cust_password, actions');

        bdump([
            'function'        => 'checkLogin',
            'cust_password'   => $row['cust_password'],
            "SESSION['pass']" => $_SESSION['pass'],
        ]);

        //found customer - check password
        //unauthorized access
        if (
            ! $row ||
            ! isset($_SESSION['pass']) ||
            ($_SESSION['pass'] !== $row['cust_password'])
        ) {

            unset($_SESSION['log']);
            unset($_SESSION['pass']);
            unset($_SESSION['current_currency']);

            bdump([
                'DROP_SESSION' => $_SESSION,
                'function'     => 'checkLogin',
                'row_actions'  => $row['actions'],
            ]);

        } else {

            $rls = unserialize($row['actions']);

            bdump([
                'IS_ADMIN_SESSION' => $_SESSION,
                'function'         => 'checkLogin',
                'row_actions'      => $row['actions'],
                'rls'              => $rls,
            ]);

            unset($row);
            # fix log errors WARNING: in_array() expects parameter 2 to be array, boolean given
            if (! is_array($rls)) {
                $rls = [];
            }

        }
    }

    return $rls;
}

function checkLogin()
{

    $rls  = [];
    $mess = '';

    //look for user in the database
    if (isset($_SESSION['log'])) {

        $db = MysqliDb::getInstance();
        $db->where('Login', trim($_SESSION['log']));
        $row = $db->getOne('customers', 'cust_password, actions');

        if (! $row) {
            $mess .= 'Пользователь  не найден. ';
        }
        if (! isset($_SESSION['pass'])) {
            $mess .= 'Пароль не сохранен. ';
        }
        if (($_SESSION['pass'] !== $row['cust_password'])) {
            $mess .= 'Пароль не совпадает ';
        }

        if ($mess !== '') {
            unset($_SESSION['log']);
            unset($_SESSION['pass']);
            unset($_SESSION['current_currency']);
        } else {

            try {
                $rls = unserialize($row['actions']);
                unset($row);
            } catch (Exception $e) {
                $rls = [];
            }

        }

    } else {
        $mess .= 'Пользователь  не залогинен. ';
    }

    if ($mess !== '') {
        bdump($mess);
    }

    return $rls;
}

function verifyPassword($login, $password)
{
    $db = MysqliDb::getInstance();
    $db->where('Login', trim($login));
    $row = $db->getOne('customers', 'cust_password, CID');

    if (($db->count != 1) || $db->getLastError()) {
        bdump("Wrong Login! [{$login}]; " . $db->getLastError());
        return false;
    }

    // if ($db->count > 0 && password_verify($password, $row['cust_password'])) {
    if (password_verify($password, $row['cust_password'])) {

        $_SESSION['log']              = $login;
        $_SESSION['pass']             = $row['cust_password']; //password_hash($password, PASSWORD_DEFAULT);
        $_SESSION['current_currency'] = $row['CID'];

        // update statistic
        // stAddCustomerLog($login);
        // move cart content into DB
        // moveCartFromSession2DB();
        // dump(['set_SESSION' => $_SESSION]);

        return true;
    } else {
        bdump("Wrong password for [{$login}]");
        return false;
    }

}

function regForceSavePassword($login, $password)
{

    // dumpe([$login, $password]);

    // Хеширование пароля
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $data = [
        'cust_password' => $hashedPassword,
        'Login'         => trim($login),
    ];

    $db = MysqliDb::getInstance();
    $db->where('Login', trim($login));

    if ($db->update('customers', $data)) {
        bdump($db->count . ' records were updated');
    } else {
        bdump('update failed: ' . $db->getLastError());
    }

    dump([
        'sql'            => $db->getLastQuery(),
        'hashedPassword' => $hashedPassword,
        'ПАРОЛЬ СБРОШЕН' => $data,
        '_POST'          => $_POST['user_pw'],
    ]);

    // dumpe($db->getLastQuery());
    return $hashedPassword;
}

$site_url = 'ant2025.os';
$logo256  = 'logo256.jpg';

$access_denied_html = '<div class="alert alert-danger d-flex align-items-center my-5" role="alert"><div>Access Denied<div></div>';

$bootstrap_icons_css_local = '<link rel="stylesheet" href="/lib/bootstrap-icons-1.11.3/font/bootstrap-icons.min.css">';
$bootstrap_css_local       = '<link rel="stylesheet" href="/lib/bootstrap-5.3.3-dist/css/bootstrap.min.css">';

$bootstrap_icons_css_CDN = '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">';
$bootstrap_css_CDN       = '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">';

$ERROR_FORBIDDEN_HTML = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/media/favicon.ico" rel="shortcut icon" type="image/x-icon">
    <title>Login Form</title>
{$bootstrap_icons_css_local}
{$bootstrap_css_local}

</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4 my-5">
                <h2 class="text-center mt-5">{$site_url}</h2>

                <img alt="nix.by" class="d-block mx-auto rounded" src="/media/{$logo256}" style="background-color:#fff;margin:60px">

                <form id="aushform" method="post">
                    <div class="mb-3">
                        <label for="user_login" class="form-label">Username</label>
                        <input type="text" class="form-control" id="user_login" name="user_login" value="admin" placeholder="Enter username">
                    </div>
                    <div class="mb-3">
                        <label for="user_pw" class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="user_pw" name="user_pw" id="user_pw" placeholder="Enter password">
                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                <i class="bi bi-eye-slash" id="toggleIcon"></i>
                            </button>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Sign in</button>
                </form>
                {$access_denied_html}
            </div>
        </div>
    </div>
    <script>
    document.getElementById('togglePassword').addEventListener('click', function() {
        const password = document.getElementById('user_pw');
        const icon = document.getElementById('toggleIcon');
        if (password.type === 'password') {
            password.type = 'text';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        } else {
            password.type = 'password';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        }
    });
    </script>
</body>

</html>
HTML;

define('ERROR_FORBIDDEN', $ERROR_FORBIDDEN_HTML);
