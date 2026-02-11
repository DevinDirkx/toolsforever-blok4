<?php
$dbhost = 'mariadb';
$dbname = 'tools4ever';
$dbuser = 'root';
$dbpass = 'password';
$conn = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
?>