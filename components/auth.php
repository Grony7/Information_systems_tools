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

