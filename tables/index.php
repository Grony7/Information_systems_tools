<?php
require $_SERVER['DOCUMENT_ROOT'] . '/components/auth.php';
authorizationRequired();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <title>Таблица RECEIVING</title>
    <link rel="stylesheet" href="/styles/styles.css">
    <link rel="stylesheet" href="/styles/tables/menu.css">
</head>
<body>
<section class="tableSection">
    <h1 class="pageTitle">Таблицы</h1>
    <div class="buttonWrapper">
        <a class="backLinkButton" href="../">
            <img src='/public/icon/back-icon.svg' width='30' height='30' alt='изменить'>
            <span>На главную</span>
        </a>
    </div>
    <nav>
        <ul class="tableList">
            <li class="tableItem">
                <a class="button" href="/tables/specialClothing">
                    Спецодежда
                </a>
            </li>
            <li class="tableItem">
                <a class="button" href="/tables/workshops">
                    Цехи
                </a>
            </li>
            <li class="tableItem">
                <a class="button" href="/tables/employees">
                    Сотрудники
                </a>
            </li>
            <li class="tableItem">
                <a class="button" href="/tables/receiving">
                    Получение
                </a>
            </li>
        </ul>
    </nav>
</section>
</body>
</html>