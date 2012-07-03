<?php
/**
 * This file is part of the OOPbuilder project
 *
 * @author Wouter J <http://wouterj.nl>
 * @license Creative Commons Attribution Share-Alike <http://creativecommons.org/licenses/by-sa/3.0/>
 */

namespace OOPbuilder\Console;

use Symfony\Component\Console\Application as BaseApplication;

/**
 * Handles the CLI
 */
class Application extends BaseApplication
{
    public function __construct()
    {
        parent::__construct('OOPbuilder', '2.0');
    }
}
