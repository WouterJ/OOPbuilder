<?php

namespace OOPbuilder\Builder;

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
        $this->access = $access;
        $this->defaultValue = $defaultValue;
    }

    /**
     * Creates the property code
     *
     * @return string $property The source of one property
     */
    public function build()
    {
        return $this->access.' $'.$this->name.($this->defaultvalue !== null
                                                   ? ' = '.trim($this->defaultvalue)
                                                   : ''
                                              ).';';
    }
}
