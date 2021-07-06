<?php

    // initialize data array
    $notes = [];
    $search = $received_data->search;

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
        // post-processing search, case-sensitive
        if (stripos($body, $search) === false) {
          continue;
        }

        $notes[] = ['id' => $id, 'body' => $body, 'edit' => false];
    }

    // close the statement
    $stmt->close();

    // send results back
    echo json_encode($notes);
?>
