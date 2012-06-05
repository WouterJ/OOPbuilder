<?php
/**
 * This file is part of the OOPbuilder project
 *
 * @author Wouter J <http://wouterj.nl>
 * @license Creative Commons Attribution Share-Alike <http://creativecommons.org/licenses/by-sa/3.0/>
 */

namespace OOPbuilder;

/**
 * A class who provide some extra functions.
 */
class Helper
{
    /**
     * Parses a value to a nice value.
     *
     * @todo deprecated this
     *
     * @param string $value The value
     *
     * @return string The resulted value source
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
        } else {
            $valueSource = "'".$value."'";
        }

        return $valueSource;
    }

    /**
     * Validates an access.
     *
     * @param string $value The access input
     *
     * @return boolean True when it is a valid access, false otherwise
     */
    public static function is_access($value)
    {
        return in_array($value, array(
                   'public',
                   'protected',
                   'private',
               ));
    }

    /**
     * Switched between a PSR-0 Class and the path
     *
     * @link https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md The PSR-0 standards
     *
     * @param string $className The classname (including prefixes or namespaces)
     * 
     * @return string The path (including filename)
     */
    public static function class2path($className)
    {
        $className = ltrim($className, '\\');
        $fileName  = '';
        $namespace = '';
        if ($lastNsPos = strripos($className, '\\')) {
            $namespace = substr($className, 0, $lastNsPos);
            $className = substr($className, $lastNsPos + 1);
            $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
        }
        return ($fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php');
    }
}
