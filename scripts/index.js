const updateFormAction = () => {
    const selectedYear = document.getElementById("year").value;

    if (selectedYear) {
        document.getElementById("reportForm").action = "report.php?year=" + selectedYear;
    }
}

updateFormAction();