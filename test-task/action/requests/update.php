<?php
    function update_note($id, $updated_note, $max_note_len, $connection){
      try {
        // check updated note
        if (strlen($updated_note) === 0) {
          // if updated note is empty
          throw new Exception('New note is empty. If you want to delete note, please, press delete button');
        } else if (strlen($updated_note) > $max_note_len) {
          // if updated note is too large
          throw new  Exception('Your note is too large. Number of symbols must no more than ' . $max_note_len);
        }

        // create sql query with placeholders
        $sql = "UPDATE notes SET  note = ? WHERE notes.id = ?";
        // prepare statement
        $stmt = $connection->prepare($sql);
        // bind parameters
        $stmt->bind_param('si', $updated_note, $id);
        // execute
        $stmt->execute();
        // send success message
        echo json_encode(['status'=>'success', 'send'=>'']);

      } catch(Exception $e){
        // send an error message
        echo json_encode(['status'=>'error', 'send'=>$e->getMessage()]);
      }
    }
?>
