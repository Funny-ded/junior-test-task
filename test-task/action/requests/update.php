<?php

    // initialize constants
    $updated_note = $received_data->note;
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

        // i don`t know
        $updated_note = mysqli_real_escape_string($conn, $updated_note);

        // create sql query
        $sql = "UPDATE notes SET  note = '$updated_note' WHERE notes.id = $id";

        // make the query
        if(!mysqli_query($conn, $sql)){

            // if not success then send an error message
            echo json_encode('query error: '.mysqli_error($conn));

        } else {

            // success
            echo json_encode('update success');

        }
    }

?>