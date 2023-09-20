<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Выбор отчета</title>
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="styles/index.css">
</head>
<body>
<section class="menu">
    <div>
        <h1>Отчет о получении спецодежды по заводу за год</h1>

        <form class="dataForm" method="POST" id="reportForm" action="report.php">
            <label for="year">Год:</label>
            <select name="year" id="year" required class="selectYear" onchange="updateFormAction()">
                <?php
                    require 'components/createListOption.php';
                    createListOption();
                ?>
            </select>
            <button class="dataButton" type="submit"> Сформировать отчет</button>
        </form>
    </div>

    <script src="scripts/index.js"></script>

</section>
</body>
</html>

