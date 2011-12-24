<?php

class ClassBuilder extends Builder
{
	protected $name;
	protected $extends;
	protected $methods = array();

	public function __construct( $name, $extends = null )
	{
		$this->name = (string) ucfirst($name);
		$this->extends = (string) $extends;
	}

	public function addPropertie( PropBuilder $prop )
	{
		$this->methods[] = $prop; // Yes, I know a propertie is not a method, but lets make this script simple! :)
	}

	public function addMethod( MethodBuilder $method )
	{
		$this->methods[] = $method;
	}

	public function __toString()
	{
		$class = 'class '.$this->name.(!empty($this->extends) 
									? 'extends '.ucfirst($extends)
									: '')."\n".'{';

		foreach( $this->methods as $method )
		{
			$class .= "\n\t".(string) $method;
		}

		$class .= "\n".'}';

		return $class;
	}
}
