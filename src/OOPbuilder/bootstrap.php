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

        'Exception/BadArgumentTypeException',
        'Exception/BadInstanceOfArgumentException',

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
$container['autoloader.init'] = function ($c) {
    $autoloader = new $c['autoloader.class']();

    foreach ($c['autoloader.files'] as $file) {
        $autoloader->set($file);
    }

    return $autoloader;
};
$container['autoloader'] = function ($c) {
    $c['autoloader.init']->run();
};

$container['config.data.file'] = current(glob(ROOT.'/*.uml'));
$container['config.data'] = function ($c) {
    $umlParser = new UMLparser();
    if (!file_exists($c['config.data.file'])) {
        throw new LogicException('There is no uml file found at '.ROOT);
    }

    $data = array();
    $data['content'] = $umlParser->parse(file_get_contents($c));
    $data['projectname'] = basename($c['config.data.file'], '.uml');

    return $data;
};
$container['config'] = function ($c) {
    $config = new Config();

    foreach ($c['config.data'] as $setting => $value) {
        $config->set($setting, $value);
    }

    return $config;
};

$container['oopbuilder.config'] = $container['config'];
$container['oopbuilder'] = function ($c) {
    $config = $c['oopbuilder.config'];

    try {
        $oopBuilder = new OOPbuilder($config);
    } catch (\InvalidArgumentException $e) {
        echo $e->getMessage();
    }
};
