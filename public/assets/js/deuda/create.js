import { url, csrfToken } from "../global/variables.js";

const formNuevaDeuda = document.getElementById("formularioNuevaDeuda");


$(document).ready(function() {
    var $select = $("#socioNuevaDeuda");
    $select.select2({
        ajax: {
            url: `${url}/buscarSocio`,
            type: "post",
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    searchTerm: params.term
                };
            },
            processResults: function(response) {
                var options = []; // Array para almacenar las opciones

                // Agrega una opción por defecto (si lo deseas)
                options.push({
                    id: '',
                    text: ''
                });

                // Agrega opciones desde la respuesta del servidor
                $.each(response, function(index, res) {
                    options.push({
                        id: res.id,
                        text: `${res.persona.nombre_pers} ${res.persona.apellido_pers} - ${res.persona.ci_pers}`
                    });
                });

                return {
                    results: options
                };
            },
            cache: true
        },
        language: {
            noResults: function() {
                return "No se encontraron resultados";
            },
            searching: function() {
                return "Buscando...";
            }
        }
    });
});


formNuevaDeuda.addEventListener('submit', async (e) => {
    e.preventDefault();
    const response = await fetch(`${url}/deuda`, {
        method: 'POST',
        body: new FormData(formNuevaDeuda),
        headers: {
            'X-CSRF-TOKEN': csrfToken,
        }
    });

    if(response.status === 200){
        const result = await response.json();
        console.log(result);
        // if(result.message = "succcess"){
        //     console.log("todo guardado correctamente");
        // }else{
        //     console.log("algo sucedio");
        // }
    }
});


