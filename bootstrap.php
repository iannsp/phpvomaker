<?php
/*
 * get information about directory BS Framework are
 */

/**
 *
 * autoload to BS Framework Objects
 * @param string $name
 */
function _vomakerautoload_($name) {
	$pathinfo     =    pathinfo(dirname(__FILE__));
    $searchpath     =     explode('\\', $name);
    $name    = array_pop( $searchpath );
    $searchpath =  $pathinfo['dirname'].DIRECTORY_SEPARATOR.implode(DIRECTORY_SEPARATOR,$searchpath).DIRECTORY_SEPARATOR;
        if(file_exists("{$searchpath}{$name}.php")){
            require_once("{$searchpath}{$name}.php");
        }
}

/**
 * register this autoload function in spl_registers
 */
spl_autoload_register('_vomakerautoload_');
