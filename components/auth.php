<?php
session_start();

function rightsCheck($action)
{
    $user_role = isset($_SESSION['user_role']) ? $_SESSION['user_role'] : 'Гость';

    $allowed_actions = [
        'Гость' => [],
        'Оператор' => ['create_report'],
        'Администратор' => ['create', 'edit', 'delete', 'create_report', 'role']
    ];

    return in_array($action, $allowed_actions[$user_role]);
}

function authorizationRequired()
{
    if (!isset($_SESSION['user_email'])) {
        header('Location: /auth/login.php');
        exit();
    }
}

function login($email, $user_role)
{
    $_SESSION['user_email'] = $email;
    $_SESSION['user_role'] = $user_role;
}

function logout()
{
    session_unset();
    session_destroy();
}

function isLoggedin()
{
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

