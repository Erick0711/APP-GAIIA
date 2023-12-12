

import { data, url, csrfToken, tipoPagoDeuda, cuentaBancariaDeuda, observacionDeuda, fechaPagoDeuda } from "../global/variables.js";

const buscarSocio = document.getElementById("buscarSocio");
const containerSocio = document.getElementById("containerSocio");
const resultadoSocio = document.getElementById("resultadoSocio");
const tablaSocio = document.getElementById("containerTableSocio");
const inputMonto = document.getElementById("montoPago");
const cuentaContable = document.getElementById("cuentaContable");
const cuentaBancaria = document.getElementById("cuentaBancaria");
const idSocio = document.getElementById("idSocio");
const articulo = document.getElementById("articulo");
// const containerCuentaBancaria = document.getElementById("containerCuentaBancaria");
const guardarDeuda = document.getElementById("pagarDeuda");

const montoTotalDeuda = document.getElementById("montoTotalDeuda");

const contenidoDeuda = document.getElementById("deudaSocio");

const formularioPago = document.getElementById("formularioPago");

// // campos para del modal de deuda
// const tipoPagoDeuda = document.getElementById("tipoPagoDeuda");
// const cuentaBancariaDeuda = document.getElementById("cuentaBancariaDeuda");
// const observacionDeuda = document.getElementById("observacionDeuda");
// const fechaPagoDeuda = document.getElementById("fechaPagoDeuda");
let seleccion = 0;
// buscar el socio por ya sea por su id y nombre
$(window).on("load", function () {
    buscarSocio.addEventListener("keyup", async (e) => {
        let evento = e.target;
        const value = evento.value;
        data.append("buscarSocio", value);
        const response = await fetch(`${url}/buscarSocio`, {
            method: "POST",
            body: data,
            headers: {
                'X-CSRF-TOKEN': csrfToken,
            },
        });
        if (response.status === 200) {
            const socios = await response.json();
            tablaSocio.classList.remove("d-none");
            resultadoSocio.innerHTML = "";

            socios.forEach((socio) => {
                const { persona, id } = socio;
                const tr = document.createElement("tr");
                tr.setAttribute("data-id", id);
                // Celda para el nombre
                const tdNombre = document.createElement("td");
                const nombreCompleto = persona.nombre_pers + persona.apellido_pers; // Suponiendo que "nombre_completo" es el atributo que contiene el nombre y apellido concatenado
                const textNombre = document.createTextNode(nombreCompleto);
                tdNombre.appendChild(textNombre);
                tr.appendChild(tdNombre);

                // Celda para el apellido
                const celdaCi = document.createElement("td");
                celdaCi.classList.add("text-center")
                const ci_pers = persona.ci_pers; // Suponiendo que "apellido_pers" es el atributo del apellido
                const ci = document.createTextNode(ci_pers);
                celdaCi.appendChild(ci);
                tr.appendChild(celdaCi);

                // Celda para las opciones
                const tdOpciones = document.createElement("td");
                tdOpciones.classList.add("text-center")
                const boton = document.createElement("button");
                boton.textContent = "Seleccionar"; // Puedes cambiar el texto del botón si lo deseas
                boton.classList.add("seleccionarSocio", "btn", "btn-success", "btn-sm");
                tdOpciones.appendChild(boton);
                tr.appendChild(tdOpciones);

                resultadoSocio.appendChild(tr);
            })
            // resultadoBusqueda.innerHTML = result;

            botonSeleccionarSocio();
        }

    });
});

// * Vaciar formulario
function vaciarFormularioPago(tipo) {
    if (tipo == "ingreso") {
        containerSocio.classList.remove("d-none");
        inputMonto.classList.remove("bg-danger");
        inputMonto.classList.add("bg-success");
        // containerCuentaBancaria.classList.remove("d-none");
    }else if(tipo == "egreso"){
        inputMonto.classList.remove("bg-success");
        inputMonto.classList.add("bg-danger");
        containerSocio.classList.add("d-none");
        resultadoSocio.innerHTML = "";
        tablaSocio.classList.add("d-none");
        // containerCuentaBancaria.classList.add("d-none");
        // document.getElementById("idSocio").value = "";
        // buscarSocio.value = "";
    }else{
        containerSocio.classList.add("d-none");
        buscarSocio.value = "";
        // document.getElementById("idSocio").value = "";
        tablaSocio.classList.add("d-none");

        $("#articulo").select2("val", "Seleccionar");
        $("#cuentaContable").select2("val", "Seleccionar");
    }


    // $("#cuentaBancaria").select2("val", "Seleccionar");
    $("#gestion").select2("val", "Seleccionar");
    $("#tipoPago").select2("val", "Seleccionar");
    $("#fechaPago").val("");
    $("#montoPago").val("");
    $("#observacionPago").val("");
    $("idSocio").val("");
    $("reciboPago").val("");
    $("reciboTesoreraPago").val("");
}
// obtener id de la cuenta contable
$("#cuentaContable").on("change", obtenerArticulo);

async function obtenerArticulo() {
    const valor = cuentaContable.value;
    if (valor == 2) {
        vaciarFormularioPago("ingreso")
    } else {
        vaciarFormularioPago("egreso")
        $("#idSocio").val("");
        $("#buscarSocio").val("");
        seleccion = 0;
    }
    data.append("id_cuentaContable", valor);
    const response = await fetch(`${url}/obtenerArticulo`, {
        method: "POST",
        body: data,
        headers: {
            'X-CSRF-TOKEN': csrfToken,
        },
    });
    if (response.ok) {
        const articulos = await response.json();

        articulo.innerHTML = "";
        // creamos un option vacio para placeholder del select
        const option = document.createElement("option");
        articulo.appendChild(option);

        // empezamos a maquetar recorriendo cada articulo obtenido
        articulos.forEach(art => {
            const option = document.createElement("option");
            option.value = art.id;
            option.textContent = `${art.nombre_art}`;
            option.setAttribute("data-monto", art.monto_art)
            articulo.appendChild(option);
        });

        // obtenemos el monto del articulo al hacer un chage
        // $("#articulo").on("change", obtenerMontoArticulo)
    }
}


function botonSeleccionarSocio() {
    const socioButton = $(".seleccionarSocio");
    socioButton.each(function (index, boton) {
        boton.addEventListener("click", async () => {
            if (seleccion === 0) {
                const tr = boton.closest("tr");
                const dataId = tr.getAttribute("data-id");
                const filas = document.querySelectorAll("tr[data-id]");
                filas.forEach(function (fila) {
                    if (fila.getAttribute("data-id") !== dataId) {
                        fila.remove();
                    }
                });
                // colocamos en el de la fila al campo idsocio
                document.getElementById("idSocio").value = dataId;
                boton.innerHTML = "Quitar";
                boton.classList.remove("btn-success");
                boton.classList.add("btn-danger");
                seleccion = 1;
                data.append("idSocio", dataId);
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
            } else {
                boton.innerHTML = "Seleccionar";
                boton.classList.remove("btn-danger");
                boton.classList.add("btn-success");
                buscarSocio.value = "";
                seleccion = 0;
                document.getElementById("idSocio").value = "";
            }
        })
    });
}

function obtenerMontoArticulo() {
    const monto = $("#articulo option:selected").data("monto");
    inputMonto.value = `${monto}`;
}


// enviamos el formulario de pago
formularioPago.addEventListener("submit", async (e) => {
    e.preventDefault();
    const valor = cuentaContable.value;
    const formulario = new FormData(formularioPago);
    formulario.append("userId", userId);
    if(valor == 2){
        if(document.getElementById("idSocio").value.length > 0){
            const response = await fetch(`${url}/guardarPago`, {
                method: "POST",
                body: formulario,
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                }
            });
                
            if (response.status === 200) {
                const resultPago = await response.json();
                console.log(resultPago);
                if (resultPago === "success") {
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
                    vaciarFormularioPago("reset");
                    $("#idSocio").val("");
                    inputMonto.classList = "";
                    inputMonto.classList.add("form-control", "bg-white");
                } else {
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
                        title: 'Algo sucedio'
                    })
                }
                // console.log(resultPago); 
            }
        }else{
            Swal.fire('Para ingresar un pago debes seleccionar un Socio');
        }

    }else if(valor == 1){
        const response = await fetch(`${url}/guardarGasto`, {
            method: "POST",
            body: formulario,
            headers: {
                'X-CSRF-TOKEN': csrfToken,
            }
        });
        
    if (response.status === 200) {
            const resultPago = await response.json();
            if (resultPago === "success") {
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
                vaciarFormularioPago("reset");
                $("#idSocio").val("");
                inputMonto.classList = "";
                inputMonto.classList.add("form-control", "bg-white");
            } else {
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
                    title: 'Algo sucedio'
                })
            }
        }
    }
});


const modalDeudaSocio = document.getElementById("cerrarModalSocio");
modalDeudaSocio.addEventListener("click", () => {
    contenidoDeuda.innerHTML = "";
    montoTotalSeleccionado = 0;
    montoTotalDeuda.value = "";
})


function obtenerDatosDeuda(result) {
    const { deudas } = result;
    const persona = deudas[ 0 ].socio.persona;
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
                    vaciarFormularioPago("reset");
                    inputMonto.classList.remove("bg-danger")
                    contenidoDeuda.innerHTML = "";
                    resultadoSocio.innerHTML = "";
                    seleccion = 0;
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

// $('#cuentaBancaria').on('change', cuentaSocio)
// async function cuentaSocio (){
//     // const valor = e.target;
//     const idCuentaBancaria = cuentaBancaria.value;
    
//     data.append('idCuentaBancaria', idCuentaBancaria);
//     data.append('idSocio', idSocio.value);

//     const response = await fetch(`${url}/obtenerCuentaSocio`, {
//         method: 'POST',
//         body: data,
//         headers: {
//             'X-CSRF-TOKEN': csrfToken,
//         }
//     })

//     if(response.status === 200){
//         const result = await response.json();
//         console.log(result);
//         if(result != "vacio"){
//             const {id, monto} = result;
//             var cuentaSocio = document.getElementById("cuentaSocio");
//             var option = document.createElement("option");
//             option.value = id;
//             option.innerHTML = monto;
//             cuentaSocio.appendChild(option);
//             $("#cuentaSocio").on('change', async () => {
//                 const data = new FormData()
//                 data.append('idCuentaSocio', cuentaSocio.value);
//                 const responseCuenta = await fetch(`${url}/obtenerMontoSocio`,{
//                     method: 'POST',
//                     body: data,
//                     headers: {
//                         'X-CSRF-TOKEN': csrfToken,
//                     }
//                 })
//                 if(responseCuenta.status === 200){
//                     const resultCuentaSocio = await responseCuenta.json();
//                     const {monto} = resultCuentaSocio;
//                     const cuentaSocioAplicada = inputMonto.value - monto;
//                     inputMonto.value = cuentaSocioAplicada;
//                 }
//             })
//         }
//     }
// }



// cuentaBancaria.addEventListener('change', async (e) => {

// })