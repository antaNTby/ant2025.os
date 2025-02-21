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
