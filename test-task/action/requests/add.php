<?php
    // initialize necessary variables
    $max_note_len = 255;
    $error = '';
    $new_note = $received_data->note;

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
        // if it is not


        // i don`t know why
        $new_note = mysqli_real_escape_string($conn, $new_note);

        // create a query
        $sql = "INSERT INTO notes(note) VALUES ('$new_note')";

        // make the query
        if (!mysqli_query($conn, $sql)){

            // send an error message if it is not success
            echo json_encode('query error: '.mysqli_error($conn));

        } else{

            // send a success message if it is success
            echo json_encode('adding success');
        }
    }
?>