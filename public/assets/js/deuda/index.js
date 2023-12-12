import { data, url, csrfToken, tipoPagoDeuda, cuentaBancariaDeuda, observacionDeuda, fechaPagoDeuda } from "../global/variables.js";

const contenidoDeuda = document.getElementById("deudaSocio");
const guardarDeuda = document.getElementById("pagarDeuda");

const montoTotalDeuda = document.getElementById("montoTotalDeuda");
const buscarDeuda = document.getElementById("buscarDeuda");
const resultadoSocio = document.getElementById("resultadoBusquedaDeuda");


// Modal deuda
const modalNuevaDeuda = document.getElementById("nuevaDeuda");

// ** buscar las deudas del socio
    function botonSeleccionarDeuda() {
        const buttonDeuda = $(".pagarDeuda");
        buttonDeuda.each(function (index, boton) {
            boton.addEventListener("click", async () => {

                    const idSocio = boton.getAttribute('data-socio');
                    data.append("idSocio", idSocio);
                    const response = await fetch(`${url}/buscarDeudaSocio`, {
                        method: "POST",
                        body: data,
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                        }
                    });
                    if (response.status === 200) {
                        const result = await response.json();
                        console.log(result);
                        if (result.message === "success") {
                            obtenerDatosDeuda(result);
                            checkDeudaSumar();
                            anularDeuda();
                        } else if (result.message === 404) {
                            console.log(result.message);
                        }
                    }
            })
        });
    }



    function obtenerDatosDeuda(result) {
        const { deudas } = result;
        const persona = deudas[0].socio.persona;
        $("#registrarDeuda").modal("show");
        document.getElementById("socioDeuda").innerHTML = `<p>${persona.nombre_pers} ${persona.apellido_pers}</p>`;
        // Crear un array con las rutas de las propiedades que quieres mostrar
        const propiedadesMostrar = [ "articulo.nombre_art", "articulo.monto_art", "gestion.anio_gest" ];
    
        deudas.forEach((deuda) => {
            const tr = document.createElement("tr");
            tr.setAttribute("data-fila", deuda.id);
            // Iterar por cada propiedad y crear una celda para cada una
            propiedadesMostrar.forEach((rutaPropiedad) => {
                const celda = document.createElement("td");
                celda.classList.add("text-center");
    
                // Obtener el valor de la propiedad anidada
                const propiedades = rutaPropiedad.split('.'); // Convertir la ruta en un array de propiedades
                let valorPropiedad = deuda;
                for (const propiedad of propiedades) {
                    valorPropiedad = valorPropiedad[ propiedad ];
                }
    
                const contenido = document.createTextNode(valorPropiedad);
                celda.appendChild(contenido);
                tr.appendChild(celda);
    
            });// Crear un checkbox adicional y agregarle la clase "deuda"
            const checkbox = document.createElement("input");
            checkbox.type = "checkbox";
            checkbox.classList.add("deuda");
            checkbox.value = deuda.articulo.monto_art;
            const celdaCheckbox = document.createElement("td");
            celdaCheckbox.classList.add("text-center");
            celdaCheckbox.appendChild(checkbox);
            tr.appendChild(celdaCheckbox);
    
            contenidoDeuda.appendChild(tr);
        });
    }


const modalDeudaSocio = document.getElementById("cerrarModalSocio");
modalDeudaSocio.addEventListener("click", () => {
    contenidoDeuda.innerHTML = "";
    montoTotalSeleccionado = 0;
    montoTotalDeuda.value = "";
})



let montoTotalSeleccionado = 0;

function checkDeudaSumar() {
    const checksDeudas = document.querySelectorAll(".deuda");
    checksDeudas.forEach((checkDeuda) => {
        checkDeuda.addEventListener("change", () => {
            if (checkDeuda.classList.contains("deuda")) {
                const monto = parseFloat(checkDeuda.value);
                if (checkDeuda.checked) {
                    // Si el checkbox se marcó, sumar el monto
                    montoTotalSeleccionado += monto;
                } else {
                    // Si el checkbox se desmarcó, restar el monto
                    montoTotalSeleccionado -= monto;
                }
                // Actualizar el valor en el campo de texto
                montoTotalDeuda.value = montoTotalSeleccionado.toFixed(2); // Siempre redondear a 2 decimales
            }
        })
    })
}
botonSeleccionarDeuda();
// * Vaciar formulario
function vaciarFormularioDeuda() {

    $("#cuentaBancaria").select2("val", "Seleccionar");
    $("#gestion").select2("val", "Seleccionar");
    $("#tipoPago").select2("val", "Seleccionar");
    $("#fechaPago").val("");
    $("#montoPago").val("");
    $("#observacionPago").val("");
    $("#buscarDeuda").val("");
}

function anularDeuda() {
    guardarDeuda.addEventListener("click", async (e) => {
        e.preventDefault();
        let arreglo_deuda = [];

        const checksDeudas = document.querySelectorAll(".deuda");
        // inicio del recorrido check
        checksDeudas.forEach((checkDeuda) => {
            if (checkDeuda.checked) {
                const fila = checkDeuda.closest("tr");
                const dataFila = fila.getAttribute("data-fila");
                arreglo_deuda = [...arreglo_deuda, dataFila]
            }
        })
        // fin del recorrido check

        if(arreglo_deuda.length > 0 && tipoPagoDeuda.value > 0 && cuentaBancariaDeuda.value > 0){
            data.append("id_deuda", JSON.stringify(arreglo_deuda));
            data.append("id_tipoPago", tipoPagoDeuda.value);
            data.append("id_cuenta_bancaria", cuentaBancariaDeuda.value);
            data.append("observacionDeuda", observacionDeuda.value);
            data.append("fechaPagoDeuda", fechaPagoDeuda.value)
            data.append("id_user", userId);

            const response = await fetch(`${url}/pagarDeuda`, {
                method: "POST",
                body: data,
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                }
            })
            if (response.status === 200) {
                const result = await response.json();
                console.log(result);
                if (result.message == "success") {
                    vaciarFormularioDeuda();
                    contenidoDeuda.innerHTML = "";
                    arreglo_deuda = [];
                    montoTotalDeuda.value = "";
                    montoTotalSeleccionado = 0;
                    cuentaBancariaDeuda.selectedIndex = 0;
                    tipoPagoDeuda.selectedIndex = 0;
                    $("#registrarDeuda").modal("hide")
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })
    
                    Toast.fire({
                        icon: 'success',
                        title: 'Guardado Correctamente'
                    })
                }
            }
        }else{
            Swal.fire('Debes completar cada campo correctamente')
        }
    })
}

buscarDeuda.addEventListener("keyup", async (e) => {
        let evento = e.target;
        const value = evento.value;
        data.append("buscarDeuda", value);
        const response = await fetch(`${url}/buscarDeuda`, {
            method: "POST",
            body: data,
            headers: {
                'X-CSRF-TOKEN': csrfToken,
            },
        });
        if (response.status === 200) {
            const deudas = await response.json();
            resultadoSocio.innerHTML = "";
            console.log(deudas);
            deudas.forEach((deuda) => {
                const { id, articulo, gestion, socio } = deuda;
                const tr = document.createElement("tr");
                tr.setAttribute("data-id", id);
                // Celda para el nombre
                const tdNombre = document.createElement("td");
                const nombreCompleto = socio.persona.nombre_pers + socio.persona.apellido_pers; 
                const textNombre = document.createTextNode(nombreCompleto);
                tdNombre.appendChild(textNombre);
                tr.appendChild(tdNombre);

                // celda CI
                const tdCi = document.createElement("td");
                const ci = socio.persona.ci_pers; 
                const textCi = document.createTextNode(ci);
                tdCi.appendChild(textCi);
                tr.appendChild(tdCi);

                // celda ARTICULO
                const tdArticulo = document.createElement("td");
                const articuloDato = articulo.nombre_art; 
                const textArticulo = document.createTextNode(articuloDato);
                tdArticulo.appendChild(textArticulo);
                tr.appendChild(tdArticulo);

                // celda MONTO
                const tdMonto = document.createElement("td");
                const monto = articulo.monto_art; 
                const textMonto = document.createTextNode(monto);
                tdMonto.appendChild(textMonto);
                tr.appendChild(tdMonto);

                // celda GESTION
                const tdGestion = document.createElement("td");
                const gestionDato = gestion.anio_gest; 
                const textGestion = document.createTextNode(gestionDato);
                tdGestion.appendChild(textGestion);
                tr.appendChild(tdGestion);


                // Celda para las opciones
                const tdOpciones = document.createElement("td");
                tdOpciones.classList.add("text-center")
                const boton = document.createElement("button");
                boton.innerHTML = '<i class="fas fa-dollar-sign"></i>';
                boton.classList.add("pagarDeuda", "btn", "btn-success", "btn-xs");
                boton.setAttribute("data-socio", socio.id)
                tdOpciones.appendChild(boton);
                tr.appendChild(tdOpciones);

                resultadoSocio.appendChild(tr);
            })
            botonSeleccionarDeuda()
        }
    });
