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
<section class="report">

    <?php
    require 'components/createReport.php';
    creatReport();
    ?>

    <a class="backLink" href="/">На главную</a>
</section>
</body>
</html>
