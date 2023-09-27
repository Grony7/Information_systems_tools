<!DOCTYPE html>
<html lang="ru">
<head>
    <title>Удаление</title>
    <link rel="stylesheet" href="/styles/styles.css">
    <link rel="stylesheet" href="/styles/tables/form.css">
</head>
<body>
<section class='messageWrapper'>
    <div class='messageContent'>

        <?php
        require $_SERVER['DOCUMENT_ROOT'] . '/components/auth.php';
        authorizationRequired();

        $can_delete = rightsCheck('delete');
        if (!$can_delete) {
            echo "<p class='textMessage'>У вас нет прав для удаления записи.</p>";
            echo "<a class='formButton' href='index.php'>Вернуться к списку</a>";
        } else {

            require '../../components/DBConnect.php';

            if (isset($_GET['id']) && is_numeric($_GET['id'])) {
                $id = $_GET['id'];

                $mysqli = connectToDatabase();
                $sql = "DELETE FROM WORKSHOPS WHERE id = ?";
                $stmt = mysqli_prepare($mysqli, $sql);
                mysqli_stmt_bind_param($stmt, "i", $id);

                if (mysqli_stmt_execute($stmt)) {
                    echo "<p class='textMessage'>Запись успешно удалена.</p>";
                } else {
                    echo "<p class='textMessage'>Ошибка удаления записи: " . mysqli_error($mysqli) . "</p>";
                }

                mysqli_stmt_close($stmt);
                mysqli_close($mysqli);
            } else {
                echo "<p class='textMessage'>Некорректный идентификатор записи.</p>";
            }

            echo "<a class='formButton' href='index.php'>Вернуться к списку</a>";
        } ?>
    </div>
</section>
</body>
</html>