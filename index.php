<?php
#### index.php ####
### 2025-02-19 ####
echo "hello! root index is here";

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
