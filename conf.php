<?php
  define('DB_SERVER', 'localhost');
  define('DB_USERNAME', 'root');
  define('DB_PASSWORD', 'Qjxcafnllrwluxru1');
  define('DB_NAME', 'bookingsystem');

  $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

  if ($link === false) {
    die("Error: Could not connect. " . mysqli_connect_error());
  }
?>
