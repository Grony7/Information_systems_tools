<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Выбор отчета</title>
    <link rel="stylesheet" href="/styles/styles.css">
    <link rel="stylesheet" href="/styles/index.css">
</head>
<body>
<section class="menu">
    <div class="formWrapper">
        <h1 class="title">База данных выдачи спецодежды</h1>
        <div>

        </div>
        <?php
        require $_SERVER['DOCUMENT_ROOT'] . '/components/auth.php';
        authorizationRequired();

        if (isLoggedin()) {
            $user_email = $_SESSION['user_email'];
            $user_role = $_SESSION['user_role'];

            echo "<p style='margin: 0 0 20px;'>Вы авторизованы как $user_email ($user_role)</p>";
            echo "<a class='button' href='/auth/logout.php'>Выход</a>";
        } else {
            echo "<p>Авторизация: </p>";
            echo "<a class='button' href='/auth/login.php'>Авторизоваться</a>";
        }
        ?>
        <a class="button" href="./tables">Таблицы</a>
        <?php
         $can_edit_role = rightsCheck('role');
         if ($can_edit_role) {
             echo "<a class='button' href='./tables/adminRoles/index.php'>Роли пользователей</a>";
         }

         $can_create_report = rightsCheck('create_report');
         if ($can_create_report) {

        ?>
        <h2>Отчет за год:</h2>
        <form class="dataForm" method="POST" id="reportForm" action="report.php">
            <label for="year">Год:</label>
            <select name="year" id="year" required class="selectYear" onchange="updateFormAction()">
                <?php
                require $_SERVER['DOCUMENT_ROOT'] . '/components/createListOption.php';
                createListOption();
                ?>
            </select>
            <button class="dataButton" type="submit"> Сформировать отчет</button>
        </form>
             <?php } ?>
    </div>

    <script src="scripts/index.js"></script>

</section>
</body>
</html>
