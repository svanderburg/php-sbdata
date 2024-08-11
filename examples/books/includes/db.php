<?php
$dbh = new PDO("mysql:unix_socket=/home/sander/var/run/mysqld/mysqld.sock;dbname=books", "sander", "", array(
	PDO::ATTR_PERSISTENT => true
));
?>
