// timer.js

let tiempoRestante;
let intervaloTiempo;

function iniciarTemporizador(tiempoSeleccionado) {
    if (tiempoSeleccionado === 'ilimitado') {
        document.getElementById('tiempoTranscurrido').innerText = '⏳ Sin límite de tiempo';
        return;
    }

    tiempoRestante = parseInt(tiempoSeleccionado) * 60; // Convertir minutos a segundos

    intervaloTiempo = setInterval(() => {
        if (tiempoRestante <= 0) {
            clearInterval(intervaloTiempo);
            finalizarPartida('Tiempo agotado');
        } else {
            actualizarVisualizadorTiempo();
            tiempoRestante--;
        }
    }, 1000);
}

function actualizarVisualizadorTiempo() {
    const minutos = Math.floor(tiempoRestante / 60);
    const segundos = tiempoRestante % 60;
    document.getElementById('tiempoTranscurrido').innerText = `⏳ ${minutos}:${segundos < 10 ? '0' : ''}${segundos}`;
}

/* 3ra opción de finalizacion, por tiempo terminado */
function finalizarPartida(motivo) {
   /*  alert(`La partida ha terminado: ${motivo}`); */
    
    //Aca mandar a la ruta guardarPartida del controlador GameControler que esta en php con los datos de la partida para guardar la misma 
    // y redirigir a la vista de "dashboard" con el mensaje de la partida guardada
    
/* 
    window.fetch("/guardarPartida", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify({
            aciertos: aciertos,
            intentos: intentos,
            tiempo: document.getElementById('tiempoSeleccionadoId').value,
        }),
    })
    .then(response => response.json())
    .then(data => {
        alert(data.mensaje);
        window.location.href = "/dashboard";
    })
 */

    // Mostrar un swetalert con el mensaje de la partida finalizada y que al apretar el boton de OK guarde los datos de la partida y redirija a la vista de dashboard
    
    Swal.fire({
        title: 'Partida finalizada',
        text: motivo,
        icon: 'info',
        confirmButtonText: 'OK',
    }).then(() => {
        //guardarPartida();
    });



    /* location.reload(); */
}

// Inicializa el temporizador cuando la página carga (si se pasa el tiempo desde el backend)
document.addEventListener('DOMContentLoaded', () => {
    const tiempoSeleccionado = document.getElementById('tiempoSeleccionadoId').value;
    iniciarTemporizador(tiempoSeleccionado);
});

// Guarda la partida en la base de datos
function guardarPartida() {
    window.fetch("/guardarPartida", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify({
            aciertos: document.getElementById('aciertos').innerText,
            intentos: document.getElementById('intentosRestantes').innerText,
            tiempo: document.getElementById('tiempoSeleccionadoId').value,
        }),
    })
    .then(response => response.json())
    .then(data => {
        alert(data.mensaje);
        window.location.href = "/dashboard";
    })
}