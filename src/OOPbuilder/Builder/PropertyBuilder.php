<?php
/**
 * This file is part of the OOPbuilder project
 *
 * @author Wouter J <http://wouterj.nl>
 * @license Creative Commons Attribution Share-Alike <http://creativecommons.org/licenses/by-sa/3.0/>
 */

namespace OOPbuilder\Builder;

use OOPbuilder\Helper;

/**
 * Build a Property.
 */
class PropertyBuilder implements BuilderInterface
{
    protected $name;
    protected $access;
    protected $defaultValue;

	/**
	 * Constructor.
	 *
	 * @param string $name		   The name of the property
	 * @param string $access	   Optional The access of the property, can be public(default), protected, or private
	 * @param mixed  $defaultValue Optional The default value of the parameter
	 */
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
     * Create the property.
     *
     * @return string The source of the property
     */
    public function build()
    {
        return $this->access.' $'.$this->name.($this->defaultValue !== null
                                                   ? ' = '.trim($this->defaultValue)
                                                   : ''
                                              ).';';
    }
}
