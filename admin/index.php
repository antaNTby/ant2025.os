<?php 
#### index.php ####
### 2025-02-19 ####
require '../vendor/autoload.php';

// Set the default character encoding
if (function_exists('mb_internal_encoding') === true)
{
    mb_internal_encoding('UTF-8');
}
// Set the default locale
if (function_exists('setlocale') === true)
{
    // setlocale(LC_ALL, 'en_US.UTF-8');
    setlocale(LC_ALL, 'ru_Belarus.UTF-8');
}


### отладчик Symfony\Component\VarDumper
### https://symfony.com/doc/current/components/var_dumper.html#using-the-vardumper-component-in-your-phpunit-test-suite

use Symfony\Component\VarDumper\VarDumper;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;
use Symfony\Component\VarDumper\Cloner\VarCloner;

// Установка обработчика дампа
VarDumper::setHandler(function ($var) {
    // Создаем экземпляр HtmlDumper
    $dumper = new HtmlDumper();

    // Устанавливаем тему
    $dumper->setTheme('dark');

    // Настраиваем стили
    $dumper->setStyles([
        'default' => 'background-color:#282c34; opacity:0.8; color:#abb2bf; line-height:1.2em;',
        'num' => 'color:#d19a66;',
        'str' => 'color:#98c379;',
        'note' => 'color:#61afef;',
    ]);
    // Сбрасываем стили
    $dumper->setStyles([]);

    // Настраиваем опции отображения
    $dumper->setDisplayOptions([
        'maxDepth' => 3,
        'maxStringLength' => 80,
        // 'fileLinkFormat' => 'file://%f#L%l',
        // 'fileLinkFormat' => 'vscode://file/%f:%l'
        'fileLinkFormat' => 'subl://open?url=file://%f&line=%l'
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
use Smarty\Smarty;

$smarty = new Smarty();
$smarty->setTemplateDir('../admin/tpl');                        // здесь лежат шаблоны tpl.html

$smarty->setCompileDir('../admin/smarty/compile_dir'); // здесь компилируюся *.php
$smarty->setConfigDir('../admin/smarty/smarty_config/');           // незнаю
$smarty->setCacheDir('../admin/smarty/smarty_cache/');

$smarty->compile_id    = 'ant2025';
$smarty->force_compile = true;
// $smarty->setEscapeHtml(true); //Enable auto-escaping for HTML as follows:
$smarty->setEscapeHtml(false);
// $smarty->testInstall();
dump($smarty);

### конец ### шаблонизатор Smarty 5.x





// dd("ddd");









