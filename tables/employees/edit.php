<!DOCTYPE html>
<html lang="ru">
<head>
    <title>Редактирование записи</title>
    <link rel="stylesheet" href="/styles/styles.css">
    <link rel="stylesheet" href="/styles/tables/form.css">
</head>
<body>

<?php
require '../../components/DBConnect.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $employee_name = $_POST['employeeName'];
        $position = $_POST['position'];
        $discount_on_clothing = $_POST['discountOnClothing'];
        $workshop_id = $_POST['workshopId'];

        $discount_on_clothing = min($discount_on_clothing, 100);

        $mysqli = connectToDatabase();
        $sql = "UPDATE EMPLOYEES SET employee_name=?, position=?, discount_on_clothing=?, workshop_id=? WHERE id=?";
        $stmt = mysqli_prepare($mysqli, $sql);
        mysqli_stmt_bind_param($stmt, "ssdii", $employee_name, $position, $discount_on_clothing, $workshop_id, $id);

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

        $mysqli = connectToDatabase();
        $sql = "SELECT * FROM EMPLOYEES WHERE id = ?";
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

        $workshops_sql = "SELECT id, workshop_name FROM WORKSHOPS";
        $workshops_result = mysqli_query($mysqli, $workshops_sql);

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        ?>

        <section class="formSection">
            <h1 class="pageTitle">Редактирование записи</h1>
            <a class="backLinkButton" href="index.php">
                <img src='/public/icon/back-icon.svg' width='30' height='30' alt='изменить'>
            </a>
            <form class="form" method="POST">
                <label for="employeeName">Имя сотрудника:</label>
                <input type="text" id="employeeName" name="employeeName" value="<?= $row['employee_name'] ?>">

                <label for="position">Должность:</label>
                <input type="text" id="position" name="position" value="<?= $row['position'] ?>">

                <label for="discountOnClothing">Скидка на одежду:</label>
                <input type="number" id="discountOnClothing" name="discountOnClothing"
                       value="<?= $row['discount_on_clothing'] ?>" max="100">

                <label for="workshopId">Цех:</label>
                <select name="workshopId" id="workshopId">
                    <?php
                    while ($workshop_row = mysqli_fetch_assoc($workshops_result)) {
                        $selected = ($workshop_row['id'] == $row['workshop_id']) ? "selected" : "";
                        echo "<option value='" . $workshop_row['id'] . "' $selected>" . $workshop_row['workshop_name'] . "</option>";
                    }
                    ?>
                </select>

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
