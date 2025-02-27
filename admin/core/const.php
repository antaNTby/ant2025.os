<?php
#### const.php
### КОНСТАНТЫ

// FROM connect.inc.php
const SLASH    = '/';                                 //   {$smarty.const.SLASH}
const SITE_URL = 'ant2025.os';                        //    {$smarty.const.SITE_URL}
                                                      // const CONF_FULL_SHOP_URL = 'antCMS.os/admin';                //    {$smarty.const.CONF_FULL_SHOP_URL}
const ADMIN_FILE        = '/admin/admin.php';         //    {$smarty.const.ADMIN_FILE}
const ADMIN_LOGOUT_LINK = ADMIN_FILE . '?logout=yes'; //    {$smarty.const.ADMIN_LOGOUT_LINK}

const FILEDEBUGJSON         = 'log/FILEDEBUG.JSON';   //  {$smarty.const.FILEDEBUGJSON}
const SQLDEBUG              = 'log/SQLDEBUG.JSON';    //  {$smarty.const.SQLDEBUG}
const SMARTYDEBUGJSON       = 'log/SMARTYDEBUG.JSON'; //  {$smarty.const.SMARTYDEBUGJSON}
const ADMIN_SMARTY_LOG_VARS = 0;                      //   {$smarty.const.ADMIN_SMARTY_LOG_VARS}

const ERROR_DB_INIT = SITE_URL . ' :: ' . 'Database connection problem!'; //   {$smarty.const.ERROR_DB_INIT} database system

const LOGO256 = 'logo256.jpg'; //   {$smarty.const.LOGO256}
const LOGO64  = 'logo64.jpg';  //   {$smarty.const.LOGO64}

const PATH_INCLUDES = 'core/includes/';

const PATH_CONFIGS      = 'core/configs/';
const PATH_DESCRIPTIONS = 'core/descriptions/';

const PATH_TPL     = 'tpl/';
const PATH_TPL_SUB = 'tpl/sub/';

const EXT_TPL = '.tpl.html';
