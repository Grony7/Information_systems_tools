<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Отчет о получении спецодежды</title>
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="styles/report.css">
</head>
<body>


<?php
require $_SERVER['DOCUMENT_ROOT'] . '/components/createReport.php';
require $_SERVER['DOCUMENT_ROOT'] . '/components/auth.php';
authorizationRequired();

$can_create_report = rightsCheck('create_report');
if (!$can_create_report) {
    echo "<div class='messageWrapper'>";
    echo "<p class='textMessage'>У вас нет прав для удаления записи.</p>";
    echo "<a class='formButton' href='index.php'>Вернуться на главную</a></div>";
} else {
    echo "<section class='report'>";
        creatReport();
        echo "<a class='backLink' href=' / '>На главную</a>";
    echo "</section>";
    }
?>


</body>
</html>
