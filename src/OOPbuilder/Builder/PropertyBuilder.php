<?php

/**
 * This file is part of the OOPbuilder project
 *
 * @author Wouter J <http://wouterj.nl>
 * @license Creative Commons Attribution Share-Alike <http://creativecommons.org/licenses/by-sa/3.0/>
 */

namespace OOPbuilder\Builder;

use OOPbuilder\Helper;

class PropertyBuilder implements BuilderInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $access;

    /**
     * @var string
     */
    protected $defaultValue;

    public function __construct($name, $access = 'public', $defaultValue = null)
    {
        $this->name = $name;
        $this->access = (Helper::is_access($access)
                            ? $access
                            : 'public'
                        );
        $this->defaultValue = ($defaultValue == null 
                                    ? null
                                    : Helper::parseValue($defaultValue)
                              );
    }

    /**
     * Creates the property code
     *
     * @return string $property The source of one property
     */
    public function build()
    {
        return $this->access.' $'.$this->name.($this->defaultValue !== null
                                                   ? ' = '.trim($this->defaultValue)
                                                   : ''
                                              ).';';
    }
}
