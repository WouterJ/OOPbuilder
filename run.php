<?php

class UserException extends Exception {}

function __autoload( $class )
{
	require_once 'classes/'.$class.'.php';
}

try
{
	try
	{
		$files = glob(getcwd().'\\'.'*.oopbuild');

		if( !$files || (count($files) == 0) )
		{
			throw new UserException('We cannot find a oopbuild file. Please make a oopbuild file into OOPbuilder/');
		}
		else
		{
			foreach( $files as $file )
			{
				if( isset($_GET['dir']) )
				{
					$dir = $_GET['dir'];
				}
				else
				{
					chdir('../');
					$dir = getcwd();
				}
				$project = new OOPbuilder( $file, $dir.'\\'.current(explode('.',basename($file))) );
				$project->build();
			}
		}
	}
	catch( UserException $e )
	{
		echo $e->getMessage();
	}
}
catch( Exception $e )
{
	echo '[SYSTEM] '.$e->getMessage();
}
