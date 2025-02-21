<?php
#### index.php ####
### 2025-02-19 ####
require '../vendor/autoload.php';

/*
 * Get Tracy up and running
 * https://tracy.nette.org/
 */

use Smarty\Smarty;
use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;
use Symfony\Component\VarDumper\VarDumper;
use Tracy\Debugger;

// в режиме разработки вы будете видеть уведомления или предупреждения об ошибках как BlueScreen
// Debugger::$strictMode = E_ALL; /* ... */; // (bool|int) по умолчанию false, вы можете выбрать только определенные уровни ошибок (например, E_USER_DEPRECATED | E_DEPRECATED)
Debugger::$strictMode = true; // display all errors
// Debugger::$strictMode = E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED; // all errors except deprecated notices
Debugger::$showLocation = true; // Shows all additional location information
// отображает беззвучные (@) сообщения об ошибках
Debugger::$scream = E_ALL; /* ... */; // (bool|int) по умолчанию false, с версии 2.9 можно выбрать только определенные уровни ошибок (например, E_USER_DEPRECATED | E_DEPRECATED)
// скрывать значения этих ключей (начиная с версии Tracy 2.8)
Debugger::$keysToHide = ['password' /* ... */]; // (string[]) по умолчанию []

Debugger::$logDirectory = 'C:/tmp';

// Debugger::$dumpTheme = 'dark';
Debugger::$dumpTheme = 'light';
// Debugger::$showBar = false;
Debugger::$maxDepth  = 2;  // default: 3
Debugger::$maxLength = 80; // default: 150

// формат ссылки для открытия в редакторе
// Debugger::$editor = /* ... */; // (string|null) по умолчанию 'editor://open/?file=%file&line=%line'
Debugger::$editor = 'subl://open?file=%file&line=%line';

Debugger::enable();

// пример вывода в плавающем окне
//            bdump([1, 3, 5, 7, 9], 'odd numbers up to ten');

// пример вывода в теле сайта
//            $arr=[222,333,44,5555,6,77777];
//            Debugger::dump($arr);

// Еще один полезный инструмент – секундомер отладчика с точностью до микросекунд:
//            Debugger::timer();
//            // sweet dreams my cherrie
//            sleep(2);
//            $elapsed = Debugger::timer();
//            // $elapsed = 2
//            echo $elapsed;
//            dump( $elapsed);

### отладчик Symfony\Component\VarDumper
### https://symfony.com/doc/current/components/var_dumper.html#using-the-vardumper-component-in-your-phpunit-test-suite

// Установка обработчика дампа
VarDumper::setHandler(function ($var) {
    // Создаем экземпляр HtmlDumper
    $dumper = new HtmlDumper();

    // Устанавливаем тему
    $dumper->setTheme('dark');

    // Настраиваем стили
    $dumper->setStyles([
        'default' => 'background-color:#282c34; opacity:0.8; color:#abb2bf; line-height:1.2em;',
        'num'     => 'color:#d19a66;',
        'str'     => 'color:#98c379;',
        'note'    => 'color:#61afef;',
    ]);
    // Сбрасываем стили
    $dumper->setStyles([]);

    // Настраиваем опции отображения
    $dumper->setDisplayOptions([
        'maxDepth'        => 3,
        'maxStringLength' => 80,
        // 'fileLinkFormat' => 'file://%f#L%l',
        // 'fileLinkFormat' => 'vscode://file/%f:%l'
        'fileLinkFormat'  => 'subl://open?url=file://%f&line=%l',
    ]);

    // Создаем экземпляр VarCloner
    $cloner = new VarCloner();

    // Вывод дампа в браузер
    $dumper->dump($cloner->cloneVar($var));
}); //VarDumper::setHandler

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

### шаблонизатор Smarty 5.x

$smarty = new Smarty();
$smarty->setTemplateDir('../admin/tpl'); // здесь лежат шаблоны tpl.html

$smarty->setCompileDir('../admin/smarty/compile_dir');  // здесь компилируюся *.php
$smarty->setConfigDir('../admin/smarty/smarty_config'); // незнаю
$smarty->setCacheDir('../admin/smarty/smarty_cache');

$smarty->compile_id    = 'ant2025';
$smarty->force_compile = true;
// $smarty->setEscapeHtml(true); //Enable auto-escaping for HTML as follows:
$smarty->setEscapeHtml(false);
$smarty->testInstall();
// dump($smarty->compile_id);

### КОНСТАНТЫ
// const DBMS          = 'mysqli';                                           //   {$smarty.const.DBMS}          database host
// const DB_HOST       = 'localhost';                                        //   {$smarty.const.DB_HOST}       username
// const DB_USER       = 'nixby_dbadmin';                                    //   {$smarty.const.DB_USER}       database name
// const DB_PASS       = 'openserver';                                       //   {$smarty.const.DB_PASS}       database prefix
// const DB_NAME       = 'db_antCMS';                                        //   {$smarty.const.DB_NAME}       password
// const DB_PRFX       = 'ant_';

// const DBMS    = 'mysqli';    //   {$smarty.const.DBMS}          database host
// const DB_HOST = 'localhost'; //   {$smarty.const.DB_HOST}       username
// const DB_USER = 'root';      //   {$smarty.const.DB_USER}       database name
// const DB_PASS = '';          //   {$smarty.const.DB_PASS}       database prefix
// const DB_NAME = 'db_antCMS'; //   {$smarty.const.DB_NAME}       password
// const DB_PRFX = 'ant_';

const DBMS    = 'mysqli';    //   {$smarty.const.DBMS}          database host
const DB_HOST = 'MySQL-5.7'; //   {$smarty.const.DB_HOST}       username
const DB_USER = 'root';      //   {$smarty.const.DB_USER}       database name
// const DB_PASS = 'root';      //   {$smarty.const.DB_PASS}       database prefix
const DB_PASS = '';          //   {$smarty.const.DB_PASS}       database prefix
const DB_NAME = 'db_antCMS'; //   {$smarty.const.DB_NAME}       password
const DB_PRFX = 'ant_';

$pdo_connect = [
    'user'           => DB_USER,
    'pass'           => DB_PASS,
    'db'             => DB_NAME,
    'host'           => DB_HOST,
    'charset'        => 'utf8mb4',
    'headersCharset' => 'utf8',
];

$config = [
    # Database Driver Type (optional)
    # default value: mysql
    # values: mysql, pgsql, sqlite, oracle
    'driver'    => 'mysql',

# Host name or IP Address (optional)
    # hostname:port (for Port Usage. Example: 127.0.0.1:1010)
    # default value: localhost
    'host'      => DB_HOST,

# IP Address for Database Host (optional)
    # default value: null
    'port'      => 3306,

# Database Name (required)
    'database'  => DB_NAME,

# Database User Name (required)
    'username'  => DB_USER,

# Database User Password (required)#
    'password'  => DB_PASS,

# Database Charset (optional)
    # default value: utf8
    'charset'   => 'utf8mb4',
    // 'charset'   => 'utf8',

# Database Charset Collation (optional)
    # default value: utf8_general_ci
    'collation' => 'utf8mb4_unicode_ci',
    // 'collation' => 'utf8_general_ci',

# Database Prefix (optional)
    # default value: null
    // 'prefix'    => DB_PRFX,
    'prefix'    => null,

# Cache Directory of the Sql Result (optional)
    # default value: __DIR__ . '/cache/'
    'cachedir'  => '../admin/database/database_cache',
    # default value: true
    'debug'     => true,
];

// dump($smarty->compile_id);
### конец ### шаблонизатор Smarty 5.x
