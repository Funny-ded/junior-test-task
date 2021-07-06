<?php
    // database connection
    include('../config/db_connect.php');

    // receive data from post request from main.js
    $received_data = json_decode(file_get_contents('php://input'));

    // actions with request
    if ($received_data->action == 'fetchAll'){

        // fetch all data from the database
        include('./requests/fetch.php');

    } else if($received_data->action == 'addNote') {

        // add data to the database
        include('./requests/add.php');

    } else if($received_data->action == 'updateData'){

        // update data in the database
        include('./requests/update.php');

    } else if ($received_data->action == 'deleteData'){

        // delete data from the database
        include('./requests/delete.php');

    } else{

        // something went wrong
        echo json_encode([['id' => 0, 'note' => 'fail']]);
    }

    // close connection
    $mysqli->close();
?>
