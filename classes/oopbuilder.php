<?php
/*
 * ClassName
 *	- (string) ClassName prop
 *	
 *	+ constructor( $hello )
 */
class OOPbuilder
{
	protected $file;
	protected $classes;

	protected $basepath;
	protected $_current;

	public function __construct( $file, $basepath = null )
	{
		if( !empty($basepath) )
		{
			$this->basepath = $basepath;
		}

		if( ( substr($this->basepath, -1) != '/' ) || ( substr($this->basepath, -1) != '\\' ) )
			$this->basepath .= '\\';

		$this->file = file($file);

		if( !is_dir($this->basepath) )
		{ # make the project dir
			mkdir($this->basepath);
		}
		if( !is_dir($this->basepath.'classes/') )
		{ # make classes path
			mkdir($this->basepath.'classes/');
		}
	}

	public function build()
	{
		foreach( $this->file as $line )
		{
			if( trim($line) !== '' )
			{
				if( !preg_match('/^\t/', $line) )
				{ # It's a ClassName
					$this->classes[trim($line)] = Array();
					$this->current = trim($line);
				}
				else
				{ # It's a method or property
					if( preg_match('/(\+|-|--)\s\w/', $line) )
					{ # It's a method
						preg_match('/\t(\+|-|--)\s(\w*?)\((.*?)\)/', $line, $method);
						$method = array_map(function( $arr ) { return trim($arr); }, $method);

						$this->classes[$this->current][] = new MethodBuilder( $method[1], (strtolower($method[2]) == 'constructor' 
																		? '__construct'
																		: $method[2]), explode(', ', $method[3]));
					}
					else
					{ # It's a property
						preg_match('/\t(\+|-|--)\s\((.*?)\)\s(.*?)(?:(?:\s|)=(.*?)|)$/', $line, $prop);
						$prop = array_map(function( $arr ) { return trim($arr); }, $prop);

						$this->classes[$this->current][] = new PropBuilder( $prop[1], $prop[2], $prop[3], (!empty($prop[4])
																										? $prop[4]
																										: ''));
					}
				}
			}
		}
		var_dump($this->classes);

		foreach( $this->classes as $class )
		{
			$name = array_search($class, $this->classes);
			$newClass = new ClassBuilder( $name );
			foreach( $class as $child )
			{
				if( $child instanceof PropBuilder )
				{ # It's a propertie
					$newClass->addPropertie( $child );
				}
				else
				{ # It's a method
					$newClass->addMethod( $child );
				}
			}
			$this->makeClass($name, (string) $newClass);
		}
	}

	protected function makeClass( $className, $class )
	{
		$className = strtolower($className);
		$file = fopen($this->basepath.'/classes/'.$className.'.php', 'w');

		if( $file )
		{
			if( !fwrite($file, "<?php\n\n".$class) )
			{
				throw new Exception('The class cannot write, check the permissions');
			}
			fclose($file);
		}
		else
		{
			throw new Exception('Classfile cannot maked, check the permissions.');
		}
	}
}
