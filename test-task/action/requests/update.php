<?php

    // initialize constants
    $updated_note = $received_data->body;
    $max_note_len = 255;
    $error = '';
    $id = $received_data->id;

    // check updated note
    if(!$updated_note){

        // if updated note is empty
        $error = 'New note is empty. If you want to delete note, please, press delete button';

    } else if(strlen($updated_note) > $max_note_len){

        // if updated note is too large
        $error = 'Your note is too large. Number of symbols must no more than '.$max_note_len;

    } else if (!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/', $updated_note)){

        // if updated note contains forbidden symbols
        $error = 'The new note is incorrect. Please, use only characters and commas';
    }


    if ($error){

        // if there are any error then send an error message
        echo json_encode($error);

    } else {

        // create sql query with placeholders
        $sql = "UPDATE notes SET  note = ? WHERE notes.id = ?";
        // prepare statement
        $stmt = $mysqli->prepare($sql);
        // bind parameters
        $stmt->bind_param('si', $updated_note, $id);
        // execute
        $stmt->execute();

        // send success message
        echo json_encode('update success');
    }

?>
