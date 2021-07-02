<?php

    // get an id
    $id = $received_data->id;

    // create a sql query
    $sql = "DELETE FROM notes WHERE notes.id = $id";

    // make the query
    if (!mysqli_query($conn, $sql)){

        // if not success then send an error message
        echo json_encode('query error: '.mysqli_error($conn));

    } else {

        // success
        echo json_encode('delete success');

    }
?>