<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход</title>
    <link rel="stylesheet" href="/styles/auth.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
<section class="authSection">
    <h1 class="pageTitle">Вход</h1>

<?php
require $_SERVER['DOCUMENT_ROOT'] . '/components/DBConnect.php';
require $_SERVER['DOCUMENT_ROOT'] . '/components/auth.php';


$mysqli = connectToDatabase();
$max_failed_attempts = 3;
$block_duration_minutes = 30;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (isUserBlocked($email, $max_failed_attempts, $block_duration_minutes, $mysqli)) {
        echo "<p class='TAC errorText'>Доступ заблокирован. Пожалуйста, подождите.</p>";
    } else {
        $query = "SELECT id, email, password, role FROM users WHERE email = ?";
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) == 1) {
            mysqli_stmt_bind_result($stmt, $user_id, $user_email, $hashed_password, $user_role);
            mysqli_stmt_fetch($stmt);

            if (password_verify($password, $hashed_password)) {
                resetFailedAttemptInfo($email, $mysqli);

                login($user_email, $user_role);
                header('Location: /index.php');
                exit();
            } else {
                updateFailedAttemptInfo($email, $mysqli);

                echo "<p class='TAC errorText'>Неверный пароль.</p>";
            }
        } else {
            echo "<p class='TAC errorText'>Пользователь с таким email не найден.</p>";
        }

        mysqli_stmt_close($stmt);
    }
}

mysqli_close($mysqli);
?>

    <form class="authForm" method="POST">
        <label class="label" for="email">Email:
            <input class="input" type="email" id="email" name="email" required><br>
        </label>
        <label class="label" for="password">Пароль:
            <input class="input" type="password" id="password" name="password" required><br>
        </label>
        <div class="g-recaptcha" data-sitekey="6Lczu1soAAAAALdL4qdk3b6j2S1WxkXyBghmjBJj"></div>

        <button class="authButton" type="submit">Войти</button>
    </form>

    <p class="reg">Нет аккаунта? <a class="authLink" href="register.php">Зарегистрируйтесь</a></p>
    <p class="reg">Забыли пароль? <a class="authLink" href="recovery.php">Восстановить пароль</a></p>

</section>
</body>
</html>
