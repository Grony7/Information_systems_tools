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
        $employee_id = $_POST['employeeId'];
        $clothing_id = $_POST['clothingId'];
        $receiving_date = $_POST['receivingDate'];
        $signature = isset($_POST['signature']) ? 1 : 0;

        $mysqli = connectToDatabase();
        $sql = "UPDATE RECEIVING SET employee_id=?, clothing_id=?, receiving_date=?, signature=? WHERE id=?";
        $stmt = mysqli_prepare($mysqli, $sql);
        mysqli_stmt_bind_param($stmt, "iisii", $employee_id, $clothing_id, $receiving_date, $signature, $id);

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
        $sql = "SELECT * FROM RECEIVING WHERE id = ?";
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

        $employees_sql = "SELECT id, employee_name FROM EMPLOYEES";
        $employees_result = mysqli_query($mysqli, $employees_sql);

        $clothing_sql = "SELECT id, clothing_type FROM SPECIAL_CLOTHING";
        $clothing_result = mysqli_query($mysqli, $clothing_sql);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        ?>

        <section class="formSection">
            <h1 class="pageTitle">Редактирование записи</h1>
            <a class="backLinkButton" href="index.php">
                <img src='/public/icon/back-icon.svg' width='30' height='30' alt='изменить'>
            </a>
            <form class="form" method="POST">
                <label for="employeeId">Идентификатор сотрудника:</label>
                <select name="employeeId" id="employeeId">
                    <?php
                    while ($employee_row = mysqli_fetch_assoc($employees_result)) {
                        $selected = ($employee_row['id'] == $row['employee_id']) ? "selected" : "";
                        echo "<option value='" . $employee_row['id'] . "' $selected>" . $employee_row['employee_name'] . "</option>";
                    }
                    ?>
                </select>

                <label for="clothingId">Идентификатор одежды:</label>
                <select name="clothingId" id="clothingId">
                    <?php
                    while ($clothing_row = mysqli_fetch_assoc($clothing_result)) {
                        $selected = ($clothing_row['id'] == $row['clothing_id']) ? "selected" : "";
                        echo "<option value='" . $clothing_row['id'] . "' $selected>" . $clothing_row['clothing_type'] . "</option>";
                    }
                    ?>
                </select>

                <label for="receivingDate">Дата получения:</label>
                <input type="date" id="receivingDate" name="receivingDate" value="<?= $row['receiving_date'] ?>">

                <label for="signature">Подпись:</label>
                <input type="checkbox" id="signature" name="signature" <?= ($row['signature'] ? "checked" : "") ?>>

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
