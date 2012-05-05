<?php

define('SRC_ROOT', realpath(__DIR__.'/../src'));

$files = array(
    'Helper',

    'Builder/BuilderInterface',
    'Builder/ClassBuilder',
    'Builder/MethodBuilder',
    'Builder/PropertyBuilder',

	'Parser/ParserInterface',
	'Parser/UMLparser',
);

foreach ($files as $file) {
    require_once SRC_ROOT.DIRECTORY_SEPARATOR.'OOPbuilder'.DIRECTORY_SEPARATOR.$file.'.php';
}
