<?php

define('SRC_ROOT', realpath(__DIR__.'/../src'));

$files = array(
    'Helper',
    'Builder/BuilderInterface',
    'Builder/ClassBuilder',
    'Builder/MethodBuilder',
    'Builder/PropertyBuilder',
);

foreach ($files as $file) {
    require_once SRC_ROOT.DIRECTORY_SEPARATOR.'OOPbuilder'.DIRECTORY_SEPARATOR.$file.'.php';
}
