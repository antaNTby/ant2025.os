<?php
#### index.php ####
### 2025-02-19 ####

const CONF_SECURITY_EXPIRE = 12; //   {$smarty.const.CONF_SECURITY_EXPIRE}
const CONF_SECURE_SESSIONS = 1;  //   {$smarty.const.CONF_SECURE_SESSIONS}
define('SECURITY_EXPIRE', 60 * 60 * CONF_SECURITY_EXPIRE);

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
        echo $db->count . 'records wereupdated' . '::' . $id;
    } else {
        echo 'replace failed: ' . $db->getLastError();
    }

    return true;
}

function sess_destroy($key)
{
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

session_set_save_handler('sess_open', 'sess_close', 'sess_read', 'sess_write', 'sess_destroy', 'sess_gc');
session_set_cookie_params(SECURITY_EXPIRE);

session_start();

// в режиме разработки вы будете видеть уведомления или предупреждения об ошибках как BlueScreen
// Tracy\Debugger::$strictMode = E_ALL; /* ... */; // (bool|int) по умолчанию false, вы можете выбрать только определенные уровни ошибок (например, E_USER_DEPRECATED | E_DEPRECATED)
// Tracy\Debugger::$strictMode = true; // display all errors
// Tracy\Debugger::$strictMode = E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED; // all errors except deprecated notices
// Tracy\Debugger::$showLocation = true; // Shows all additional location information
// отображает беззвучные (@) сообщения об ошибках
// Tracy\Debugger::$scream = E_ALL; /* ... */; // (bool|int) по умолчанию false, с версии 2.9 можно выбрать только определенные уровни ошибок (например, E_USER_DEPRECATED | E_DEPRECATED)
// скрывать значения этих ключей (начиная с версии Tracy 2.8)
// Tracy\Debugger::$keysToHide = ['password' /* ... */]; // (string[]) по умолчанию []

// пример вывода в плавающем окне
//            bdump([1, 3, 5, 7, 9], 'odd numbersuptoten');

// пример вывода в теле сайта
//            $arr=[222,333,44,5555,6,77777];
//            Tracy\Debugger::dump($arr);

// Еще один полезный инструмент – секундомер отладчика с точностью до микросекунд:
//            Tracy\Debugger::timer();
//            // sweet dreams my cherrie
//            sleep(2);
//            $elapsed = Tracy\Debugger::timer();
//            // $elapsed = 2
//            echo $elapsed;
//            dump($elapsed);

### отладчик Symfony\Component\VarDumper
### https://symfony.com/doc/current/components/var_dumper.html#using-the-vardumper-component-in-your-phpunit-test-suite

// Установка обработчика дампа

######### use Symfony\Component\VarDumper\Cloner\VarCloner;
######### use Symfony\Component\VarDumper\Dumper\HtmlDumper;
######### use Symfony\Component\VarDumper\VarDumper;
######### VarDumper::setHandler(function ($var) {
#########     // Создаем экземпляр HtmlDumper
#########     $dumper = new HtmlDumper();
#########
#########     // Устанавливаем тему
#########     $dumper->setTheme('dark');
#########
#########     // Настраиваем стили
#########     $dumper->setStyles([
#########         'default' => 'background - color: #282c34; opacity:0.8; color:#abb2bf; line-height:1.2em;',
#########         'num'     => 'color:#d19a66;',
#########         'str'     => 'color:#98c379;',
#########         'note'    => 'color:#61afef;',
#########     ]);
#########     // Сбрасываем стили
#########     $dumper->setStyles([]);
#########
#########     // Настраиваем опции отображения
#########     $dumper->setDisplayOptions([
#########         'maxDepth'        => 3,
#########         'maxStringLength' => 80,
#########         // 'fileLinkFormat' => 'file://%f#L%l',
#########         // 'fileLinkFormat' => 'vscode://file/%f:%l'
#########         'fileLinkFormat'  => 'subl://open?url=file://%f&line=%l',
#########     ]);
#########
#########     // Создаем экземпляр VarCloner
#########     $cloner = new VarCloner();
#########
#########     // Вывод дампа в браузер
#########     $dumper->dump($cloner->cloneVar($var));
######### }); //VarDumper::setHandler

####  //Выполняем _стлизованный_ дамп переменной
####  class PropertyExample
####  {
####      public string $publicProperty = 'The `+` prefix denotes public properties,';
####      protected string $protectedProperty = '`#` protected ones and `-` private ones.';
####      private string $privateProperty = 'Hovering a property shows a reminder.';
####  }
####  $varClass = new PropertyExample();
####  dump($varClass);
### конец ### отладчик Symfony\Component\VarDumper
