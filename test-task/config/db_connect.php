<?php
    $conn = mysqli_connect('localhost', 'prokhor', 'test123', 'notes_page');

    if (!$conn){
        echo "Connection error: ".mysqli_connect_error();
    }
?>