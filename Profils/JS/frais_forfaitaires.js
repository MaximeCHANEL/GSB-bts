document.addEventListener("DOMContentLoaded", function () {
    const selectType = document.getElementById("type_frais");
    const justificatifRow = document.getElementById("justificatifRow");

    selectType.addEventListener("change", function () {
        justificatifRow.style.display = this.value === "4" ? "table-row" : "none";
    });
});