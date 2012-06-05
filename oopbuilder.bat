@echo OFF
if "%PHPBIN%" == "" set PHPBIN=E:\wouter\web\wamp\bin\php\php5.3.5\php.exe
"%PHPBIN%" "E:\wouter\web\wamp\www\OOPbuilder\oopbuilder.php" %*
