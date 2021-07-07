<?php
    // database connection
    $con = include('../config/db_connect.php');
    // maximum length of note
    $max_note_len = 255;

    // requests functions
    include('./requests/fetch.php');
    include('./requests/add.php');
    include('./requests/update.php');
    include('./requests/delete.php');

    $mysqli = create_connection($con['hostname'], $con['username'], $con['password'], $con['db']);

    // receive data from post request from main.js
    $received_data = json_decode(file_get_contents('php://input'));

    // actions with request
    if ($received_data->action == 'fetchAll'){
        // fetch all data from the database
        fetch_all($mysqli);
    } else if($received_data->action == 'addNote') {
        // add data to the database
        add_note($received_data->body, $max_note_len, $mysqli);
    } else if($received_data->action == 'updateData'){
        // update data in the database
      update_note($received_data->id, $received_data->body, $max_note_len, $mysqli);
    } else if ($received_data->action == 'deleteData') {
      // delete data from the database
      delete_note($received_data->id, $mysqli);
    }
    // close connection
    $mysqli->close();
?>
