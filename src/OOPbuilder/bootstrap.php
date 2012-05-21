<?php

define('SRC_ROOT', realpath(__DIR__));
define('ROOT', realpath(__DIR__.'/../../'));

require_once SRC_ROOT.'/OOPbuilder/Autoloader.php';
require_once SRC_ROOT.'/Pimple/lib/Pimple.php';

use OOPbuilder\Autoloader;
use OOPbuilder\Config;
use OOPbuilder\Parser\UMLparser;

$container = new Pimple();

$container['autoloader.files'] = array(
    'OOPbuilder' => array(
        'Helper',
        'OOPbuilder',
        'Config',

        'Builder/BuilderInterface',
        'Builder/ClassBuilder',
        'Builder/MethodBuilder',
        'Builder/PropertyBuilder',

        'Parser/ParserInterface',
        'Parser/UMLparser',

        'File/File',
        'File/FileMapper',
    )
);
$container['autoloader.class'] = 'OOPbuilder\Autoloader';
$container['autoloader.init'] = function($c) {
    $autoloader = new $c['autoloader.class']();

    foreach ($c['autoloader.files'] as $file) {
        $autoloader->set($file);
    }

    return $autoloader;
};
$container['autoloader'] = function($c) {
    $c['autoloader.init']->run();
};

$container['config.data.file'] = current(glob(ROOT.'/*.uml'));
$container['config.data'] = function($c) {
    $umlParser = new UMLparser();
    if (!file_exists($c)) {
        throw new LogicException('There is no uml file found at '.ROOT);
    }

    return $umlParser->parse(file_get_contents($c));
};
$container['config.init'] = function($c) {
    $config = new Config();

    foreach ($c['config.umlfile'] as
};
