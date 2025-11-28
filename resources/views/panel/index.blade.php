<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wheel Fire Club - {{ $title ?? 'Juego' }}</title>
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

   <audio loop muted id="background-music" preload="auto">
        <source src="{{ asset('audio/music.mp3') }}" type="audio/mpeg">
        <source src="{{ asset('audio/music.ogg') }}" type="audio/ogg">
    </audio>

    <div class="layout-container">
        
        <div class="header">
            <h1 class="titulo-panel" id="movie-title">{{ $title ?? 'BOJACK HORSEMAN' }}</h1>
        </div>

        <div class="alphabet-panel">
            <div id="alphabet-sidebar">
                @php $alphabet = range('A', 'Z'); @endphp
                @foreach ($alphabet as $letter)
                    @php
                        $baseFileName = strtolower($letter);
                        if ($letter === 'Y') $baseFileName = 'igriega';
                        
                        $normalImg = asset('img/letras/' . $baseFileName . '.png');
                        $tachedImg = asset('img/letras_tachadas/' . $baseFileName . '_tachada.png');
                    @endphp
                    <div class="key-container" data-letter="{{ $letter }}" onclick="seleccionarLetra('{{ $letter }}')">
                        <img id="img-{{ $letter }}"
                             class="key-image"
                             src="{{ $normalImg }}"
                             data-tached-src="{{ $tachedImg }}"
                             alt="{{ $letter }}"
                             onerror="this.style.display='none'; this.parentElement.innerText='{{ $letter }}'">
                    </div>
                @endforeach
            </div>
        </div>

        <div class="center-panel">
            <div class="board-section">
                <div id="frase-container"></div>
            </div>

            <div class="play-zone">
                <div class="player-block">
                    @php
                        $avatars = [1 => 'img/eleven.png', 2 => 'img/mike.png', 3 => 'img/lucas.png', 4 => 'img/dustin.png', 5 => 'img/will.png'];
                        $avatarImg = $avatars[session('idavatar', 1)] ?? 'img/default.png';
                    @endphp
                    <div class="avatar-circle">
                        <img src="{{ asset($avatarImg) }}" alt="Avatar">
                    </div>
                    <div class="stat-box">
                        <span style="font-size:0.8rem; color:#aaa;">JUGADOR</span>
                        <span style="display:block;">{{ session('player_name', 'Player 1') }}</span>
                    </div>
                    <div class="stat-box">
                        <span style="font-size:0.8rem; color:#aaa;">PUNTOS</span>
                        <span class="stat-value" id="puntos-actuales">{{ $score_inicial ?? 0 }}</span>
                    </div>
                </div>

                <div class="wheel-wrapper">
                    <div class="marco-ruleta">
                        <div id="flecha">⬆</div>
                        <div id="ruleta">
                            <img src="{{ asset('img/ruleta.png') }}" alt="Ruleta">
                        </div>
                    </div>
                    <div style="text-align:center; width:100%;">
                        <p id="mensaje-ruleta"></p>
                        <button id="btnGirar">GIRAR RULETA</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="right-panel">
            <div class="timer-box">
                <span class="timer-label">TIEMPO RESTANTE</span>
                <div id="temporizador">03:00</div>
            </div>

            <div class="controls-box">
                <button id="btnAdivinar" class="action-btn btn-guess">⚡ ADIVINAR FRASE</button>
                <button onclick="resetGame()" class="action-btn btn-reset">🔄 REINICIAR</button>
                <button onclick="logout()" class="action-btn btn-exit">🚪 SALIR</button>
            </div>
        </div>

    </div>

    <div id="guessModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.95); z-index:3000; align-items:center; justify-content:center;">
        <div style="background:#111; padding:40px; border:4px solid #8b0000; text-align:center; max-width:600px; width:90%; border-radius:15px; box-shadow:0 0 50px #8b0000;">
            <h2 style="color:#f00; margin-bottom:10px; font-size:2rem;">¿ADIVINAR FRASE?</h2>
            <p style="color:#aaa; margin-bottom:20px;">⚠️ Si fallas, pierdes la partida inmediatamente.</p>
            <input type="text" id="guessInput" style="width:100%; padding:20px; font-size:1.5rem; background:#222; color:#fff; border:2px solid #555; margin-bottom:20px; text-transform:uppercase; text-align:center;" placeholder="ESCRIBE LA FRASE AQUÍ...">
            <div style="display:flex; gap:15px; justify-content:center;">
                <button onclick="confirmGuess()" style="padding:15px 40px; background:#28a745; color:#fff; border:none; font-weight:bold; cursor:pointer; font-size:1.1rem;">CONFIRMAR</button>
                <button onclick="closeGuessModal()" style="padding:15px 40px; background:#dc3545; color:#fff; border:none; font-weight:bold; cursor:pointer; font-size:1.1rem;">CANCELAR</button>
            </div>
        </div>
    </div>

    <div id="result-display"></div>

    <script>
        const csrf = document.querySelector('meta[name="csrf-token"]').content;
        let tiempoRestante = 180;
        let temporizadorInterval;
        let letrasUsadas = [];
        let opcionRuletaActual = null;
        let anguloActual = 0;
        let estaGirando = false;
        let juegoActivo = true;
        let puntuacion = {{ $score_inicial ?? 0 }};
        const backgroundMusic = document.getElementById('background-music');
        const fraseActual = "{{ Session::get('frase_actual', 'BOJACK HORSEMAN') }}";
        const ruleta = document.getElementById('ruleta');
        const btnGirar = document.getElementById('btnGirar');
        const displayResultado = document.getElementById('mensaje-ruleta');
        const temporizadorHTML = document.getElementById('temporizador');
        const TOTAL_SECTORES = 8;
        const GRADOS_POR_SECTOR = 360 / TOTAL_SECTORES;
        const opcionesPorSector = ["Demogorgon", "Consonante", "Eleven", "Vocal", "Vecna", "Consonante", "Demoperro", "Vocal"];

        document.addEventListener('DOMContentLoaded', () => {
            actualizarFraseDisplay();
            iniciarTemporizador();
            btnGirar.addEventListener('click', girarRuleta);
            document.getElementById('btnAdivinar').addEventListener('click', openGuessModal);
            ruleta.addEventListener('transitionend', finalizarGiro);
            document.getElementById('puntos-actuales').textContent = puntuacion;
        });

        function actualizarPuntuacion(puntos) {
            puntuacion = Math.max(0, puntuacion + puntos);
            document.getElementById('puntos-actuales').textContent = puntuacion;
            fetch("{{ route('puntuacion.letra') }}", {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrf },
                body: JSON.stringify({ puntos: puntos })
            }).then(resp => resp.json()).then(data => {
                if (data.score !== undefined) {
                    puntuacion = data.score;
                    document.getElementById('puntos-actuales').textContent = data.score;
                }
            }).catch(err => console.error('Error score:', err));
        }

        // --- FUNCIONES VICTORIA / DERROTA CORREGIDAS ---

        function mostrarVictoria() {
            juegoActivo = false;
            clearInterval(temporizadorInterval);
            
            fetch("{{ route('puntuacion.adivinar') }}", {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrf },
                body: JSON.stringify({ frase: fraseActual })
            }).then(resp => resp.json()).then(data => {
                if (data.score !== undefined) {
                    puntuacion = data.score;
                    document.getElementById('puntos-actuales').textContent = data.score;
                }
            }).catch(err => console.error('Error:', err));
            
            // MODAL FINAL PERSISTENTE
            const el = document.getElementById('result-display');
            el.innerHTML = `
                <h1 style="color:#28a745; font-size:3rem; margin-bottom:20px;">🎉 ¡VICTORIA!</h1>
                <p style="color:#ffd700; font-size:1.5rem; margin-bottom:30px;">+100 PUNTOS</p>
                <button onclick="volverAlInicio()" style="padding:15px 40px; background:#28a745; color:#fff; border:2px solid #fff; font-weight:bold; cursor:pointer; font-size:1.3rem; border-radius:8px; font-family:'Courier New', monospace; text-transform:uppercase; transition: all 0.3s ease; box-shadow: 0 0 20px rgba(255, 255, 255, 0.3);">
                    🏠 VOLVER A JUGAR
                </button>
            `;
            el.style.display = 'flex'; // IMPORTANTE: Se queda visible
            
            bloquearJuego();
        }

        function terminarJuego(victoria) {
            if (victoria) { mostrarVictoria(); return; }

            juegoActivo = false;
            clearInterval(temporizadorInterval);
            
            // MODAL FINAL PERSISTENTE
            const el = document.getElementById('result-display');
            el.innerHTML = `
                <h1 style="color:#dc3545; font-size:3rem; margin-bottom:20px;">💀 GAME OVER</h1>
                <p style="color:#aaa; font-size:1.2rem; margin-bottom:30px;">Has perdido esta partida</p>
                <button onclick="volverAlInicio()" style="padding:15px 40px; background:#dc3545; color:#fff; border:2px solid #fff; font-weight:bold; cursor:pointer; font-size:1.3rem; border-radius:8px; font-family:'Courier New', monospace; text-transform:uppercase; transition: all 0.3s ease; box-shadow: 0 0 20px rgba(255, 255, 255, 0.3);">
                    🏠 VOLVER A JUGAR
                </button>
            `;
            el.style.display = 'flex'; // IMPORTANTE: Se queda visible
            
            bloquearJuego();
        }

        // Auxiliar para bloquear UI
        function bloquearJuego() {
            btnGirar.disabled = true;
            document.querySelectorAll('.key-container').forEach(btn => {
                btn.style.pointerEvents = 'none';
                btn.classList.add('disabled');
            });
            document.getElementById('btnAdivinar').disabled = true;
            document.querySelector('.layout-container').style.filter = "grayscale(1) brightness(0.5)";
            document.querySelector('.layout-container').style.pointerEvents = "none";
            // Rehabilitamos puntero solo en el modal final
            document.getElementById('result-display').style.pointerEvents = "auto";
        }

        // --- RESTO DE LÓGICA ---

        function girarRuleta() {
            if (estaGirando || !juegoActivo) return;
            estaGirando = true;
            btnGirar.disabled = true;
            displayResultado.textContent = "GIRANDO...";
            displayResultado.style.color = "#fff";
            anguloActual += (5 * 360) + Math.floor(Math.random() * 360);
            ruleta.style.transform = `rotate(${anguloActual}deg)`;
        }

        function finalizarGiro() {
            estaGirando = false;
            btnGirar.disabled = false;
            const gradosNorm = anguloActual % 360;
            const indice = Math.floor(((360 - gradosNorm + 180) % 360) / GRADOS_POR_SECTOR);
            procesarResultado(opcionesPorSector[indice >= 0 ? indice : 0]);
        }

        function procesarResultado(opcion) {
            opcionRuletaActual = null;
            let msg = "", color = "#fff";
            if (opcion === 'Vocal') { opcionRuletaActual = 'VOCAL'; msg = "🗣 VOCAL"; color = "#ffd700"; }
            else if (opcion === 'Consonante') { opcionRuletaActual = 'CONSONANTE'; msg = "🔤 CONSONANTE"; color = "#00ffff"; }
            else if (opcion === 'Eleven') { modifyingTime(20); msg = "🧇 ELEVEN (+20s)"; color = "#4CAF50"; mostrarMensajeFlotante("🧇 ¡ELEVEN TE AYUDA!"); }
            else if (opcion === 'Vecna') { modifyingTime(-20); msg = "🕰 VECNA (-20s)"; color = "#ff0000"; mostrarMensajeFlotante("👹 ¡VECNA TE ENCONTRÓ!"); }
            else if (['Demogorgon', 'Demoperro'].includes(opcion)) { 
                let t = (opcion === 'Demogorgon' ? -10 : -5); modifyingTime(t); msg = `👹 MONSTRUO (${t}s)`; color = "#ff4444"; mostrarMensajeFlotante(`👹 ¡${opcion}!`); 
            }
            displayResultado.textContent = msg;
            displayResultado.style.color = color;
            actualizarTeclado();
        }

        function seleccionarLetra(letra) {
            if (!juegoActivo) return;
            if (letrasUsadas.includes(letra)) return;
            if (!opcionRuletaActual) { mostrarMensajeFlotante("🎡 GIRA PRIMERO"); return; }
            const esV = "AEIOU".includes(letra);
            if (opcionRuletaActual === 'VOCAL' && !esV) { mostrarMensajeFlotante("❌ SOLO VOCALES"); return; }
            if (opcionRuletaActual === 'CONSONANTE' && esV) { mostrarMensajeFlotante("❌ SOLO CONSONANTES"); return; }

            letrasUsadas.push(letra);
            const t = document.querySelector(`.key-container[data-letter="${letra}"]`);
            if(t) { t.classList.add('disabled'); const i = t.querySelector('img'); if(i && i.dataset.tachedSrc) i.src = i.dataset.tachedSrc; }

            if (fraseActual.includes(letra)) {
                revelarLetra(letra);
                actualizarPuntuacion(10);
                mostrarMensajeFlotante("✅ CORRECTO (+10pts)");
                verificarVictoria();
            } else {
                mostrarMensajeFlotante("❌ FALLO");
                modificarTiempo(-5);
            }
            opcionRuletaActual = null;
            displayResultado.textContent = "";
            actualizarTeclado();
        }

        function actualizarTeclado() {
            document.querySelectorAll('.key-container').forEach(k => {
                k.classList.remove('vocal-active', 'consonante-active');
                if (!k.classList.contains('disabled')) {
                    const l = k.dataset.letter; const esV = "AEIOU".includes(l);
                    if (opcionRuletaActual === 'VOCAL' && esV) k.classList.add('vocal-active');
                    else if (opcionRuletaActual === 'CONSONANTE' && !esV) k.classList.add('consonante-active');
                }
            });
        }

        function actualizarFraseDisplay() {
            const c = document.getElementById('frase-container'); c.innerHTML = '';
            fraseActual.toUpperCase().split(' ').forEach(palabra => {
                const dP = document.createElement('div'); dP.className = 'palabra';
                for (let l of palabra) {
                    if (!/[A-Z]/.test(l)) continue;
                    const dL = document.createElement('div'); dL.className = 'letra'; dL.dataset.letra = l;
                    dL.innerHTML = `<span class="letra-texto">${l}</span>`;
                    dP.appendChild(dL);
                }
                c.appendChild(dP);
            });
            letrasUsadas.forEach(l => { revelarLetra(l); const t = document.querySelector(`.key-container[data-letter="${l}"]`); if(t){ t.classList.add('disabled'); const i = t.querySelector('img'); if(i && i.dataset.tachedSrc) i.src = i.dataset.tachedSrc; } });
        }

        function revelarLetra(l) { document.querySelectorAll(`.letra[data-letra="${l}"]`).forEach(el => { el.classList.add('revelada'); el.style.transform = 'rotate(0deg) scale(1.05)'; }); }
        function verificarVictoria() { if (document.querySelectorAll('.letra:not(.revelada)').length === 0) mostrarVictoria(); }
        function iniciarTemporizador() { actualizarTimerUI(); temporizadorInterval = setInterval(() => { if (juegoActivo && tiempoRestante > 0) { tiempoRestante--; actualizarTimerUI(); } else if (tiempoRestante <= 0) terminarJuego(false); }, 1000); }
        function actualizarTimerUI() { const m = Math.floor(tiempoRestante/60).toString().padStart(2,'0'), s = (tiempoRestante%60).toString().padStart(2,'0'); temporizadorHTML.innerText = `${m}:${s}`; temporizadorHTML.className = tiempoRestante < 30 ? 'danger' : ''; }
        function modifyingTime(s) { tiempoRestante = Math.max(0, tiempoRestante + s); actualizarTimerUI(); }
        
        // Mensajes FLOTANTES (Temporales)
        function mostrarMensajeFlotante(t) {
            // No mostrar mensajes flotantes si el juego ha terminado
            if (!juegoActivo) return; 
            const el = document.getElementById('result-display');
            el.innerHTML = `<h2>${t}</h2>`;
            el.style.display = 'block';
            setTimeout(() => { if(juegoActivo) el.style.display = 'none'; }, 1500);
        }

        function openGuessModal() { document.getElementById('guessModal').style.display = 'flex'; }
        function closeGuessModal() { document.getElementById('guessModal').style.display = 'none'; }
        function confirmGuess() {
            if (document.getElementById('guessInput').value.toUpperCase().trim() === fraseActual) {
                document.querySelectorAll('.letra').forEach(el => el.classList.add('revelada'));
                mostrarVictoria();
            } else {
                mostrarMensajeFlotante("☠️ INCORRECTO");
                setTimeout(() => terminarJuego(false), 1000);
            }
            closeGuessModal();
        }

        function resetGame() { if(confirm("¿Reiniciar?")) window.location.href = "{{ route('panel.reset') }}"; }
        function logout() { window.location.href = "{{ route('player.logout') }}"; }
        
        // Función Volver al Inicio
        function volverAlInicio() { window.location.href = "{{ route('welcome') }}"; }

        function enableAudioHandler() {
            if (backgroundMusic) {
                backgroundMusic.volume = 0.5; backgroundMusic.muted = false; 
                backgroundMusic.play().catch(e => console.error("Audio error:", e));
                document.removeEventListener('click', enableAudioHandler);
            }
        }
        document.addEventListener('click', enableAudioHandler);
    </script>
</body>
</html>