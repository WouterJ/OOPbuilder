<?php

class PropBuilder extends Builder
{
	protected $visibility = 'public';
	protected $name;
	protected $value;
	protected $type;

	public function __construct( $visibility, $type, $name, $value = null )
	{
		$vis = array(
			'--' => 'private',
			'-' => 'protected'
		);
		$this->visibility = (
			in_array($visibility, $vis)
				? $visibility
				: array_key_exists( $visibility, $vis )
					? $vis[$visibility]
					: 'public');
		$this->type = (string) strtolower($type);
		$this->name = (string) strtolower((substr($name, 1) == '$' 
								? $name 
								: '$'.$name));
		$this->value = addslashes($value);
	}

	public function __toString()
	{
		return $this->visibility.' '.$this->name.(empty($this->value)
													? ''
													: ' = '.stripslashes($this->value)).";";
	}
}
