<?php
require $_SERVER['DOCUMENT_ROOT'] . '/components/auth.php';

logout();

header('Location: login.php');
exit();
?>