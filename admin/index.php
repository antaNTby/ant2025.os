<?php
#### index.php ####
### 2025-02-19 ####
// echo __DIR__ . " -\admin\index.php-<br>";

session_set_save_handler('sess_open', 'sess_close', 'sess_read', 'sess_write', 'sess_destroy', 'sess_gc');
session_set_cookie_params(SECURITY_EXPIRE);

session_start();

####
####
####
####
####
####
####
####
####
####
####
####
####
####
####
####
####
####
####
####
####
####
####
####
####
####
####
####
####
####
####
####
####
####
####
####
####
####
####
####
####
####
####
####
####
####
####
####
####
####
####
####
####
####
####
####
####
####
####
####
####
####
####
####
####
####
####
####
####
####
####
####

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
