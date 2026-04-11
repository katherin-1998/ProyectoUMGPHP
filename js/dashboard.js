function mostrarIngresoPuerta() {
    fetch("ingreso_puerta.php")
        .then(response => response.text())
        .then(html => {
            document.getElementById("contenido").innerHTML = html;
        })
        .catch(err => console.error("Error cargando ingreso por puerta:", err));
}
