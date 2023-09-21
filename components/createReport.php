<?php
require 'components/DBConnect.php';

function creatReport()
{
    if (isset($_GET["year"])) {
        $year = $_GET["year"];
    }

    $mysqli = connectToDatabase();

    $sql_workshops = "SELECT DISTINCT workshops.workshop_name 
                      FROM workshops
                      JOIN employees ON workshops.id = employees.workshop_id
                      JOIN receiving ON employees.id = receiving.employee_id
                      WHERE YEAR(receiving.receiving_date) = $year";

    $result_workshops = mysqli_query($mysqli, $sql_workshops);

    if ($result_workshops) {
        $total_all_workshops = 0;

        echo "<h1 class='mainTitle'>Отчет о получении спецодежды по заводу за $year год</h1>";

        while ($row_workshop = mysqli_fetch_assoc($result_workshops)) {
            $workshop_name = $row_workshop["workshop_name"];

            $sql = "SELECT employees.employee_name, special_clothing.clothing_type, 
                    special_clothing.unit_cost, employees.discount_on_clothing, 
                    employees.workshop_id, workshops.workshop_name
                    FROM employees
                    JOIN receiving ON employees.id = receiving.employee_id
                    JOIN special_clothing ON receiving.clothing_id = special_clothing.id
                    JOIN workshops ON employees.workshop_id = workshops.id
                    WHERE YEAR(receiving.receiving_date) = $year AND workshops.workshop_name = '$workshop_name'";

            $result = mysqli_query($mysqli, $sql);

            if ($result) {
                echo "<h2>$workshop_name</h2>";
                echo "<table class='workshopTable'>";
                echo "<tr>
                            <th>Ф.И.О работника</th>
                            <th>Вид спецодежды</th>
                            <th>Стоимость единицы, руб.</th>
                            <th>Скидка, %</th>
                            <th>Стоимость с учетом скидки, руб.</th>
                           </tr>
                         ";

                $total_workshop = 0;

                while ($row = mysqli_fetch_assoc($result)) {
                    $discount = $row["discount_on_clothing"];
                    $cost = $row["unit_cost"];
                    $costWithDiscount = $cost - ($cost * $discount / 100);

                    echo "<tr>
                                <td>{$row['employee_name']}</td>
                                <td>{$row['clothing_type']}</td>
                                <td>{$row['unit_cost']}</td>
                                <td>{$row['discount_on_clothing']}</td>
                                <td>$costWithDiscount</td>
                               </tr>
                              ";

                    $total_workshop += $costWithDiscount;
                }

                $total_all_workshops += $total_workshop;

                echo "</table>";

                echo "<p class='workshopPriceContainer'><span class='workshopPrice'>Итого по цеху: </span><span>$total_workshop руб.</span></p>";
            }
        }

        echo "<hr class='line'/>";
        echo "<p class='allReportPriceContainer'><span class='allReportPrice'>Итого</span><span>$total_all_workshops руб.</span></p>";

        mysqli_close($mysqli);
    }
}
