<?php
    // database connection
    $con = include('../config/db_connect.php');

    // response class
    include('./classes/response.php');

    $mysqli = create_connection($con['hostname'], $con['username'], $con['password'], $con['db']);

    // receive data from post request from main.js
    $_POST = json_decode(file_get_contents('php://input'), true);

    $response = new Response($mysqli);

    // close connection
    $mysqli->close();
    // send data back
    $response->send_response();

?>
