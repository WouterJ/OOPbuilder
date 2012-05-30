<?php
/**
 * This file is part of the OOPbuilder project
 *
 * @author Wouter J <http://wouterj.nl>
 * @license Creative Commons Attribution Share-Alike <http://creativecommons.org/licenses/by-sa/3.0/>
 */

namespace OOPbuilder\Parser;

interface ParserInterface
{
    /**
     * Parse the given data in the given format.
     *
     * @param string $data The data
     */
	public function parse($data);
}
