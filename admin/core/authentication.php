<?php
### authentication.php

define('SECURITY_EXPIRE', 60 * 60 * CONF_SECURITY_EXPIRE);
$LOG_OK = false;

session_set_save_handler('sess_open', 'sess_close', 'sess_read', 'sess_write', 'sess_destroy', 'sess_gc');

session_set_cookie_params(SECURITY_EXPIRE);

# посылаем cookie сессии
if (isset($_COOKIE['PHPSESSID'])) {
    if (SECURITY_EXPIRE > 0) {
        set_cookie('PHPSESSID', $_COOKIE['PHPSESSID'], time() + SECURITY_EXPIRE);
    } else {
        set_cookie('PHPSESSID', $_COOKIE['PHPSESSID']);
    }
}

// ЗДЕСЬ ВСТАВЛЯЮТСЯ DO=PROCESSOR

// cls();

$relaccess = checklogin();

if ((! isset($_SESSION['log']) || ! in_array(100, $relaccess))) {

    if (isset($_POST['user_login']) && isset($_POST['user_pw']))
    // if (isset($_POST['user_login']))

    {

        // включено подтверждение регистрации
        if (regAuthenticate($_POST['user_login'], $_POST['user_pw'])) {

            Redirect(set_query('&__tt='));

        }
        die(ERROR_FORBIDDEN_LOGIN);
    }

    $wrongLoginOrPw = 1;
    die(ERROR_FORBIDDEN);
} else {
    $LOG_OK = true;
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
        Redirect("/index.php");
    }

    die(ERROR_FORBIDDEN);
}
