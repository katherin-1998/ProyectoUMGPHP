(function() {
    console.log("Inicializando selectores de salón...");

    const sede = document.getElementById("sede_select");
    const nivel = document.getElementById("nivel_select");
    const salon = document.getElementById("salon_select");
    const btn = document.getElementById("btn_generar_reporte"); // nombre correcto del botón

    if (!sede || !nivel || !salon) {
        console.warn("Selectores no encontrados, abortando.");
        return;
    }

    // Eliminar listeners anteriores clonando los elementos
    const sedeNuevo = sede.cloneNode(true);
    sede.parentNode.replaceChild(sedeNuevo, sede);
    const nivelNuevo = nivel.cloneNode(true);
    nivel.parentNode.replaceChild(nivelNuevo, nivel);
    const salonNuevo = salon.cloneNode(true);
    salon.parentNode.replaceChild(salonNuevo, salon);

    const s = document.getElementById("sede_select");
    const n = document.getElementById("nivel_select");
    const sl = document.getElementById("salon_select");
    const b = document.getElementById("btn_generar_reporte");

    s.addEventListener("change", function() {
        n.innerHTML = '<option value="">-- Seleccione Nivel --</option>';
        sl.innerHTML = '<option value="">-- Seleccione Salón --</option>';
        n.disabled = true;
        sl.disabled = true;

        if (this.value) {
            // Ruta absoluta desde la raíz del proyecto
            fetch("/ProyectoUMGPHP/php/reporte_salon/php/get_niveles.php?id_instalacion=" + this.value)
                .then(r => r.json())
                .then(data => {
                    console.log("Niveles recibidos:", data);
                    if (data.length > 0) {
                        n.disabled = false;
                        data.forEach(item => {
                            n.innerHTML += `<option value="${item.id_nivel}">${item.nombre_nivel}</option>`;
                        });
                    }
                })
                .catch(err => console.error("Error niveles:", err));
        }
    });

    n.addEventListener("change", function() {
        sl.innerHTML = '<option value="">-- Seleccione Salón --</option>';
        sl.disabled = true;

        if (this.value) {
            fetch("/ProyectoUMGPHP/php/reporte_salon/php/get_salones.php?id_nivel=" + this.value)
                .then(r => r.json())
                .then(data => {
                    console.log("Salones recibidos:", data);
                    if (data.length > 0) {
                        sl.disabled = false;
                        data.forEach(item => {
                            sl.innerHTML += `<option value="${item.id_salon}">${item.nombre_salon}</option>`;
                        });
                    }
                })
                .catch(err => console.error("Error salones:", err));
        }
    });

    if (b) {
        b.addEventListener("click", function() {
            if (!sl.value) {
                alert("Por favor, selecciona un salón antes de generar el reporte.");
                return;
            }
            const contenedor = document.getElementById("resultado_arbol");
            contenedor.innerHTML = '<div class="text-center text-white">Cargando datos...</div>';

            fetch("/ProyectoUMGPHP/php/reporte_salon/php/consultar_reporte.php?id_salon=" + sl.value)
                .then(r => r.text())
                .then(html => {
                    contenedor.innerHTML = html;
                })
                .catch(err => {
                    contenedor.innerHTML = "Error al obtener el reporte.";
                    console.error(err);
                });
        });
    }
})();