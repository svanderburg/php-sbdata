<?php
$dbh = new PDO("mysql:host=localhost;dbname=todoitems", "root", "admin", array(
	PDO::ATTR_PERSISTENT => true
));
?>
