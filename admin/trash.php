<?php

####    "installed_packages":
####    [
####        "Advanced CSV",
####        "Color Highlight",
####        "CSV",
####        "CSV Record View",
####        "Dark Knight Color Scheme",
####        "HTML-CSS-JS Prettify",
####        "HTML5",
####        "INI",
####        "Package Control",
####        "phpfmt",
####        "SideBarEnhancements",
####        "Smarty",
####    ],

// echo "hello! admin index is here";

// $dird          = dirname($_SERVER['PHP_SELF']); ## "/"
// $sourcessrandd = ['//' => '/', '\\' => '/'];
// $dird          = strtr($dird, $sourcessrandd);
// $dirf          = ($dird != "/") ? "/" : "";
// $url =  "https://".$_SERVER['HTTP_HOST'] . $dird . $dirf;

// echo "<pre>dird  = `{$dird}`   </pre>";
// // echo "<pre>dirf  = `{$dirf}`   </pre>";
// // echo "<pre>url  = `{$url}`   </pre>";

// define('CONF_FULL_SHOP_URL', trim($url)); // "http://antcms.os/admin/"
// define('PATH_DELIMITER', (isset($_SERVER['WINDIR']) || isset($_SERVER['windir'])) ? ';' : ':');
// // Set the default timezone -- date_default_timezone_set('America/New_York');
// date_default_timezone_set('Europe/Minsk');
// // Set the default character encoding
// if (function_exists('mb_internal_encoding') === true)
// {
//     mb_internal_encoding('UTF-8');
// }

// Set the default locale
// if (function_exists('setlocale') === true)
// {
//     // setlocale(LC_ALL, 'en_US.UTF-8');
//     setlocale(LC_ALL, 'ru_Belarus.UTF-8');
// }

// echo CONF_FULL_SHOP_URL;

/*

{
    "phpcs_php_path":               "c:/OSPanel/modules/PHP-8.3/PHP",
    "phpcs_executable_path":        "c:/OSPanel/data/PHP-8.3/default/composer/vendor/bin/phpcs.bat",
    "phpmd_executable_path":        "c:/OSPanel/data/PHP-8.3/default/composer/vendor/bin/phpmd.bat",
    "phpcbf_executable_path":       "c:/OSPanel/data/PHP-8.3/default/composer/vendor/bin/phpcbf.bat",
    "php_cs_fixer_executable_path": "c:/OSPanel/data/PHP-8.3/default/composer/vendor/bin/php-cs-fixer.bat",
}

*/

// https://calc-best.ru/matematicheskie/delenie-umnozhenie-pribavlenie-i-vychitanie-stolbikom/delenie-stolbikom?n1=950&n2=19

// $variable = ['key' => 'value'];
// // VarDumper::dump($variable);

// class PropertyExample
// {
//     public string $publicProperty = 'The `+` prefix denotes public properties,';
//     protected string $protectedProperty = '`#` protected ones and `-` private ones.';
//     private string $privateProperty = 'Hovering a property shows a reminder.';
// }
// $varClass = new PropertyExample();
// dump($varClass);
### конец ### шаблонизатор Smarty 5.x

// dump($smarty->compile_id);

// dd("ddd");
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Проверка соединения
if ($mysqli->connect_error) {
    die('Ошибка подключения: ' . $mysqli->connect_error);
}

// Несколько SQL-запросов
$sql = "
    INSERT INTO `ant_ippost` (time_stamp,title,ip) VALUES (NOW(),'John Doe', '192.168.31.200');
    INSERT INTO `ant_ippost` (time_stamp,title,ip) VALUES (NOW(),'Jane Smith', '192.168.31.255');
    UPDATE `ant_ippost` SET ip = '192.168.1.111' WHERE title = 'John Doe';
";

if ($mysqli->multi_query($sql)) {
    do {
        // Если есть больше результатов
        if ($result = $mysqli->store_result()) {
            while ($row = $result->fetch_row()) {
                printf("%s\n", $row[0]);
            }
            $result->free();
        }
        // Проверка следующего результата
    } while ($mysqli->more_results() && $mysqli->next_result());
} else {
    echo "Ошибка выполнения multi-query: " . $mysqli->error;
}

// Закрытие соединения
$mysqli->close();

require_once '../classes/MySQLMultiQuery.php';

$testMQ = new MySQLMultiQuery(DB_HOST, DB_USER, DB_PASS, DB_NAME);

$sql = "
    INSERT INTO `ant_ippost` (time_stamp, title, ip) VALUES (NOW(), 'Baiden Old', '192.222.31.200');
    INSERT INTO `ant_ippost` (time_stamp, title, ip) VALUES (NOW(), 'Baiden Old', '192.222.31.200');
    INSERT INTO `ant_ippost` (time_stamp, title, ip) VALUES (NOW(), 'Baiden Old', '192.222.31.200');
    INSERT INTO `ant_ippost` (time_stamp, title, ip) VALUES (NOW(), 'Baiden Old', '192.222.31.200');
    INSERT INTO `ant_ippost` (time_stamp, title, ip) VALUES (NOW(), 'Trump Dumb', '192.222.31.255');
    INSERT INTO `ant_ippost` (time_stamp, title, ip) VALUES (NOW(), 'Baiden Old', '192.222.31.200');
    INSERT INTO `ant_ippost` (time_stamp, title, ip) VALUES (NOW(), 'Baiden Old', '192.222.31.200');
    INSERT INTO `ant_ippost` (time_stamp, title, ip) VALUES (NOW(), 'Trump Dumb', '192.222.31.255');
    INSERT INTO `ant_ippost` (time_stamp, title, ip) VALUES (NOW(), 'Baiden Old', '192.222.31.200');
    INSERT INTO `ant_ippost` (time_stamp, title, ip) VALUES (NOW(), 'Baiden Old', '192.222.31.200');
    INSERT INTO `ant_ippost` (time_stamp, title, ip) VALUES (NOW(), 'Trump Dumb', '192.222.31.255');
    INSERT INTO `ant_ippost` (time_stamp, title, ip) VALUES (NOW(), 'Baiden Old', '192.222.31.200');
    INSERT INTO `ant_ippost` (time_stamp, title, ip) VALUES (NOW(), 'Baiden Old', '192.222.31.200');
    INSERT INTO `ant_ippost` (time_stamp, title, ip) VALUES (NOW(), 'Trump Dumb', '192.222.31.255');
    INSERT INTO `ant_ippost` (time_stamp, title, ip) VALUES (NOW(), 'Baiden Old', '192.222.31.200');
    INSERT INTO `ant_ippost` (time_stamp, title, ip) VALUES (NOW(), 'Baiden Old', '192.222.31.200');
    INSERT INTO `ant_ippost` (time_stamp, title, ip) VALUES (NOW(), 'Trump Dumb', '192.222.31.255');
    INSERT INTO `ant_ippost` (time_stamp, title, ip) VALUES (NOW(), 'Trump Dumb', '192.222.31.255');
    INSERT INTO `ant_ippost` (time_stamp, title, ip) VALUES (NOW(), 'Trump Dumb', '192.222.31.255');
    INSERT INTO `ant_ippost` (time_stamp, title, ip) VALUES (NOW(), 'Trump Dumb', '192.222.31.255');
    UPDATE `ant_ippost` SET ip = '192.168.1.111' WHERE title like '%D%';
";

$testMQ->executeQueries($sql);
echo "Количество выполненных запросов: " . $testMQ->getExecutedQueriesCount() . "\n";
echo "Время выполнения запросов: " . $testMQ->getExecutionTime() . " секунд\n";
echo "Вставленные ID: " . implode(', ', $testMQ->getInsertedIds()) . "\n";
echo "Обновленные записи: " . implode(', ', $testMQ->getUpdatedRows()) . "\n";
$testMQ->close();

{
    "cmd":["npm", "run", "dev"],
    "working_dir":"$project_path",
    "shell":true;
}
{
    "cmd":["npm", "run", "build"],
    "working_dir":"$project_path",
    "shell":true;
}
C: \Users\a\AppData\Roaming\Sublime Text\Packages\User;

"installed_packages":
[
    "Advanced CSV",
    "Color Highlight",
    "Color Scheme - Bass",
    "CSV",
    "CSV Record View",
    "Dark Knight Color Scheme",
    "HTML-CSS-JS Prettify",
    "HTML5",
    "INI",
    "LSP",
    "LSP-svelte",
    "Package Control",
    "phpfmt",
    "ReadonlyMode",
    "SideBarEnhancements",
    "Smarty",
],

// Settings in here override those in "/phpfmt/phpfmt.sublime-settings",

{
    "autocomplete":false,
    "autoimport":false,
    "excludes":[
        "SpaceBetweenMethods",
    ],
    "format_on_save":true,
    "passes":
    [
        "AlignDoubleArrow",
        "AlignPHPCode",
        "SpaceAfterExclamationMark",
        "AlignConstVisibilityEquals",
        "AutoSemicolon",
        "ConvertOpenTagWithEcho",
        "AlignSuperEquals",
        "MergeNamespaceWithOpenTag",
        "RemoveSemicolonAfterCurly",
        "RestoreComments",
        "ShortArray",
        "ExtraCommaInArray",
        "AlignDoubleSlashComments",

        "AlignEquals",
        "AlignGroupDoubleArrow",

    ],
    "php_bin":"c:/OSPanel/modules/PHP-8.3/PHP/php-win.exe",
    /*"php_bin": "c:/OSPanel/modules/PHP-8.3/PHP/php-win.exe",*/
    "psr1":false,
    "psr1_naming":false,
    "psr2":true,
    "readini":true,
    "smart_linebreak_after_curly":false,
    "version":4,
    "wp":false,
}
