export function confirmDelete(event, button) {
    event.preventDefault();

    const confirmMessage = "¿Deseas Eliminar este Rol?";

    Swal.fire({
        title: confirmMessage,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Aceptar',
        cancelButtonText: 'Cancelar',
        timer: 2000, // Tiempo en milisegundos
        timerProgressBar: true,
        timerProgressBarColor: '#007bff' // Color de la barra de progreso
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = button.getAttribute('href');
        }
    });
}

export  function confirmReset(event, button) {
    event.preventDefault();

    Swal.fire({
        title: "¿Deseas Restaurar este Rol?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Aceptar',
        cancelButtonText: 'Cancelar',
        timer: 2000, // Tiempo en milisegundos
        timerProgressBar: true,
        timerProgressBarColor: '#007bff' // Color de la barra de progreso
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = button.getAttribute('href');
        }
    });
}


function confirmDeletsse(event, button) {
    event.preventDefault();

    const confirmMessage = "¿Deseas Eliminar este Rol?";

    Swal.fire({
        title: confirmMessage,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Aceptar',
        cancelButtonText: 'Cancelar',
        timer: 2000, // Tiempo en milisegundos
        timerProgressBar: true,
        timerProgressBarColor: '#007bff' // Color de la barra de progreso
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = button.getAttribute('href');
        }
    });
}