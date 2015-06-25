<?php

function autoload($className)
{
    if(is_load_exception($className)) return;
    $className = ltrim($className, '\\');
    $fileName  = '';
    $namespace = '';
    if ($lastNsPos = strrpos($className, '\\')) {
        $namespace = substr($className, 0, $lastNsPos);
        $className = substr($className, $lastNsPos + 1);
        $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
    }
    $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
    require $fileName;
}
function is_load_exception($className) {
  return ($className=="wp_atom_server" || $className=="WP_User_Search" || $className=="Repos\Service");
}
spl_autoload_register('autoload');
?>
