<?php
function connectToDatabase() {
    $server = 'localhost:3306';
    $username = 'root';
    $password = 'grony';
    $database = 'workwear';

    $mysqli = new mysqli($server, $username, $password, $database);

    if ($mysqli->connect_error) {
        throw new Exception("Ошибка подключения к базе данных: " . $mysqli->connect_error);
    }

    return $mysqli;
}
?>