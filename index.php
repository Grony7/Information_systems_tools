<?php
    require 'components/dbconnect.php';
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Отчет о получении спецодежды</title>
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="styles/main.css">
</head>
<body>
<section class="report">
    <div>
        <h1>Отчет о получении спецодежды по заводу за год</h1>

        <form class="dataForm" method="POST" id="reportForm" action="report.php">
            <label for="year">Год:</label>
            <select name="year" id="year" required class="selectYear" onchange="updateFormAction()">
                <?php
                $mysqli = connectToDatabase();

                if (!$mysqli) {
                    die("Ошибка подключения к базе данных: " . mysqli_connect_error());
                }

                $sql_years = "SELECT DISTINCT YEAR(дата_получения) AS год FROM ПОЛУЧЕНИЕ";

                $result_years = mysqli_query($mysqli, $sql_years);

                if ($result_years->num_rows > 0) {
                    while ($row_year = mysqli_fetch_assoc($result_years)) {
                        $year_option = $row_year["год"];
                        echo "<option value=\"$year_option\">$year_option</option>";
                    }
                }

                mysqli_close($mysqli);
                ?>
            </select>

            <button class="dataButton" type="submit"> Сформировать отчет</button>
        </form>
    </div>

    <script src="scripts/index.js"></script>

</section>
</body>
</html>

