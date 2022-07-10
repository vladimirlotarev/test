<?php

  include($_SERVER["DOCUMENT_ROOT"].'/config.php');
  
  $mysql = @new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  if (!$mysql) die("Connection failed: " . mysqli_connect_error());

?>
