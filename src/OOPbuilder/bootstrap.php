<?php
/**
 * This file is part of the OOPbuilder project
 *
 * @author Wouter J <http://wouterj.nl>
 * @license Creative Commons Attribution Share-Alike <http://creativecommons.org/licenses/by-sa/3.0/>
 */

define('SRC_ROOT', realpath(__DIR__));
define('ROOT', realpath(__DIR__.'/../../'));

require_once SRC_ROOT.'/OOPbuilder/Autoloader.php';
require_once SRC_ROOT.'/Pimple/lib/Pimple.php';

use OOPbuilder\Autoloader;
use OOPbuilder\Config;
use OOPbuilder\Parser\UMLparser;

$container = new Pimple();

/**
 * All files who needs to be included
 */
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
/**
 * The autoloader class
 */
$container['autoloader.class'] = 'OOPbuilder\Autoloader';
/**
 * Fill the config class
 */
$container['autoloader.init'] = function ($c) {
    $autoloader = new $c['autoloader.class']();

    foreach ($c['autoloader.files'] as $file) {
        $autoloader->set($file);
    }

    return $autoloader;
};
/**
 * Run the autoloader to include all files
 */
$container['autoloader'] = function ($c) {
    $c['autoloader.init']->run();
};

$container['autoloader']();

$container['config.data.file'] = function ($c) {
    $file = current(glob(ROOT.'/*.uml'));
    if (!file_exists($file)) {
        throw new LogicException('There is no uml file found at '.ROOT);
    }

    return $file;
};
$container['config.class'] = 'UMLparser';
$container['config.data'] = function ($c) {
    $umlParser = new ();

    $data = array();
    $data['content'] = $umlParser->parse(file_get_contents($c['config.data.file']));
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

$container['oopbuilder.createproject'] = function ($c) {
    $config = $c['config'];

    var_dump($config);
};
$container['oopbuilder'] = function ($c) {
    $c['oopbuilder.createproject']();
};
