<?php

define('LIB_ROOT', realpath(__DIR__.'/../lib'));

$files = array(
    'Builder/BuilderInterface',
    'Builder/ClassBuilder',
    'Builder/MethodBuilder',
    'Builder/PropertyBuilder',
);

foreach ($files as $file) {
    require_once LIB_ROOT.DIRECTORY_SEPARATOR.'OOPbuilder'.DIRECTORY_SEPARATOR.$file.'.php';
}
