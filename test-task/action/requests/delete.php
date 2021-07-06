<?php

    // get an id
    $id = $received_data->id;

    // create a sql query with placeholder
    $sql = "DELETE FROM notes WHERE notes.id = ?";

    // prepare for execution
    $stmt = $mysqli->prepare($sql);

    // bind parameters
    $stmt->bind_param('i', $id);

    // execute
    $stmt->execute();

    // send success message
    echo json_encode('delete success');

?>
