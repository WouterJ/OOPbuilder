<?php
/**
 * This file is part of the OOPbuilder project
 *
 * @author Wouter J <http://wouterj.nl>
 * @license Creative Commons Attribution Share-Alike <http://creativecommons.org/licenses/by-sa/3.0/>
 */

define('SRC_ROOT', realpath(__DIR__.'/../'));
define('ROOT', getcwd());

// register autoloader
require_once SRC_ROOT.'/vendor/autoload.php';

use OOPbuilder\Config;
use OOPbuilder\Parser\UMLparser;
use OOPbuilder\Builder\ClassBuilder;
use OOPbuilder\Builder\MethodBuilder;
use OOPbuilder\Builder\PropertyBuilder;

$container = new Pimple();

$container['config.data.file'] = function ($c) {
    $file = current(glob(ROOT.'/*.uml'));
    if (!file_exists($file)) {
        throw new LogicException('There is no uml file found at '.ROOT);
    }

    return $file;
};
// looks like a bug in PHP => Namespace of the use keywords is not used when using a string
// TODO Report this bug
//$container['config.class'] = 'UMLparser';
$container['config.data'] = function ($c) {
    try {
        // change this if bug is fixed
        $umlParser = new UMLparser();

        $data = array();
        $data['content'] = $umlParser->parse(file_get_contents($c['config.data.file']));
        $data['projectname'] = basename($c['config.data.file'], '.uml');

        return $data;
    } catch (Exception $e) {
        echo $e->getMessage().PHP_EOL.PHP_EOL;
    }
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

    $objects = $config->get('content');

    foreach ($objects as $object) {
        switch ($object['type']) {
            case 'class' :
                // handle classes

                // build the class
                $class = new ClassBuilder($object['name']);

                if (isset($object['implements'])) {
                    foreach (explode(',', $object['implements']) as $implement) {
                        $class->implement(trim($implement));
                    }
                }
                if (isset($object['extends'])) {
                    $class->extend(trim($object['extends']));
                }

                foreach ($object['properties'] as $property) {
                    // create properties
                    $class->addProperty(
                        new PropertyBuilder($property['name'], $property['access'], (isset($property['value'])
                                                                                            ? $property['value']
                                                                                            : null
                                                                                        ))
                                       );
                }

                foreach ($object['methods'] as $method) {
                    // create methods
                    $methodb = new MethodBuilder($method['name'], $method['access']);

                    foreach ($method['arguments'] as $argument) {
                        $methodb->addArgument($argument['name'], $argument['value']);
                    }

                    $class->addMethod($methodb);
                }

                var_dump($class->build());

                break;

            case 'interface' :
                // handle interfaces
                break;
        }
    }
};
$container['oopbuilder'] = function ($c) {
    $c['oopbuilder.createproject'];
};
