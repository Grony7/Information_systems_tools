<!DOCTYPE html>
<html lang="ru">
<head>
    <title>Таблица "выдачи"</title>
    <link rel="stylesheet" href="/styles/styles.css">
    <link rel="stylesheet" href="/styles/tables/index.css">
</head>
<body>
<section class="tableSection">
    <h1 class="pageTitle">Таблица "выдачи"</h1>
    <div class="buttonWrapper">
        <a class="backLinkButton" href="../">
            <img src='/public/icon/back-icon.svg' width='30' height='30' alt='изменить'>
        </a>
        <a class="button" href="create.php">Создать новую запись</a>
    </div>

    <?php

    require '../../components/DBConnect.php';

    function formatDate($date)
    {
        $months = [
            1 => 'января', 2 => 'февраля', 3 => 'марта', 4 => 'апреля', 5 => 'мая', 6 => 'июня',
            7 => 'июля', 8 => 'августа', 9 => 'сентября', 10 => 'октября', 11 => 'ноября', 12 => 'декабря',
        ];

        $dateParts = explode('-', $date);
        $day = (int)$dateParts[2];
        $month = (int)$dateParts[1];
        $year = (int)$dateParts[0];


        return $day . ' ' . $months[$month] . ' ' . $year . ' г.';
    }

    $mysqli = connectToDatabase();
    $sql = "SELECT RECEIVING.id, EMPLOYEES.employee_name, SPECIAL_CLOTHING.clothing_type, RECEIVING.receiving_date, RECEIVING.signature
        FROM RECEIVING
        JOIN EMPLOYEES ON RECEIVING.employee_id = EMPLOYEES.id
        JOIN SPECIAL_CLOTHING ON RECEIVING.clothing_id = SPECIAL_CLOTHING.id";

    $result = mysqli_query($mysqli, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo "<table class='table'>
            <tr>
                <th>Сотрудник</th>
                <th>Одежда</th>
                <th>Дата получения</th>
                <th>Подпись</th>
                <th>Изменить</th>
                <th>Удалить</th>
            </tr>";

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                <td>" . $row['employee_name'] . "</td>
                <td>" . $row['clothing_type'] . "</td>
                <td>" . formatDate($row['receiving_date']) . "</td>
                <td>" . ($row['signature'] ? 'Есть подпись' : 'Нет подписи') . "</td>
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