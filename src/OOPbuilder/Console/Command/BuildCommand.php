<?php
/**
 * This file is part of the OOPbuilder project
 *
 * @author Wouter J <http://wouterj.nl>
 * @license Creative Commons Attribution Share-Alike <http://creativecommons.org/licenses/by-sa/3.0/>
 */

namespace OOPbuilder\Console\Command;

use Symfony\Component\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * The CLI command for building an application
 */
class BuildCommand extends Command
{
    public function configure()
    {
        $this
            ->setName('build')
            ->setDescription('Build a project based on the given UML file')
            ->addOption('--dry-run', null, InputOption::VALUE_NONE, 'Do nothing, just look what should be done');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
    }
}
