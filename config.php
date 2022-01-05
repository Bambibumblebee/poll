<?php
define('HOST', 'localhost');
define('USERNAME', '');
define('PASSWORD', '');
define('DBNAME', '');

$dsn = "mysql:host=".HOST.";dbname=".DBNAME;
$options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);


?>