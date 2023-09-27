const updateFormAction = () => {
    const selectedYear = document.getElementById("year");

    if (selectedYear) {
        document.getElementById("reportForm").action = "report.php?year=" + selectedYear.value;
    }
}

updateFormAction();