<?php
    // initialize data array
    $notes = [];

    // create sql query
    $sql = "SELECT * FROM notes ORDER BY id DESC";

    // make the query to get results
    $results = mysqli_query($conn, $sql);

    // for each row in data table
    while($singleNote = mysqli_fetch_assoc($results)) {

        // save data as variables
        $note_id = $singleNote['id'];
        // XSS defence
        $note_body = htmlspecialchars($singleNote['note']);
        // add data row to data array
        $notes[] = ['id' => $note_id, 'note' => $note_body, 'edit' => false];
    }
    // reverse data array to make data array order by id
    $notes = array_reverse($notes);

    // free results
    mysqli_free_result($results);

    // send results back
    echo json_encode($notes);
?>
