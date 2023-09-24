<!DOCTYPE html>
<html lang="ru">
<head>
    <title>Таблица "цехи"</title>
    <link rel="stylesheet" href="/styles/styles.css">
    <link rel="stylesheet" href="/styles/tables/index.css">
</head>
<body>
<section class="tableSection">
    <h1 class="pageTitle">Таблица "цехи"</h1>
    <div class="buttonWrapper">
        <a class="backLinkButton" href="../">
            <img src='/public/icon/back-icon.svg' width='30' height='30' alt='изменить'>
        </a>
        <a class="button" href="create.php">Создать новую запись</a>
    </div>

    <?php
    require '../../components/DBConnect.php';

    $mysqli = connectToDatabase();
    $sql = "SELECT workshops.id, workshops.workshop_name, employees.employee_name AS supervisor_name
        FROM WORKSHOPS
        LEFT JOIN EMPLOYEES ON workshops.supervisor_id = employees.id";
    $result = mysqli_query($mysqli, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo "<table class='table'>
            <tr>
                <th>Цех</th>
                <th>Начальник цеха</th>
                <th>Изменить</th>
                <th>Удалить</th>
            </tr>";

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                <td>" . $row['workshop_name'] . "</td>
                <td>" . $row['supervisor_name'] . "</td>
                <td>
                    <a class='iconButton' href='edit.php?id=" . $row['id'] . "'>
                        <img src='/public/icon/edit-icon.svg' width='20' height='20' alt='изменить'>
                    </a>
                </td>
                <td>
                    <a class='iconButton' href='delete.php?id=" . $row['id'] . "' onclick='return confirmDelete();'>
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
<script>
    function confirmDelete() {
        return confirm("Вы уверены, что хотите удалить эту запись?");
    }
</script>
</body>
</html>