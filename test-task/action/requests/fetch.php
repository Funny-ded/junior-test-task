<?php
    // initialize data array
    $notes = [];
    $search = $received_data->search;

    // create sql query
    $sql = "SELECT * FROM notes";

    // make the query to get results
    $results = mysqli_query($conn, $sql);

    // for each row in data table
    while($singleNote = mysqli_fetch_assoc($results)) {
        // XSS defence
        $note_body = htmlspecialchars($singleNote['note']);

        if (strpos($note_body, $search) === false){
          continue;
        }
        // save data as variables
        $note_id = $singleNote['id'];


        // add data row to data array
        $notes[] = ['id' => $note_id, 'note' => $note_body, 'edit' => false];
    }


    // free results
    mysqli_free_result($results);

    // send results back
    echo json_encode($notes);
?>
