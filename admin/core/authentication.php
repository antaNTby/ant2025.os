<?php
### authentication.php
function checkLogin()
{

    $rls = [];
    //look for user in the database
    if (isset($_SESSION['log'])) {

        // $q   = db_query('SELECT cust_password, actions FROM ' . CUSTOMERS_TABLE . "WHERE Login = '" . trim($_SESSION['log']) . "'");
        // $row = db_fetch_row($q);

        $db = MysqliDb::getInstance();
        $db->where('Login', trim($_SESSION['log']));
        $row = $db->getOne('customers', 'cust_password, actions');

        // dump($row);
        //found customer - check password
        //unauthorized access

        dump([
            'cust_password'   => $row['cust_password'],
            "SESSION['pass']" => $_SESSION['pass'],
            'is not true'     => ($row['cust_password'] != $_SESSION['pass']),
            "password_verify" => password_verify($_POST['user_pw'], $row['cust_password'], )
            ,
        ]);

        if (! $row || ! isset($_SESSION['pass']) || ! password_verify($_POST['user_pw'], $row['cust_password'])) {

            unset($_SESSION['log']);
            unset($_SESSION['pass']);
            unset($_SESSION['current_currency']);

            dump([
                "DROP_SESSION" => $_SESSION,
                "row_actions"  => $row['actions'],
            ]);

        } else {

            $rls = unserialize($row['actions']);

            dump($rls);
            unset($row);
            # fix log errors WARNING: in_array() expects parameter 2 to be array, boolean given
            if (! is_array($rls)) {
                $rls = [];
            }

        }
    }

    return $rls;
}

function regAuthenticate($login, $password)
{
    $db = MysqliDb::getInstance();
    $db->where('Login', trim($login));
    $row = $db->getOne('customers', 'cust_password, CID');

    dump([
        "function"        => "regAuthenticate",
        "_POST"           => $_POST['user_pw'],
        "password"        => $password,
        "row"             => $row['cust_password'],
        "password_verify" => password_verify($password, $row['cust_password']),
    ]);

    if ($db->count > 0 && password_verify($password, $row['cust_password'])) {

        $_SESSION['log']              = $login;
        $_SESSION['pass']             = $row['cust_password']; //password_hash($password, PASSWORD_DEFAULT);
        $_SESSION['current_currency'] = $row['CID'];

        // update statistic
        // stAddCustomerLog($login);
        // move cart content into DB
        // moveCartFromSession2DB();
        dump(["set_SESSION" => $_SESSION]);

        return true;
    } else {
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
        "sql"            => $db->getLastQuery(),
        "hashedPassword" => $hashedPassword,
        "ПАРОЛЬ СБРОШЕН" => $data,
        "_POST"          => $_POST['user_pw'],
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
