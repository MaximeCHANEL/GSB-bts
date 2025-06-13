document.addEventListener("DOMContentLoaded", function () {
    const selectType = document.getElementById("type_frais");
    const justificationRow = document.querySelector(".justification");

    if (justificationRow) justificationRow.style.display = "none";

    selectType.addEventListener("change", function () {
        if (justificationRow) {
            justificationRow.style.display = this.value === "4" ? "table-row" : "none";
        }
    });
});