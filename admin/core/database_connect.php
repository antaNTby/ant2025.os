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

// require_once '../vendor/thingengineer/mysqli-database-class/MysqliDb.php';
// require_once 'core/database_connect.php';

// //Advanced initialization:
// $db = new MysqliDb($sqli_connect);

// $db->where('company_name', '%дом%', 'like');
// $db->orWhere('company_name', '%апа%', 'like');
// $data = $db->get('companies', 2); //contains an Array 10 companies

// dump($data);
// dump($data[0]['company_name']);

// echo "Last executed query was " . $db->getLastQuery();

/*

        $dumpO = '
        MysqliDb {#18 ▼
          #_mysqli: []
          #_query: null
          #_lastQuery: null
          #_queryOptions: []
          #_join: []
          #_where: []
          #_joinAnd: []
          #_having: []
          #_orderBy: []
          #_groupBy: []
          #_tableLocks: []
          #_tableLockMethod: "READ"
          #_bindParams: array:1 [▼
            0 => ""
          ]
          +count: 0
          +totalCount: 0
          #_stmtError: null
          #_stmtErrno: null
          #isSubQuery: false
          #_lastInsertId: null
          #_updateColumns: null
          +returnType: "array"
          #_nestJoin: false
          -_tableName: ""
          #_forUpdate: false
          #_lockInShareMode: false
          #_mapKey: null
          #traceStartQ: 0
          #traceEnabled: false
          #traceStripPrefix: ""
          +trace: []
          +pageLimit: 20
          +totalPages: 0
          #connectionsSettings: array:1 [▼
            "default" => array:7 [▼
              "host" => "MySQL-5.7"
              "username" => "root"
              "password" => ""
              "db" => "db_antCMS"
              "port" => 3306
              "socket" => null
              "charset" => "utf8mb4"
            ]
          ]
          +defConnectionName: "default"
          +autoReconnect: true
          #autoReconnectCount: 0
          #_transaction_in_progress: false
        }
        ';

        // dump($db);

        $db->jsonBuilder();
        $db->where('company_name', '%дом%', 'like');
        $db->orWhere('company_name', '%апа%', 'like');
        $data = $db->get('companies', 4); //contains an Array 10 companies
        bdump($data);

        // dump($data[0]['company_name']);
        echo "Last executed query was " . $db->getLastQuery();

        $db->objectBuilder();
        $db->where('company_name', '%пан%', 'like');
        $db->orWhere('company_name', '%кр%', 'like');
        $data = $db->get('companies', 4); //contains an Array 10 companies
        bdump($data);

        $db->arrayBuilder();
        $db->where('company_name', '%пан%', 'like');
        $db->orWhere('company_name', '%кр%', 'like');
        $data = $db->get('companies', 4); //contains an Array 10 companies
        bdump($data);

        $db->jsonBuilder();
        $db->where('company_name', '%дом%', 'like');
        $db->orWhere('company_name', '%апа%', 'like');
        $data = $db->get('companies', 4); //contains an Array 10 companies
        bdump($data);

        $db->where('company_name', '%дом%', 'like');
        $db->orWhere('company_name', '%апа%', 'like');
        $data = $db->get('companies', 4); //contains an Array 10 companies
        bdump($data);

        // dump($data[0]['company_name']);

        // echo "Last executed query was " . $db->getLastQuery();

*/
