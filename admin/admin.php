<?php

// echo __DIR__ . '-admin.php-<br>';

require_once PATH_CORE . 'const.php';    // управляющие и служебные константы
require_once PATH_CORE . 'orklang.php';  // строки текста
require_once PATH_CORE . 'settings.php'; // настройки
require_once PATH_CORE . 'functions.php';
require_once PATH_CORE . 'headers.php';
require_once PATH_CORE . 'tables.php';

$_POST   = stripslashes_deep($_POST);
$_GET    = stripslashes_deep($_GET);
$_COOKIE = stripslashes_deep($_COOKIE);

// require_once PATH_CORE . 'authentication.php';

if (isset($_COOKIE['PHPSESSID'])) {
    if (SECURITY_EXPIRE > 0) {
        set_cookie('PHPSESSID', $_COOKIE['PHPSESSID'], time() + SECURITY_EXPIRE);
    } else {
        set_cookie('PHPSESSID', $_COOKIE['PHPSESSID']);
    }
}

// unset($_SESSION['log']);
// unset($_SESSION['pass']);
// unset($_SESSION['current_currency']);
// regForceSavePassword($_POST['user_login'], $_POST['user_pw']);

// ЗДЕСЬ ВСТАВЛЯЮТСЯ DO=PROCESSOR

$relaccess = checkLogin();

if (! isset($_SESSION['log']) || ! in_array(100, $relaccess)) {

    if (isset($_POST['user_login']) && isset($_POST['user_pw'])) {
        // regForceSavePassword($_POST['user_login'], $_POST['user_pw']);

        $hs = verifyPassword($_POST['user_login'], $_POST['user_pw']);

        if ($hs) {
            $url = set_query('&__tt=');
            // bdump($url);
            Redirect($url);
        }

        die(ERROR_FORBIDDEN);
    }

    die(ERROR_FORBIDDEN);
}

//  else {
//     die(ERROR_FORBIDDEN);
// }

# user logout
if (isset($_GET['logout'])) {

    unset($_SESSION['log']);
    unset($_SESSION['pass']);
    unset($_SESSION['current_currency']);

    // RedirectJavaScript(ADMIN_FILE . '?access_deny=' . SITE_URL);
    // RedirectJavaScript(ADMIN_FILE);

    if (in_array(100, $relaccess)) {
        Redirect('/');
    } else {
        // Redirect("/index.php?user_details=yes");
        // Redirect('/index.php');
        die(ERROR_FORBIDDEN);
    }

    die(ERROR_FORBIDDEN);
}

###

if (isset($_SESSION['log'])) {
    $smarty->assign('adminlogname', $_SESSION['log']);
}
//define start smarty template
$smarty->assign('admin_main_content_template', 'start.tpl.html');

$smarty->display('admin.tpl.html');
