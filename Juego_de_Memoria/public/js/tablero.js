//Funciones para el tablero de juego

let primeraCarta = null;
let segundaCarta = null;
let bloqueado = false;
let aciertos = 0;
let intentos = 0;

// Event Listener para iniciar el tablero
document.addEventListener('DOMContentLoaded', () => {
    const dificultad = document.getElementById('dificultad')?.value;
    const nroCartas = document.getElementById('nroCartasId')?.value;
    const tipoCartas = document.getElementById('tipo_cartas')?.value;
    generarTablero(dificultad, tipoCartas, nroCartas);
});



function generarTablero(dificultad, tipoCartas, nroCartas) {

    const tipos = {
        'numeros': Array.from({ length: nroCartas / 2 }, (_, i) => i + 1),
        'animales': ['🐶', '🐱', '🦁', '🐷', '🐸', '🐵', '🐼', '🦊'],
        'imagenes': ['🌄', '🏞️', '🌅', '🌠', '🌉', '🏖️', '🗻', '🏜️']
    };

    if (!tipoCartas || !['numeros', 'animales', 'imagenes'].includes(tipoCartas)) {
        console.error('Error: tipoCartas es inválido o no está definido');
        return;
    }

    let cartas = tipos[tipoCartas].slice(0, nroCartas / 2);
    cartas = cartas.concat(cartas).sort(() => Math.random() - 0.5);

    const tablero = document.getElementById('tablero');
    tablero.innerHTML = '';

    cartas.forEach(carta => {
        const cartaDiv = document.createElement('div');
        cartaDiv.className = 'carta';
        cartaDiv.dataset.valor = carta;
        cartaDiv.innerText = '?';
        cartaDiv.addEventListener('click', () => voltearCarta(cartaDiv));
        tablero.appendChild(cartaDiv);
    });

    aciertos = 0;
    intentos = 0;
    actualizarMarcadores();
}

function voltearCarta(carta) {
    if (bloqueado || carta.innerText !== '?') return;

    carta.innerText = carta.dataset.valor;

    if (!primeraCarta) {
        primeraCarta = carta;
    } else {
        segundaCarta = carta;
        bloqueado = true;
        intentos++;
        setTimeout(verificarPareja, 800);
    }
}

function verificarPareja() {
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
}

function actualizarMarcadores() {
    document.getElementById('aciertos').innerText = aciertos;
    document.getElementById('intentosRestantes').innerText = intentos;
}

function verificarFinDelJuego() {
    const totalParejas = document.querySelectorAll('.carta').length / 2;
    const intentosObtenidos = document.getElementById('intentosObtenidosId')?.value;
    
    // GANAR - Verifico si los aciertos son igual a la cantidad de parejas
    if (aciertos === totalParejas) {
        setTimeout(() => alert('🎉 ¡Has ganado la partida!'), 500);
    }

    // PERDER por intentos - Verifico si los intentos obtenidos (los que me da cada dificultad) son igual a la cantidad de intentos
    if (intentos === intentosObtenidos) {
        setTimeout(() => alert('🙁 ¡Has perdido la partida!'), 500);
    }

}

