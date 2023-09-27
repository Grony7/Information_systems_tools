<!DOCTYPE html>
<html lang="ru">
<head>
    <title>Редактирование записи</title>
    <link rel="stylesheet" href="/styles/styles.css">
    <link rel="stylesheet" href="/styles/tables/form.css">
</head>
<body>

<?php
require $_SERVER['DOCUMENT_ROOT'] . '/components/DBConnect.php';
require $_SERVER['DOCUMENT_ROOT'] . '/components/auth.php';
authorizationRequired();

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    $can_edit = rightsCheck('edit');

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $can_edit) {
        $clothing_type = $_POST['clothing_type'];
        $wearing_period_months = $_POST['wearing_period_months'];
        $unit_cost = $_POST['unit_cost'];

        $mysqli = connectToDatabase();
        $sql = "UPDATE SPECIAL_CLOTHING SET clothing_type=?, wearing_period_months=?, unit_cost=? WHERE id=?";
        $stmt = mysqli_prepare($mysqli, $sql);
        mysqli_stmt_bind_param($stmt, "sddi", $clothing_type, $wearing_period_months, $unit_cost, $id);


        echo "<div class='messageWrapper'>
                <div class='messageContent'>";

        if (mysqli_stmt_execute($stmt)) {
            echo "<p class='textMessage'>Запись успешно обновлена.</p>";
            echo "<a class='formButton' href='index.php'>Вернуться к списку записей</a>";
        } else {
            echo "<p class='textMessage'> Ошибка обновления записи: " . mysqli_error($mysqli) . "</p>";
            echo "<a class='formButton' href='index.php'>Вернуться к списку записей</a>";
        }
        echo "</div></div>";

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    } else {
        if (!$can_edit) {
            echo "<div class='messageWrapper'>
                    <div class='messageContent'>
                        <p class='textMessage'>У вас недостаточно прав для редактирования записи.</p>
                        <a class='formButton' href='index.php'>Вернуться к списку записей</a>
                    </div>
                  </div>
                ";
            exit;
        }


        $mysqli = connectToDatabase();
        $sql = "SELECT * FROM SPECIAL_CLOTHING WHERE id = ?";
        $stmt = mysqli_prepare($mysqli, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);

        if (!$row) {
            echo "<div class='messageWrapper'>
                    <div class='messageContent'>
                        <p class='textMessage'> Запись не найдена.</p>
                        <a class='formButton' href='index.php'>Вернуться к списку записей</a>
                    </div>
                  </div>
                ";
            mysqli_stmt_close($stmt);
            mysqli_close($mysqli);
            exit;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        ?>

        <section class="formSection">
            <h1 class="pageTitle">Редактирование записи</h1>
            <a class="backLinkButton" href="index.php">
                <img src='/public/icon/back-icon.svg' width='30' height='30' alt='изменить'>
            </a>
            <form class="form" method="POST">
                <label for="clothing_type">Тип одежды:</label>
                <input type="text" id="clothing_type" name="clothing_type" value="<?= $row['clothing_type'] ?>">

                <label for="wearing_period_months">Период ношения (месяцы):</label>
                <input type="number" id="wearing_period_months" name="wearing_period_months"
                       value="<?= $row['wearing_period_months'] ?>">

                <label for="unit_cost">Стоимость:</label>
                <input type="number" id="unit_cost" name="unit_cost" value="<?= $row['unit_cost'] ?>">

                <button class="formButton" type="submit">Изменить</button>
            </form>
        </section>
        <?php
    }
} else {
    echo "<div class='messageWrapper'>
            <div class='messageContent'>
               <p class='textMessage'> Некорректный идентификатор записи.</p>
               <a class='formButton' href='index.php'>Вернуться к списку записей</a>
            </div>
          </div>
          ";
}
?>
</body>
</html>
