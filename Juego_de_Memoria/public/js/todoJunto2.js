// En este archivo dejo todas las funcionalidades del tablero y del temporizador ya que por separado me generan problemas

// Variables para el juego
let primeraCarta = null;
let segundaCarta = null;
let bloqueado = false;
let aciertos = 0;
let intentos = 0;
let tiempoRestante;
let intervaloTiempo;

// Event Listener para iniciar el tablero
document.addEventListener("DOMContentLoaded", () => {
    const dificultad = document.getElementById("dificultad")?.value;
    const nroCartas = document.getElementById("nroCartasId")?.value;
    const tipoCartas = document.getElementById("tipo_cartas")?.value;
    const tiempoSeleccionado = document.getElementById(
        "tiempoSeleccionadoId"
    ).value;

    generarTablero(dificultad, tipoCartas, nroCartas);
    iniciarTemporizador(tiempoSeleccionado);
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

    // DESCOMENTAR
    /* let cartas = tipos[tipoCartas].slice(0, nroCartas / 2); */
    let cartas = tipos.slice(0, nroCartas / 2);
    cartas = cartas.concat(cartas).sort(() => Math.random() - 0.5);

    console.log(cartas);

    const tablero = document.getElementById("tablero");
    tablero.innerHTML = "";

    contadorID = 1;

    cartas.forEach((carta) => {
        const cartaDiv = document.createElement("div");
        cartaDiv.id = "cartaId" + contadorID;
        contadorID++;
        cartaDiv.className = "carta";
        cartaDiv.dataset.valor = carta;

        // creo el contendor  para la parte de atras de la carta
        /* const placeholder = document.createElement("span");
        placeholder.className = "placeholder";
        cartaDiv.appendChild(placeholder); */
        /* placeholder.innerText = "?"; */

        // Verificar si es una imagen o un número
        // Construcción dinámica de la ruta de la imagen según el tipo de carta
        const img = document.createElement("img");
        img.src = baseUrl + "/" + tipoCartas + "/" + carta + ".jpg";
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
        clearInterval(intervaloTiempo); // Detener el temporizador
        setTimeout(() => {
            Swal.fire({
                title: "🎉 ¡¡EXCELENTE MEMORIA!!",
                text: "Has encontrado todas las parejas. ¡Felicitaciones!",
                icon: "success",
                confirmButtonText: "Continuar",
            }).then(() => guardarPartida());
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
        confirmButtonText: "Ir a Inicio",
    }).then(() => guardarPartida());
}

// GUARDAR LA PARTIDA
// Version 1
function guardarPartida() {
    window
        .fetch("/guardarPartida", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({
                aciertos: aciertos,
                intentos: intentos,
                tiempo: document.getElementById("tiempoSeleccionadoId").value,
            }),
        })
        .then((response) => response.json())
        .then((data) => {
            alert(data.mensaje);
            window.location.href = "/dashboard";
        });
}

// Version 2
function guardarPartida(
    resultado,
    aciertos,
    intentos,
    tiempoTranscurrido,
    estadoCartas
) {
    fetch("/guardar-partida", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        },
        body: JSON.stringify({
            resultado: resultado,
            dificultad: document.getElementById("dificultad").value,
            tipo_cartas: document.getElementById("tipo_cartas").value,
            tiempo: tiempoTranscurrido,
            intentos: intentos,
            aciertos: aciertos,
            estado_cartas: estadoCartas,
        }),
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                window.location.href = "/dashboard"; // Redirige al Dashboard
            }
        })
        .catch((error) => console.error("Error:", error));
}

/* /////////////////////////// COOKIES  //////////////////////*/
//FUNCIONA
/* document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('btnInterrumpir').addEventListener('click', function() {
        guardarPartidaEnCookie();
        alert('Partida guardada, puedes retomarla más tarde.');
    });

    // Llamamos a la función para cargar la partida si hay datos guardados
    cargarPartidaDesdeCookie();
});

document.getElementById('btnCargarPartida').addEventListener('click', function() {
    cargarPartidaDesdeCookie();
});

// BORRAR LA COOKIE -- ERROR LLAMARLA DESPUES DE CARGAR LA PARTIDA
function borrarCookiePartida() {
    document.cookie = 'partidaGuardada=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
} */


/* ESCUCHADOR PARA GUARDAR LA PARTIDA INTERRUMPIDA */
/* window.addEventListener('beforeunload', () => {
    const cartasEstado = document.querySelectorAll('.carta');
    guardarPartidaEnCookie(
        1, // idUsuario (ejemplo)
        101, // numeroPartida (ejemplo)
        'incompleta', // resultado
        'animales', // tipoCartas
        'medio', // dificultad
        intentos,
        aciertos,
        tiempoTranscurrido,
        cartasEstado
    );
});
 */


/* CARGAR LA PARTIDA QUE ESTA EN LA COOKIE */
// FUNCIONA 
/* document.addEventListener('DOMContentLoaded', () => {
    const partida = cargarPartidaDesdeCookie();
    if (partida) {
        // Restaurar los datos en la vista
        console.log(`Cargando partida ${partida.numeroPartida} para el usuario ${partida.idUsuario}`);

        // Restaurar intentos, aciertos y tiempo
        intentos = partida.intentos;
        aciertos = partida.aciertos;
        tiempoTranscurrido = partida.tiempo;

        // Restaurar el estado de las cartas
        partida.cartas.forEach(cartaData => {
            const cartaElement = document.getElementById(cartaData.id);
            cartaElement.dataset.valor = cartaData.valor;
            if (cartaData.volteada) {
                cartaElement.classList.add('acertada');
            } else {
                cartaElement.classList.remove('acertada');
            }
        });

        actualizarMarcadores();
    }
});
 */

/* FUNCION PARA GUARDAR LA PARTIDA INTERRUMPIDA */
/* function guardarPartidaEnCookie(idUsuario, numeroPartida, resultado, tipoCartas, dificultad, intentos, aciertos, tiempo, cartas) {
    // Objeto con los datos de la partida
    const partida = {
        idUsuario: idUsuario,
        numeroPartida: numeroPartida,
        resultado: resultado,
        tipoCartas: tipoCartas,
        dificultad: dificultad,
        fecha: new Date().toISOString(), // Fecha actual en formato ISO
        intentos: intentos,
        aciertos: aciertos,
        tiempo: tiempo,
        cartas: cartas.map(carta => ({
            id: carta.id, 
            valor: carta.dataset.valor, 
            volteada: carta.classList.contains('volteada')
        }))
    };

    // JSON convertido y codificado
    const partidaCodificada = btoa(JSON.stringify(partida));

    // guardo la cookie 7dias
    document.cookie = `partidaGuardada=${partidaCodificada}; max-age=${60 * 60 * 24 * 7}; path=/`;
    
    console.log("Partida guardada en la cookie correctamente.");
} */

    //FUNCIONA
   /*  function guardarPartidaEnCookie() {
        const partida = {
            idUsuario: document.getElementById('idUser').value,
            numeroPartida: document.getElementById('nroPartida').textContent,
            dificultad: document.getElementById('tipo_cartas').value,
            tiempo: document.getElementById('tiempoTranscurrido').textContent,
            intentos: document.getElementById('intentos').textContent,
            aciertos: document.getElementById('aciertos').textContent,
            tablero: obtenerEstadoTablero() // Obtener posiciones de cartas y su estado
        };
    
        document.cookie = `partidaGuardada=${JSON.stringify(partida)}; path=/`;
    }

    // obtener el estado de las cartas del tablero 
    function obtenerEstadoTablero() {
        let cartas = [];
        document.querySelectorAll('.carta').forEach((carta, index) => {
            cartas.push({
                index: index+1,
                estado: carta.classList.contains('acertada') ? 'acertada' : 'oculta'
            });
        });
        return cartas;
    } */
    

/* FUNCION PARA CARGAR PARTIDA INTERRUMPIDA DESDE LA COOKIE */
/* function cargarPartidaDesdeCookie() {
    const cookies = document.cookie.split('; ');
    let partidaGuardada = null;

    // Buscar la cookie de la partida guardada
    cookies.forEach(cookie => {
        const [nombre, valor] = cookie.split('=');
        if (nombre === 'partidaGuardada') {
            partidaGuardada = JSON.parse(atob(valor)); // Decodificar y parsear JSON
        }
    });

    if (!partidaGuardada) {
        console.log("No hay una partida guardada.");
        return null;
    }

    console.log("Partida cargada correctamente:", partidaGuardada);
    return partidaGuardada;
}
 */

//Funciona
/* function cargarPartidaDesdeCookie() {
    const cookies = document.cookie.split('; ');
    let partidaGuardada = cookies.find(row => row.startsWith('partidaGuardada='));

    if (partidaGuardada) {
        const partida = JSON.parse(partidaGuardada.split('=')[1]);

        document.getElementById('nroPartida').textContent = partida.numeroPartida;
        document.getElementById('tipo_cartas').value = partida.dificultad;
        document.getElementById('tiempoTranscurrido').textContent = partida.tiempo;
        document.getElementById('intentos').textContent = partida.intentos;
        document.getElementById('aciertos').textContent = partida.aciertos;

        // Restaurar el estado del tablero
        restaurarEstadoTablero(partida.tablero);
    }
}
 */
// Funciona
/* function restaurarEstadoTablero(cartas) {
    const cartasDOM = document.querySelectorAll('.carta');
    cartas.forEach((carta, index) => {
        if (carta.estado === 'acertada') {
            cartasDOM[index].classList.add('acertada');
        } else {
            cartasDOM[index].classList.remove('acertada');
        }
    });
}
 */






























/* OTRAS VERSIONES DE ALGUNAS FUNCIONES */

/* arreglos de prueba  */
/* const tipos = {
    'numeros': Array.from({ length: nroCartas / 2 }, (_, i) => i + 1),
    'animales': ['🐶', '🐱', '🦁', '🐷', '🐸', '🐵', '🐼', '🦊', '🐯', '🐰', '🐻', '🐨', '🦄', '🐺', '🐢', '🐙'],
    'imagenes': ['🌄', '🏞️', '🌅', '🌠', '🌉', '🏖️', '🗻', '🏜️', '🏕️', '🛤️', '🏝️', '🏔️', '⛰️', '🌋', '🏟️', '🏛️']
}; */

// DESCOMETAR
/* const tipos = {
  'numeros': Array.from({ length: nroCartas / 2 }, (_, i) => i + 1),
  'animales': Array.from({ length: 16 }, (_, i) => `animales/${i + 1}.jpg`),
  'aviones': Array.from({ length: 16 }, (_, i) => `aviones/${i + 1}.jpg`)
}; */

/* cartas.forEach(carta => {
        const cartaDiv = document.createElement('div');
        cartaDiv.id = 'cartaId'+contadorID;
        contadorID++;
        cartaDiv.className = 'carta';
        cartaDiv.dataset.valor = carta;
        cartaDiv.innerText = '?';
        cartaDiv.addEventListener('click', () => voltearCarta(cartaDiv));
        tablero.appendChild(cartaDiv);
    }); */

// DESCOMENTAR
/* cartas.forEach(carta => {
      const cartaDiv = document.createElement('div');
      cartaDiv.id = 'cartaId' + contadorID;
      contadorID++;
      cartaDiv.className = 'carta';
      cartaDiv.dataset.valor = carta;
      cartaDiv.innerText = '?';
      
      // Verificar si es una imagen o un número
      if (tipoCartas === 'numeros') {
          cartaDiv.innerText = '?';
      } else {
          // Agrega una imagen como contenido de la carta
          const img = document.createElement('img');
          img.src = baseUrl + '/' + carta;

          // img.src = '../images/' + carta; 
          // img.src = `{{asset('images/${carta}')}}`; 
          img.alt = 'Carta de juego';
          img.classList.add('imagen-carta');
          img.style.display = 'none'; 
          cartaDiv.appendChild(img);
      }
      
      cartaDiv.addEventListener('click', () => voltearCarta(cartaDiv));
      tablero.appendChild(cartaDiv);
  });
*/

// 1ER VERSION VOLTEO - SIRVE
// Compruebo las cartas volteadas
/* function voltearCarta(carta) {
    if (bloqueado || carta.innerText !== '?') return;

    carta.innerText = carta.dataset.valor;

    console.log(carta.dataset.valor);

    if (!primeraCarta) {
        primeraCarta = carta;
    } else {
        segundaCarta = carta;
        bloqueado = true;
        intentos++;
        setTimeout(verificarPareja, 800);
    }
} */

// DESCOMENTAR
/* 
    function voltearCarta(carta) {
      if (bloqueado || (carta.querySelector('img') && carta.querySelector('img').style.display === 'block')) return;
  
      const img = carta.querySelector('img');
      if (img) {
          img.style.display = 'block'; // Muestra la imagen si existe
          carta.innerText = ''; // Quita el '?'
      } else {
          carta.innerText = carta.dataset.valor; // Muestra el número si no es una imagen
      }
  
      if (!primeraCarta) {
          primeraCarta = carta;
      } else {
          segundaCarta = carta;
          bloqueado = true;
          intentos++;
          setTimeout(verificarPareja, 800);
      }
  } */

// DESCOMETAR
/* function verificarPareja() {
    if (primeraCarta.dataset.valor === segundaCarta.dataset.valor) {
        aciertos++;
        primeraCarta.classList.add('acertada');
        segundaCarta.classList.add('acertada');
    } else {
        primeraCarta.innerText = '?';
        segundaCarta.innerText = '?';
    }
    
    primeraCarta = null;
    segundaCarta = null;
    bloqueado = false;
    
    actualizarMarcadores();
    
    verificarFinDelJuego();
} */
