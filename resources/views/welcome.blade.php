<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wheel Fire Club - Inicio</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: white;
        }
        
        .container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 3rem;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            text-align: center;
            max-width: 400px;
            width: 90%;
            border: 1px solid rgba(255,255,255,0.2);
        }
        
        h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: #ffd700;
            text-shadow: 0 0 10px rgba(255, 215, 0, 0.5);
        }
        
        .subtitle {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
            text-align: left;
        }
        
        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
            color: #ffd700;
        }
        
        input[type="text"] {
            width: 100%;
            padding: 12px;
            border: 2px solid rgba(255,255,255,0.3);
            border-radius: 8px;
            background: rgba(255,255,255,0.1);
            color: white;
            font-size: 1rem;
            transition: border-color 0.3s;
        }
        
        input[type="text"]:focus {
            outline: none;
            border-color: #ffd700;
        }
        
        input[type="text"]::placeholder {
            color: rgba(255,255,255,0.6);
        }
        
        .btn-group {
            display: flex;
            gap: 1rem;
        }
        
        button {
            flex: 1;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .btn-login {
            background: #4CAF50;
            color: white;
        }
        
        .btn-login:hover {
            background: #45a049;
            transform: translateY(-2px);
        }
        
        .btn-register {
            background: #2196F3;
            color: white;
        }
        
        .btn-register:hover {
            background: #0b7dda;
            transform: translateY(-2px);
        }
        
        .error {
            color: #ff6b6b;
            margin-top: 1rem;
            padding: 0.75rem;
            background: rgba(255, 107, 107, 0.1);
            border-radius: 5px;
            border-left: 4px solid #ff6b6b;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🎡 Wheel Fire Club</h1>
        <p class="subtitle">Ingresa tu nombre para comenzar la aventura</p>
        
        @if(session('error'))
            <div class="error">{{ session('error') }}</div>
        @endif

        <form action="{{ route('player.login') }}" method="POST" style="margin-bottom: 2rem;">
            @csrf
            <div class="form-group">
                <label for="name">Nombre de Jugador:</label>
                <input type="text" id="name" name="name" required placeholder="Ingresa tu nombre">
            </div>
            <button type="submit" class="btn-login">🎮 Iniciar Sesión</button>
        </form>

        <form action="{{ route('player.register') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name_register">¿Nuevo Jugador?</label>
                <input type="text" id="name_register" name="name" required placeholder="Elige tu nombre">
            </div>
            <button type="submit" class="btn-register">✨ Registrarse</button>
        </form>
    </div>
</body>
</html>