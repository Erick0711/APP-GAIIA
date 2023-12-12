
const resultadoPersona = document.getElementById("resultadoBusquedaPersona");
const buscadorPersona = document.getElementById("buscadorPersonaCi");
const globalElement = document.getElementById("global");
const url = globalElement.dataset.url;
const csrfToken = globalElement.dataset.csrf;
const data = new FormData();

buscadorPersona.addEventListener('keyup', async (e) => {
    let valorCi = e.target.value;
    if(valorCi.length > 0)
    {
        valorCi = valorCi
    }else{
        valorCi = 0;
    }
    data.append('ci_pers', valorCi);
    const response = await fetch(`${url}/buscarPersona`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
        },
        body: data
    })
    if (response.ok) {
        const result = await response.text();
        resultadoPersona.innerHTML = '';
        resultadoPersona.innerHTML = result;
        console.log(result);
        // actualizarTablaPersonas(result);
    }
})


function confirmDelete(event, button) {
    event.preventDefault();

    const confirmMessage = "¿Deseas Eliminar esta Persona?";

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
function confirmReset(event, button) {
    event.preventDefault();

    Swal.fire({
        title: "¿Deseas Restaurar esta Persona?",
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