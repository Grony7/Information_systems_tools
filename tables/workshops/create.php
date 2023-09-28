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
        <label for="workshopName">Цех:</label>
        <input type="text" name="workshopName" id="workshopName" required>

        <label for="supervisorId">Начальник цеха:</label>
        <select name="supervisorId" id="supervisorId" required>
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

        <button class="formButton" type="submit" name="create">Создать</button>
    </form>
</section>


<?php

$mysqli = connectToDatabase();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["create"])) {
    $workshop_name = $_POST['workshopName'];
    $supervisor_id = $_POST['supervisorId'];

    $sql = "INSERT INTO WORKSHOPS (workshop_name, supervisor_id)
            VALUES ('$workshop_name', $supervisor_id)";
    if (!mysqli_query($mysqli, $sql)) {
        echo "<script>alert('Ошибка при добавлении записи')</script>";
    }
}

mysqli_close($mysqli);
}
?>

</body>
</html>
