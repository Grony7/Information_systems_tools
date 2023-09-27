<!DOCTYPE html>
<html lang="ru">
<head>
    <title>Создание новой записи</title>
    <link rel="stylesheet" href="/styles/styles.css">
    <link rel="stylesheet" href="/styles/tables/form.css">
</head>
<body>
<section class="formSection">

    <h1 class="pageTitle">Создание новой записи</h1>

    <a class="backLinkButton" href="index.php">
        <img src='/public/icon/back-icon.svg' width='30' height='30' alt='изменить'>
    </a>

    <?php
    require $_SERVER['DOCUMENT_ROOT'] . '/components/auth.php';
    authorizationRequired();

    $can_create = rightsCheck('create');
    if (!$can_create) {
        echo "<p>У вас нет прав для создания записи.</p>";
    } else {
    ?>

    <form class="form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="clothingType">Тип одежды:</label>
        <input type="text" name="clothingType" id="clothingType" required>

        <label for="wearingPeriodMonths">Период ношения (месяцы):</label>
        <input type="number" min="0" id="wearingPeriodMonths" name="wearingPeriodMonths" step="0.1" required>

        <label for="unitCost">Стоимость:</label>
        <input type="number" min="0" id="unitCost" name="unitCost" step="0.01" required>

        <button class="formButton" type="submit" name="create">Создать</button>
    </form>

</section>


<?php

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["create"])) {
    require '../../components/DBConnect.php';

    $clothing_type = $_POST["clothingType"];
    $wearing_period_months = $_POST["wearingPeriodMonths"];
    $unit_cost = $_POST["unitCost"];

    $wearing_period_months = max($wearing_period_months, 0);
    $unit_cost = max($unit_cost, 0);

    $sql = "INSERT INTO SPECIAL_CLOTHING (clothing_type, wearing_period_months, unit_cost)
            VALUES ('$clothing_type', $wearing_period_months, $unit_cost)";


    $mysqli = connectToDatabase();

    if (!mysqli_query($mysqli, $sql)) {
        echo "<script>alert('Ошибка при добавлении записи')</script>";
    }
}

mysqli_close($mysqli);
}
?>

</body>
</html>