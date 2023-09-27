<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление ролями</title>
    <link rel="stylesheet" href="/styles/tables/index.css">
</head>
<body>
<section class="tableSection">
<h1 class="pageTitle">Управление ролями пользователей</h1>
    <div class="buttonWrapper">
        <a class="backLinkButton" href="/index.php">
            <img src='/public/icon/back-icon.svg' width='30' height='30' alt='изменить'>
        </a>
    </div>
<?php
require $_SERVER['DOCUMENT_ROOT'] . '/components/DBConnect.php';
require $_SERVER['DOCUMENT_ROOT'] . '/components/auth.php';
authorizationRequired();
$can_edit_role = rightsCheck('role');


if ($can_edit_role) {
    $mysqli = connectToDatabase();

    $allowed_roles = ['Гость', 'Оператор', 'Администратор'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['user_id']) && isset($_POST['new_role'])) {
            $user_id = $_POST['user_id'];
            $new_role = $_POST['new_role'];

            if (in_array($new_role, $allowed_roles)) {
                $update_query = "UPDATE users SET role = ? WHERE id = ?";
                $stmt = mysqli_prepare($mysqli, $update_query);
                mysqli_stmt_bind_param($stmt, "si", $new_role, $user_id);

                if (mysqli_stmt_execute($stmt)) {
                    echo "<p class='successText'>Роль пользователя успешно изменена.</p>";
                } else {
                    echo "<p class='errorText'>Ошибка при изменении роли: " . mysqli_error($mysqli) . "</p>";
                }

                mysqli_stmt_close($stmt);
            } else {
                echo "<p class='errorText'>Недопустимая роль.</p>";
            }
        }
    }

    $select_query = "SELECT id, email, role FROM users";
    $result = mysqli_query($mysqli, $select_query);

    if (mysqli_num_rows($result) > 0) {
        echo "<table class='table'>";
        echo "<tr>
                <th>ID</th>
                <th>Email</th>
                <th>Роль</th>
                <th>Изменить роль</th>
              </tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
             <td>" . $row['id'] . "</td>
             <td>" . $row['email'] . "</td>
             <td>" . $row['role'] . "</td>
             <td>
             <form method='POST' class='editTD'>
                <input type='hidden' name='user_id' value='" . $row['id'] . "'>" .
             "<select name='new_role'>";
            foreach ($allowed_roles as $role) {
                $selected = ($row['role'] === $role) ? 'selected' : '';
                echo "<option value='$role' $selected>$role</option>";
            }
            echo "</select>
             <button class='iconButton' type='submit' onchange='updateFormAction()'>                            
                    <img src='/public/icon/edit-icon.svg' width='20' height='20' alt='изменить'>
                  </button>
            </form>
            </td>
            </tr>";
        }
        echo "</table>";
    } else {
        echo "<p class='errorText'>Пользователи не найдены.</p>";
    }

    mysqli_close($mysqli);
} else {
    echo "<p class='errorText'>У вас нет прав для управления ролями.</p>";
}
?>
</section>
<script>
    function confirmDelete() {
        return confirm("Вы уверены, что хотите изменить роль пользователя");
    }
</script>
</body>
</html>
