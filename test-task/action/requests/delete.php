<?php
    function delete_note($id, $connection){
      try {
        // create a sql query with placeholder
        $sql = "DELETE FROM notes WHERE notes.id = ?";
        // prepare for execution
        $stmt = $connection->prepare($sql);
        // bind parameters
        $stmt->bind_param('i', $id);
        // execute
        $stmt->execute();
        // send success message
        echo json_encode(['status'=>'success', 'send'=>'']);

      } catch (Exception $e){
        // send an error message
        echo json_encode(['status'=>'error', 'send'=>$e->getMessage()]);
      }
    }
?>
