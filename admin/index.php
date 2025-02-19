<?php 
#### index.php ####
### 2025-02-19 ####




require '../vendor/autoload.php';










echo "hello! admin index is here";

$dird          = dirname($_SERVER['PHP_SELF']); ## "/"
$sourcessrandd = ['//' => '/', '\\' => '/'];
$dird          = strtr($dird, $sourcessrandd);
$dirf          = ($dird != "/") ? "/" : "";
$url =  "https://".$_SERVER['HTTP_HOST'] . $dird . $dirf;

echo "<pre>dird  = `{$dird}`   </pre>";
// echo "<pre>dirf  = `{$dirf}`   </pre>";
// echo "<pre>url  = `{$url}`   </pre>";

define('CONF_FULL_SHOP_URL', trim($url)); // "http://antcms.os/admin/"
define('PATH_DELIMITER', (isset($_SERVER['WINDIR']) || isset($_SERVER['windir'])) ? ';' : ':');
// Set the default timezone -- date_default_timezone_set('America/New_York');
date_default_timezone_set('Europe/Minsk');
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

echo CONF_FULL_SHOP_URL;

/*

{
    "phpcs_php_path":               "c:/OSPanel/modules/PHP-8.3/PHP",
    "phpcs_executable_path":        "c:/OSPanel/data/PHP-8.3/default/composer/vendor/bin/phpcs.bat",
    "phpmd_executable_path":        "c:/OSPanel/data/PHP-8.3/default/composer/vendor/bin/phpmd.bat",
    "phpcbf_executable_path":       "c:/OSPanel/data/PHP-8.3/default/composer/vendor/bin/phpcbf.bat",
    "php_cs_fixer_executable_path": "c:/OSPanel/data/PHP-8.3/default/composer/vendor/bin/php-cs-fixer.bat",
}

*/