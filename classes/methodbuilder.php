<?php

class MethodBuilder extends Builder
{
	protected $visibility = 'public';
	protected $type;
	protected $name;
	protected $parameters;

	public function __construct( $visibility, $name, array $parameters = array(), $type = '' )
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
		$this->name = (string) preg_replace_callback('/^[A-Z]/', function( $match ) { return strtolower($match); }, $name);
		$this->type = (string) $type;
		$this->parameters = $parameters;

	}

	public function __toString()
	{
		$method = "\n\t".$this->visibility.(empty($this->type)
												? ''
												: ' ').$this->type.' function '.$this->name.'( ';
		foreach( $this->parameters as $param )
		{
			if( $param != end($this->parameters) )
			{
				$method .= $param.', ';
			}
			else
			{
				$method .= $param;
			}
		}
		$method .= ' )'."\n\t".'{'."\n\t".'}';

		return $method;
	}
}
