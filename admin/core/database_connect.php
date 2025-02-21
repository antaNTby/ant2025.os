<?php
##### database_connect.php

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

const DBMS              = 'mysqli';             //   {$smarty.const.DBMS}          database host   # Database Driver Type (optional)
const DB_DRIVER         = 'mysqli';             //   {$smarty.const.DBMS}          database host   # Database Driver Type (optional)
const DB_HOST           = 'MySQL-5.7';          //   {$smarty.const.DB_HOST}       username # hostname:port (for Port Usage. Example: 127.0.0.1:1010)
const DB_USER           = 'root';               //   {$smarty.const.DB_USER}       database name # Database Name (required)
const DB_PASS           = '';                   //   {$smarty.const.DB_PASS}       database prefix
const DB_NAME           = 'db_antCMS';          //   {$smarty.const.DB_NAME}       password
const DB_PRFX           = 'ant_';               # Database Prefix (optional)
const DB_CHARSET        = 'utf8mb4';            # Database Charset (optional)
const DB_HEADERSCHARSET = 'utf8';               # Database Charset (optional)
const DB_COLLATION      = 'utf8mb4_unicode_ci'; # Database Charset Collation (optional)
const DB_CACHEDIR       = '../admin/database/database_cache';
const DB_PORT           = 3306;

$pdo_connect = [
    'host'           => DB_HOST,
    'db'             => DB_NAME,
    'user'           => DB_USER,
    'pass'           => DB_PASS,
    'charset'        => DB_CHARSET,
    'headersCharset' => DB_HEADERSCHARSET,
];

$sqli_connect = [
    'host'     => DB_HOST,
    'username' => DB_USER,
    'password' => DB_PASS,
    'db'       => DB_NAME,
    'port'     => DB_PORT,
    'prefix'   => DB_PRFX,
    'charset'  => DB_CHARSET,
];
