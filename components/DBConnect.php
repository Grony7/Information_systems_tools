<?php
function connectToDatabase() {
    $server = 'localhost:3306';
    $username = 'root';
    $password = 'grony';
    $database = 'workwear';

    $mysqli = mysqli_connect($server, $username, $password, $database);

    if (!$mysqli) {
        die("Ошибка подключения к базе данных: " . mysqli_connect_error());
    }

    return $mysqli;
}
?>