<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Agregar Post</title>
    <style>
        body {
            margin: 0;
            background: #220a38;
            font-family: Arial, sans-serif;
            color: #f0e9f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            padding: 1rem;
        }

        .form-container {
            background: #3d2660;
            padding: 2rem;
            border-radius: 12px;
            width: 350px;
            box-shadow: 0 0 15px #8e1454aa;
        }

        h2 {
            margin-top: 0;
            margin-bottom: 1.5rem;
            text-align: center;
            color: #f8bbd0;
        }

        label {
            display: block;
            margin-bottom: 0.3rem;
            font-weight: bold;
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 0.8rem;
            border-radius: 8px;
            border: none;
            background: #2c1245;
            color: #f0e9f5;
            margin-bottom: 1.2rem;
            font-size: 1rem;
            resize: vertical;
        }

        input[type="text"]:focus,
        textarea:focus {
            outline: 2px solid #c2185b;
            background: #411d6a;
        }

        button {
            width: 100%;
            padding: 1rem;
            border: none;
            border-radius: 12px;
            background: #c2185b;
            color: white;
            font-weight: bold;
            font-size: 1.1rem;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button:hover {
            background: #8e1454;
        }

        .errors {
            background: #8e145466;
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 1rem;
            color: #f8bbd0;
            font-weight: bold;
        }

        .errors ul {
            margin: 0;
            padding-left: 1.2rem;
        }

        a.back-link {
            display: block;
            text-align: center;
            margin-top: 1.5rem;
            color: #81c0ff;
            text-decoration: none;
        }

        a.back-link:hover {
            color: #d64c81;
        }
    </style>
</head>
<body>
    <main class="form-container" role="main" aria-label="Formulario para agregar nuevo post">
        <h2>Agregar Nuevo Post</h2>

        @if ($errors->any())
            <div class="errors" role="alert" aria-live="assertive" tabindex="0">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('posts.store') }}" method="POST" novalidate>
            @csrf

            <label for="title">Título</label>
            <input
                type="text"
                id="title"
                name="title"
                required
                value="{{ old('title') }}"
                autocomplete="off"
                aria-required="true"
            />

            <label for="content">Contenido</label>
            <textarea
                id="content"
                name="content"
                required
                autocomplete="off"
                aria-required="true"
                rows="6"
            >{{ old('content') }}</textarea>

            <button type="submit">Publicar</button>
        </form>

        <a href="{{ route('posts.index') }}" class="back-link" aria-label="Volver al listado de posts">Volver al listado</a>
    </main>
</body>
</html>
