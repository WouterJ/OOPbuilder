<?php

namespace OOPbuilder;

class Helper
{
    /**
     * Parses a value to a nice value
     *
     * @param string $value
     * @return string $valueSource The resulted value source
     */
    public static function parseValue($value)
    {
        if (is_numeric($value)                                      # interger/float
            || in_array($value, array('true', 'false', 'null'))     # true/false/null
            || preg_match('/^array\((.*?)\)$/i', $value)            # array
            || preg_match('/^new\s(.*?)/', $value)                  # instance
            || (in_array(substr($value, 0, 1), array("'", '"'))     # already quoted string
                && in_array(substr($value, -1), array("'", '"'))
               )
           ) {
            $valueSource = $value;
        }
        else {
            $valueSource = "'".$value."'";
        }

        return $valueSource;
    }

    /**
     * Validates an access
     *
     * @param string $access The access input
     * @return boolean $is_access When it is a valid access
     */
    public static function is_access($value)
    {
        return in_array($value, array(
                   'public',
                   'protected',
                   'private',
               ));
    }
}
