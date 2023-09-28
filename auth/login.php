<?php
require $_SERVER['DOCUMENT_ROOT'] . '/components/DBConnect.php';

session_start();

function login($email, $user_role) {
    $_SESSION['user_email'] = $email;
    $_SESSION['user_role'] = $user_role;
}

function isLoggedin() {
    return isset($_SESSION['user_email']);
}

function isUserBlocked($email, $max_failed_attempts, $block_duration_minutes, $mysqli) {
    $query = "SELECT last_failed_attempt, failed_attempt_count FROM users WHERE email = ?";
    $stmt = mysqli_prepare($mysqli, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) == 1) {
        mysqli_stmt_bind_result($stmt, $last_failed_attempt, $failed_attempt_count);
        mysqli_stmt_fetch($stmt);

        if ($failed_attempt_count >= $max_failed_attempts) {
            $current_time = time();
            $blocked_until = strtotime($last_failed_attempt) + ($block_duration_minutes * 60);

            if ($current_time < $blocked_until) {
                mysqli_stmt_close($stmt);
                return true;
            } else {
                $reset_query = "UPDATE users SET failed_attempt_count = 0 WHERE email = ?";
                $reset_stmt = mysqli_prepare($mysqli, $reset_query);
                mysqli_stmt_bind_param($reset_stmt, "s", $email);
                mysqli_stmt_execute($reset_stmt);
                mysqli_stmt_close($reset_stmt);
            }
        }
    }

    mysqli_stmt_close($stmt);
    return false;
}

function updateFailedAttemptInfo($email, $mysqli) {
    $query = "SELECT failed_attempt_count, last_failed_attempt FROM users WHERE email = ?";
    $stmt = mysqli_prepare($mysqli, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_error($stmt)) {
        die("Ошибка выполнения SQL-запроса: " . mysqli_stmt_error($stmt));
    }

    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) == 1) {
        mysqli_stmt_bind_result($stmt, $failed_attempt_count, $last_failed_attempt);
        mysqli_stmt_fetch($stmt);
        $failed_attempt_count++;

        $current_time = date('Y-m-d H:i:s');

        $query = "UPDATE users SET failed_attempt_count = ?, last_failed_attempt = ? WHERE email = ?";
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_bind_param($stmt, "iss", $failed_attempt_count, $current_time, $email);
        mysqli_stmt_execute($stmt);
        echo "Current Time: " . $current_time;

        if (mysqli_stmt_error($stmt)) {
            die("Ошибка выполнения SQL-запроса: " . mysqli_stmt_error($stmt));
        }
    }

    mysqli_stmt_close($stmt);
}



function resetFailedAttemptInfo($email, $mysqli) {
    $query = "UPDATE users SET failed_attempt_count = 0, last_failed_attempt = 0 WHERE email = ?";
    $stmt = mysqli_prepare($mysqli, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

$mysqli = connectToDatabase();
$max_failed_attempts = 3;
$block_duration_minutes = 30;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (isUserBlocked($email, $max_failed_attempts, $block_duration_minutes, $mysqli)) {
        echo "<p class='errorText'>Доступ заблокирован. Пожалуйста, подождите.</p>";
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

                echo "<p class='errorText'>Неверный пароль.</p>";
            }
        } else {
            echo "<p class='errorText'>Пользователь с таким email не найден.</p>";
        }

        mysqli_stmt_close($stmt);
    }
}

mysqli_close($mysqli);
?>

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

    <form class="authForm" method="POST">
        <label class="label" for="email">Email:
            <input class="input" type="email" id="email" name="email" required><br>
        </label>
        <label class="label" for="password">Пароль:
            <input class="input" type="password" id="password" name="password" required><br>
        </label>

        <button class="authButton" type="submit">Войти</button>
    </form>

    <p class="reg">Нет аккаунта? <a class="authLink" href="register.php">Зарегистрируйтесь</a></p>
</section>
</body>
</html>
