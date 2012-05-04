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
        $this->defaultValue = ($defaultValue == null 
                                    ? null
                                    : $this->parseValue($defaultValue)
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

    /**
     * Parses a value to a nice value
     *
     * @access protected
     * @param string $value
     * @return string $valueSource The resulted value source
     */
    protected function parseValue($value)
    {
        if (is_numeric($value)                                  # interger/float
            || in_array($value, array('true', 'false', 'null')) # true/false/null
            || preg_match('/^array\((.*?)\)$/i', $value)        # array
            || preg_match('/^new\s(.*?)/', $value)              # instance
            || in_array($value, array("''", '""'))              # empty string
           ) {
            $valueSource = $value;
        }
        else {
            $valueSource = "'".$value."'";
        }

        return $valueSource;
    }
}
