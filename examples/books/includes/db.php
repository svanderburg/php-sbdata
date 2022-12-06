<?php
$dbh = new PDO("mysql:host=localhost;dbname=books", "root", "admin", array(
	PDO::ATTR_PERSISTENT => true
));
?>
