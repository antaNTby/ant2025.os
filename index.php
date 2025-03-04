<?php
require __DIR__ . '/vendor/autoload.php';

Tracy\Debugger::$logDirectory = __DIR__ . '/debuggerLog';
// Tracy\Debugger::$dumpTheme = 'dark';
Tracy\Debugger::$dumpTheme = 'light';
Tracy\Debugger::$showBar   = true;
Tracy\Debugger::$maxDepth  = 2;  // default: 3
Tracy\Debugger::$maxLength = 80; // default: 150
// Tracy\Debugger::$editor    = "editor://open/?file=%file&line=%line";
Tracy\Debugger::$editor = '%file:%line';

require_once __DIR__ . '/vendor/thingengineer/mysqli-database-class/MysqliDb.php';

// запускаем сессию
require_once __DIR__ . '/admin/index.php';

# сбрасываем время сессии
session_cache_expire();
Tracy\Debugger::setSessionStorage(new Tracy\NativeSession);
Tracy\Debugger::enable();
Tracy\Debugger::timer();

### шаблонизатор Smarty 5.x
use Smarty\Smarty;

$smarty = new Smarty();
$smarty->setTemplateDir(__DIR__ . '/admin/tpl'); // здесь лежат шаблоны tpl.html

$smarty->setCompileDir(__DIR__ . '/admin/smarty/compile_dir');  // здесь компилируюся *.php
$smarty->setConfigDir(__DIR__ . '/admin/smarty/smarty_config'); // незнаю
$smarty->setCacheDir(__DIR__ . '/admin/smarty/smarty_cache');

$smarty->compile_id    = 'ant2025';
$smarty->force_compile = true;
// $smarty->setEscapeHtml(true); //Enable auto-escaping for HTML as follows:
$smarty->setEscapeHtml(false);
// $smarty->testInstall();
// $smarty->testInstall();

### конец ### шаблонизатор Smarty 5.x

require_once __DIR__ . '/admin/admin.php';
