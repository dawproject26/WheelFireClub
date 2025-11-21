<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>WheelFire Club</title>
</head>
<body>


    <h1>WheelFire Club</h1>


    <div>
    <h3>Tiempo: <span id="timer">120</span>s</h3>
    <h3>Puntuación: <span id="score">0</span></h3>
    </div>


    <hr>


    <h2>Frase</h2>
    <div id="phrases">
    @foreach ($panel->phrases as $phrase)
    <p class="phrase" data-id="{{ $phrase->id }}">
    @foreach (str_split($phrase->phrase) as $char)
    @if ($char === ' ')
    <span class="space">&nbsp;&nbsp;</span>
    @else
    <span class="letter">_ </span>
    @endif
    @endforeach
    </p>
    @endforeach
    </div>


    <hr>


    <h2>Abecedario</h2>
    <div id="alphabet">
    @foreach (range('A','Z') as $letter)
    <button class="letter-btn" data-letter="{{ $letter }}">{{ $letter }}</button>
    @endforeach
    </div>


    <hr>


    <h2>Ruleta</h2>
    <button id="spin">Girar</button>
    <p id="spin-result"></p>


    <hr>


    <h2>Adivinar</h2>
    <input type="text" id="guess-input">
    <button id="guess-btn">Enviar</button>


    <script>
    // Aquí irían las llamadas AJAX que integrarás luego.
    </script>


</body>
</html>