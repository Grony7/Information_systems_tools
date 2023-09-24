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
    <form class="form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="employeeName">Имя сотрудника:</label>
        <input type="text" name="employeeName" id="employeeName" required>
        <label for="position">Должность:</label>
        <input type="text" name="position" id="position" required>
        <label for="discountOnClothing">Скидка на одежду:</label>
        <input type="number" name="discountOnClothing" id="discountOnClothing" step="0.01" max="100" required>
        <label for="workshopId">Цех:</label>
        <select name="workshopId" id="workshopId">
            <?php
            require '../../components/DBConnect.php';
            $mysqli = connectToDatabase();
            $sql = "SELECT id, workshop_name FROM WORKSHOPS";
            $result = mysqli_query($mysqli, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='" . $row['id'] . "'>" . $row['workshop_name'] . "</option>";
            }
            mysqli_close($mysqli);
            ?>
        </select>
        <button class="formButton" type="submit" name="create">Создать</button>
    </form>
</section>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["create"])) {
    $employee_name = $_POST['employeeName'];
    $position = $_POST['position'];
    $discount_on_clothing = $_POST['discountOnClothing'];
    $workshop_id = $_POST['workshopId'];

    $discount_on_clothing = min($discount_on_clothing, 100);

    $sql = "INSERT INTO EMPLOYEES (employee_name, position, discount_on_clothing, workshop_id)
            VALUES ('$employee_name', '$position', $discount_on_clothing, $workshop_id)";

    $mysqli = connectToDatabase();

    if (!mysqli_query($mysqli, $sql)) {
        echo "<script>alert('Ошибка при добавлении записи')</script>";
    }

    mysqli_close($mysqli);
}
?>

</body>
</html>
