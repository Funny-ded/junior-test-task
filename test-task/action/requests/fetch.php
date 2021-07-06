<?php

    // initialize data array
    $notes = [];

    // create sql query
    $sql = "SELECT * FROM notes";

    // prepare for execution
    $stmt = $mysqli->prepare($sql);

    // execution
    $stmt->execute();

    // bind results into variables
    $stmt->bind_result($id, $body);


    // for each row in data table
    while($stmt->fetch()) {

        $notes[] = ['id' => $id, 'body' => $body, 'edit' => false];
    }

    // close the statement
    $stmt->close();

    // send results back
    echo json_encode($notes);
?>
