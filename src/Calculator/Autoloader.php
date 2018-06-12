<?php
/**
 * Created by PhpStorm.
 * User: felix
 * Date: 6/11/18
 * Time: 5:12 PM
 */

class Autoloader
{
    static public function loader($className) {
        $filename = "src/Calculator/" . str_replace("\\", '/', $className) . ".php";
        if (file_exists($filename)) {
            include($filename);
            if (class_exists($className)) {
                return TRUE;
            }
        }
        return FALSE;
    }
}
spl_autoload_register('Autoloader::loader');