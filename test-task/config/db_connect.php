<?php
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    // connection parameters
    $hostname = 'localhost';
    $username = 'prokhor';
    $password = 'test123';
    $db = 'notes_page';

    // try to connect
    try {
      $mysqli = new mysqli($hostname, $username, $password, $db);

    } catch (mysqli_sql_exception $e) {
      throw $e;
    }
?>
