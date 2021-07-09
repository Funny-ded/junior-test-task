<?php
    function add_note($new_note, $max_note_len, $connection){
      // check new note
      try {
        if (!$new_note) {
          // if note is empty
          throw new Exception('new note is empty');
        } else if (strlen($new_note) > $max_note_len) {
          // if length of note is more than it should be
          throw new Exception('Your note is too large. Number of symbols must no more than ' . $max_note_len);
        }

        // create a query with placeholder
        $sql = "INSERT INTO notes(note) VALUES (?)";
        // prepare for execution
        $stmt = $connection->prepare($sql);
        // bind parameters
        $stmt->bind_param('s', $new_note);
        // execute
        $stmt->execute();
        // send success message
        echo json_encode(['status'=>'success', 'send'=>'']);

      } catch(Exception $e) {
        // send an error message
        echo json_encode(['status'=>'error', 'send'=>$e->getMessage()]);
      }
    }
?>
