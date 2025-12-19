<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $receta->nombre }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
            color: #4F46E5;
            border-bottom: 3px solid #4F46E5;
            padding-bottom: 10px;
        }
        h2 {
            color: #6366F1;
            margin-top: 30px;
        }
        .info-box {
            background-color: #F3F4F6;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .info-item {
            display: inline-block;
            margin-right: 20px;
            font-weight: bold;
        }
        .badge {
            display: inline-block;
            padding: 5px 10px;
            background-color: #4F46E5;
            color: white;
            border-radius: 15px;
            font-size: 12px;
            margin-right: 10px;
        }
        ul {
            list-style-type: none;
            padding-left: 0;
        }
        li {
            padding: 5px 0;
            padding-left: 20px;
            position: relative;
        }
        li:before {
            content: "✓";
            position: absolute;
            left: 0;
            color: #4F46E5;
            font-weight: bold;
        }
        .instrucciones {
            white-space: pre-line;
        }
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #ccc;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <h1>{{ $receta->nombre }}</h1>
    
    <div class="info-box">
        <span class="badge">{{ $receta->categoria->nombre }}</span>
        <span class="badge">{{ ucfirst($receta->dificultad) }}</span>
        <br><br>
        <div class="info-item">⏱️ {{ $receta->tiempo_preparacion }} minutos</div>
        <div class="info-item">👥 {{ $receta->porciones }} porciones</div>
        <div class="info-item">👨‍🍳 Por: {{ $receta->user->name }}</div>
    </div>

    <h2>Descripción</h2>
    <p>{{ $receta->descripcion }}</p>

    <h2>Ingredientes</h2>
    <ul>
        @foreach($receta->ingredientes as $ingrediente)
            <li>{{ $ingrediente->pivot->cantidad }} de {{ $ingrediente->nombre }}</li>
        @endforeach
    </ul>

    <h2>Instrucciones</h2>
    <div class="instrucciones">{{ $receta->instrucciones }}</div>

    <div class="footer">
        <p>Generado desde tu Recetario - {{ now()->format('d/m/Y H:i') }}</p>
    </div>
</body>
</html>