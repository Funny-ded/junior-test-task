<?php
    function fetch_all($connection) {
      try {
        // initialize data array
        $notes = [];
        // create sql query
        $sql = "SELECT * FROM notes";
        // prepare for execution
        $stmt = $connection->prepare($sql);
        // execution
        $stmt->execute();
        // bind results into variables
        $stmt->bind_result($id, $body);

        // for each row in data table
        while ($stmt->fetch()) {
          // update notes array
          $notes[] = ['id' => $id, 'body' => $body, 'edit' => false];
        }

        // close the statement
        $stmt->close();
        // send results back
        echo json_encode(['status' => 'success', 'send' => $notes]);

      } catch (Exception $e){
        // send an error message
        echo json_encode(['status'=>'error', 'send'=>$e->getMessage()]);
      }
    }
?>
