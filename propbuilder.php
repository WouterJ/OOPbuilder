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
		$this->name = (substr($name, 1) == '$' 
							? $name
							: 'hello' );
		$this->value = addslashes($value);

		var_dump(get_object_vars($this));
	}

	public function __toString()
	{
		$prop = $this->visibility.' '.$this->name.(empty($this->value)
													? ''
													: ' = '.$this->value).";\n";
	}
}
