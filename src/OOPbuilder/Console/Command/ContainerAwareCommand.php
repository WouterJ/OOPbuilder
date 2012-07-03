<?php
/**
 * This file is part of the OOPbuilder project
 *
 * @author Wouter J <http://wouterj.nl>
 * @license Creative Commons Attribution Share-Alike <http://creativecommons.org/licenses/by-sa/3.0/>
 */

namespace OOPbuilder\Console\Command;

use Symfony\Component\Console\Command;

class ContainerAwareCommand extends Command
{
    /**
     * @var Pimple
     */
    private $container;

    protected function getContainer()
    {
        if (null === $this->container) {
            $this->setContainer();
        }

        return $this->container;
    }

    public function setContainer(\Pimple $container)
    {
        $this->container = $container;
    }
}
