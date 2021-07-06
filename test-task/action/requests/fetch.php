<?php

    // initialize data array
    $notes = [];
    $search = $received_data->search;

    // create sql query
    if ($search) {
      $sql = "SELECT * FROM notes WHERE note LIKE ? ";
      $search = "%".$search."%";
      $stmt = $mysqli->prepare($sql);

      $stmt->bind_param('s', $search);
    } else {
      $sql = "SELECT * FROM notes";
      $stmt = $mysqli->prepare($sql);
    }
    // prepare for execution


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
