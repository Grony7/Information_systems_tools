<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Восстановление пароля</title>
    <link rel="stylesheet" href="/styles/auth.css">
</head>
<body>
<section class="authSection">
    <h1 class="pageTitle">Сброс пароля</h1>

<?php
require $_SERVER['DOCUMENT_ROOT'] . '/components/DBConnect.php';
require $_SERVER['DOCUMENT_ROOT'] . '/components/auth.php';

$mysqli = connectToDatabase();

if (isset($_GET['token'])) {
    $token = mysqli_real_escape_string($mysqli, $_GET['token']);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $password = mysqli_real_escape_string($mysqli, $_POST["password"]);
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $query = "UPDATE users SET password = '$hashed_password', reset_token = NULL WHERE reset_token = '$token'";
        $result = mysqli_query($mysqli, $query);

        if ($result) {
            echo "<p class='TAC successText'>Пароль успешно изменен. Теперь вы можете <a class='authLink' href='login.php'>войти</a> с новым паролем.</p>";
        } else {
            echo "<p class='TAC errorText'>Произошла ошибка при смене пароля. Пожалуйста, попробуйте позже.</p>";
        }
    }
} else {
    echo "<p class='TAC errorText'>Неверный токен сброса пароля.</p>";
}


mysqli_close($mysqli);
?>

<form method="post" class="authForm">
    <label for="password">Введите новый пароль:</label>
    <input type="password" name="password" id="password" minlength="8" required>
    <button class="authButton" type="submit">Сменить пароль</button>
</form>
</body>
</html>
