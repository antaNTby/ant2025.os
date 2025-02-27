<?php
#### index.php ####
### 2025-02-19 ####
require '../vendor/autoload.php';

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
// Debugger::$keysToHide = ['password' /* ... */]; // (string[]) по умолчанию []

Debugger::$logDirectory = __DIR__ . '/debuggerLog';

// Debugger::$dumpTheme = 'dark';
Debugger::$dumpTheme = 'light';
// Debugger::$showBar = false;
Debugger::$maxDepth  = 2;  // default: 3
Debugger::$maxLength = 80; // default: 150

// формат ссылки для открытия в редакторе
// Debugger::$editor = /* ... */; // (string|null) по умолчанию 'editor://open/?file=%file&line=%line'
// Debugger::$editor = 'subl://open?file=%file&line=%line';
Debugger::$editor = 'editor://open/?file=%file&line=%line';
// Debugger::enable();
// Debugger::setSessionStorage(new Tracy\NativeSession);
// Debugger::dispatch();

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
// $smarty->testInstall();

// dump($smarty->compile_id);

### конец ### шаблонизатор Smarty 5.x

##### MysqliDb -- Simple MySQLi wrapper and object mapper with prepared statements
/*
vendor\thingengineer\mysqli-database-class\dbObject.md
https://github.com/ThingEngineer/PHP-MySQLi-Database-Class
composer require thingengineer/mysqli-database-class:dev-master
*/

require_once '../vendor/thingengineer/mysqli-database-class/MysqliDb.php';

require_once 'admin.php';
