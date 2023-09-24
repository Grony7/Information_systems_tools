<!DOCTYPE html>
<html lang="ru">
<head>
    <title>Таблица "спецодежда"</title>
    <link rel="stylesheet" href="/styles/styles.css">
    <link rel="stylesheet" href="/styles/tables/index.css"></head>
<body>
<section class="tableSection">
    <h1 class="pageTitle">Таблица "спецодежда"</h1>
    <div class="buttonWrapper">
        <a class="backLinkButton" href="../">
            <img src='/public/icon/back-icon.svg' width='30' height='30' alt='изменить'>
        </a>
        <a class="button" href="create.php">Создать новую запись</a>
    </div>
<?php

require '../../components/DBConnect.php';

$mysqli = connectToDatabase();
$sql = "SELECT * FROM SPECIAL_CLOTHING";
$result = mysqli_query($mysqli, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "<table class='table'>
            <tr>
                <th>Тип одежды</th>
                <th>Период ношения, месяц</th>
                <th>Стоимость</th>
                <th>Изменить</th>
                <th>Удалить</th>
            </tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        $costInRubles = number_format($row['unit_cost'], 2, ',', ' ') . ' ₽';

        echo "<tr>
                <td>" . $row['clothing_type'] . "</td>
                <td>" . $row['wearing_period_months'] . "</td>
                <td>" . $costInRubles . "</td>
                <td>
                    <a class='iconButton' href='edit.php?id=" . $row['id'] . "'>
                        <img src='/public/icon/edit-icon.svg' width='20' height='20' alt='изменить'>
                    </a>
                </td>
                <td>
                    <a class='iconButton' href='delete.php?id=" . $row['id'] . "'>
                        <img src='/public/icon/delete-icon.svg' width='20' height='20' alt='удалить'>
                    </a>
                </td>        
                </tr>";
    }

    echo "</table>";
}

mysqli_close($mysqli);
?>

</section>
</body>
</html>
