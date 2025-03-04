<?php

require_once PATH_CORE . 'const.php';    // управляющие и служебные константы
require_once PATH_CORE . 'orklang.php';  // строки текста
require_once PATH_CORE . 'settings.php'; // настройки
require_once PATH_CORE . 'functions.php';
require_once PATH_CORE . 'headers.php';
require_once PATH_CORE . 'tables.php';

$_POST   = stripslashes_deep($_POST);
$_GET    = stripslashes_deep($_GET);
$_COOKIE = stripslashes_deep($_COOKIE);

require_once PATH_CORE . 'login_html.php';

if (isset($_COOKIE['PHPSESSID'])) {
    if (SECURITY_EXPIRE > 0) {
        set_cookie('PHPSESSID', $_COOKIE['PHPSESSID'], time() + SECURITY_EXPIRE);
    } else {
        set_cookie('PHPSESSID', $_COOKIE['PHPSESSID']);
    }
}

// ЗДЕСЬ ВСТАВЛЯЮТСЯ DO=PROCESSOR
$relaccess = checkLoginMe();
dump($_SESSION);
// dump($relaccess);

// if ((! isset($_SESSION['log']) || ! in_array(100, $relaccess))) {
//     $wrongLoginOrPw = 1;

//     $elapsed = Tracy\Debugger::timer();
//     // dump($elapsed);
//     die(ERROR_FORBIDDEN);
// } else {
//     $LOG_OK = true;
// //define start smarty template
//     $smarty->assign('log_error', '');
//     $smarty->assign('admin_main_content_template', 'start.tpl.html');
// }

if (! isset($_SESSION['log']) || ! in_array(100, $relaccess)) {

    if (isset($_POST['user_login']) && isset($_POST['user_pw'])) {

        if (regAuthenticate($_POST['user_login'], $_POST['user_pw'])) {
            dump([$_SESSION, $_POST['user_login'], $_POST['user_pw']]);
            Redirect(set_query('&__tt='));
        }

        die(ERROR_FORBIDDEN);
    }

    die(ERROR_FORBIDDEN);
} else {
    die(ERROR_FORBIDDEN);
}

# user logout
if (isset($_GET['logout'])) {
    unset($_SESSION['log']);
    unset($_SESSION['pass']);

    // RedirectJavaScript(ADMIN_FILE . '?access_deny=' . SITE_URL);
    // RedirectJavaScript(ADMIN_FILE);

    if (in_array(100, $relaccess)) {
        Redirect(ADMIN_FILE);
    } else {
        // Redirect("/index.php?user_details=yes");
        // Redirect('/index.php');
        die(ERROR_FORBIDDEN);
    }

    die(ERROR_FORBIDDEN);
}

###

### define department and subdepartment
// include_once PATH_CORE . 'departments.php';

// include_once PATH_CORE . 'admin_end.php';

// или вход или введите пароль
if (isset($_SESSION['log'])) {
    $smarty->assign('adminlogname', $_SESSION['log']);
}

// $smarty->display('admin.tpl.html');
