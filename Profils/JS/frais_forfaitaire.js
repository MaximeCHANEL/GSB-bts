document.getElementById("type_frais").addEventListener("change", function () {
    let justificatif = document.querySelector(".justification"); // Sélectionne le bloc
    if (this.value === "4") { // Vérifie si la valeur sélectionnée est "Autre"
        justificatif.style.display = "block"; // Affiche le bloc
    } else {
        justificatif.style.display = "none"; // Cache le bloc si un autre choix est sélectionné
    }
});