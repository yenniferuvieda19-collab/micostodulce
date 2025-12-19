
// Esperar a que el documento esté listo
document.addEventListener('DOMContentLoaded', function() {
    console.log("🧁 Mi Costo Dulce: Scripts cargados y listos.");

    // Función de ejemplo para calcular costos (la usaremos más adelante)
    // Esta función ayudará a calcular: Cantidad * Precio Unitario
    const calcularCosto = (cantidad, precio) => {
        return (parseFloat(cantidad) * parseFloat(precio)).toFixed(2);
    };

    // Aquí activaremos alertas automáticas o cálculos en tiempo real
});

// Función para confirmar antes de eliminar un ingrediente o receta
function confirmarEliminacion(nombre) {
    return confirm(`¿Estás seguro de que quieres eliminar "${nombre}"? Esta acción no se puede deshacer.`);
}