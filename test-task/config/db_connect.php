<?php
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    // try to connect
    function create_connection($hostname, $username, $password, $db){
      try {
        return new mysqli($hostname, $username, $password, $db);

      } catch (mysqli_sql_exception $e) {
        // send an error message
        echo json_encode(['status' => 'error', 'send' => $e->getMessage()]);
        die();
      }
    }

    // connection parameters
    return [
    'hostname' => 'localhost',
    'username' => 'prokhor',
    'password' => 'test123',
    'db' => 'notes_page']
?>
