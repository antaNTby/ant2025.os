<?php

header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Content-Type: text/html; charset=utf8");

// Заголовок для разрешения всех доменов
header("Access-Control-Allow-Origin: *");
// Разрешение определенного домена
// header("Access-Control-Allow-Origin: http://example.com");

// Дополнительные заголовки могут потребоваться для поддержки различных типов запросов
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
