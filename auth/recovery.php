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
<h1 class="pageTitle">Восстановление пароля</h1>

<?php

require $_SERVER['DOCUMENT_ROOT'] . '/components/DBConnect.php';
require $_SERVER['DOCUMENT_ROOT'] . '/components/auth.php';


$mysqli = connectToDatabase();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($mysqli, $_POST["email"]);

    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($mysqli, $query);

    if (mysqli_num_rows($result) == 1) {
        $token = bin2hex(random_bytes(32));

        $query = "UPDATE users SET reset_token = '$token' WHERE email = '$email'";
        $result = mysqli_query($mysqli, $query);

        if ($result) {
            $reset_link = "http://isis/auth/resetPassword.php?token=$token";
            $to = $email;
            $subject = "Сброс пароля";
            $message = "Для сброса пароля перейдите по следующей ссылке: $reset_link";
            $headers = "Восстановление пароля для базы данных";

            if (mail($to, $subject, $message, $headers)) {
                echo "<p class='TAC successText'>Ссылка для сброса пароля отправлена на вашу почту.</p>";
            } else {
                echo "<p class='TAC errorText'> Ошибка при отправке письма. Пожалуйста, попробуйте позже.</p>";
            }
        } else {
            echo "<p class='TAC errorText'>Ошибка при генерации токена. Пожалуйста, попробуйте позже.</p>";
        }
    } else {
        echo "<p class='TAC errorText'>Пользователь с таким email не найден.</p>";
    }
}

mysqli_close($mysqli);
?>
<form method="post" class="authForm">
    <label for="email">Введите ваш email:</label>
    <input type="email" name="email" id="email" required>
    <button class="authButton" type="submit">Отправить</button>
</form>
</section>
</body>
</html>