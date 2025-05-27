<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Editar Post</title>
    <style>
        /* Usa el mismo estilo que create */
        body {
            background: #1a0b24;
            color: #f0e9f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .form-container {
            background: #2c1245;
            padding: 2rem;
            border-radius: 12px;
            width: 400px;
            box-shadow: 0 0 20px #6e0e4a99;
        }
        h2 {
            color: #c2185b;
            margin-bottom: 1.5rem;
            text-align: center;
        }
        label {
            display: block;
            margin-bottom: 0.5rem;
            color: #d4a4c3;
        }
        input[type="text"],
        textarea {
            width: 100%;
            padding: 0.7rem;
            border: none;
            border-radius: 8px;
            background: #3d2660;
            color: #fff;
            font-size: 1rem;
            margin-bottom: 1rem;
        }
        textarea {
            resize: vertical;
            min-height: 120px;
        }
        button {
            background: #c2185b;
            border: none;
            padding: 0.9rem 1.5rem;
            color: white;
            font-weight: 600;
            border-radius: 10px;
            cursor: pointer;
            width: 100%;
            font-size: 1.1rem;
            transition: background 0.3s ease;
        }
        button:hover {
            background: #8e1454;
        }
        a.back-link {
            display: inline-block;
            margin-top: 1rem;
            color: #81c0ff;
            text-decoration: none;
            text-align: center;
            width: 100%;
        }
        a.back-link:hover {
            color: #d64c81;
        }
        .errors {
            background: #8e145466;
            border-radius: 8px;
            padding: 0.5rem 1rem;
            margin-bottom: 1rem;
            color: #f8bbd0;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Editar Post</h2>

        @if ($errors->any())
            <div class="errors">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('posts.update', $post->id) }}" method="POST">
            @csrf
            @method('PUT')

            <label for="title">Título</label>
            <input type="text" id="title" name="title" required value="{{ old('title', $post->title) }}">

            <label for="content">Contenido</label>
            <textarea id="content" name="content" required>{{ old('content', $post->content) }}</textarea>

            <button type="submit">Actualizar</button>
        </form>

        <a href="{{ route('posts.index') }}" class="back-link">Volver al listado</a>
    </div>
</body>
</html>
