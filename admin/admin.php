<?php
const PATH_CORE = 'admin/core/';

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

// $db->where('company_name', '%дом%', 'like');
// $db->orWhere('company_name', '%апа%', 'like');
// $data = $db->get('companies', 4); //contains an Array 10 companies
// bdump($data);

#########
#########
#########
#########
#########

require_once PATH_CORE . 'const.php';    // управляющие и служебные константы
require_once PATH_CORE . 'orklang.php';  // строки текста
require_once PATH_CORE . 'settings.php'; // настройки
require_once PATH_CORE . 'functions.php';
require_once PATH_CORE . 'headers.php';
require_once PATH_CORE . 'tables.php';

$LOG_OK = false;
define('SECURITY_EXPIRE', 60 * 60 * CONF_SECURITY_EXPIRE);
require_once PATH_CORE . 'loginHtml.php'; // управляющие и служебные константы

// $smarty->display('error_forbidden_login.tpl.html');

// include_once PATH_CORE . 'authentication.php';
if (isset($_COOKIE['PHPSESSID'])) {
    if (SECURITY_EXPIRE > 0) {
        set_cookie('PHPSESSID', $_COOKIE['PHPSESSID'], time() + SECURITY_EXPIRE);
    } else {
        set_cookie('PHPSESSID', $_COOKIE['PHPSESSID']);
    }
}

session_set_save_handler('sess_open', 'sess_close', 'sess_read', 'sess_write', 'sess_destroy', 'sess_gc');
session_set_cookie_params(SECURITY_EXPIRE);

$_POST   = stripslashes_deep($_POST);
$_GET    = stripslashes_deep($_GET);
$_COOKIE = stripslashes_deep($_COOKIE);

# сбрасываем время сессии
session_cache_expire();
# стартуем сессию
#####  session_start();
#####  Tracy can display Debug bar and Bluescreens for AJAX requests and redirects. Tracy creates its own sessions, stores #####  data in its own temporary files, and uses a `tracy-session` cookie.
#####
#####  Tracy can also be configured to use a native PHP session, which is started before Tracy is turned on:
#####
#####  ```php
session_start();
// Tracy\Debugger::setSessionStorage(new Tracy\NativeSession);
Tracy\Debugger::enable();

$relaccess = checkLoginMe();

echo "jjhjjj";

if ((! isset($_SESSION['log']) || ! in_array(100, $relaccess))) {
    $wrongLoginOrPw = 1;
    die(ERROR_FORBIDDEN);
} else {
    $LOG_OK = true;
//define start smarty template
    $smarty->assign('log_error', '');
    $smarty->assign('admin_main_content_template', 'start.tpl.html');
}

###

### define department and subdepartment
// include_once PATH_CORE . 'departments.php';

// include_once PATH_CORE . 'admin_end.php';

// или вход или введите пароль
if (isset($_SESSION['log'])) {
    $smarty->assign('adminlogname', $_SESSION['log']);
}
$smarty->display('admin.tpl.html');
