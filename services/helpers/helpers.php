<?php
define("COLOR_DEFAULT","\e[39m");
define("COLOR_BLACK","\e[30m");
define("COLOR_RED","\e[31m");
define("COLOR_GREEN","\e[32m");
define("COLOR_YELLOW","\e[33m");
define("COLOR_BLUE","\e[34m");
define("COLOR_MAGENTA","\e[35m");
define("COLOR_CRAY","\e[36m");
define("COLOR_LIGHT_GRAY","\e[37m");
define("COLOR_DARK_GRAY","\e[90m");
define("COLOR_LIGHT_RED","\e[91m");
define("COLOR_LIGHT_GREEN","\e[92m");
define("COLOR_LIGHT_YELLOW","\e[93m");

define("COLOR_LIGHT_BLUE","\e[94m");
define("COLOR_LIGHT_MAGENTA","\e[95m");
define("COLOR_LIGHT_CRAY","\e[96m");
define("COLOR_WHITE","\e[97m");

function echoWithColor(string $string,String $color){
        echo ($color.$string.COLOR_DEFAULT);
}
function readlineWithColor(string $string,String $color) : string{
    echoWithColor($string,COLOR_LIGHT_BLUE);
    return readline();
}

function getOs()
{
    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        $os = "Windows";
    } else {
        $os = "Linux";
    }
    return $os;
}

