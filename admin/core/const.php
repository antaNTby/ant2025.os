<?php
#### const.php
### КОНСТАНТЫ

// FROM connect.inc.php
const SLASH    = '/';                                 //   {$smarty.const.SLASH}
const SITE_URL = 'ant2025.os';                        //    {$smarty.const.SITE_URL}
                                                      // const CONF_FULL_SHOP_URL = 'antCMS.os/admin';                //    {$smarty.const.CONF_FULL_SHOP_URL}
const ADMIN_FILE        = '/admin/admin.php';         //    {$smarty.const.ADMIN_FILE}
const ADMIN_LOGOUT_LINK = ADMIN_FILE . '?logout=yes'; //    {$smarty.const.ADMIN_LOGOUT_LINK}

const ERROR_DB_INIT = SITE_URL . ' :: ' . 'Database connection problem!'; //   {$smarty.const.ERROR_DB_INIT} database system

const LOGO256 = 'logo256.jpg'; //   {$smarty.const.LOGO256}
const LOGO64  = 'logo64.jpg';  //   {$smarty.const.LOGO64}

const EXT_TPL = '.tpl.html';

const BOOTSTRAP_ICONS_CSS_LOCAL = '<link rel="stylesheet" href="/lib/bootstrap-icons-1.11.3/font/bootstrap-icons.min.css">';
const BOOTSTRAP_CSS_LOCAL       = '<link rel="stylesheet" href="/lib/bootstrap-5.3.3-dist/css/bootstrap.min.css">';

//         "symfony/var-dumper": "^7.2"
