<?php

  class Response{
      private array $send = [];

      public function __construct(mysqli $connection){
        try {
          if ($_POST['action'] === 'fetchAll') {
            // fetch data
            $this->send = $this->fetch_all($connection);
          } elseif ($_POST['action'] === 'updateData') {
            // update note
            $this->send = $this->update_note($_POST['id'], $_POST['body'], $connection);
          } elseif ($_POST['action'] === 'addNote') {
            // add new note
            $this->send = $this->add_note($_POST['body'], $connection);
          } else {
            // delete note
            $this->send = $this->delete_note($_POST['id'], $connection);
          }
        } catch (Exception $e){
          $this->send = ['status'=>'error', 'send'=>$e->getMessage()];
        }
      }

      private function fetch_all(mysqli $connection): array
      {
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
          return ['status'=>'success', 'send'=>$notes];

        } catch (Exception $e){
          // send an error message
          return ['status'=>'error', 'send'=>$e->getMessage()];
        }
      }

      private function update_note($id, string $updated_note, mysqli $connection, $max_note_len = 255): array
      {
        try {
          // check updated note
          if (!str_replace([" ", "\n", "\r", "\r\n"], '', $updated_note)) {
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
          return ['status'=>'success', 'send'=>''];

        } catch(Exception $e){
          // send an error message
          return ['status'=>'error', 'send'=>$e->getMessage()];
        }
      }

      private function add_note(string $new_note, mysqli $connection, $max_note_len = 255): array
      {
        try {
          if (!str_replace([" ", "\n", "\r", "\r\n"], '', $new_note)) {
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
          return ['status'=>'success', 'send'=>''];

        } catch(Exception $e) {
          // send an error message
          return ['status'=>'error', 'send'=>$e->getMessage()];
        }
      }

      private function delete_note($id, mysqli $connection): array
      {
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
          return ['status'=>'success', 'send'=>''];

        } catch (Exception $e){
          // send an error message
          return ['status'=>'error', 'send'=>$e->getMessage()];
        }
      }

      public function send_response(){
        echo json_encode($this->send);
      }
    }
?>
