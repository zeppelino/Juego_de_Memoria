// En este archivo dejo todas las funcionalidades del tablero y del temporizador ya que por separado me generan problemas

// Variables para el juego
let primeraCarta = null;
let segundaCarta = null;
let bloqueado = false;
let aciertos = 0;
let intentos = 0;
let tiempoRestante;
let intervaloTiempo;

// Escuchadores para los botones rendirse e interrumpir
document.getElementById("btnRendirse").addEventListener("click", function() {
    Swal.fire({
        title: "Estas Abandonando la partida",
        text: "Perderas tu partida",
        icon: "error",
        confirmButtonText: "Continuar",
    }).then(() => guardarPartida("abandonada", "finalizada"));
    /* guardarPartida("abandonada", "finalizada"); */
});

document.getElementById("btnInterrumpir").addEventListener("click", function() {
    guardarPartida("en curso", "activa");
});


// Event Listener para iniciar el tablero
document.addEventListener("DOMContentLoaded", () => {

    let tablero = document.getElementById('tableroContinuar');

    const esPartidaGuardada = tablero?  tablero.dataset.esPartidaGuardada === "true" : "false";
    

    if (esPartidaGuardada == true) {
        cargarPartida();
    } else {

        const dificultad = document.getElementById("dificultad")?.value;
        const nroCartas = document.getElementById("nroCartasId")?.value;
        const tipoCartas = document.getElementById("tipo_cartas")?.value;
        const tiempoSeleccionado = document.getElementById(
            "tiempoSeleccionadoId"
        ).value;

        generarTablero(dificultad, tipoCartas, nroCartas);
        iniciarTemporizador(tiempoSeleccionado);

    }

});

///////////////  FUNCIONES PARA EL TABLERO  ///////////////
function generarTablero(dificultad, tipoCartas, nroCartas) {

    const tipos = Array.from({ length: 16 }, (_, i) => i + 1);

    if (
        !tipoCartas ||
        !["numeros", "animales", "aviones"].includes(tipoCartas)
    ) {
        console.error("Error: tipoCartas es inválido o no está definido");
        return;
    }

    // genero el ordern de las cartas
    let cartas = tipos.slice(0, nroCartas / 2);
    cartas = cartas.concat(cartas).sort(() => Math.random() - 0.5);

    //console.log(cartas);

    const tablero = document.getElementById("tablero");
    tablero.innerHTML = "";

    contadorID = 1;

    cartas.forEach((carta) => {
        const cartaDiv = document.createElement("div");
        cartaDiv.id = "cartaId" + contadorID;
        contadorID++;
        cartaDiv.className = "carta";
        cartaDiv.dataset.valor = carta;

    
        // Construcción dinámica de la ruta de la imagen según el tipo de carta
        const img = document.createElement("img");
        const baseUrl2 = "../images";
        img.src = baseUrl2 + "/" + tipoCartas + "/" + carta + ".jpg";
        img.alt = "Carta de juego";
        img.classList.add("imagen-carta");
        img.style.display = "none";
        cartaDiv.appendChild(img);

        cartaDiv.addEventListener("click", () =>
            voltearCarta(cartaDiv, tipoCartas)
        );
        tablero.appendChild(cartaDiv);
    });
    aciertos = 0;
    intentos = 0;
    actualizarMarcadores();
}

function voltearCarta(carta, tipoCartas) {
    if (
        bloqueado ||
        (carta.querySelector("img") &&
            carta.querySelector("img").style.display === "block")
    )
        return;

    const img = carta.querySelector("img");
    const placeholder = carta.querySelector(".placeholder");

    if (img) {
        img.style.display = "block"; // Mostrar la imagen si existe
        if (placeholder) placeholder.style.display = "none"; // Ocultar el signo de interrogación
    } else if (placeholder) {
        placeholder.style.display = "block"; // Mostrar el signo de interrogación si no hay imagen
    }

    if (!primeraCarta) {
        primeraCarta = carta;
    } else {
        segundaCarta = carta;
        bloqueado = true;
        intentos++;
        setTimeout(verificarPareja, 800);
    }
}

// Verifico si las cartas son iguales

function verificarPareja() {
    if (primeraCarta.dataset.valor === segundaCarta.dataset.valor) {
        aciertos++;
        primeraCarta.classList.add("acertada");
        segundaCarta.classList.add("acertada");
    } else {
        // Restablece las cartas a su estado inicial (con signo de interrogación)
        const primeraImg = primeraCarta.querySelector("img");
        const segundaImg = segundaCarta.querySelector("img");
        const primeraPlaceholder = primeraCarta.querySelector(".placeholder");
        const segundaPlaceholder = segundaCarta.querySelector(".placeholder");

        // Si hay imágenes, ocúltalas y muestra el signo de interrogación
        if (primeraImg) primeraImg.style.display = "none";
        if (segundaImg) segundaImg.style.display = "none";

        // Asegúrate de mostrar el signo de interrogación
        if (primeraPlaceholder) primeraPlaceholder.style.display = "block";
        if (segundaPlaceholder) segundaPlaceholder.style.display = "block";
    }

    primeraCarta = null;
    segundaCarta = null;
    bloqueado = false;

    actualizarMarcadores();

    verificarFinDelJuego();
}

// Actualizador de marcadores
function actualizarMarcadores() {
    document.getElementById("aciertos").innerText = aciertos;
    document.getElementById("intentosRestantes").innerText = intentos;
}

///////////////  FUNCIONES PARA EL TEMPORIZADOR  ///////////////
function iniciarTemporizador(tiempoSeleccionado) {
    if (tiempoSeleccionado === "ilimitado") {
        document.getElementById("tiempoTranscurrido").innerText =
            "⏳ Sin límite de tiempo";
        return;
    }

    tiempoRestante = parseInt(tiempoSeleccionado) * 60; // Convertir minutos a segundos

    intervaloTiempo = setInterval(() => {
        if (tiempoRestante <= 0) {
            clearInterval(intervaloTiempo);
            finalizarPartida("Tiempo agotado");
        } else {
            actualizarVisualizadorTiempo();
            tiempoRestante--;
        }
    }, 1000);
}

// Actualizo el temp que muestro
function actualizarVisualizadorTiempo() {
    const minutos = Math.floor(tiempoRestante / 60);
    const segundos = tiempoRestante % 60;
    document.getElementById("tiempoTranscurrido").innerText = `⏳ ${minutos}:${
        segundos < 10 ? "0" : ""
    }${segundos}`;
}

///////////////  FUNCIONES PARA FINALIZAR EL JUEGO  ///////////////
function verificarFinDelJuego() {
    const totalParejas = document.querySelectorAll(".carta").length / 2;

    // GANAR - Verifico si los aciertos son igual a la cantidad de parejas
    if (aciertos === totalParejas) {
        let resultado = "ganada";
        let estado = "finalizada";
        clearInterval(intervaloTiempo); // Detener el temporizador
        setTimeout(() => {
            Swal.fire({
                title: "🎉 ¡¡EXCELENTE MEMORIA!!",
                text: "Has encontrado todas las parejas. ¡Felicitaciones!",
                icon: "success",
                confirmButtonText: "Continuar",
            }).then(() => guardarPartida(resultado, estado));
        }, 500);

        return;
    }

    // PERDER - por intentos o tiempo

    const intentosObtenidos = document.getElementById(
        "intentosObtenidosId"
    )?.value;
    const intentosRestantes = intentosObtenidos - intentos;

    if (intentosRestantes <= 0 || tiempoRestante <= 0) {
        clearInterval(intervaloTiempo); // Detener el temporizador
        let mensaje;

        if (intentosRestantes <= 0) {
            mensaje = "Has agotado tus intentos.";
        } else if (tiempoRestante <= 0) {
            mensaje = "El tiempo se ha agotado.";
        }

        finalizarPartida(mensaje, totalParejas);

        return;
    }
}

// Finaliza la partida y muestro mensaje
function finalizarPartida(mensaje, totalParejas) {
    let porcentajeAciertos = (aciertos / totalParejas) * 100;
    let icono = "";
    let mensaje2 = "";
    let resultado = "perdida";
    let estado = "finalizada";

    if (porcentajeAciertos >= 80) {
        mensaje2 = "💪 ¡¡MUY BUENA MEMORIA!!";
        icono = "info";
    } else if (porcentajeAciertos >= 60) {
        mensaje2 = "👍 ¡¡BUENA MEMORIA!! ¡¡Puedes mejorar!!";
        icono = "warning";
    } else {
        mensaje2 = "🧠 ¡¡MALA MEMORIA!! ¡¡Debes practicar más!!";
        icono = "error";
    }

    /* ALERTA - MENSAJE EN PANTALLA CON LOS DIFERENTES RESULTADOS  */

    Swal.fire({
        title: "Partida finalizada",
        text: mensaje + "\n" + mensaje2,
        icon: icono,
        confirmButtonText: "Continuar",
    }).then(() => guardarPartida(resultado, estado));
}

////////////// GUARDAR LA PARTIDA ///////////////////

// con AXIOS
function guardarPartida(resultado, estado) {


    let tiempoTotalFormateado;
    let tiempoRestanteFormateado;

    const tiempoSeleccionado = document.getElementById("tiempoSeleccionadoId").value;

        if (tiempoSeleccionado === "ilimitado") {
            tiempoTotalFormateado = formatearTiempo(0);
            tiempoRestanteFormateado = formatearTiempo(0);
        } else if (/^\d{2}:\d{2}:\d{2}$/.test(tiempoSeleccionado)) {
            // Si el tiempo viene en formato 00:00:00 lo cambio 
            const tiempoEnSegundos = tiempoAsegundos(tiempoSeleccionado);
        
            tiempoTotalFormateado = formatearTiempo(tiempoEnSegundos);
            tiempoRestanteFormateado = formatearTiempo(tiempoRestante);
        } else {
            tiempoTotalFormateado = formatearTiempo(parseInt(tiempoSeleccionado * 60));
            tiempoRestanteFormateado = formatearTiempo(tiempoRestante);
        }
    
        
    /* if(document.getElementById("tiempoSeleccionadoId").value === "ilimitado"){
        tiempoTotalFormateado = formatearTiempo(0);
        tiempoRestanteFormateado = formatearTiempo(0);
    }else{
        tiempoTotalFormateado = formatearTiempo(parseInt(document.getElementById("tiempoSeleccionadoId").value *60));
        tiempoRestanteFormateado = formatearTiempo(tiempoRestante); 
    } */

    const datosPartida = {
        resultado: resultado,
        nro_partida: parseInt(document.getElementById("nroPartidaId").value),
        dificultad: document.getElementById("dificultad").value,
        tipo_cartas: document.getElementById("tipo_cartas").value,
        tiempo_total: tiempoTotalFormateado,
        intentos: intentos,
        aciertos: aciertos,
        tiempo_restante: tiempoRestanteFormateado,
        estado: estado,
        estado_cartas: obtenerEstadoCartas(),
    };

    // ver si se envia bien el json , recordar ver el controlador si recibe bien los datos
    console.log(JSON.stringify(datosPartida));
    
    /* let ruta = document.getElementById('rutaId').value; */
    /* axios.post(ruta, datosPartida, { */
    let tablero = document.getElementById('tableroContinuar');

    const esPartidaGuardada = tablero?  tablero.dataset.esPartidaGuardada === "true" : "false";

    console.log(esPartidaGuardada);
    
    if(esPartidaGuardada === true){
        axios
        .post("../interrumpir", datosPartida, {
            headers: {
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
        })
        .then((response) => {
            Swal.fire(
                "Guardado",
                "Tu partida ha sido guardada exitosamente.",
                "success"
            ).then(() => (window.location.href = "../dashboard"));
        })
        .catch((error) => {
            console.error("Error al guardar la partida:", error);
            Swal.fire(
                "Error",
                "Hubo un problema al conectar con el servidor.",
                "error"
            );
        });

    }else{
        axios
        .post("../guardarPartida", datosPartida, {
            headers: {
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
        })
        .then((response) => {
            Swal.fire(
                "Guardado",
                "Tu partida ha sido guardada exitosamente.",
                "success"
            ).then(() => (window.location.href = "../dashboard"));
        })
        .catch((error) => {
            console.error("Error al guardar la partida:", error);
            Swal.fire(
                "Error",
                "Hubo un problema al conectar con el servidor.",
                "error"
            );
        });
    }
    
}

/* FUNCIONES PARA FORMATEAR TIEMPOS */
/* De segundos a 00:00:00 */
function formatearTiempo(segundos) {
    const horas = Math.floor(segundos / 3600);
    const minutos = Math.floor((segundos % 3600) / 60);
    const secs = segundos % 60;

    // devuelve hor:min:seg
    return `${String(horas).padStart(2, '0')}:${String(minutos).padStart(2, '0')}:${String(secs).padStart(2, '0')}`;
    
}

/* De 00:00:00 a segundos */
function tiempoAsegundos(tiempo) {
    const [horas, minutos, segundos] = tiempo.split(':').map(Number);
    const totalSegundos = (horas * 3600) + (minutos * 60) + segundos;
    return totalSegundos;
}

// Obtener el estado de las cartas del tablero
function obtenerEstadoCartas() {
    let cartas = document.querySelectorAll(".carta");
    let estadoCartas = [];

    cartas.forEach((carta, index) => {
        estadoCartas.push({
            id: index + 1,
            estado: carta.classList.contains("acertada")
                ? "acertada"
                : "oculta",
            carta: carta.dataset.valor,
        });
    });

    return estadoCartas;
}


/* ////////////////////  FUNCIONES PARA RESTAURAR LA PARTIDA   //////////////////////////// */
function cargarPartida() {
    const tablero1 = document.getElementById("tableroContinuar"); 

    let cartas = [];

    const dificultad = tablero1.dataset.dificultad; // cambiar por los documentgetElementById
    const tipoCartas = tablero1.dataset.tipoCartas;
    const tiempoRestante = tiempoAsegundos(tablero1.dataset.tiempoRestante); // CONVERTIRLO EN SEGUNDOS
    const tiempoTotal = tiempoAsegundos(tablero1.dataset.tiempoTotal);
    cartas = JSON.parse(tablero1.dataset.cartas);
    const intentosRestantes = parseInt(tablero1.dataset.intentos);
    const aciertosOld = parseInt(tablero1.dataset.aciertos);


    const tablero = document.getElementById('tablero');

    // Limpiar el tablero
    tablero.innerHTML = "";

    console.log(cartas);
    console.log(tablero1);

    const baseUrl2 = "../images";

    cartas.forEach((carta, index) => {
        const cartaDiv = document.createElement("div");
        cartaDiv.id = "cartaId" + (index +1 );
        cartaDiv.className = "carta";
        cartaDiv.dataset.valor = carta.carta;

        const img = document.createElement("img");
       
        img.src = baseUrl2 + "/" + tipoCartas + "/" + carta.carta + ".jpg"; // ver por que no toma la imagen
        img.alt = "Carta de juego";
        img.classList.add("imagen-carta");

        if(carta.estado == 'oculta'){
            img.style.display = "none";
        }else{
            cartaDiv.className = 'carta acertada';
            img.style.display = 'block';
        }
        cartaDiv.appendChild(img);
        cartaDiv.addEventListener("click", () => voltearCarta(cartaDiv, tipoCartas));

        tablero.appendChild(cartaDiv);

    });

    // Restaurar los marcadores
    document.getElementById("tiempoTranscurrido").textContent = tiempoRestante;
    document.getElementById("intentosRestantes").textContent = intentosRestantes; // intentos obtenidos
    intentos = intentosRestantes;
    document.getElementById("aciertos").textContent = aciertosOld;
    aciertos = aciertosOld;

    // Iniciar el temporizador desde el tiempo restante
    continuarTemporizador(tablero1.dataset.tiempoRestante, tablero1.dataset.tiempoTotal);
}


function continuarTemporizador(tiempoBD) {
    if (tiempoBD === "00:00:00") {
        document.getElementById("tiempoTranscurrido").innerText =
            "⏳ Sin límite de tiempo";
        return;
    }

    // Convertir el tiempo desde formato h:i:s a segundos
    const [horas, minutos, segundos] = tiempoBD.split(":").map(Number);
    tiempoRestante = horas * 3600 + minutos * 60 + segundos;

    intervaloTiempo = setInterval(() => {
        if (tiempoRestante <= 0) {
            clearInterval(intervaloTiempo);
            finalizarPartida("Tiempo agotado");
        } else {
            actualizarVisualizadorTiempoContinuar();
            tiempoRestante--;
        }
    }, 1000);
}

// Actualizar visualizador para formato h:i:s
function actualizarVisualizadorTiempoContinuar() {
    const horas = Math.floor(tiempoRestante / 3600);
    const minutos = Math.floor((tiempoRestante % 3600) / 60);
    const segundos = tiempoRestante % 60;
    document.getElementById("tiempoTranscurrido").innerText = `⏳ ${
        minutos < 10 ? "0" : ""
    }${minutos}:${segundos < 10 ? "0" : ""}${segundos}`;
}



// con NATIVO
/* function guardarPartida(resultado, estado) {
            const datosPartida = {
                resultado: resultado ,// aciertos === document.querySelectorAll(".carta").length / 2 ? 'ganado' : 'perdido' ,
                dificultad: document.getElementById('dificultad').value,
                tipo_cartas: document.getElementById('tipo_cartas').value,
                tiempo_total: document.getElementById('tiempoSeleccionadoId').value,
                intentos: intentos,
                aciertos: aciertos,
                tiempo_restante: tiempoRestante,
                estado: estado,
                estado_cartas: obtenerEstadoCartas()
            };
        
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "/guardaPartida", true);
            xhr.setRequestHeader("Content-Type", "application/json");
            xhr.setRequestHeader("X-CSRF-TOKEN", document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
        
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    Swal.fire('Guardado', 'Tu partida ha sido guardada exitosamente.', 'success')
                        .then(() => window.location.href = '/dashboard');
                } else if (xhr.readyState === 4) {
                    Swal.fire('Error', 'Hubo un problema al conectar con el servidor.', 'error');
                }
            };
        
            xhr.send(JSON.stringify(datosPartida));
        } */

// con NATIVO
/* function guardarPartida(resultado, estado) {
            const datosPartida = {
                resultado: resultado ,// aciertos === document.querySelectorAll(".carta").length / 2 ? 'ganado' : 'perdido' ,
                dificultad: document.getElementById('dificultad').value,
                tipo_cartas: document.getElementById('tipo_cartas').value,
                tiempo_total: document.getElementById('tiempoSeleccionadoId').value,
                intentos: intentos,
                aciertos: aciertos,
                tiempo_restante: tiempoRestante,
                estado: estado,
                estado_cartas: obtenerEstadoCartas()
            };
        
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "/guardaPartida", true);
            xhr.setRequestHeader("Content-Type", "application/json");
            xhr.setRequestHeader("X-CSRF-TOKEN", document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
        
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    Swal.fire('Guardado', 'Tu partida ha sido guardada exitosamente.', 'success')
                        .then(() => window.location.href = '/dashboard');
                } else if (xhr.readyState === 4) {
                    Swal.fire('Error', 'Hubo un problema al conectar con el servidor.', 'error');
                }
            };
        
            xhr.send(JSON.stringify(datosPartida));
        } */
