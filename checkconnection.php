<?php
// This file provides the information for accessing the database and connecting to MySQL. It also sets the language coding to utf-8
// First we define the constants:
$user = 'root';
$pass = 'Mobile';
$host = 'localhost';
$dbname = 'warehouse';

// Next we assign the database connection to a variable that we will call $dbcon:
$dbcon = new mysqli($host, $user, $pass, $dbname) OR die ('Could not connect to MySQL: ' . $dbcon->connect_error);

// Finally, we set the language encoding as utf-8
$dbcon->set_charset('utf-8');
?>
