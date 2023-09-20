<?php
require 'components/dbconnect.php';

function reportCreation()
{
    if (isset($_GET["year"])) {
        $year = $_GET["year"];
    }

    $mysqli = connectToDatabase();

    $sql_workshops = "SELECT DISTINCT ЦЕХИ.наименование_цеха FROM ЦЕХИ";

    $result_workshops = mysqli_query($mysqli, $sql_workshops);

    if ($result_workshops) {
        $total_all_workshops = 0;

        echo "<h1 class='mainTitle'>Отчет о получении спецодежды по заводу за $year год</h1>";

        while ($row_workshop = mysqli_fetch_assoc($result_workshops)) {
            $workshop_name = $row_workshop["наименование_цеха"];

            $sql = "SELECT РАБОТНИКИ.Ф_И_О_работника, СПЕЦОДЕЖДА.вид_спецодежды, 
                    СПЕЦОДЕЖДА.стоимость_единицы, РАБОТНИКИ.скидка_на_спецодежду, 
                    РАБОТНИКИ.id_цеха, ЦЕХИ.наименование_цеха
                    FROM РАБОТНИКИ
                    JOIN ПОЛУЧЕНИЕ ON РАБОТНИКИ.id = ПОЛУЧЕНИЕ.id_работника
                    JOIN СПЕЦОДЕЖДА ON ПОЛУЧЕНИЕ.id_спецодежды = СПЕЦОДЕЖДА.id
                    JOIN ЦЕХИ ON РАБОТНИКИ.id_цеха = ЦЕХИ.id
                    WHERE YEAR(ПОЛУЧЕНИЕ.дата_получения) = $year AND ЦЕХИ.наименование_цеха = '$workshop_name'";

            $result = mysqli_query($mysqli, $sql);

            if ($result) {
                echo "<h2>$workshop_name</h2>";
                echo "<table class='workshopTable'>";
                echo "<tr>
                            <th>Ф.И.О работника</th>
                            <th>Вид спецодежды</th>
                            <th>Стоимость единицы, тыс. руб.</th>
                            <th>Скидка, %</th>
                            <th>Стоимость с учетом скидки, тыс. руб.</th>
                           </tr>
                         ";

                $total_workshop = 0;

                while ($row = mysqli_fetch_assoc($result)) {
                    $discount = $row["скидка_на_спецодежду"];
                    $cost = $row["стоимость_единицы"];
                    $costWithDiscount = $cost - ($cost * $discount / 100);

                    echo "<tr>
                                <td>{$row['Ф_И_О_работника']}</td>
                                <td>{$row['вид_спецодежды']}</td>
                                <td>{$row['стоимость_единицы']}</td>
                                <td>{$row['скидка_на_спецодежду']}</td>
                                <td>$costWithDiscount</td>
                               </tr>
                              ";

                    $total_workshop += $costWithDiscount;
                }

                $total_all_workshops += $total_workshop;

                echo "</table>";

                echo "<p class='workshopPriceContainer'><span class='workshopPrice'>Итого по цеху: </span><span>$total_workshop тыс. руб.</span></p>";
            }
        }

        echo "<hr class='line'/>";

        echo "<p class='allReportPriceContainer'><span class='allReportPrice'>Итого</span><span>$total_all_workshops тыс. руб.</span></p>" ;

        mysqli_close($mysqli);
    }
}
