<?php

require_once PATH_CORE . 'const.php';    // управляющие и служебные константы
require_once PATH_CORE . 'orklang.php';  // строки текста
require_once PATH_CORE . 'settings.php'; // настройки
require_once PATH_CORE . 'functions.php';
require_once PATH_CORE . 'headers.php';
require_once PATH_CORE . 'tables.php';

require_once PATH_CORE . "login_html.php";

$relaccess = checkLoginMe();

// include_once PATH_CORE . 'authentication.php';
if (isset($_COOKIE['PHPSESSID'])) {
    if (SECURITY_EXPIRE > 0) {
        set_cookie('PHPSESSID', $_COOKIE['PHPSESSID'], time() + SECURITY_EXPIRE);
    } else {
        set_cookie('PHPSESSID', $_COOKIE['PHPSESSID']);
    }
}

$_POST   = stripslashes_deep($_POST);
$_GET    = stripslashes_deep($_GET);
$_COOKIE = stripslashes_deep($_COOKIE);

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
