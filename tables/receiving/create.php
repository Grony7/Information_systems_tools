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
        <label for="employeeId">Сотрудник:</label>
        <select name="employeeId" id="employeeId" required>
            <?php
            require $_SERVER['DOCUMENT_ROOT'] . '/components/DBConnect.php';

            $mysqli = connectToDatabase();

            $sql = "SELECT id, employee_name FROM EMPLOYEES";
            $result = mysqli_query($mysqli, $sql);

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='" . $row['id'] . "'>" . $row['employee_name'] . "</option>";
            }

            mysqli_close($mysqli);
            ?>
        </select>

        <label for="clothingId">Одежда:</label>
        <select name="clothingId" id="clothingId" required>
            <?php
            $mysqli = connectToDatabase();

            $sql = "SELECT id, clothing_type FROM SPECIAL_CLOTHING";
            $result = mysqli_query($mysqli, $sql);

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='" . $row['id'] . "'>" . $row['clothing_type'] . "</option>";
            }

            mysqli_close($mysqli);
            ?>
        </select>

        <label for="receivingDate">Дата получения:</label>
        <input type="date" name="receivingDate" id="receivingDate" required>

        <label for="signature">Подпись:</label>
        <input type="checkbox" name="signature" id="signature">

        <button class="formButton" type="submit" name="create">Создать</button>
    </form>
</section>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["create"])) {
    $employee_id = $_POST['employeeId'];
    $clothing_id = $_POST['clothingId'];
    $receiving_date = $_POST['receivingDate'];
    $signature = isset($_POST['signature']) ? 1 : 0;

    $mysqli = connectToDatabase();

    $sql = "INSERT INTO RECEIVING (employee_id, clothing_id, receiving_date, signature)
            VALUES ($employee_id, $clothing_id, '$receiving_date', $signature)";
    if (!mysqli_query($mysqli, $sql)) {
        echo "<script>alert('Ошибка при добавлении записи')</script>";
    }

    mysqli_close($mysqli);
}
}
?>

</body>
</html>