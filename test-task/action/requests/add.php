<?php
    // initialize necessary variables
    $max_note_len = 255;
    $error = '';
    $new_note = $received_data->body;

    // check new note
    if (!$new_note){
        // if note is empty
        $error = 'new note is empty';

    } else if (strlen($new_note) > $max_note_len){

        // if length of note is more than it should be
        $error = 'Your note is too large. Number of symbols must no more than '.$max_note_len;

    } else if (!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/', $new_note)) {

            // if there are forbidden symbols
            $error = 'The new note is incorrect. Please, use only characters and commas';

    }

    // check if there are any errors
    if ($error) {

        // if it is then send an error message
        echo json_encode($error);

    } else{

        // create a query with placeholder
        $sql = "INSERT INTO notes(note) VALUES (?)";
        // prepare for execution
        $stmt = $mysqli->prepare($sql);
        // bind parameters
        $stmt->bind_param('s', $new_note);
        // execute
        $stmt->execute();
        // send success message
        echo json_encode('adding success');

    }
?>
