<?php
$dbh = new PDO("mysql:unix_socket=/home/sander/var/run/mysqld/mysqld.sock;dbname=todoitems", "sander", "", array(
	PDO::ATTR_PERSISTENT => true
));
?>
