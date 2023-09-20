<?php

require 'components/DBConnect.php';

function createListOption()
{
    $mysqli = connectToDatabase();

    $sql_years = "SELECT DISTINCT YEAR(дата_получения) AS год FROM ПОЛУЧЕНИЕ";

    $result_years = mysqli_query($mysqli, $sql_years);

    if (mysqli_num_rows($result_years) > 0) {
        while ($row_year = mysqli_fetch_assoc($result_years)) {
            $year_option = $row_year["год"];
            echo "<option value=\"$year_option\">$year_option</option>";
        }
    }

    mysqli_close($mysqli);
}