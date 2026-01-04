/**
 * 🧁 Mi Costo Dulce: Scripts Generales
 */

document.addEventListener('DOMContentLoaded', function() {
    console.log("🧁 Mi Costo Dulce: Scripts cargados y listos.");

    // Ver/Ocultar Contraseña 
    const toggleButtons = document.querySelectorAll('.toggle-password');

    toggleButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Intentamos obtener el input de dos maneras para que nunca falle:
            // 1. Por el ID en 'data-target' (si existe)
            // 2. Buscando el input que está dentro del mismo grupo (parentElement)
            const targetId = this.getAttribute('data-target');
            const input = targetId ? document.getElementById(targetId) : this.parentElement.querySelector('input');
            const icon = this.querySelector('i'); 

            if (input && icon) {
                // Cambia entre 'password' y 'text'
                const isPassword = input.type === 'password';
                input.type = isPassword ? 'text' : 'password';
                
                // Alterna las clases del icono (ojo abierto / ojo tachado)
                if (isPassword) {
                    icon.classList.replace('fa-eye', 'fa-eye-slash');
                } else {
                    icon.classList.replace('fa-eye-slash', 'fa-eye');
                }
            } else {
                console.error("❌ No se encontró el input o el icono para este botón.");
            }
        });
    });

    //  Herramientas de Cálculo ---
    window.calcularCosto = (cantidad, precio) => {
        const total = (parseFloat(cantidad) * parseFloat(precio));
        return isNaN(total) ? "0.00" : total.toFixed(2);
    };

});


// Función para confirmar antes de eliminar
function confirmarEliminacion(nombre) {
    return confirm(`¿Estás seguro de que quieres eliminar "${nombre}"?\n\nEsta acción no se puede deshacer.`);
}