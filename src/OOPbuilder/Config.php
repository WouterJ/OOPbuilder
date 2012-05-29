<?php
/**
 * This file is part of the OOPbuilder project
 *
 * @author Wouter J <http://wouterj.nl>
 * @license Creative Commons Attribution Share-Alike <http://creativecommons.org/licenses/by-sa/3.0/>
 */

namespace OOPbuilder;

/**
 * This class is the repository for the config
 */
class Config
{
    protected $setting = array();

	/**
	 * Sets a setting
	 *
	 * @param string $id The name of the setting
	 * @param mixed $value The value of the setting
	 */
    public function set($id, $value)
    {
        $this->$setting[$id] = $value;
    }

	/**
	 * Gest a setting
	 *
	 * @param string $id The name of the setting
	 *
	 * @return mixed The value of the given setting
     *
     * @throws \InvalidArgumentException When $id does not exists
	 */
    public function get($id)
    {
        if (!isset($this->$setting[$id])) {
            throw new \InvalidArgumentException(
                          sprintf(
                              'The %s setting does not exists in Config::get()',
                              $id
                          )
                      );
        }

        return $this->$setting[$id];
    }
}
