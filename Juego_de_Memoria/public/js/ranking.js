// ranking.js

// Cargar el ranking al cargar la página
document.addEventListener('DOMContentLoaded', cargarRanking);

function cargarRanking() {
    fetch('/api/ranking')
        .then(response => response.json())
        .then(data => mostrarRanking(data));
}

function mostrarRanking(partidas) {
    const rankingDiv = document.getElementById('ranking');
    rankingDiv.innerHTML = '<h5>🏆 Ranking Personal</h5>';

    partidas.slice(0, 5).forEach((partida, index) => {
        const partidaDiv = document.createElement('div');
        partidaDiv.className = 'ranking-item';
        partidaDiv.innerHTML = `
            <p><strong>#${index + 1} - Partida ${partida.numero_partida}</strong></p>
            <p>🕒 Tiempo: ${partida.tiempo} seg</p>
            <p>🔄 Intentos: ${partida.intentos}</p>
            <p>🎯 Dificultad: ${partida.dificultad}</p>
        `;
        rankingDiv.appendChild(partidaDiv);
    });
}
