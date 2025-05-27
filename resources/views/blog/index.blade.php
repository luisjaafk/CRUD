<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Listado de Posts</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&display=swap');

        /* Reset básico */
        * {
            box-sizing: border-box;
        }
        body {
            margin: 0;
            min-height: 100vh;
            background: linear-gradient(135deg, #1b002a, #42002f);
            font-family: 'Poppins', sans-serif;
            color: #e3d7f1;
            padding: 2rem;
            overflow-x: hidden;
        }
        h1 {
            text-align: center;
            font-weight: 600;
            font-size: 3rem;
            margin-bottom: 2rem;
            color: #f50057;
            text-shadow: 0 0 12px #aa0055cc;
            letter-spacing: 2px;
        }
        /* Botón agregar post */
        .btn-add {
            display: inline-block;
            background: linear-gradient(45deg, #c2185b, #aa0055);
            padding: 0.7rem 1.8rem;
            border-radius: 50px;
            font-weight: 600;
            color: white;
            text-decoration: none;
            box-shadow: 0 4px 20px #aa005599;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-bottom: 1.8rem;
            user-select: none;
        }
        .btn-add:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 30px #ff2e8ccc;
        }

        /* Tabla */
        table {
            width: 100%;
            border-collapse: collapse;
            background: rgba(56, 16, 56, 0.85);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 8px 30px #88004caa;
            animation: fadeSlideIn 0.7s ease forwards;
            opacity: 0;
            transform: translateY(25px);
        }
        th, td {
            padding: 1.2rem 1.5rem;
            text-align: left;
            font-weight: 400;
        }
        th {
            background: #8a005c;
            color: #fff;
            font-weight: 600;
            letter-spacing: 0.1rem;
            user-select: none;
            text-transform: uppercase;
            font-size: 0.9rem;
        }
        tbody tr {
            border-bottom: 1px solid #6b004b;
            transition: background-color 0.3s ease;
            cursor: default;
        }
        tbody tr:nth-child(even) {
            background: rgba(255,255,255,0.05);
        }
        tbody tr:hover {
            background-color: #c2185b33;
        }
        td {
            color: #e3d7f1;
            font-size: 1rem;
        }
        /* Acciones */
        a.action-btn {
            background: linear-gradient(45deg, #aa0055, #d64c81);
            color: white;
            padding: 0.4rem 1rem;
            border-radius: 30px;
            font-weight: 600;
            font-size: 0.9rem;
            margin-right: 0.6rem;
            text-decoration: none;
            box-shadow: 0 3px 10px #d64c8199;
            transition: background 0.3s ease, box-shadow 0.3s ease;
            user-select: none;
        }
        a.action-btn:hover {
            background: #ff2e8c;
            box-shadow: 0 5px 20px #ff2e8cdd;
        }
        form.delete-form {
            display: inline;
        }
        button.delete-btn {
            background: transparent;
            border: none;
            color: #ff2e8c;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            padding: 0.3rem 0.8rem;
            border-radius: 30px;
            transition: background-color 0.3s ease, color 0.3s ease;
            user-select: none;
        }
        button.delete-btn:hover {
            background-color: #ff2e8c;
            color: white;
            box-shadow: 0 4px 15px #ff2e8ccc;
        }

        /* Mensaje éxito */
        .message {
            max-width: 600px;
            margin: 1rem auto 2rem;
            background: #aa0055cc;
            padding: 1rem 1.2rem;
            text-align: center;
            font-weight: 600;
            font-size: 1.1rem;
            color: white;
            border-radius: 12px;
            box-shadow: 0 5px 20px #ff2e8ccc;
            user-select: none;
        }

        /* Paginación simple (Laravel) */
        .pagination {
            display: flex;
            justify-content: center;
            list-style: none;
            padding: 1rem 0;
            gap: 1rem;
            user-select: none;
        }
        .pagination li {
            background: #6e0e4a;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            cursor: pointer;
            font-weight: 600;
            color: white;
            box-shadow: 0 3px 15px #aa005588;
            transition: background-color 0.3s ease;
        }
        .pagination li.active, 
        .pagination li:hover {
            background: #ff2e8c;
            box-shadow: 0 6px 25px #ff2e8ccc;
        }
        .pagination li.disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* Animación entrada */
        @keyframes fadeSlideIn {
            from {
                opacity: 0;
                transform: translateY(25px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>

    <h1>Todos los Posts</h1>

    @if(session('success'))
        <div class="message">{{ session('success') }}</div>
    @endif

    <a href="{{ route('posts.create') }}" class="btn-add" aria-label="Agregar nuevo post">+ Nuevo Post</a>

    <table role="grid" aria-label="Listado de Posts">
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Contenido</th>
                <th>Autor</th>
                <th>Creado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($posts as $post)
                <tr>
                    <td>{{ $post->id }}</td>
                    <td>{{ $post->title }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($post->content, 60, '...') }}</td>
                    <td>{{ $post->user->name ?? 'Anon' }}</td>
                    <td>{{ $post->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <a href="{{ route('posts.edit', $post->id) }}" class="action-btn" aria-label="Editar post {{ $post->title }}">Editar</a>

                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="delete-form" onsubmit="return confirm('¿Eliminar el post \'{{ $post->title }}\'?');" aria-label="Eliminar post {{ $post->title }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete-btn" title="Eliminar post {{ $post->title }}">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center; color:#d18db7;">
                        No hay posts para mostrar
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Paginación Laravel --}}
    <div style="margin-top: 1.5rem;">
        {{ $posts->links() }}
    </div>

</body>
</html>
