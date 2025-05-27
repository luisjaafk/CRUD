<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    /**
     * Mostrar lista de posts.
     */
    public function index()
    {
        // Puedes mostrar todos los posts o solo del usuario autenticado
        $posts = Post::with('user')->orderBy('created_at', 'desc')->paginate(10);

        return view('blog.index', compact('posts'));
    }

    /**
     * Mostrar formulario para crear un nuevo post.
     */
    public function create()
    {
        return view('blog.create'); // Puedes usar 'blog.post' si prefieres
    }

    /**
     * Guardar nuevo post.
     */
    public function store(Request $request)
    {
        $post = new Post();
        $post->title = $request->title;
        $post->content = $request->content;
        $post->user_id = Auth::id(); 
        $post->save();
        return redirect()->route('posts.index')->with('success', 'Post creado correctamente.');
    }

    /**
     * Mostrar un post específico.
     */
    public function show(string $id)
    {
        $post = Post::findOrFail($id);
        return view('blog.show', compact('post'));
    }

    /**
     * Mostrar formulario para editar post.
     */
    public function edit(string $id)
    {
        $post = Post::findOrFail($id);

        if ($post->user_id !== Auth::id()) {
            abort(403);
        }

        return view('blog.edit', compact('post'));
    }

    /**
     * Actualizar un post.
     */
    public function update(Request $request, string $id)
    {
        $post = Post::findOrFail($id);

        if ($post->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $post->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return redirect()->route('posts.index')->with('success', 'Post actualizado correctamente.');
    }

    /**
     * Eliminar un post.
     */
    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);

        if ($post->user_id !== Auth::id()) {
            abort(403);
        }

        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post eliminado correctamente.');
    }
}
