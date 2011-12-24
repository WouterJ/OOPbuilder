# OOPbuilder
Welcome to OOPbuilder. OOPbuilder is an plugin to startup a new OOP project. In the latest version, 1.0, the OOPbuilder works with PHP and it only can build OO PHP projects. Later it will be used by running in the console and you can make OO projects in other languages as well.

## The OOPbuild file
First make an oopfile file in the root of OOPbuilder. The oopfile must has the following name: `<projectname>.oopbuild` The `<projectname>` is the name of the project and it will be the name of the directory that OOPbuilder makes.
In that file you write the structure of the classes. For instance, if you want to make a User Class:

	User
		- (string) name
		- (string) pass
		+ constructor( $name )
		+ setPassword( $pass )
		+ getName()
		+ getPass()
		+ save()

First we write the class name (User). Then you add a tab and add the class childs. The childs are properties and methods. Properties have the following syntax:

	--|-|+ (type) name [= value]

-- is private, - is protected and + is public. Then you write within () the type of the var. The name is the next parameter and if you want to add a default value add `= value` at the end.

The methods have the following syntax:

	--|-|+ methodname( [Class] paremeter1[, paremeter2, ...] )

The first visibility characters are the same as the propertie visibility. Then the method name add within () you write the parameters. You can add a Class to force that that parameters has a class.

## Run OOPbuilder
Open in your localhost the OOPbuilder script (run.php). Add a dir parameter to specify a basedir. If you don't specify the basedir the basedir is the dir where OOPbuilder in is.
