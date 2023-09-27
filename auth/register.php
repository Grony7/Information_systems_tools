<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link rel="stylesheet" href="/styles/auth.css">
</head>
<body>
<section class="authSection">

    <h1 class="pageTitle">Регистрация</h1>

    <?php
    require $_SERVER['DOCUMENT_ROOT'] . '/components/DBConnect.php';
    $mysqli = connectToDatabase();
    session_start();
    if (isset($_SESSION['user_id'])) {
        header('Location: /tables/index.php');
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $query = "SELECT * FROM users WHERE email = ?";
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            echo "<p class='errorText'>Пользователь с таким email уже существует.</p>";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $query = "INSERT INTO users (email, password) VALUES (?, ?)";
            $stmt = mysqli_prepare($mysqli, $query);
            mysqli_stmt_bind_param($stmt, "ss", $email, $hashed_password);

            if (mysqli_stmt_execute($stmt)) {
                echo "<p class='successText'>Регистрация прошла успешно. Теперь вы можете <a class='authLink' href='login.php'>войти</a>.</p>";
            } else {
                echo "<p class='errorText'>Ошибка при регистрации: " . mysqli_error($mysqli) . "</p>";
            }
        }

        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }
    ?>

    <form class="authForm" method="POST">
        <label class="label" for="email">Email:
        <input class="input" type="email" id="email" name="email" required><br>
        </label>
        <label class="label" for="password">Пароль:
        <input class="input" type="password" id="password" name="password" required><br>
        </label>
        <button type="submit" class="authButton">Зарегистрироваться</button>
    </form>

    <p class="reg">Уже есть аккаунт? <a class="authLink" href="login.php">Войдите</a></p>
</section>
</body>
</html>
